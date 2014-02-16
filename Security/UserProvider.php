<?php

namespace Dzangocart\Bundle\CoreBundle\Security;

use FOS\UserBundle\Security\UserProvider as BaseUserProvider;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;

class UserProvider extends BaseUserProvider
{
    const ROLE_USER                 = 'ROLE_USER';
    const ROLE_STORE_ADMIN          = 'ROLE_STORE_ADMIN';
    const ROLE_STORE_SUPER_ADMIN    = 'ROLE_STORE_SUPER_ADMIN';
    const ROLE_ADMIN                = 'ROLE_ADMIN';

    /**
     * {@inheritDoc}
     */
    public function refreshUser(SecurityUserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException(sprintf('Expected an instance of %s, but got "%s".', $this->userManager->getClass(), get_class($user)));
        }

        if (null === $reloadedUser = $this->userManager->findUserBy(array('id' => $user->getId()))) {
            throw new UsernameNotFoundException(sprintf('User with ID "%d" could not be reloaded.', $user->getId()));
        }

        return $reloadedUser;
    }
}
