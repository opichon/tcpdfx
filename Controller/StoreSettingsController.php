<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Model\StoreQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class StoreSettingsController extends BaseController
{
    /**
     * @Route("/settings/identity", name="store_settings_identity")
     * @Template("DzangocartCoreBundle:StoreSettings:identity.html.twig")
     */
    public function identityAction(Request $request)
    {
        return array(
            'store' => $this->getStore()
        );
    }

    /**
     * @Route("/settings/gateways", name="store_settings_gateways")
     * @Template("DzangocartCoreBundle:StoreSettings:gateways.html.twig")
     */
    public function gatewaysAction(Request $request)
    {
        return array(
            'store' => $this->getStore()
        );
    }

    /**
     * @Route("/settings/presentation", name="store_settings_presentation")
     * @Template("DzangocartCoreBundle:StoreSettings:presentation.html.twig")
     */
    public function presentationAction(Request $request)
    {
        return array(
            'store' => $this->getStore()
        );
    }

    /**
     * @Route("/settings/user", name="store_settings_user")
     * @Template("DzangocartCoreBundle:StoreSettings:user.html.twig")
     */
    public function userAction(Request $request)
    {
        return array(
            'store' => $this->getStore()
        );
    }
}
