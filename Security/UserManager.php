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

    public function findUserByUsername($username)
    {
        return $this->findUserBy(array('username' => $username));
    }

    public function getStore()
    {
        return $this->container->has('dzangocart.store_finder')
            ? $this->container->get('dzangocart.store_finder')->getStore()
            : null;
    }

    /**
     * {@inheritDoc}
     */
    protected function createQuery()
    {
        $store = $this->getStore();

        if ($store) {
            return PropelQuery::from($this->class)
                ->filterByRealm($store->getRealm())
                ->_or()
                ->filterByRealm(null);
        } else {
            return PropelQuery::from($this->class)
                ->filterByRealm(null);
        }
    }
}
