<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\Store;
use Dzangocart\Bundle\CoreBundle\Model\TaxRateQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryFormType extends BaseAbstractType
{
    protected $store;

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'catalogue',
            'show_legend' => false,
            'csrf_protection' => false  //TODO enable CSRF
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label'=>'catalogue.category.form.name.label',
            'required' => true
        ));

        $builder->add('code', 'text', array(
            'label' => 'catalogue.category.form.code.label',
            'required' => false
        ));

        $builder->add('suffix', 'text', array(
            'label' => 'catalogue.category.form.suffix.label',
            'required' => false
        ));

        $builder->add('price', 'number', array(
            'attr' => array(
                'min' => 0
            ),
            'label' => 'catalogue.category.form.price.label',
            'required' => true
        ));

        $builder->add('taxRateId', 'choice', array(
            'label' => 'catalogue.category.form.tax_rate_id.label',
            'choices'   => $this->getTaxRate(),
            'required' => false
        ));

        $builder->add('taxIncluded', 'checkbox', array(
            'label' => 'catalogue.category.form.tax_included.label',
            'required' => false
        ));

        $builder->add('export', 'checkbox', array(
            'label' => 'catalogue.category.form.export.label',
            'required' => false
        ));

        $builder->add('shipping', 'checkbox', array(
            'label' => 'catalogue.category.form.shipping.label',
            'required' => false
        ));

        $builder->add('download', 'checkbox', array(
            'label' => 'catalogue.category.form.download.label',
            'required' => false
        ));

        $builder->add('pack', 'checkbox', array(
            'label' => 'catalogue.category.form.pack.label',
            'required' => false
        ));

        $builder->add('minQuantity', 'integer', array(
            'label' => 'catalogue.category.form.min_quantity.label',
            'attr' => array(
                'min' => 1
            ),
            'required' => true
        ));

        $builder->add('maxQuantity', 'integer', array(
            'label' => 'catalogue.category.form.max_quantity.label',
            'attr' => array(
                'min' => 1
            ),
            'required' => true
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'catalogue.category.form.submit'
        ));
    }

    public function getName()
    {
        return "category";
    }

    protected function getStore()
    {
        return $this->store;
    }

    protected function getTaxRate()
    {
        $tax_rates = array();

        $taxes = TaxRateQuery::create()
            ->filterByCountry(
                $this->getStore()
                    ->getCountryId()
            )
            ->find();

        foreach ($taxes as $tax) {
            $tax_rates[$tax->getId()] = $tax->getName();
        }

        return $tax_rates;
    }
}
