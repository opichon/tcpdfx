<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrdersFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'order',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('order_id', 'text', array(
            'label' => 'order.filters.id',
            'required' => false
        ));

        $builder->add('store', 'choice', array(
            'label' => 'order.filters.store',
            'required' => false,
            'choices' => $this->getStores()
        ));

        $builder->add('customer', 'text', array(
            'required' => false,
            'label' => 'order.filters.customer',
            'mapped' => false
        ));

        $builder->add('customer_id', 'hidden', array(
            'required' => false,
        ));

        $builder->add('date_from', 'date', array(
            'required' => true,
            'label' => 'order.filters.date_from',
            'widget' => 'single_text',
            'attr' => array(
               'class' => 'date date_from'
            )
        ));

        $builder->add('date_to', 'date', array(
            'required' => true,
            'label' => 'order.filters.date_to',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_to'
            )
        ));

        $builder->add('period', 'text', array(
            'mapped' => false,
            'required' => true,
            'data' => '',
            'label' => 'order.filters.period',
            'attr' => array(
                'class' => 'period'
            )
        ));

        $builder->add('test', 'checkbox', array(
            'label' => 'order.filters.test',
            'attr' => array(
                'class' => 'checkbox'
            ),
        ));
    }

    public function getName()
    {
        return 'orders_filters';
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
