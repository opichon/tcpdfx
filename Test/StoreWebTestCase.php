<?php

namespace Dzangocart\Bundle\CoreBundle\Test;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class StoreWebTestCase extends KernelTestCase
{
    protected $store;

    /**
     * Creates a Client.
     *
     * @param array $options An array of options to pass to the createKernel class
     * @param array $server  An array of server parameters
     *
     * @return Client A Client instance
     */
    protected function createClient(array $options = array(), array $server = array())
    {
        static::bootKernel($options);

        $container = static::$kernel->getContainer();

        $client = static::$kernel->getContainer()->get('test.client');

        $client->setServerParameters(
            array_merge(
                array(
                    'HTTP_HOST' => $this->store->getHostname($container->getParameter('dzangocart_host'))
                ),
                $server
            )
        );

        return $client;
    }

    protected function setUp()
    {
        static::bootKernel();

        $container = static::$kernel->getContainer();

        $this->store = StoreQuery::create()
            ->findPk($_ENV['STORE_ID']);

        if (!$this->store) {
            die('No store found for testing.');
        }
    }

    protected function getStore()
    {
        return $this->store;
    }
}
