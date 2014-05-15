<?php

namespace Dzangocart\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class PaymentPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('dzangocart.payment.registry')) {
            return;
        }

        $definition = $container->getDefinition(
            'dzangocart.payment.registry'
        );

        foreach ($container->findTaggedServiceIds('dzangocart.payment') as $id => $attributes) {
            $definition->addMethodCall(
                'register',
                array(new Reference($id))
            );
        }
    }

}
