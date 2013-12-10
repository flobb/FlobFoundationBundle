<?php

namespace FlorianBelhomme\Bundle\FoundationBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FlorianBelhommeFoundationExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
    }
    
    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        // This will change the Twig configuration if needed (template path for exemple)
        if ((true === isset($bundles['TwigBundle'])) && (true === $config['theme']['form'])) {
            $this->configureTwigBundle($container);
        }

        // This will change the KnpMenu configuration if needed (template path for exemple)
        if ((true === isset($bundles['TwigBundle'])) && (true === isset($bundles['KnpMenuBundle'])) && (true === $config['theme']['knp_menu'])) {
            $this->configureKnpMenuBundle($container);
        }

        // This will change the KnpPagination configuration if needed (template path for exemple)
        if ((true === isset($bundles['TwigBundle'])) && (true === isset($bundles['KnpPaginatorBundle'])) && (true === $config['theme']['knp_paginator'])) {
            $this->configureKnpPaginatorBundle($container);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureTwigBundle(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('twig', array('form'  => array('resources' => array($this->formTemplate))));
    }
    
    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureKnpMenuBundle(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('knp_menu', array('twig' => array('template'  => $this->menuTemplate)));
    }
    
    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureKnpPaginatorBundle(ContainerBuilder $container)
    {
        $container->prependExtensionConfig('knp_paginator', array('template' => array('pagination' => $this->paginationTemplate)));
    }
}
