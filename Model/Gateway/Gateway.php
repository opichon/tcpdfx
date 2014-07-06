<?php

namespace Dzangocart\Bundle\CoreBundle\Model\Gateway;

use Dzangocart\Bundle\CoreBundle\Model\Gateway\om\BaseGateway;

class Gateway extends BaseGateway
{
    const STATUS_PENDING = 0;
	const STATUS_READY = 1;
  	const STATUS_ACTIVE = 3;

    public function getName()
    {
        return $this->getService()->getName();
    }

    public function isTesting()
    {
    	return $this->getTesting();
    }
}
