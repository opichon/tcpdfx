<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
	public function getStore()
	{
		if ($this->container->has('dzangocart.store_finder')) {
			return $this->container->get('dzangocart.store_finder')->getStore();
		}
	}

    protected function getBaseTemplate()
    {
        return 'DzangocartCoreBundle::layout.html.twig';
    }
}
