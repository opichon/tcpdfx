<?php

namespace Dzangocart\Bundle\CoreBundle\Exception;

use Exception;

use Dzangocart\Bundle\CoreBundle\Model\Store;

abstract class StoreException extends RuntimeException implements DzangocartException
{
	protected $store;

	public function __construct($message = null, $code = 0, Exception $previous = null, Store $store)
	{
		parent::__construct($message, $code, $previous);

		$this->store = $store;
	}
}