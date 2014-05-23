<?php

namespace Dzangocart\Bundle\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;

use Symfony\Component\DependencyInjection\ContainerAware;

class UserMenuBuilder extends ContainerAware
{
    public function topMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $context = $this->container->get('security.context');

        if ($context->isGranted('ROLE_USER')) {

            $user = $context->getToken()->getUser();

            $user_name = $user->getProfile()->getGivenNames();

            if (!$user_name) {
                $user_name = $user->getUsername();
            }

            $welcome = $menu->addChild(
                'user_menu.user.welcome',
                array(
                    'label' => 'user_menu.user.welcome'
                )
            )
            ->setLabelAttribute('class', 'navbar-text')
            ->setExtra('translation_domain', 'user_menu')
            ->setExtra('translation_params', array(
                '%user%' => $user_name
            ));

            $menu->addChild(
                'user_menu.user.profile',
                array('route' => 'fos_user_profile_show')
            )
            ->setExtra('translation_domain', 'user_menu');

            $menu->addChild(
                'user_menu.user.logout',
                array('route' => 'fos_user_security_logout')
            )
            ->setExtra('translation_domain', 'user_menu');

        }

        return $menu;
    }

}
