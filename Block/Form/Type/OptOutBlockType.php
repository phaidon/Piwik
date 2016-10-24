<?php
/**
 * Copyright Piwik Team 2016
 *
 * This work is contributed to the Zikula Foundation under one or more
 * Contributor Agreements and licensed to You under the following license:
 *
 * @license GNU/LGPLv3 (or at your option, any later version).
 * @link https://github.com/phaidon/Piwik
 */

namespace Phaidon\PiwikModule\Block\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Common\Translator\TranslatorTrait;

/**
 * Class SearchBlockType
 */
class SearchBlockType extends AbstractType
{
    use TranslatorTrait;

    /**
     * SearchBlockType constructor.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->setTranslator($translator);
    }

    /**
     * Sets the translator.
     *
     * @param TranslatorInterface $translator Translator service instance
     */
    public function setTranslator(/*TranslatorInterface */$translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('optOutWidth', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'label' => $this->__('Width of block')
            ])
            ->add('optOutHeight', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'label' => $this->__('Height of block')
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'phaidonpiwikmodule_optoutblock';
    }
}
