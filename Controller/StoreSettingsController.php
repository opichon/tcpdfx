<?php

namespace Dzangocart\Bundle\CoreBundle\Controller;

use Dzangocart\Bundle\CoreBundle\Form\Type\StoreOAuthSttingsType;
use Dzangocart\Bundle\CoreBundle\Form\Type\StoreUserSettingsType;
use Dzangocart\Bundle\CoreBundle\Form\Type\TokenGenerateType;
use Dzangocart\Bundle\CoreBundle\Model\ApiToken;
use Dzangocart\Bundle\CoreBundle\Model\ApiTokenQuery;
use Dzangocart\Bundle\CoreBundle\Model\StoreOAuthSettings;
use Dzangocart\Bundle\CoreBundle\Model\StoreOAuthSettingsQuery;
use Dzangocart\Bundle\CoreBundle\Model\StoreUserSettingsQuery;

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
       $query = StoreUserSettingsQuery::create();

        if ($store = $this->getStore()) {
            $query->filterByStore($store);

        } elseif ($store_id = $request->query->get('id')) {
            $query->filterByStoreId($store_id);
        }

        $user_settings = $query->findOne();

        if (!$user_settings) {
            throw $this->createNotFoundException(
                $this->get('translator')->trans('settings.user.edit.error.not_found', array(), 'settings', $request->getLocale())
            );
        }

       $form = $this->createForm(
            new StoreUserSettingsType(),
            $user_settings,
            array(
                'action' => $this->generateUrl('store_settings_user')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

            $user_settings->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'settings.user.edit.success',
                    array(),
                    'settings',
                    $request->getLocale()
                )
            );

            return $this->redirect($this->generateUrl('store_settings_user'));
        }

        return array(
            'form' => $form->createView(),
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

    /**
     * @Route("/settings/oauth", name="store_settings_oauth")
     * @Template("DzangocartCoreBundle:StoreSettings:oauth.html.twig")
     */
    public function oauthAction(Request $request)
    {

        $oauthh_settings = StoreOAuthSettingsQuery::create()
            ->filterByStore($this->getStore())
            ->findOne();

        if (!$oauthh_settings) {
            $oauthh_settings = new StoreOAuthSettings();

            $oauthh_settings->setId($this->getStore()->getId());
        }

       $form = $this->createForm(
            new StoreOAuthSttingsType(),
            $oauthh_settings,
            array(
                'action' => $this->generateUrl('store_settings_oauth')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {

            $oauthh_settings->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'settings.oauth.create.success',
                    array(),
                    'settings',
                    $request->getLocale()
                )
            );

            return $this->redirect($this->generateUrl('store_settings_oauth'));
        }

        return array(
            'form' => $form->createView(),
            'store' => $this->getStore()
        );
    }
}
