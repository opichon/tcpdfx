<?php

namespace Dzangocart\Bundle\CoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class DzangocartCoreExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('dzangocart.host', $config['host']);
        $container->setParameter('dzangocart.redirect_url', $config['redirect_url']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config/services'));
        $loader->load('security.yml');
        $loader->load('twig.yml');
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if (true === isset($bundles['DzangocartDomainSubscriptionBundle'])) {
            $this->configureDzangocartDomainSubscriptionBundle($container, $config);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureDzangocartDomainSubscriptionBundle(ContainerBuilder $container, $config)
    {
        $container->prependExtensionConfig(
            'dzangocart_domain_subscription',
            array(
                'host' => $config['host']
            )
        );
    }
}
