<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Store;

use PHPUnit_Framework_TestCase;

use Dzangocart\Bundle\CoreBundle\Model\AffiliateQuery;
use Dzangocart\Bundle\CoreBundle\Model\Store;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GetAffiliateTest extends KernelTestCase
{
    protected $store;

    public function setUp()
    {
        self::bootKernel();

        $this->store = new Store();
    }

    public function testGetAffiliateFromNullId()
    {
        $this->assertNull($this->store->getAffiliate(false, true));
        $this->assertNull($this->store->getAffiliate(false, false));
    }

    public function testGetAffiliate()
    {
        $affiliates = AffiliateQuery::create()
            ->find();

        foreach ($affiliates as $affiliate) {
            $store = $affiliate->getStore();

            $this->assertEquals($affiliate, $store->getAffiliate($affiliate->getId(), true));

            if ($affiliate->isSuspended()) {
                $this->assertNull($store->getAffiliate($affiliate->getId(), false));
                $this->assertEquals($store->getAffiliate($affiliate->getId(), true));
            } else {
                $this->assertEquals($affiliate, $store->getAffiliate($affiliate->getId(), false));
                $this->assertEquals($affiliate, $store->getAffiliate($affiliate->getId(), true));
            }
        }
    }
}
