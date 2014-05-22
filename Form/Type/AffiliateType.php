<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AffiliateType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'affiliate_type',
            'translation_domain' => 'affiliate',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label'=>'affiliate.form.name.label',
            'required' => FALSE
        ));

        $builder->add('website', 'text', array(
            'label' => 'affiliate.form.website.label',
            'required' => FALSE,
        ));

        $builder->add('Save', 'submit');
    }

    public function getName()
    {
        return "affiliate_type";
    }

}
