<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseAffiliate;

class Affiliate extends BaseAffiliate
{
	public function isSuspended()
	{
		return $this->getSuspended();
	}
}
