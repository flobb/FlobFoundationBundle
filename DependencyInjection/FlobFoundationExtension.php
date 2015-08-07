<?php

namespace Flob\Bundle\FoundationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class FlobFoundationExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (isset($bundles['KnpMenuBundle'])) {
            $loader->load('knp_menu.yml');
            $container->setParameter('flob.menu_extension.template', $config['template']['breadcrumb']);
        }

        if (isset($bundles['WhiteOctoberPagerfantaBundle'])) {
            $loader->load('pagerfanta.yml');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        if ($config['theme']['form']) {
            if (isset($bundles['TwigBundle'])) {
                $container->prependExtensionConfig('twig', ['form' => ['resources' => [$config['template']['form']]]]);
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle to theme form or set the configuration of flob_foundation.theme.form to false');
            }
        }

        if ($config['theme']['knp_menu']) {
            if ((isset($bundles['TwigBundle'])) && (isset($bundles['KnpMenuBundle']))) {
                $container->prependExtensionConfig('knp_menu', ['twig' => ['template' => $config['template']['knp_menu']]]);
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle and KNP Menu Bundle to theme menu or set the configuration of flob_foundation.theme.knp_menu to false');
            }
        }

        if ($config['theme']['knp_paginator']) {
            if ((isset($bundles['TwigBundle'])) && (isset($bundles['KnpPaginatorBundle']))) {
                $container->prependExtensionConfig('knp_paginator', ['template' => ['pagination' => $config['template']['knp_paginator']]]);
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle and KNP Paginator Bundle to theme pagination or set the configuration of flob_foundation.theme.knp_paginator to false');
            }
        }

        if ($config['theme']['pagerfanta']) {
            if ((isset($bundles['TwigBundle'])) && (isset($bundles['WhiteOctoberPagerfantaBundle']))) {
                $container->prependExtensionConfig('white_october_pagerfanta', ['default_view' => $config['template']['pagerfanta']]);
            } else {
                throw new InvalidConfigurationException('You need to enable Twig Bundle and WhiteOctober Pagerfanta Bundle to theme pagination or set the configuration of flob_foundation.theme.pagerfanta to false');
            }
        }
    }
}
