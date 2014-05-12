<?php

namespace Dzangocart\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class PaymentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('dzangocart.payment') as $id => $attributes) {

            if (false === $container->hasDefinition($id)) {
                continue;
            }

            $definition = $container->getDefinition($id);

            $definition->addMethodCall('addPayment', array(new Reference($id)));

            $calls = $definition->getMethodCalls();
            $definition->setMethodCalls(array());

            $definition->setMethodCalls(array_merge($definition->getMethodCalls(), $calls));
        }
    }

}
