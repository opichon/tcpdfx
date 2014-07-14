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
            'name' => 'catagory_edit',
            'translation_domain' => 'catalogue',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label'=>'catalogue.category.form.name.label',
            'required' => TRUE
        ));

        $builder->add('code', 'text', array(
            'label' => 'catalogue.category.form.code.label',
            'required' => FALSE
        ));

        $builder->add('suffix', 'text', array(
            'label' => 'catalogue.category.form.suffix.label',
            'required' => FALSE
        ));

        $builder->add('price', 'integer', array(
            'attr' => array(
                'min' => 1
            ),
            'label' => 'catalogue.category.form.price.label',
            'required' => TRUE
        ));

        $builder->add('taxRateId', 'choice', array(
            'label' => 'catalogue.category.form.tax_rate_id.label',
            'choices'   => $this->getTaxRate(),
            'required' => FALSE
        ));

        $builder->add('taxIncluded', 'checkbox', array(
            'label' => 'catalogue.category.form.tax_included.label',
            'required' => FALSE
        ));

        $builder->add('export', 'checkbox', array(
            'label' => 'catalogue.category.form.export.label',
            'required' => FALSE
        ));

        $builder->add('shipping', 'checkbox', array(
            'label' => 'catalogue.category.form.shipping.label',
            'required' => FALSE
        ));

        $builder->add('download', 'checkbox', array(
            'label' => 'catalogue.category.form.download.label',
            'required' => FALSE
        ));

        $builder->add('pack', 'checkbox', array(
            'label' => 'catalogue.category.form.pack.label',
            'required' => FALSE
        ));

        $builder->add('minQuantity', 'integer', array(
            'label' => 'catalogue.category.form.min_quantity.label',
            'attr' => array(
                'min' => 1
            ),
            'required' => TRUE
        ));

        $builder->add('maxQuantity', 'integer', array(
            'label' => 'catalogue.category.form.max_quantity.label',
            'attr' => array(
                'min' => 1
            ),
            'required' => TRUE
        ));
        $builder->add('Save', 'submit');
    }

    public function getName()
    {
        return "catagory_edit";
    }

    protected function getTaxRate()
    {
        $tax_rates = array();

        $taxes = TaxRateQuery::create()
            ->filterByCountry($this->store->getCountryId())
            ->find();

        foreach ($taxes as $tax) {
            $tax_rates[$tax->getId()] = $tax->getName();
        }

        return $tax_rates;
    }

}