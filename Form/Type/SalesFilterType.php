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

    }

    public function getName()
    {
        return "sales_filters";
    }
}