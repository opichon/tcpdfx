<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class UserSettingsType extends BaseAbstractType
{
    protected $options = array(
        'data_class' => 'Dzangocart\Bundle\CoreBundle\Model\UserSettings',
        'name'       => 'usersettings',
    );

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('storeId');
        $builder->add('userHandling');
        $builder->add('loginUrl');
        $builder->add('registerUrl');
        $builder->add('autoRegister');
        $builder->add('autoRegisterUrl');
        $builder->add('profileUrl');
        $builder->add('passwordUrl');
        $builder->add('emailAsLogin');
        $builder->add('openId');
    }
}
