<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Store;

use PHPUnit_Framework_TestCase;

use Dzangocart\Bundle\CoreBundle\Model\Store;

class AllowOrdersTest extends PHPUnit_Framework_TestCase
{
    protected $store;

    protected function setUp()
    {
        $this->store = new Store();
	    $this->store->setStatus(Store::STATUS_UNCONFIRMED);
    }

    public function testUnconfirmed()
    {
    	$this->assertFalse($this->store->allowOrders());
    }

    public function testConfirmed()
    {
    	$this->store->confirm();
    	$this->assertFalse($this->store->allowOrders());
    }

    public function testReady()
    {
	    $this->store->ready();
    	$this->assertFalse($this->store->allowOrders());
    }

    public function testActive()
    {
    	$this->store->activate();
    	$this->assertTrue($this->store->allowOrders());
    }

    public function testSuspended()
    {
	    $this->store->setStatus(Store::STATUS_SUSPENDED);
    	$this->assertFalse($this->store->allowOrders());
    }

    public function testDisabled()
    {
    	$this->store->setStatus(Store::STATUS_DISABLED);
    	$this->assertFalse($this->store->allowOrders());
    }

    public function testClosed()
    {
	    $this->store->setStatus(Store::STATUS_CLOSED);
    	$this->assertFalse($this->store->allowOrders());
    }
}