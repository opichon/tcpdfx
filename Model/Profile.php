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
}
