<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Profile;

class ProfileWithoutEmailTest extends AbstractProfileTest
{
	protected function setUp()
	{
		parent::setUp();

		$this->profile
			->method('getSurname')
			->willReturn('Pichon');

		$this->profile
			->method('getGivenNames')
			->willReturn('Olivier');

		$this->profile
			->method('getEmail')
			->willReturn(null);
	}

	protected function getFullName($surname, $given_names, $email)
	{
		return sprintf(
			'%2$s %1$s',
			$surname,
			$given_names,
			$email
		);
	}

	protected function getReverseFullName($surname, $given_names, $email)
	{
		return sprintf(
			'%1$s, %2$s',
			$surname,
			$given_names,
			$email
		);
	}
}