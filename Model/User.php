<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseUser;

use FOS\UserBundle\Model\UserInterface;

class User extends BaseUser implements UserInterface
{
    /**
     * Plain password. Used when changing the password. Must not be persisted.
     *
     * @var string
     */
    protected $plainPassword;

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
    }

    public function getEmail()
    {

    }

    public function setEmail($email)
    {

    }

    public function gerEmailCanonical()
    {
    	return $this->getEmail();
    }

    public function setEmailCanonical($email)
    {

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

	public function seSuperAdin($boolean)
	{
		return $this->setIsSuperAdmin($boolean);
	}

    public function getConfirmationToken(){
    	// TODO
    }

    public function setConfirmationToken($confirmationToken)
    {
    	// TODO
    }

	public function isPasswordRequestNonExpired($ttl)
	{
		// TODO
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
                $this->_new
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
            $this->_new
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
    	// FIXME
        return array();
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
    	// FIXME
        return $this;
    }

    public function hasRole($value)
    {
    	// FIXME
        return false;
    }

    public function removeRole($value)
    {
    	// FIXME
    }

    public function setRoles(array $v)
    {
    	// FIXME
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
        return !$this->getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function isCredentialsNonExpired()
    {
        if (true === $this->getCredentialsExpired()) {
            return false;
        }

        if (null !== $this->getCredentialsExpireAt() && $this->getCredentialsExpireAt()->getTimestamp() < time()) {
            return false;
        }

        return true;
    }
}
