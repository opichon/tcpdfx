<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseApiToken;

abstract class ApiToken extends BaseApiToken
{
    abstract public function getEntity();

    abstract public function getUser();

}