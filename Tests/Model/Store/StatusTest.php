<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Store;

use PHPUnit_Framework_TestCase;

use Dzangocart\Bundle\CoreBundle\Model\Store;

class StatusTest extends PHPUnit_Framework_TestCase
{
	protected $store;

	protected function setUp()
	{
		$store = $this->getMockBuilder('Dzangocart\Bundle\CoreBundle\Model\Store')
			->setMethods(array('countActiveProdGateways'))
			->getMock();

		$store
			->expects($this->any())
			->method('countActiveProdGateways')
			->will($this->returnValue(1));

		$store->setStatus(Store::STATUS_UNCONFIRMED);

		$this->store = $store;
	}

	public function testUnconfirmed()
	{
		$this->assertFalse($this->store->isConfirmed(), 'unconfirmed');
		$this->assertFalse($this->store->isReady(), 'not ready');
		$this->assertFalse($this->store->isActive(), 'not active');
		$this->assertFalse($this->store->isDisabled(), 'not disabled');
		$this->assertFalse($this->store->isSuspended(), 'not suspended');
		$this->assertFalse($this->store->isClosed(), 'not closed');
	}

    public function testConfirmed()
    {
    	$this->store->confirm();

		$this->assertTrue($this->store->isConfirmed(), 'confirmed');
		$this->assertFalse($this->store->isReady(), 'not ready');
		$this->assertFalse($this->store->isActive(), 'not active');
		$this->assertFalse($this->store->isDisabled(), 'not disabled');
		$this->assertFalse($this->store->isSuspended(), 'not suspended');
		$this->assertFalse($this->store->isClosed(), 'not closed');
    }

    public function testReadyExpired()
    {
	    $this->store->setExpiresAt(date_create()->modify('-1 year'));
    	$this->store->confirm();
    	$this->store->ready();

    	$this->assertTrue($this->store->isExpired(), 'expired');
		$this->assertTrue($this->store->isConfirmed(), 'confirmed');
		$this->assertFalse($this->store->isReady(), 'not ready');
		$this->assertFalse($this->store->isActive(), 'not active');
		$this->assertFalse($this->store->isDisabled(), 'not disabled');
		$this->assertFalse($this->store->isSuspended(), 'not suspended');
		$this->assertFalse($this->store->isClosed(), 'not closed');
    }

    public function testReadyFixedExpiration()
    {
	    $this->store->setExpiresAt(date_create()->modify('+1 year'));
    	$this->store->confirm();
    	$this->store->ready();

    	$this->assertFalse($this->store->isExpired(), 'not expired');
		$this->assertTrue($this->store->isConfirmed(), 'confirmed');
		$this->assertTrue($this->store->isReady(), 'ready');
		$this->assertFalse($this->store->isActive(), 'not active');
		$this->assertFalse($this->store->isDisabled(), 'not disabled');
		$this->assertFalse($this->store->isSuspended(), 'not suspended');
		$this->assertFalse($this->store->isClosed(), 'not closed');
    }

    public function testReadyNoExpiration()
    {
	    $this->store->setExpiresAt(null);
    	$this->store->confirm();
    	$this->store->ready();

    	$this->assertNull($this->store->getExpiresAt('U'));
    	$this->assertFalse($this->store->isExpired(), 'not expired');
		$this->assertTrue($this->store->isConfirmed(), 'confirmed');
		$this->assertTrue($this->store->isReady(), 'ready');
		$this->assertFalse($this->store->isActive(), 'not active');
		$this->assertFalse($this->store->isDisabled(), 'not disabled');
		$this->assertFalse($this->store->isSuspended(), 'not suspended');
		$this->assertFalse($this->store->isClosed(), 'not closed');
    }

    public function testActive()
    {
	    $this->store->setExpiresAt(date_create()->modify('+1 year'));
    	$this->store->confirm();
    	$this->store->ready();
    	$this->store->activate();

		$this->assertTrue($this->store->isConfirmed(), 'confirmed');
		$this->assertTrue($this->store->isReady(), 'ready');
		$this->assertTrue($this->store->isActive(), 'active');
		$this->assertFalse($this->store->isDisabled(), 'not disabled');
		$this->assertFalse($this->store->isSuspended(), 'not suspended');
		$this->assertFalse($this->store->isClosed(), 'not closed');
    }
}
