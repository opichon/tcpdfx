<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseGateway;

class Gateway extends BaseGateway
{
    public function getname()
    {
        return $this->getGatewayService()->getName();
    }
}
