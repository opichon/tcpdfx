<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected $store;
    
    public function getStore()
    {
        return $this->container->get('dzangocart.store_listener')->getStore();
    }
}
