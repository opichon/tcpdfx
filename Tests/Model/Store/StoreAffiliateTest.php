<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Store;

use PHPUnit_Framework_TestCase;

use Dzangocart\Bundle\CoreBundle\Model\Store;

class StoreAffiliateTest extends PHPUnit_Framework_TestCase
{
    protected $store;

    public function setUp()
    {
        $this->store = new Store();
    }

    public function testGetAffiliateFromNullId()
    {
        $this->assertFalse($this->store->getAffiliate(null, true));
        this->assertFalse($this->store->getAffiliate(null, false)));
    }
}
