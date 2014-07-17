<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class POFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'po',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('order_id', 'text', array(
            'required' => false
        ));

        $builder->add('bank', 'text', array(
            'required' => false
        ));

        $builder->add('cheque', 'text', array(
            'required' => false
        ));

        $builder->add('store', 'choice', array(
            'label' => 'po.transactions.filters.store',
            'required' => false,
            'choices' => $this->getStores()
        ));

        $builder->add('date_from', 'date', array(
            'required' => true,
            'label' => 'po.transactions.filters.date_from',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_from'
            )
        ));

        $builder->add('date_to', 'date', array(
            'required' => true,
            'label' => 'po.transactions.filters.date_to',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_to'
            )
        ));

        $builder->add('period', 'text', array(
            'mapped' => false,
            'required' => true,
            'data' => '',
            'label' => 'po.transactions.filters.period',
            'attr' => array(
                'class' => 'period'
            )
        ));

        $builder->add('test', 'checkbox', array(
            'label' => 'po.transactions.filters.test',
            'attr' => array(
                'class' => 'checkbox'
            ),
        ));
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

    public function getName()
    {
        return "po_filters";
    }
}
