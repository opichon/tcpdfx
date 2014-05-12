<?php

namespace Dzangocart\Bundle\CoreBundle;

use Dzangocart\Bundle\CoreBundle\DependencyInjection\Compiler\PaymentPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DzangocartCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new PaymentPass());
    }
}
