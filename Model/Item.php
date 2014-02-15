<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseItem;

class Item extends BaseItem
{
	public function getOrder()
	{
		return $this->getCart();
	}
}
