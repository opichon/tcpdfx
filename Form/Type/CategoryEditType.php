<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\Store;
use Dzangocart\Bundle\CoreBundle\Model\TaxQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryEditType extends BaseAbstractType
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

        $builder->add('pCode', 'text', array(
            'label' => 'catalogue.category.form.pcode.label',
            'required' => FALSE
        ));

        $builder->add('price', 'number', array(
            'label' => 'catalogue.category.form.price.label',
            'required' => TRUE
        ));

        $builder->add('taxRateId', 'choice', array(
            'label' => 'catalogue.category.form.tax_rate_id.label',
            'choices'   => $this->getTaxRate(),
            'required' => FALSE
        ));

        $builder->add('taxIncluded', 'choice', array(
            'label' => 'catalogue.category.form.tax_included.label',
            'choices'   => array('0' => 'No', '1' => 'Yes'),
            'required' => TRUE
        ));
        
        $builder->add('export', 'choice', array(
            'label' => 'catalogue.category.form.export.label',
            'choices'   => array('0' => 'No', '1' => 'Yes'),
            'required' => TRUE
        ));
        
        $builder->add('shipping', 'choice', array(
            'label' => 'catalogue.category.form.shipping.label',
            'choices'   => array('0' => 'No', '1' => 'Yes'),
            'required' => FALSE
        ));
        
        $builder->add('download', 'choice', array(
            'label' => 'catalogue.category.form.download.label',
            'choices'   => array('0' => 'No', '1' => 'Yes'),
            'required' => FALSE
        ));
            
        $builder->add('minQuantity', 'integer', array(
            'label' => 'catalogue.category.form.min_quantity.label',
            'required' => TRUE
        ));
        
        $builder->add('maxQuantity', 'integer', array(
            'label' => 'catalogue.category.form.max_quantity.label',
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
        
        $taxes = TaxQuery::create()
            ->filterByCountry($this->store->getCountryId())
            ->find();

        foreach ($taxes as $tax) {
            $tax_rates[$tax->getId()] = $tax->getName();
        }
        
        return $tax_rates;
    }

}
