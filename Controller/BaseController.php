<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected $store;

    public function getStore()
    {
        if (!$this->store) {
            $this->store = $this->container->get('dzangocart.store_finder')->getStore();
        }

        return $this->store;
    }
}
