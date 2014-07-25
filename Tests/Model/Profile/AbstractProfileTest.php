<?php

namespace Dzangocart\Bundle\CoreBundle\Tests\Model\Profile;

use PHPUnit_Framework_TestCase;

use Dzangocart\Bundle\CoreBundle\Model\Profile;

abstract class AbstractProfileTest extends PHPUnit_Framework_TestCase
{
	protected $profile;

	protected function setUp()
	{
		$this->profile = $this->getMockBuilder('Dzangocart\Bundle\CoreBundle\Model\Profile')
			->setMethods(array(
				'getSurname',
				'getGivenNames',
				'getEmail'
			))
			->getMock();
	}

	public function testFullName()
	{
		$this->assertEquals(
			$this->getFullName(
				$this->profile->getSurname(),
				$this->profile->getGivenNames(),
				$this->profile->getEmail()
			),
			$this->profile->getFullName(false)
		);
	}

	public function testReverseFullName()
	{
		$this->assertEquals(
			$this->getReverseFullName(
				$this->profile->getSurname(),
				$this->profile->getGivenNames(),
				$this->profile->getEmail()
			),
			$this->profile->getFullName(true)
		);
	}

	abstract protected function getFullName($surname, $given_names, $email);

	abstract protected function getReverseFullName($surname, $given_names, $email);
}
