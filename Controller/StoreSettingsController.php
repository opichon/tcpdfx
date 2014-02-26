<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\TokenGenerateType;
use Dzangocart\Bundle\CoreBundle\Model\ApiToken;
use Dzangocart\Bundle\CoreBundle\Model\ApiTokenQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

abstract class StoreSettingsController extends BaseController
{
    /**
     * @Route("/settings", name="store_settings_identity")
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

    /**
     *@Route("/settings/token", name="api_token")
     *@Template("DzangocartCoreBundle:StoreSettings:token.html.twig")
     */
    public function apiAction(Request $request)
    {
       $tokens = ApiTokenQuery::create()
           ->filterByStore($this->getStore())
           ->find();

       $apiToken = new ApiToken();

       $apiToken->setStore($this->getStore());

       $apiToken->setToken($this->getStore()->generateApiToken());

       $form = $this->createForm(
            new TokenGenerateType(),
            $apiToken,
            array(
                'action' => $this->generateUrl('api_token')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

            $apiToken->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'settings.token.create.success',
                    array(),
                    'settings',
                    $request->getLocale()
                )
            );

            return $this->redirect($this->generateUrl('api_token'));
        }

        return array(
            'form' => $form->createView(),
            'tokens' => $tokens,
            'store' => $this->getStore()
        );
    }

    /**
     * @Route("/settings/token/{id}/delete", name="api_token_delete")
     * @Template()
     */
    public function apiTokenDeleteAction(Request $request, $id)
    {
        $token = ApiTokenQuery::create()
            ->findPk($id);

        if (!$token) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('settings.token.delete.error.not_found', array(), 'settings', $request->getLocale())
            );
        }

       $token->delete();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans(
                'settings.token.delete.success',
                array(),
                'settings',
                $request->getLocale()
        ));

        return $this->redirect($this->generateUrl('api_token'));
    }
}
