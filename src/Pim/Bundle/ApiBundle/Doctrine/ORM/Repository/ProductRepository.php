<?php

namespace Pim\Bundle\ApiBundle\Doctrine\ORM\Repository;

use Akeneo\Component\StorageUtils\Repository\IdentifiableObjectRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\UnexpectedResultException;
use Pim\Component\Api\Repository\ProductRepositoryInterface;
use Pim\Component\Catalog\Query\ProductQueryBuilderInterface;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2017 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class ProductRepository extends EntityRepository implements ProductRepositoryInterface
{
    /** @var IdentifiableObjectRepositoryInterface */
    protected $productRepository;

    /**
     * @param EntityManager                         $em
     * @param string                                $className
     * @param IdentifiableObjectRepositoryInterface $productRepository
     */
    public function __construct(EntityManager $em, $className, IdentifiableObjectRepositoryInterface $productRepository)
    {
        parent::__construct($em, $em->getClassMetadata($className));

        $this->productRepository = $productRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneByIdentifier($identifier)
    {
        return $this->productRepository->findOneByIdentifier($identifier);
    }

    /**
     * {@inheritdoc}
     */
    public function findBySearch(ProductQueryBuilderInterface $pqb, $limit, $offset)
    {
        $qb = $pqb->getQueryBuilder();
        $qb
            ->setMaxResults($limit)
            ->setFirstResult($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function count(ProductQueryBuilderInterface $pqb)
    {
        try {
            $qb = $pqb->getQueryBuilder();

            return (int) $qb
                ->select('COUNT(DISTINCT (o.id)')
                ->resetDQLParts(['orderBy', 'groupBy'])
                ->getQuery()
                ->getSingleScalarResult();
        } catch (UnexpectedResultException $e) {
            return 0;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifierProperties()
    {
        return $this->productRepository->getIdentifierProperties();
    }
}
