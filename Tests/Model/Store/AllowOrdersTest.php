<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Store;

use PHPUnit_Framework_TestCase;

use Dzangocart\Bundle\CoreBundle\Model\Store;

class AllowOrdersTest extends PHPUnit_Framework_TestCase
{
    protected $store;

    protected function setUp()
    {
        $this->store = $this->getMockBuilder('Dzangocart\Bundle\CoreBundle\Model\Store')
            ->setMethods(array('isConfirmed', 'isSuspended', 'isClosed'))
            ->getMock();
    }

    public function testUnconfirmed()
    {
        $this->store
            ->expects($this->any())
            ->method('isConfirmed')
            ->will($this->returnValue(false));

    	$this->assertFalse($this->store->allowOrders());
    }

    public function testSuspended()
    {
        $this->store
            ->expects($this->any())
            ->method('isSuspended')
            ->will($this->returnValue(true));

        $this->assertFalse($this->store->allowOrders());
    }

    public function testClosed()
    {
        $this->store
            ->expects($this->any())
            ->method('isClosed')
            ->will($this->returnValue(true));

        $this->assertFalse($this->store->allowOrders());
    }

    public function testAllowOrders()
    {
        $this->store
            ->expects($this->any())
            ->method('isConfirmed')
            ->will($this->returnValue(true));

        $this->store
            ->expects($this->any())
            ->method('isSuspended')
            ->will($this->returnValue(false));

        $this->store
            ->expects($this->any())
            ->method('isClosed')
            ->will($this->returnValue(false));

    	$this->assertTrue($this->store->allowOrders());
    }
}
