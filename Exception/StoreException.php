<?php

namespace Dzangocart\Bundle\CoreBundle\Exception;

use RuntimeException;

use Dzangocart\Bundle\CoreBundle\Exception\DzangocartExceptionInterface;
use Dzangocart\Bundle\CoreBundle\Model\Store;

abstract class StoreException extends RuntimeException implements DzangocartExceptionInterface
{
	protected $store;

	public function __construct($message = null, $code = 0, Exception $previous = null, Store $store)
	{
		parent::__construct($message, $code, $previous);

		$this->store = $store;
	}
}