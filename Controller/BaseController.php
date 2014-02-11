<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected $store;
    
    public function getStore()
    {
        return StoreQuery::create()->findPk(5);
    }
}
