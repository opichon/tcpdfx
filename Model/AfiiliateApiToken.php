<?php

namespace Dzangocart\Bundle\CoreBundle\Model;


class AfiiliateApiToken extends ApiToken
{
    public function __construct()
    {
        parent::__construct();
        $this->setEntityType(ApiTokenPeer::CLASSKEY_2);
    }

}

