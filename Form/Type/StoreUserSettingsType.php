<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoreUserSettingsType extends BaseAbstractType
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

        $builder->add('UserHandling' , 'choice' , array(
            'label' => 'settings.user.handlings.label',
            'choices' => array( '0' => 'settings.user.authenticate.none.label', '1' => 'settings.user.authenticate.store.label', '2' => 'settings.user.authenticate.site.label' ),
            'required' => true
        ));

//        used later !
//
//        $builder->add( 'loginUrl' , 'text'  , array(
//            'label' => 'Login Url',
//            'required' => false));
//
//        $builder->add( 'registerUrl' , 'text' , array(
//            'label' => 'Register Url',
//            'required' => false));
//
//        $builder->add('autoRegister' , 'choice' , array(
//            'label' => 'Auto Register',
//             'choices' => array(0=>"No",1=>"Yes"),
//
//            'required' => true));
//
//        $builder->add( 'autoRegisterUrl' , 'text' , array(
//            'label' => '',
//            'required' => false));
//
//        $builder->add( 'profileUrl', 'text' , array(
//            'label' => 'Auto Register Url',
//            'required' => false));
//
//        $builder->add( 'passwordUrl', 'text' , array(
//            'label' => 'Password Url',
//            'required' => false));
//
//        $builder->add( 'emailAsLogin', 'checkbox' , array(
//            'label' => 'Email As Login',
//            'required' => true));
//
//        $builder->add( 'openId', 'checkbox' , array(
//            'label' => 'Is Open',
//            'required' => true));

         $builder->add('submit', 'submit', array('label'=>'settings.user.form.button.label'));
    }

    public function getName()
    {
        return "store_user_settings";
    }
}
