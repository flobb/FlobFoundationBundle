<?php

namespace FlorianBelhomme\Bundle\FoundationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FlorianBelhommeFoundationExtension extends Extension implements PrependExtensionInterface
{
    
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        
        $container->setParameter('florian_belhomme_foundation.template.breadcrumb', $config['template']['breadcrumb']);
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
        if ((isset($bundles['TwigBundle'])) && ($config['theme']['form'])) {
            $container->prependExtensionConfig('twig', array('form'  => array('resources' => array($config['template']['form']))));
        }

        // This will change the KnpMenu configuration if needed (default template path for exemple)
        if ((isset($bundles['TwigBundle'])) && (isset($bundles['KnpMenuBundle'])) && ($config['theme']['knp_menu'])) {
            $container->prependExtensionConfig('knp_menu', array('twig' => array('template' => $config['template']['knp_menu'])));
        }

        // This will change the KnpPagination configuration if needed (default template path for exemple)
        if ((isset($bundles['TwigBundle'])) && (isset($bundles['KnpPaginatorBundle'])) && ($config['theme']['knp_paginator'])) {
            $container->prependExtensionConfig('knp_paginator', array('template' => array('pagination' => $config['template']['knp_paginator'])));
        }
    }
}
