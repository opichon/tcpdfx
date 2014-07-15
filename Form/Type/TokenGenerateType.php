<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TokenGenerateType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'settings',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('submit', 'submit', array('label'=>'settings.token.button.label'));
    }

    public function getName()
    {
        return "token";
    }
}
