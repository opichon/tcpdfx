<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseStore;

class Store extends BaseStore
{
    public function fixCatalogue()
    {
        CategoryPeer::fixLevels($this->getId());
    }

    public function getResolvedHostname($host)
    {
        return $this->getDomain() . '.' . $host;
    }

    public function isOwner(User $user)
    {
        return $this->getOwnerId() == $user->getId();
    }

    public function generateApiToken()
    {
        return rtrim(strtr(base64_encode($this->getRandomNumber()), '+/', '-_'), '=');
    }

    protected function getRandomNumber()
    {
        return hash('sha256', uniqid(mt_rand(), true), true);
    }

    public function getUserSettings()
    {
        return StoreUserSettingsQuery::create()
            ->filterByStoreId($this->getId())
            ->findOne();
    }

    public function getOAuthAuthorizationCodeURl($redirect_uri)
    {

        $user_settings = $this->getUserSettings();

        $search_value = array('%client_id%', '%client_secret%', '%redirect_uri%');

        $replace_value = array(
            $user_settings->getOauthClientId(),
            '',
            $redirect_uri
        );

        $endpoint =  $user_settings
            ->getOauthAuthCodeEndpoint();

        return str_replace($search_value, $replace_value, $endpoint);
    }

    public function getOAuthAccessTokenUrl($code, $redirect_uri)
    {
        $user_settings = $this->getUserSettings();

        $search_value = array('%client_id%', '%client_secret%', '%code', '%redirect_uri%');

        $replace_value = array(
            $user_settings->getOauthClientId(),
            $user_settings->getOauthSecretKey(),
            $code,
            $redirect_uri
        );

        $endpoint = $user_settings->getOauthAccessTokenEndpoint();

        return str_replace($search_value, $replace_value, $endpoint);
    }

    public function getOAuthUserProfileUrl($token)
    {
        $user_settings = $this->getUserSettings();

        $search_value = array('%token%');

        $replace_value = array($token);

        $endpoint = $user_settings->getOauthLoginEndpoint();

        return str_replace($search_value, $replace_value, $endpoint);
    }
}
