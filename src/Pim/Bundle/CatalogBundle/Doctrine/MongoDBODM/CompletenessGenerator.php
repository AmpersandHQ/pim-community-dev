<?php

namespace Pim\Bundle\CatalogBundle\Doctrine\MongoDBODM;

use Pim\Bundle\CatalogBundle\Doctrine\CompletenessGeneratorInterface;
use Pim\Bundle\CatalogBundle\Entity\Channel;
use Pim\Bundle\CatalogBundle\Entity\Locale;
use Pim\Bundle\CatalogBundle\Entity\Family;
use Pim\Bundle\CatalogBundle\Model\ProductInterface;
use Pim\Bundle\CatalogBundle\Model\AbstractAttribute;
use Pim\Bundle\CatalogBundle\Model\Completeness;
use Pim\Bundle\CatalogBundle\Manager\ChannelManager;
use Pim\Bundle\CatalogBundle\Entity\Repository\FamilyRepository;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\MongoDB\Query\Builder;
use Doctrine\MongoDB\Query\Expr;

/**
 * Generate the completeness when Product are in MongoDBODM
 * storage. Please note that the generation for several products
 * is done on the MongoDB via a JS generated by the application via HTTP.
 *
 * This generator is only able to generate completeness for one product
 *
 * @author    Benoit Jacquemont <benoit@akeneo.com>
 * @copyright 2013 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class CompletenessGenerator implements CompletenessGeneratorInterface
{
    /**
     * @var DocumentManager;
     */
    protected $documentManager;

    /**
     * @var string
     */
    protected $productClass;

    /**
     * @var ChannelManager
     */
    protected $channelManager;

    /**
     * @var FamilyRepository
     */
    protected $familyRepository;

    /**
     * Constructor
     *
     * @param DocumentManager  $documentManager
     * @param string           $productClass
     * @param ChannelManager   $channelManager
     * @param FamilyRepository $familyRepository
     */
    public function __construct(
        DocumentManager $documentManager,
        $productClass,
        ChannelManager $channelManager,
        FamilyRepository $familyRepository
    ) {
        $this->documentManager     = $documentManager;
        $this->productClass        = $productClass;
        $this->channelManager      = $channelManager;
        $this->familyRepository    = $familyRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function generateMissingForProduct(ProductInterface $product, $flush = true)
    {
        $this->generate($product);

        if ($flush) {
            $this->documentManager->flush($product);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function generateMissingForChannel(Channel $channel)
    {
        $this->generate(null, $channel);
    }

    /**
     * {@inheritdoc}
     */
    public function generateMissing()
    {
        $this->generate();
    }

    /**
     * Generate missing completenesses for a channel if provided or a product
     * if provided. CAUTION: the product must be already flushed to the DB
     *
     * @param ProductInterface $product
     * @param Channel          $channel
     */
    protected function generate(ProductInterface $product = null, Channel $channel = null)
    {
        $productsQb = $this->documentManager->createQueryBuilder($this->productClass);

        $familyReqs = $this->getFamilyRequirements($product, $channel);

        $this->applyFindMissingQuery($productsQb, $product, $channel);

        $products = $productsQb->select('family', 'normalizedData')
            ->hydrate(false)
            ->getQuery()
            ->execute();

        foreach ($products as $product) {
            $familyId = $product['family'];
            $completenesses = $this->getCompletenesses($product['normalizedData'], $familyReqs[$familyId]);
            $this->saveCompletenesses($product['_id'], $completenesses);
        }
    }

    /**
     * Generate completenesses data from normalized data from product and
     * its family requirements. Only missing completenesses are generated.
     *
     * @param array $normalizedData
     * @parma array $normalizedReqs
     *
     * @return array $completenesses
     */
    protected function getCompletenesses(array $normalizedData, array $normalizedReqs)
    {
        $completenesses = array();
        $allCompletenesses = false;

        if ((null === $normalizedData['completenesses'])||(0 === count($normalizedData['completenesses']))) {
            $missingComps = array_keys($normalizedReqs);
            $allCompletenesses = true;
        } else {
            $missingComps = array_diff(array_keys($normalizedReqs), array_keys($normalizedData['completenesses']));
        }

        $normalizedData = array_filter(
            $normalizedData,
            function ($value) {
                return ('null' != $value);
            }
        );

        $dataFields = array_keys($normalizedData);

        foreach ($missingComps as $missingComp) {
            $attributesReqs = $normalizedReqs[$missingComp]['reqs']['attributes'];
            $pricesReqs = $normalizedReqs[$missingComp]['reqs']['prices'];
            $requiredCount = count($attributesReqs) + count($pricesReqs);

            $missingAttributes = array_diff($attributesReqs, $dataFields);

            $missingPricesCount = count($pricesReqs);

            foreach ($pricesReqs as $priceField => $currencies) {
                if (isset($normalizedData[$priceField]) &&
                    count(array_diff($currencies, array_keys($normalizedData[$priceField]))) === 0) {
                    $missingPricesCount --;
                }
            }

            $missingCount = count($missingAttributes) + $missingPricesCount;

            $ratio = round(($requiredCount - $missingCount) / $requiredCount * 100);

            $compObject = array(
                '_id'           => new \MongoId(),
                'missingCount'  => $missingCount,
                'requiredCount' => $requiredCount,
                'ratio'         => $ratio,
                'channel'       => $normalizedReqs[$missingComp]['channel'],
                'locale'        => $normalizedReqs[$missingComp]['locale']
            );

            $completenesses[$missingComp] = array(
                'object' => $compObject,
                'ratio'  => $ratio
            );
        }

        return array('completenesses' => $completenesses, 'all' => $allCompletenesses);
    }

    /**
     * Save the completenesses data for the product directly to MongoDB.
     *
     * @param string $productId
     * @param array  $compData
     */
    protected function saveCompletenesses($productId, array $compData)
    {
        $completenesses = $compData['completenesses'];
        $all = $compData['all'];

        $collection = $this->documentManager->getDocumentCollection($this->productClass);

        $query = array('_id' => $productId);
        $options = array('multiple' => false);

        if ($all) {
            $compObjects = array();
            $normalizedComps = array();

            foreach ($completenesses as $key => $value) {
                $compObjects[] = $value['object'];
                $normalizedComps[$key] = $value['ratio'];
            }
            $normalizedComps = array('normalizedData.completenesses' => $normalizedComps);

            $compObject = array('$set' => array('completenesses' => $compObjects));
            $collection->update($query, $compObject, $options);

            $normalizedComp = array('$set' => $normalizedComps);
            $collection->update($query, $normalizedComp, $options);
        } else {
            foreach ($completenesses as $key => $value) {

                $compObject = array('$push' => array('completenesses' => $value['object']));

                $collection->update($query, $compObject, $options);

                $normalizedComp = array('$set' => array('normalizedData.completenesses.'.$key => $value['ratio']));
                $collection->update($query, $normalizedComp, $options);
            }
        }
    }

    /**
     * Generate family requirements information to be used to
     * calculate completenesses.
     *
     * @param ProductInterface $product
     * @param Channel          $channel
     */
    protected function getFamilyRequirements(ProductInterface $product = null, Channel $channel = null)
    {
        $selectFamily = null;

        if (null !== $product) {
            $selectFamily = $product->getFamily();
        }
        $families = $this->familyRepository->getFullFamilies($selectFamily, $channel);
        $familyRequirements = array();

        foreach ($families as $family) {
            $reqsByChannels = array();
            $channels = array();

            foreach ($family->getAttributeRequirements() as $attributeReq) {
                $channel = $attributeReq->getChannel();

                $channels[$channel->getCode()] = $channel;

                if (!isset($reqsByChannels[$channel->getCode()])) {
                    $reqsByChannels[$channel->getCode()] = array();
                }

                $reqsByChannels[$channel->getCode()][] = $attributeReq;
            }

            $familyRequirements[$family->getId()] = $this->getFieldsNames($channels, $reqsByChannels);
        }

        return $familyRequirements;
    }

    /**
     * Generate fields name that should be present and not null for the product
     * to be defined as complete for channels and family
     * Familyreqs must be indexed by channel code
     *
     * @param array $channels
     * @param array $familyReqs
     *
     * @return array
     */
    protected function getFieldsNames(array $channels, array $familyReqs)
    {
        $fields = array();
        foreach ($channels as $channel) {
            foreach ($channel->getLocales() as $locale) {
                $expectedCompleteness = $channel->getCode().'-'.$locale->getCode();
                $fields[$expectedCompleteness] = array();
                $fields[$expectedCompleteness]['channel'] = $channel->getId();
                $fields[$expectedCompleteness]['locale'] = $locale->getId();
                $fields[$expectedCompleteness]['reqs'] = array();
                $fields[$expectedCompleteness]['reqs']['attributes'] = array();
                $fields[$expectedCompleteness]['reqs']['prices'] = array();

                foreach ($familyReqs[$channel->getCode()] as $requirement) {
                    $fieldName = $this->getNormalizedFieldName($requirement->getAttribute(), $channel, $locale);

                    if ('prices' === $requirement->getAttribute()->getBackendType()) {
                        $fields[$expectedCompleteness]['reqs']['prices'][$fieldName] = array();
                        foreach ($channel->getCurrencies() as $currency) {
                            $fields[$expectedCompleteness]['reqs']['prices'][$fieldName][] = $currency->getCode();
                        }
                    } else {
                        $fields[$expectedCompleteness]['reqs']['attributes'][] = $fieldName;
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * Get the name of a normalized data field
     *
     * @param AbstractAttribute $attribute
     * @param Channel           $channel
     * @parma Locale            $locale
     *
     * @return string
     */
    protected function getNormalizedFieldName(AbstractAttribute $attribute, Channel $channel, Locale $locale)
    {
        $suffix = '';

        if ($attribute->isLocalizable()) {
            $suffix = sprintf('-%s', $locale->getCode());
        }
        if ($attribute->isScopable()) {
            $suffix .= sprintf('-%s', $channel->getCode());
        }

        return $attribute->getCode() . $suffix;
    }

    /**
     * Apply the query part to search for product where the completenesses
     * are missing. Apply only to the channel or product if provided.
     *
     * @param Builder $productsQb
     * @param Product $product
     * @param Channel $channel
     */
    protected function applyFindMissingQuery(
        Builder $productsQb,
        ProductInterface $product = null,
        Channel $channel = null
    ) {
        if (null !== $product) {
            $productsQb->field('_id')->equals($product->getId());
        } else {
            $combinations = $this->getChannelLocaleCombinations($channel);

            if (!empty($combinations)) {
                foreach ($combinations as $combination) {
                    $expr = new Expr();
                    $expr->field('normalizedData.completenesses.'.$combination)->exists(false);
                    $productsQb->addOr($expr);
                }
            }
        }

        $productsQb->field('family')->notEqual(null);
    }

    /**
     * Generate a list of potential completeness value from existing channel
     * or from the provided channel
     *
     * @param Channel $channel
     *
     * @return array
     */
    protected function getChannelLocaleCombinations(Channel $channel = null)
    {
        $channels = array();
        $combinations = array();

        if (null !== $channel) {
            $channels = [$channel];
        } else {
            $channels = $this->channelManager->getFullChannels();
        }

        foreach ($channels as $channel) {
            $locales = $channel->getLocales();
            foreach ($locales as $locale) {
                $combinations[] = $channel->getCode().'-'.$locale->getCode();
            }
        }

        return $combinations;
    }

    /**
     * {@inheritdoc}
     */
    public function schedule(ProductInterface $product)
    {
        $product->getCompletenesses()->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function scheduleForFamily(Family $family)
    {
        $productQb = $this->documentManager->createQueryBuilder($this->productClass);

        $productQb
            ->update()
            ->multiple(true)
            ->field('family')->equals($family->getId())
            ->field('completenesses')->unsetField()
            ->field('normalizedData.completenesses')->unsetField()
            ->getQuery()
            ->execute();
    }
}
