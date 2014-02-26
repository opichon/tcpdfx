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
}
