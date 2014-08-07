<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Profile;

class ProfileWithoutSurnameTest extends AbstractProfileTest
{
    protected function setUp()
    {
        parent::setUp();

        $this->profile
            ->method('getSurname')
            ->willReturn(null);

        $this->profile
            ->method('getGivenNames')
            ->willReturn('Olivier');

        $this->profile
            ->method('getEmail')
            ->willReturn('op@dzango.com');
    }

    protected function getFullName($surname, $given_names, $email)
    {
        return sprintf(
            '%2$s ? [%3$s]',
            $surname,
            $given_names,
            $email
        );
    }

    protected function getReverseFullName($surname, $given_names, $email)
    {
        return sprintf(
            '?, %2$s [%3$s]',
            $surname,
            $given_names,
            $email
        );
    }
}
