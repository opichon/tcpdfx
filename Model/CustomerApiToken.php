<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

class CustomerApiToken extends ApiToken
{
    public function __construct()
    {
        parent::__construct();
        $this->setEntityType(ApiTokenPeer::CLASSKEY_3);
    }

}

