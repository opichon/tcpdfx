<?php

namespace Dzangocart\Bundle\CoreBundle\Security\Authorization\Voter;

use Dzangocart\Bundle\CoreBundle\Security\UserProvider;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class AdminVoter extends ContainerAware implements VoterInterface
{
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    public function supportsAttribute($attribute)
    {
        return null !== $attribute && UserProvider::ROLE_ADMIN === $attribute;
    }

    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken' == $class;
    }

    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $result = VoterInterface::ACCESS_ABSTAIN;

        if ($this->supportsClass(get_class($token))) {

            foreach ($attributes as $attribute) {
                if (!$this->supportsAttribute($attribute)) {
                    continue;
                }

                $result = VoterInterface::ACCESS_DENIED;

                $user = $token->getUser();

                if (null == $user->getRealm()) {
                    $result = VoterInterface::ACCESS_GRANTED;
                }
            }
        }

        return $result;
    }
}
