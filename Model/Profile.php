<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseProfile;

use UAM\Bundle\UserBundle\Model\Profile as ProfileInterface;

class Profile extends BaseProfile implements ProfileInterface
{
    public function getEmail()
    {
        if (!parent::getEmail() and $this->getUser()) {
              $email = $this->getUser()->getEmail();
        } else {
              $email = parent::getEmail();
        }

        return $email;
    }

    public function init(array $options)
    {
    }

    public function getFullName($reverse = false)
    {
        $surname = $this->getSurname() ?: '?';
        $given_names =  $this->getGivenNames();
        $email = $this->getEmail();

        if (empty($given_names)) {
            $pattern = empty($email) ? '%1$s' : '%1$s [%3$s]';
        } else {
            $pattern = $reverse ? '%1$s, %2$s' : '%2$s %1$s';

            if (!empty($email)) {
                $pattern .= ' [%3$s]';
            }
        }

        return sprintf(
            $pattern,
            $surname,
            $given_names,
            $email
        );
    }
}
