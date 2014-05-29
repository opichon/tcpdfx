<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'order_filters',
            'translation_domain' => 'order',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'text', array(
            'label' => 'order.filter.id.label',
            'required' => false
        ));

        $builder->add('store_name', 'text', array(
            'label' => 'order.filter.store_name.label',
            'required' => false
        ));

        $builder->add('customer', 'text', array(
            'required' => false,
            'label' => 'order.filter.customer.label',
            'mapped' => false
        ));

        $builder->add('customer_id', 'hidden', array(
            'required' => false,
        ));

        $builder->add('date_start', 'date', array(
                    'required' => true,
                    'label' => false,
                    'widget' => 'single_text',
                    'attr' => array(
                        'class' => 'date date_start',
                        'style' => 'display: none;'
                    )
        ));

        $builder->add('date_end', 'date', array(
            'required' => true,
            'label' => false,
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_end',
                'style' => 'display: none;'
            )
        ));

        $range = '';

        $builder->add('date_range', 'text', array(
            'mapped' => false,
            'required' => true,
            'data' => $range,
            'label' => 'order.filter.date_range.label',
            'attr' => array(
                'class' => 'dates',
                'autocomplete' => 'off',
                'readonly' => 'readonly'
            )
        ));
    }

    public function getName()
    {
        return "order_filters";
    }
}
