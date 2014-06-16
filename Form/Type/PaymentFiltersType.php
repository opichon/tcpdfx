<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\GatewayQuery;
use Dzangocart\Bundle\CoreBundle\Model\Store;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PaymentFiltersType extends BaseAbstractType
{
    protected $store;

    public function __construct($store)
    {
        $this->store = $store;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'payment_filters',
            'translation_domain' => 'payment',
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

        $builder->add('provider_id', 'choice', array(
            'choices'   => $this->getGateway(),
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
            'label' => 'payment.filter.date_range.label',
            'attr' => array(
                'class' => 'dates',
                'autocomplete' => 'off',
                'readonly' => 'readonly'
            )
        ));
    }

    protected function getGateway()
    {
        $gateway_services = array();

        $query = GatewayQuery::create();

        if ($this->store) {
            $query->filterByStore($this->store);
        }

        $gateways = $query->find();

        foreach ($gateways as $gateway) {
            $gateway_services[$gateway->getServiceId()] = $gateway->getName();
        }

        return $gateway_services;
    }

    public function getName()
    {
        return "payment_filters";
    }
}
