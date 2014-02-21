<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\Promotion\PromotionQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromotionEditType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'promotion_edit',
            'translation_domain' => 'promotion',
            'show_legend' => false
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('code', 'text', array(
            'label'=>'promotion.form.code.label',
            'required' => true
        ));

        $builder->add('dateFrom', 'date', array(
            'label' => 'promotion.form.date_from.label',
            'required' => true,
            'widget' => 'single_text',
        ));

        $builder->add('dateTo', 'date', array(
            'label' => 'promotion.form.date_to.label',
            'required' => false,
            'widget' => 'single_text',
        ));

        $builder->add('name', 'text', array(
            'label' => 'promotion.form.name.label',
            'required' => false
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'promotion.form.description.label',
            'required' => true
        ));
        
        $builder->add('Save', 'submit');
    }
    
    public function getName()
    {
        return "promotion_edit";
    }

}
