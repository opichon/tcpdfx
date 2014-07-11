<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\ServiceQuery;
use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentsFiltersType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'payments_filters',
            'translation_domain' => 'payment',
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

        $builder->add('store', 'choice', array(
            'label' => 'payment.filters.store',
            'required' => false,
            'choices' => $this->getStores()
        ));

        $builder->add('customer', 'text', array(
            'label' => 'payment.filters.name'
        ));

        $builder->add('customer_id', 'hidden', array(
            'label' => false
        ));

        $builder->add('date_from', 'date', array(
            'required' => true,
            'label' => 'payment.filters.date_from',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_from'
            )
        ));

        $builder->add('date_to', 'date', array(
            'required' => true,
            'label' => 'payment.filters.date_to',
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date date_to'
            )
        ));

        $builder->add('period', 'text', array(
            'mapped' => false,
            'required' => true,
            'data' => '',
            'label' => 'payment.filters.period',
            'attr' => array(
                'class' => 'period'
            )
        ));

        $builder->add('test', 'checkbox', array(
            'label' => 'payment.filters.test',
            'attr' => array(
                'class' => 'checkbox'
            ),
        ));

        $builder->add('service_id', 'choice', array(
            'choices'   => $this->getGatewayServices(),
            'required' => false
        ));

        $builder->add('status', 'choice', array(
            'choices'   => array(
                0 => 'payment.status.label.open',
                2 => 'payment.status.label.cancelled',
                4 => 'payment.status.label.error',
                8 => 'payment.status.label.approved',
                16 => 'payment.status.label.paid'
            ),
            'required' => false
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

    protected function getGatewayServices()
    {
        $services = array();

        $query = $this->getServiceQuery();

        foreach ($query->find() as $service) {
            $services[$service->getId()] = $service->getName();
        }

        return $services;
    }

    protected function getServiceQuery()
    {
        return ServiceQuery::create()
            ->orderByName();
    }

    public function getName()
    {
        return "payments_filters";
    }
}
