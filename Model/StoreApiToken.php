<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

class StoreApiToken extends ApiToken
{
    public function __construct()
    {
        parent::__construct();
        $this->setEntityType(ApiTokenPeer::CLASSKEY_1);
    }

}

