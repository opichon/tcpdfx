<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseUser;
use Dzangocart\Bundle\CoreBundle\Security\UserProvider;

use FOS\UserBundle\Model\UserInterface;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;


class User extends BaseUser implements UserInterface
{
    const STATUS_STORE_USER = 0;

    const STATUS_STORE_OWNER = 1;

    const STATUS_ADMIN = 9;

    /**
     * Plain password. Used when changing the password. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

    protected $roles = array();

    public function __construct()
    {
        parent::__construct();

        if ($this->isNew()) {
            $this->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
        }
    }

    public function getUsernameCanonical()
    {
        return $this->getUsername();
    }

    public function setUsernameCanonical($username)
    {
        // TODO
        return $this;
    }

    public function getEmail()
    {

    }

    public function setEmail($email)
    {
        return $this;
    }

    public function getEmailCanonical()
    {
        return $this->getEmail();
    }

    public function setEmailCanonical($email)
    {
        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function isEnabled()
    {
        return $this->getIsActive();
    }

    public function isSuperAdmin()
    {
        return $this->getIsSuperAdmin();
    }

    /**
     * {@inheritDoc}
     */
    public function isUser(UserInterface $user = null)
    {
        return null !== $user && $this->getId() === $user->getId();
    }

    public function setEnabled($boolean)
    {
        return $this->setIsActive($boolean);
    }

    public function setLocked($boolean)
    {
        return $this->setIsActive(!$boolean);
    }

    public function setSuperAdmin($boolean)
    {
        return $this->setIsSuperAdmin($boolean);
    }

    public function getConfirmationToken()
    {
        // TODO
    }

    public function setConfirmationToken($confirmationToken)
    {
        // TODO
    }

    public function setPasswordRequestedAt(\DateTime $date = null)
    {
        return $this;
    }

    public function isPasswordRequestNonExpired($ttl)
    {
        // TODO
        return false;
    }

    public function serialize()
    {
        return serialize(
            array(
                $this->id,
                $this->realm,
                $this->code,
                $this->username,
                $this->algorithm,
                $this->salt,
                $this->password,
                $this->created_at,
                $this->last_login,
                $this->is_active,
                $this->is_super_admin,
                $this->_new,
                $this->roles
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        list(
            $this->id,
            $this->realm,
            $this->code,
            $this->username,
            $this->algorithm,
            $this->salt,
            $this->password,
            $this->created_at,
            $this->last_login,
            $this->is_active,
            $this->is_super_admin,
            $this->_new,
            $this->roles
        ) = $data;
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /**
     * Returns the user roles
     *
     * Implements SecurityUserInterface
     *
     * @return array The roles
     */
    public function getRoles()
    {
        $roles = $this->roles;

        // we need to make sure to have at least one role
        $roles[] = static::ROLE_DEFAULT;

        if ($this->isOwner()) {
            $roles[] = UserProvider::ROLE_STORE_ADMIN;
        }

        return array_unique($roles);
    }

    /**
     * Adds a role to the user.
     *
     * @param string $role
     *
     * @return User
     */
    public function addRole($role)
    {
        $this->roles[] = $role;

        return $this;
    }

    public function hasRole($role)
    {
        return array_key_exists($role, $this->roles);
    }

    public function removeRole($value)
    {
        if ($this->hasRole($role)) {
            unset($this->roles[$role]);
        }

        return $this;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isAccountNonLocked()
    {
        return $this->getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired()
    {
        // FIXME
        return true;
    }

    public function isAdmin()
    {
        return null === $this->getRealm();
    }

    public function isOwner()
    {
        $query = StoreQuery::create()
            ->filterByOwner($this);

        return $query->count() > 0;
    }

    public function getProfile()
    {
        $profile = $this->getProfiles()->getFirst();

        if (!$profile) {
            $profile = new Profile();
            $profile->setUser($this);
        }

        return $profile;
    }

    public function getLoggedIn($context)
    {
        $token = new UsernamePasswordToken($this, NULL, "main", $this->getRoles());

        return $context->setToken($token);
    }

}
