<?php

namespace Pim\Bundle\DataGridBundle\Extension\Formatter\Property\ProductValue;

use Akeneo\Component\Localization\Presenter\PresenterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Formatter for Text Collection attribute type.
 * Works with a twig template (Resources/views/Property/text_collection.html.twig).
 *
 * @author JM Leroux <jean-marie.leroux@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class TextCollectionProperty extends FieldProperty
{
    /** @var PresenterInterface */
    protected $presenter;

    /**
     * @param TranslatorInterface $translator
     * @param PresenterInterface  $presenter
     */
    public function __construct(
        TranslatorInterface $translator,
        PresenterInterface $presenter
    ) {
        parent::__construct($translator);
        $this->presenter  = $presenter;
    }

    /**
     * {@inheritdoc}
     */
    protected function convertValue($value)
    {
        $result = $this->getBackendData($value);

        return $this->presenter->present($result, ['locale' => $this->translator->getLocale()]);
    }
}
