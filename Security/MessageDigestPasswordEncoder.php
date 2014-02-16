<?php

namespace Dzangocart\Bundle\CoreBundle\Security;

use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder as BaseEncoder;

class MessageDigestPasswordEncoder extends BaseEncoder
{
    protected function demergePasswordAndSalt($mergedPasswordSalt)
    {
        if (empty($mergedPasswordSalt)) {
            return array('', '');
        }

        $salt = $salt = substr($mergedPasswordSalt, 32, -1);

        $password = substr($mergedPasswordSalt, 0, 32);

        return array($password, $salt);
    }

    protected function mergePasswordAndSalt($password, $salt)
    {
        if (empty($salt)) {
            return $password;
        }

        if (false !== strrpos($salt, '{') || false !== strrpos($salt, '}')) {
            throw new \InvalidArgumentException('Cannot use { or } in salt.');
        }

        return $password . $salt;
    }

    /**
     * {@inheritdoc}
     */
    public function isPasswordValid($encoded, $raw, $salt)
    {
        return !$this->isPasswordTooLong($raw) && $this->comparePasswords($encoded, $this->encodePassword($raw, $salt));
    }
}
