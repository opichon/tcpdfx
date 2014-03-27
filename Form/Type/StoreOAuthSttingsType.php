<?php

namespace Dzangocart\Bundle\CoreBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StoreOAuthSttingsType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'oauth_settings',
            'translation_domain' => 'settings',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('clientId', 'text', array(
            'label' => 'settings.oauth.client_id.label',
            'required' => TRUE,
        ));

        $builder->add('secretKey', 'text', array(
            'label' => 'settings.oauth.secret_key.label',
            'required' => TRUE,
        ));

        $builder->add('authCodeUrl', 'text', array(
            'label' => 'settings.oauth.auth_code_url.label',
            'required' => TRUE
        ));

        $builder->add('accessTokenUrl', 'text', array(
            'label' => 'settings.oauth.access_token_url.label',
            'required' => TRUE
        ));

        $builder->add('Save', 'submit');
    }

    public function getName()
    {
        return "oauth_settings";
    }

}
