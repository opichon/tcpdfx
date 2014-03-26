<?php

namespace Dzangocart\Bundle\CoreBundle\Security;

interface ApiKeyUserProviderInterface
{
	public function getUserForApiKey($key);
}
