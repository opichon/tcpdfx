<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;

class UserSettingsType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Dzangocart\Bundle\CoreBundle\Model\StoreUserSettings',
        'name'       => 'storeUserSettings',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add( 'storeId' , 'choice' , array(
            'label'=>'Store Name',
            'choices' => $this->getStores(),
            'required' => true));
        
        $builder->add( 'userHandling' , 'checkbox' , array(
            'label' => 'User Handle',
            'required' => true)); 
        
        $builder->add( 'loginUrl' , 'text'  , array(
            'label' => 'Login Url',
            'required' => false));
        
        $builder->add( 'registerUrl' , 'text' , array(
            'label' => 'Register Url',
            'required' => false));
        
        $builder->add('autoRegister' , 'choice' , array(
            'label' => 'Auto Register',
             'choices' => array(0=>"No",1=>"Yes"),
            
            'required' => true));
        
        $builder->add( 'autoRegisterUrl' , 'text' , array(
            'label' => '',
            'required' => false));
        
        $builder->add( 'profileUrl', 'text' , array(
            'label' => 'Auto Register Url',
            'required' => false));
        
        $builder->add( 'passwordUrl', 'text' , array(
            'label' => 'Password Url',
            'required' => false));
        
        $builder->add( 'emailAsLogin', 'checkbox' , array(
            'label' => 'Email As Login',
            'required' => true));
        
        $builder->add( 'openId', 'checkbox' , array(
            'label' => 'Is Open',
            'required' => true));
    }
    
    protected function getStores()
    {
        $choices = array();
        $stores = StoreQuery::create()
            ->find();

        foreach ($stores as $store) {
            $choices[$store->getId()] = $store->getname();
        }

        return $choices;
    }        
}
