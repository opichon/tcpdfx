<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Profile;

class AnonymousProfileTest extends AbstractProfileTest
{
    protected function getFullName($surname, $given_names, $email)
    {
        return '?';
    }

    protected function getReverseFullName($surname, $given_names, $email)
    {
        return '?';
    }
}
