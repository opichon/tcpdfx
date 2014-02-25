<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'customer_filters',
            'translation_domain' => 'customer',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id', 'text', array(
            'required' => false
        ));

        $builder->add('realm', 'text', array(
            'required' => false
        ));
    }

    public function getName()
    {
        return "customer_filters";
    }
}
