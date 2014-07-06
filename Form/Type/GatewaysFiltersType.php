<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\EngineQuery;
use Dzangocart\Bundle\CoreBundle\Model\Gateway\ServiceQuery;
use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GatewaysFiltersType extends BaseAbstractType
{
    protected $locale;

    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'gateways_filters',
            'show_legend' => false,
            'translation_domain' => 'gateway'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('store_id', 'choice', array(
            'label' => 'gateway.filters.store_id',
            'required' => false,
            'choices' => $this->getStores()
        ));

        $builder->add('service_id', 'choice', array(
            'label' => 'gatteway.filters.service_id',
            'choices' => $this->getServices(),
            'empty_value' => '',
            'required' => false
        ));

        $builder->add('engine_id', 'choice', array(
            'label' => 'gateway.filters.engine_id',
            'choices' => $this->getEngines(),
            'empty_value' => '',
            'required' => false
        ));

        $builder->add('testing', 'choice', array(
            'label' => 'gateway.filters.testing.label',
            'choices' => $this->getTestingChoices(),
            'empty_value' => false,
            'required' => false,
        ));

        $builder->add('status', 'choice', array(
            'label' => 'gateway.filters.status',
            'choices' => $this->getStatuses(),
            'empty_value' => '',
            'required' => false
        ));

    }

    public function getName()
    {
        return 'gateways_filters';
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

    protected function getServices()
    {
        $choices = array();

        $query = ServiceQuery::create()
            ->orderByName();

        foreach ($query->find() as $service) {
            $choices[$service->getId()] = $service->getName();
        }

        return $choices;
    }

    protected function getEngines()
    {
        $choices = array();

        $query = EngineQuery::create()
            ->joinWithI18n($this->getLocale())
            ->orderByName();

        foreach ($query->find() as $engine) {
            $choices[$engine->getId()] = $engine->getName();
        }

        return $choices;
    }

    protected function getTestingChoices()
    {
        return array(
            '' => 'gateway.filters.testing.indifferent',
            0 => 'gateway.filters.testing.include',
            1 => 'gateway.filters.testing.exclude'
        );
    }

    protected function getStatuses()
    {
        return array();
    }

    protected function getLocale()
    {
        return $this->locale;
    }
}
