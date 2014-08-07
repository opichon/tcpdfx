<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Profile;

class ProfileWithoutGivenNamesAndEmailTest extends AbstractProfileTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->profile
            ->method('getSurname')
            ->willReturn('Pichon');

        $this->profile
            ->method('getGivenNames')
            ->willReturn(null);

        $this->profile
            ->method('getEmail')
            ->willReturn(null);
    }

    protected function getFullName($surname, $given_names, $email)
    {
        return sprintf(
            '%1$s',
            $surname,
            $given_names,
            $email
        );
    }

    protected function getReverseFullName($surname, $given_names, $email)
    {
        return sprintf(
            '%1$s',
            $surname,
            $given_names,
            $email
        );
    }
}
