<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PromotionFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
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
            'required' => false
        ));

        $builder->add('dateFrom', 'date', array(
            'label' => 'promotion.form.date_from.label',
            'required' => false,
            'widget' => 'single_text',
        ));

        $builder->add('dateTo', 'date', array(
            'label' => 'promotion.form.date_to.label',
            'required' => false,
            'widget' => 'single_text',
        ));

        $builder->add('name', 'text', array(
            'label' => 'promotion.form.name.label',
            'required' => true
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'promotion.form.description.label',
            'required' => true
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'promotion.form.submit'
        ));
    }

    public function getName()
    {
        return "promotion";
    }

}
