<?php

namespace Dzangocart\Bundle\CoreBundle\DependencyInjection\Compiler;

use Dzangocart\Bundle\CoreBundle\Payment\PaymentClassRegistry;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class PaymentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {

        foreach ($container->findTaggedServiceIds('dzangocart.payment') as $id => $attributes) {
            PaymentClassRegistry::getInstance()
                ->register($container->get($id));

        }
    }

}
