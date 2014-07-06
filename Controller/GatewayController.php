<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/gateway")
 */
class GatewayController extends BaseController
{
    /**
     * @Route("/", name="gateways")
     * @Template("DzangocartCoreBundle:Gateway:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        return array(
            'store' => $this->getStore(),
            'template' => $this->getBaseTemplate()
        );
    }
}