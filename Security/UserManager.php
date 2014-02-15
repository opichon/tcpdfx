<?php

namespace Dzangocart\Bundle\CoreBundle\Security;

use \PropelQuery;

use FOS\UserBundle\Propel\UserManager as BaseUserManager;
use FOS\UserBundle\Util\CanonicalizerInterface;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager extends BaseUserManager
{
    protected $container;

    public function __construct(
        EncoderFactoryInterface $encoderFactory,
        CanonicalizerInterface $usernameCanonicalizer,
        CanonicalizerInterface $emailCanonicalizer,
        $class,
        ContainerInterface $container
    )
    {
        parent::__construct($encoderFactory, $usernameCanonicalizer, $emailCanonicalizer, $class);

        $this->container = $container;
    }

    public function getStore()
    {
        return $this->container->get('dzangocart.store_finder')->getStore();
    }

    /**
     * {@inheritDoc}
     */
    protected function createQuery()
    {
        return PropelQuery::from($this->class)
            ->filterByRealm($this->getStore()->getRealm());
    }
}
