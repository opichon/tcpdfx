<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalesFilterType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'sales_filters',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('order_id', 'text', array());

        $builder->add('name', 'text', array());

        $builder->add('customer', 'text', array());

        $builder->add('customer_id', 'hidden', array());

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
        return "sales_filters";
    }
}
