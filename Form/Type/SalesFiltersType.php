<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SalesFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'sales_filters',
            'show_legend' => false,
            'translation_domain' => 'sale'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('order_id', 'text', array(
            'label' => 'sale.filters.order_id'
        ));

        $builder->add('store', 'choice', array(
            'label' => 'sale.filters.store',
            'required' => false,
            'choices' => $this->getStores()
        ));

        $builder->add('name', 'text', array(
            'label' => 'sale.filters.name'
        ));

        $builder->add('customer', 'text', array(
            'label' => 'sale.filters.name'
        ));

        $builder->add('customer_id', 'hidden', array(
            'label' => false
        ));

        $builder->add('date_from', 'date', array(
            'required' => true,
            'label' => 'sale.filters.date_from',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_from'
            )
        ));

        $builder->add('date_to', 'date', array(
            'required' => true,
            'label' => 'sale.filters.date_to',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_to'
            )
        ));

        $builder->add('period', 'text', array(
            'mapped' => false,
            'required' => true,
            'data' => '',
            'label' => 'sale.filters.period',
            'attr' => array(
                'class' => 'period'
            )
        ));

        $builder->add('test', 'checkbox', array(
            'label' => 'sale.filters.test',
            'attr' => array(
                'class' => 'checkbox'
            ),
        ));
    }

    public function getName()
    {
        return 'sales_filters';
    }

    protected function getStores()
    {
        $stores = array();

        $query = StoreQuery::create()
            ->orderByname();

        foreach ($query->find() as $store) {
            $stores[$store->getId()] = $store->getName();
        }

        return $stores;
    }
}
