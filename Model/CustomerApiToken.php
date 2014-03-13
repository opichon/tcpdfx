<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

class CustomerApiToken extends ApiToken
{
    public function __construct()
    {
        parent::__construct();
        $this->setEntityType(ApiTokenPeer::CLASSKEY_3);
    }

    public function getEntity()
    {
        return CustomerQuery::create()
            ->findPk($this->getEntityId());
    }

    public function getUser()
    {
        return $this->getEntity()
            ->getProfile()
            ->getUser();
    }

}

