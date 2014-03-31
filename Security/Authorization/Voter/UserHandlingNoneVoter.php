<?php

namespace Dzangocart\Bundle\CoreBundle\Security\Authorization\Voter;

use Dzangocart\Bundle\CoreBundle\Model\StoreUserSettings;
use Dzangocart\Bundle\CoreBundle\Security\UserProvider;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class UserHandlingNoneVoter extends ContainerAware implements VoterInterface
{
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function supportsAttribute($attribute)
    {
        return null !== $attribute && UserProvider::ROLE_USER === $attribute;
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken' == $class;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {

        $result = VoterInterface::ACCESS_ABSTAIN;

        if (!$this->supportsClass(get_class($token))) {
            return $result;
        }

        $store = $this->getStore();

        if (!$store) {
            return $result;
        }

        $user_handling = $store->getUserSettings()->getUserHandling();

        if (!$user_handling == StoreUserSettings::USER_HANDLING_NONE) {
            return $result;
        }

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

            $result = VoterInterface::ACCESS_DENIED;

            $user = $token->getUser();

            if ($store->isOwner($user)) {

                $security_context = $this->container->get('security.context');

                $user->setRoles(
                    array(UserProvider::ROLE_STORE_ADMIN
                ));

                $new_token = new UsernamePasswordToken($user, $token->getCredentials(), 'main', $user->getRoles());

                $security_context->setToken($new_token);

                $result = VoterInterface::ACCESS_GRANTED;
            }
        }

        return $result;

    }

    protected function getStore()
    {
        if (!$this->container->isScopeActive('request')) {
            return;
        }

        if (!$this->container->has('dzangocart.store_finder')) {
            return;
        }

        return $this->container->get('dzangocart.store_finder')->getStore();
    }
}
