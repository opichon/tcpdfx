<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseCustomer;

class Customer extends BaseCustomer
{
	public function getUser()
	{
		return $this
			->getUserProfile()
			->getUser();
	}

	public function getName()
	{
		return $this
			->getUserProfile()
			->getFullName(true);
	}
}
