<?php

namespace FlorianBelhomme\Bundle\FoundationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class FlorianBelhommeFoundationExtension extends Extension implements PrependExtensionInterface
{

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        // Load a Twig extension if KNP Menu is enabled
        if (isset($bundles['KnpMenuBundle'])) {

            $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
            $loader->load('services_menu.yml');

            $container->setParameter('florian_belhomme_foundation.template.breadcrumb', $config['template']['breadcrumb']);

        }
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        // This will change the Twig configuration if needed (default template path for exemple)
        if ($config['theme']['form']) {
            if (isset($bundles['TwigBundle'])) {
                $container->prependExtensionConfig('twig', array('form' => array('resources' => array($config['template']['form']))));
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle to theme form or set the configuration of florian_belhomme_foundation:theme:form to false');
            }
        }

        // This will change the KnpMenu configuration if needed (default template path for exemple)
        if ($config['theme']['knp_menu']) {
            if ((isset($bundles['TwigBundle'])) && (isset($bundles['KnpMenuBundle'])) ) {
                $container->prependExtensionConfig('knp_menu', array('twig' => array('template' => $config['template']['knp_menu'])));
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle and KNP Menu Bundle to theme menu or set the configuration of florian_belhomme_foundation:theme:knp_menu to false');
            }
        }

        // This will change the KnpPagination configuration if needed (default template path for exemple)
        if ($config['theme']['knp_paginator']) {
            if ((isset($bundles['TwigBundle'])) && (isset($bundles['KnpPaginatorBundle']))) {
                $container->prependExtensionConfig('knp_paginator', array('template' => array('pagination' => $config['template']['knp_paginator'])));
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle and KNP Paginator Bundle to theme pagination or set the configuration of florian_belhomme_foundation:theme:knp_paginator to false');
            }
        }
    }
}
