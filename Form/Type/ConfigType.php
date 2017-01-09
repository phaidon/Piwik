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

namespace Phaidon\PiwikModule\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Configuration form type class.
 */
class ConfigType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translator = $options['translator'];

        $builder
            ->add('tracking_enable', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', [
                'label' => $translator->__('Enable tracking'),
                'required' => false
            ])
            ->add('tracking_piwikpath', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'label' => $translator->__('URL to your Piwik installation'),
                'help' => $translator->__('Example: www.yourdomain.com/piwik (without leading http(s)://)')
            ])
            ->add('tracking_token', 'Symfony\Component\Form\Extension\Core\Type\TextType', [
                'label' => $translator->__('Piwik token'),
                'attr' => [
                    'max_length' => 40
                ],
                'help' => $translator->__('Your personal authentification token can be found in the Piwik web interface on the API page. It looks like 1234a5cd6789e0a12345b678cd9012ef.')
            ])
            ->add('tracking_protocol', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'label' => $translator->__('Used protocol'),
                'choices' => [
                    $translator->__('Only http (can produce problems if you are viewing your site via https)') => 1,
                    $translator->__('Only https (if you are able to connect via https)') => 2,
                    $translator->__('http/https (depending on the protocol which is used to request the site)') => 3
                ],
                'choices_as_values' => true,
                'expanded' => false,
                'multiple' => false
            ])
            ->add('tracking_siteid', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'label' => $translator->__('Site'),
                'choices' => false !== $options['sites'] ? $options['sites'] : [],
                'choices_as_values' => true,
                'expanded' => false,
                'multiple' => false
            ])
            ->add('tracking_adminpages', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', [
                'label' => $translator->__('Track admin pages'),
                'required' => false
            ])
            ->add('tracking_linktracking', 'Symfony\Component\Form\Extension\Core\Type\CheckboxType', [
                'label' => $translator->__('Track links'),
                'required' => false
            ])
            ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $translator->__('Save'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('cancel', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $translator->__('Cancel'),
                'icon' => 'fa-times',
                'attr' => [
                    'class' => 'btn btn-default'
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'phaidonpiwikmodule_config';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translator' => null,
            'sites' => []
        ]);
    }
}
