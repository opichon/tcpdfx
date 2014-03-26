<?php

namespace Dzangocart\Bundle\CoreBundle\Security;

interface ApiKeyUserProviderInterface
{
	public getUserForApiKey($key);
}
