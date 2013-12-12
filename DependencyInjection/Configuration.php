<?php

namespace FlorianBelhomme\Bundle\FoundationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fb_foundation');
        
        $rootNode
            ->children()
                ->arrayNode('theme')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('form')->defaultValue(true)->end()
                        ->booleanNode('knp_menu')->defaultValue(true)->end()
                        ->booleanNode('knp_paginator')->defaultValue(true)->end()
                    ->end()
                ->end()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form')->defaultValue('FlorianBelhommeFoundationBundle:Form:form_div_layout.html.twig')->end()
                        ->scalarNode('knp_menu')->defaultValue('FlorianBelhommeFoundationBundle:Menu:knp_menu.html.twig')->end()
                        ->scalarNode('knp_paginator')->defaultValue('FlorianBelhommeFoundationBundle:Pagination:sliding.html.twig')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
