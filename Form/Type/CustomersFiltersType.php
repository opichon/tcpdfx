<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomersFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
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
            'label'=>'customer.filters.id',
            'required' => false
        ));

        $builder->add('realm', 'text', array(
            'label'=>'customer.filters.realm',
            'required' => false
        ));

        $builder->add('name', 'text', array(
            'label'=>'customer.filters.name',
            'required' => false
        ));
//        TODO: [JP 7-24-2014] may used in future.
//        $builder->add('surname', 'text', array(
//            'label'=>'customer.filters.surname',
//            'required' => false
//        ));
//
//        $builder->add('given_names', 'text', array(
//            'label'=>'customer.filters.given_names',
//            'required' => false
//        ));

        $builder->add('gender', 'choice', array(
            'label'=>'customer.filters.gender',
            'choices' => array(1=>'customer.filters.gender.male', 0=>'customer.filters.gender.female'),
            'required' => false
        ));

        $builder->add('email', 'text', array(
            'label'=>'customer.filters.email',
            'required' => false
        ));
    }

    public function getName()
    {
        return "customer_filters";
    }
}
