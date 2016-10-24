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
 * Dashboard form type class.
 */
class DashboardType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translator = $options['translator'];

        $builder
            ->add('period', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', [
                'label' => $translator->__('Period'),
                'choices' => [
                    $translator->__('Day') => 'day',
                    $translator->__('Week') => 'week',
                    $translator->__('Month') => 'month',
                    $translator->__('Year') => 'year'/*,
                    $translator->__('Date range') => 'range'*/
                ],
                'choices_as_values' => true,
                'expanded' => false,
                'multiple' => false
            ]);

        if ($options['context'] == 'overview') {
            $builder
                ->add('date', 'Symfony\Component\Form\Extension\Core\Type\DateType', [
                    'label' => $translator->__('Date')
                ])
                /* date ranges are not enabled yet
                ->add('from', 'Symfony\Component\Form\Extension\Core\Type\DateType', [
                    'label' => $translator->__('From')
                ])
                ->add('to', 'Symfony\Component\Form\Extension\Core\Type\DateType', [
                    'label' => $translator->__('To')
                ])*/
            ;
        }

        $builder
            ->add('save', 'Symfony\Component\Form\Extension\Core\Type\SubmitType', [
                'label' => $translator->__('Show'),
                'icon' => 'fa-check',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'phaidonpiwikmodule_dashboard';
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
            'context' => 'overview'
        ]);
    }
}
