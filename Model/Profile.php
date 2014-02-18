<?php

namespace Dzangocart\Bundle\CoreBundle\Model;

use Dzangocart\Bundle\CoreBundle\Model\om\BaseProfile;

use UAM\Bundle\UserBundle\Model\Profile as ProfileInterface;

class Profile extends BaseProfile implements ProfileInterface
{
    public function getEmail()
    {
        return $this->getUser()->getEmail();
    }

    public function init(array $options)
    {
    }
}