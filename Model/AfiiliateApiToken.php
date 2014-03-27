<?php

namespace Dzangocart\Bundle\CoreBundle\Model;


class AfiiliateApiToken extends ApiToken
{
    public function __construct()
    {
        parent::__construct();
        $this->setEntityType(ApiTokenPeer::CLASSKEY_2);
    }

    public function getEntity()
    {
        //TODO
        return NULL;
    }

    public function getUser()
    {
        //TODO
        return NULL;
    }
}
