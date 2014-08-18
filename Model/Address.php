<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseAddress;

class Address extends BaseAddress {

    public function preInsert(ConnectionInterface $con = null) {
	$this->setCreatedAt(time());
	return true;
    }

}
