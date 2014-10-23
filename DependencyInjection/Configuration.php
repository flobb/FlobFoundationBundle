<?php

namespace Flob\Bundle\FoundationBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('flob_foundation');

        $rootNode
            ->children()
                ->arrayNode('theme')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('form')->defaultValue(false)->end()
                        ->booleanNode('knp_menu')->defaultValue(false)->end()
                        ->booleanNode('knp_paginator')->defaultValue(false)->end()
                    ->end()
                ->end()
                ->arrayNode('template')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('form')->defaultValue('FlobFoundationBundle:Form:foundation_form_div_layout.html.twig')->end()
                        ->scalarNode('breadcrumb')->defaultValue('FlobFoundationBundle:Menu:foundation_breadcrumb.html.twig')->end()
                        ->scalarNode('knp_menu')->defaultValue('FlobFoundationBundle:Menu:foundation_knp_menu.html.twig')->end()
                        ->scalarNode('knp_paginator')->defaultValue('FlobFoundationBundle:Pagination:foundation_sliding.html.twig')->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
