<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Form\Type\PaymentsFiltersType as BaseType;
use Dzangocart\Bundle\CoreBundle\Model\Store;
use Dzangocart\Bundle\CoreBundle\Model\Gateway\GatewayQuery;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\Translator;

class StorePaymentsFiltersType extends BaseType
{
    protected $store;

    protected $translator;

    protected $locale;

    public function __construct(Store $store, Translator $translator, $locale)
    {
        $this->store = $store;

        $this->translator = $translator;

        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('gateway_id', 'choice', array(
            'choices'   => $this->getGateways(),
            'required' => false
        ));
    }

    protected function getStore()
    {
        return $this->store;
    }

    protected function getTranslator()
    {
        return $this->translator;
    }

    protected function getLocale()
    {
        return $this->locale;
    }

    protected function getGateways()
    {
        $gateways = array();

        $query = GatewayQuery::create()
            ->joinWithI18n($this->getLocale())
            ->filterByStore($this->getStore())
            ->useServiceQuery()
                ->orderByName()
            ->endUse();

        foreach ($query->find() as $gateway) {
            $gateways[$gateway->getId()] =
                $gateway->isTesting()
                ? $this->getTranslator()->trans(
                    'gateway.name',
                    array('%name%' => $gateway->getService()->getName()),
                    'gateway'
                )
                : $gateway->getService()->getName();
        }

        return $gateways;
    }

    public function getName()
    {
        return "payments_filters";
    }
}
