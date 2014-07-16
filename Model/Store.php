<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\GatewayQuery;
use Dzangocart\Bundle\CoreBundle\Model\om\BaseStore;

class Store extends BaseStore
{
    const STATUS_UNCONFIRMED = 0; // Domain has been reserved
    const STATUS_CONFIRMED   = 1; // Domain has been confirmed
    const STATUS_READY       = 2; // At least 1 prod gateway is setup and subscription is paid
    const STATUS_ACTIVE      = 4; // Store has been activated by user
    const STATUS_SUSPENDED   = 8; // Store has been suspended by dzangocart admin
    const STATUS_CLOSED      = 16; // Store has been closed by owner
    const STATUS_DISABLED    = 32; // Store has been disabled by owner

    /**
     * @deprecated
     * Use gethostname instead
     */
    public function getResolvedHostname($host)
    {
        return $this->getDomain() . '.' . $host;
    }

    public function isConfirmed()
    {
        return ($this->getStatus() & self::STATUS_CONFIRMED) ? true : false;
    }

    public function confirm()
    {
        //$this->setup();
        $this->setStatus($this->getStatus() | self::STATUS_CONFIRMED);
    }

    public function isReady()
    {
        return ($this->isConfirmed() && $this->getStatus() & self::STATUS_READY) ? true : false;
    }

    public function ready()
    {
        if (!$this->isConfirmed() || $this->isExpired()) {
            return;
        }

        if (!$this->countActiveProdGateways()) {
            return;
        }

        $this->setStatus($this->getStatus() | self::STATUS_READY);
    }

    public function unready()
    {
        if (!$this->isReady()) {
            return;
        }

        if ($this->countActiveProdGateways()) {
            return;
        }

        $this->setStatus($this->getStatus() & ~self::STATUS_READY);

        $this->disable();
    }

    public function isActive()
    {
        return !$this->isDisabled()
            && !$this->isClosed()
            && !$this->isSuspended()
            && $this->isReady()
            && ($this->getStatus() & self::STATUS_ACTIVE);
    }

    /*
     * Whether the store has been disabled by the owner.
     * Warning:This is not quite the opposite of getActive!
     */
    public function isDisabled()
    {
        return ($this->getStatus() & self::STATUS_DISABLED) ? true : false;
    }

    public function disable()
    {
        $this->setStatus($this->getStatus() | self::STATUS_DISABLED);
    }

    public function activate()
    {
        if ($this->isDisabled()
            || $this->isClosed()
            || $this->isSuspended()
            || !$this->isReady()) {
            return;
        }
        $this->setStatus($this->getStatus() | self::STATUS_ACTIVE);
    }

    public function reactivate()
    {
        $this->setStatus($this->getStatus() & ~self::STATUS_DISABLED);
    }

    public function isSuspended()
    {
        return ($this->getStatus() & self::STATUS_SUSPENDED) ? true : false;
    }

    public function suspend()
    {
        $this->setStatus($this->getStatus() | self::STATUS_SUSPENDED);
        $this->disable();
    }

    public function unsuspend()
    {
        $this->setStatus($this->getStatus() & ~self::STATUS_SUSPENDED);
    }

    public function isClosed()
    {
        return ($this->getStatus() & self::STATUS_CLOSED) ? true : false;
    }

    public function close()
    {
        if ($this->isActive()) {
            return;
        }

        $this->setStatus($this->getStatus() | self::STATUS_CLOSED);
    }

    public function reopen()
    {
        $this->setStatus($this->getStatus() & ~self::STATUS_CLOSED);
    }

    public function allowOrders()
    {
        return ($this->isConfirmed()
            && !$this->isClosed()
            && !$this->isSuspended()) ? true : false;
    }

    public function isOwner(User $user)
    {
        return $this->getOwnerId() == $user->getId();
    }

    public function getAffiliate($id, $include_suspended = false)
    {
        return AffiliateQuery::create()
            ->filterByStore($this)
            ->_if(!$include_suspended)
                ->filterBySuspended(false)
            ->_endif()
            ->findPk($id);
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

    public function getOAuthAuthCodeUrl($redirect_uri)
    {

        $user_settings = $this->getUserSettings();

        $search_value = array('%client_id%', '%redirect_uri%');

        $replace_value = array(
            $user_settings->getOauthClientId(),
            $redirect_uri
        );

        $endpoint = $user_settings
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

    public function getOauthLoginUrl($token)
    {
        $user_settings = $this->getUserSettings();

        $search_value = array('%token%');

        $replace_value = array($token);

        $endpoint = $user_settings->getOauthLoginEndpoint();

        return str_replace($search_value, $replace_value, $endpoint);
    }

    public function fixCatalogue()
    {
        CategoryPeer::fixLevels($this->getId());
    }

    public function countActiveGateways()
    {
        return GatewayQuery::create()
            ->filterByStatus(gateway::STATUS_ACTIVE, Criteria::GREATER_THAN)
            ->filterByTesting(false)
            ->count();
    }
}
