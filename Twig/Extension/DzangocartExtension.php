<?php

namespace Dzangocart\Bundle\CoreBundle\Twig\Extension;

use \Twig_Extension;
use \Twig_Function_Method;

use Symfony\Component\DependencyInjection\ContainerInterface;

class DzangocartExtension extends Twig_Extension 
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getName()
    {
        return 'dzangoacart';
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'app_version' => new Twig_Function_Method($this, 'getVersion', array('is_safe' => array('html'))),
            'oauth_auth_code_url' => new Twig_Function_method($this, 'getOAuthAuthCodeUrl', array('is_safe' => array('html')))
        );
    }

    /**
     * Returns the version number from bin/version.txt
     * TODO [OP 2013-08-01] This code stinks! There's got to be a better way to implement this.
     */
    public function getVersion()
    {
        return file_get_contents(
            dirname(__FILE__) . "/../../../../../../../../bin/version.txt"
        );
    }

    /**
     * Returns the url to the Oauth autho code endpoint for the store.
     */
    public function getOAuthAuthCodeUrl()
    {
        if (!$this->getStore()) {
            return NULL;
        }

        $user_settings = $this->getStore()
            ->getUserSettings();

        $search_value = array("%client_id%", "%client_secret%", "%redirect_uri%");

        $replace_value = array(
            $user_settings->getOauthClientId(),
            $user_settings->getOauthSecretKey(),
            $this->generateUrl('oauth')
        );

        $raw_oauth_auth_code_url =  $this->getStore()
            ->getUserSettings()
            ->getOauthAuthCodeEndpoint();

        return str_replace($search_value, $replace_value, $raw_oauth_auth_code_url);
    }

    protected function getStore()
    {
        return $this->container->get('dzangocart.store_finder')->getStore();
    }

    protected function generateUrl($route)
    {
        return $this->container->get('router')->generate($route);
    }
}
