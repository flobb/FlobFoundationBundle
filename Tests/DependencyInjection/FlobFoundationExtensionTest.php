<?php

namespace Flob\Bundle\FoundationBundle\Tests\DependencyInjection;

use Flob\Bundle\FoundationBundle\DependencyInjection\FlobFoundationExtension;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;
use Prophecy\Argument;

class FlobFoundationExtensionTest extends BaseTestCase
{
    /**
     * Provide load right cases.
     *
     * @return array
     */
    public function getLoadRightData()
    {
        $data = [];

        // All defaults
        $configuration = [];
        $bundles = [
            'FrameworkBundle' => Argument::any(),
            'TwigBundle' => Argument::any(),
        ];
        $services = [];
        $definitions = [];

        $data[] = [$configuration, $bundles, $services, $definitions];

        // Add KNP Menu bundle
        $bundles['KnpMenuBundle'] = 'Knp\Bundle\MenuBundle\KnpMenuBundle';
        $services[] = ['flob.menu_extension.class', 'Flob\Bundle\FoundationBundle\Twig\MenuExtension'];
        $services[] = ['flob.menu_extension.template', 'FlobFoundationBundle:Menu:foundation_breadcrumb.html.twig'];
        $definitions[] = 'flob.menu_extension';
        $data[] = [$configuration, $bundles, $services, $definitions];

        // Add the conf for KNP Menu bundle
        $configuration[0]['theme']['knp_menu'] = true;
        $configuration[0]['template']['knp_menu'] = 'YourBundle:YourFolder:menutemplate.html.twig';
        $data[] = [$configuration, $bundles, $services, $definitions];

        // Add KNP Paginator bundle
        $bundles['KnpPaginatorBundle'] = 'Knp\Bundle\PaginatorBundle\KnpPaginatorBundle';
        $data[] = [$configuration, $bundles, $services, $definitions];

        // Add the conf for KNP paginator bundle
        $configuration[0]['theme']['knp_paginator'] = true;
        $configuration[0]['template']['knp_paginator'] = 'YourBundle:YourFolder:paginatortemplate.html.twig';
        $data[] = [$configuration, $bundles, $services, $definitions];

        // Add WhiteOctober Pagerfanta bundle
        $bundles['WhiteOctoberPagerfantaBundle'] = 'WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle';
        $services[] = ['flob.pagerfanta.template.foundation.class', 'Flob\Bundle\FoundationBundle\Pagerfanta\View\Template\FoundationTemplate'];
        $services[] = ['flob.pagerfanta.view.foundation.class', 'Pagerfanta\View\DefaultView'];
        $definitions[] = 'flob.pagerfanta.template.foundation';
        $definitions[] = 'flob.pagerfanta.view.foundation';
        $data[] = [$configuration, $bundles, $services, $definitions];

        // Add the conf for WhiteOctober Pagerfanta bundle
        $configuration[0]['theme']['pagerfanta'] = true;
        $configuration[0]['template']['pagerfanta'] = 'YourPagerFantaTemplate';
        $data[] = [$configuration, $bundles, $services, $definitions];

        return $data;
    }

    /**
     * @dataProvider getLoadRightData
     *
     * @param array $configuration
     * @param array $bundles
     * @param array $services
     * @param array $definitions
     */
    public function testLoadRight($configuration, $bundles, $services, $definitions)
    {
        $containerBuilder = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');

        $containerBuilder->getParameter('kernel.bundles')->willReturn($bundles)->shouldBeCalled();
        $containerBuilder->addResource(Argument::type('Symfony\Component\Config\Resource\FileResource'))->shouldBeCalled();

        $containerBuilder->setParameter(Argument::any(), Argument::any())->shouldBeCalledTimes(count($services));
        foreach ($services as $serviceArguments) {
            $containerBuilder->setParameter($serviceArguments[0], $serviceArguments[1])->shouldBeCalled();
        }

        $containerBuilder->setDefinition(Argument::any(), Argument::any())->shouldBeCalledTimes(count($definitions));
        foreach ($definitions as $definitionArgument) {
            $containerBuilder->setDefinition($definitionArgument, Argument::type('Symfony\Component\DependencyInjection\Definition'))->shouldBeCalled();
        }

        $extension = new FlobFoundationExtension();
        $extension->load($configuration, $containerBuilder->reveal());
    }

    /**
     * Provide preprend right cases.
     *
     * @return array
     */
    public function getPrependRightData()
    {
        $data = [];

        $data[] = [
            [],
            [],
            [],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any()],
            ['theme' => ['form' => true]],
            ['twig', ['form' => ['resources' => ['FlobFoundationBundle:Form:foundation_form_div_layout.html.twig']]]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any()],
            ['theme' => ['form' => true], 'template' => ['form' => 'test']],
            ['twig', ['form' => ['resources' => ['test']]]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any(), 'KnpMenuBundle' => Argument::any()],
            ['theme' => ['knp_menu' => true]],
            ['knp_menu', ['twig' => ['template' => 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig']]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any(), 'KnpMenuBundle' => Argument::any()],
            ['theme' => ['knp_menu' => true], 'template' => ['knp_menu' => 'test']],
            ['knp_menu', ['twig' => ['template' => 'test']]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any(), 'KnpPaginatorBundle' => Argument::any()],
            ['theme' => ['knp_paginator' => true]],
            ['knp_paginator', ['template' => ['pagination' => 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig']]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any(), 'KnpPaginatorBundle' => Argument::any()],
            ['theme' => ['knp_paginator' => true], 'template' => ['knp_paginator' => 'test']],
            ['knp_paginator', ['template' => ['pagination' => 'test']]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any(), 'WhiteOctoberPagerfantaBundle' => Argument::any()],
            ['theme' => ['pagerfanta' => true]],
            ['white_october_pagerfanta', ['default_view' => 'foundation']],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any(), 'WhiteOctoberPagerfantaBundle' => Argument::any()],
            ['theme' => ['pagerfanta' => true], 'template' => ['pagerfanta' => 'test']],
            ['white_october_pagerfanta', ['default_view' => 'test']],
        ];

        return $data;
    }

    /**
     * @dataProvider getPrependRightData
     *
     * @param array $bundles
     * @param array $configurations
     * @param array $prependConfig
     */
    public function testPrependRight($bundles, $configurations, $prependConfig)
    {
        $container = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');

        $container->getParameter('kernel.bundles')->willReturn($bundles)->shouldBeCalled();
        $container->getExtensionConfig('flob_foundation')->willReturn([$configurations])->shouldBeCalled();

        if (isset($prependConfig[0])) {
            $container->prependExtensionConfig($prependConfig[0], $prependConfig[1])->shouldBeCalled();
        }

        $extension = new FlobFoundationExtension();
        $extension->prepend($container->reveal());
    }

    /**
     * Provide preprend bad cases.
     *
     * @return array
     */
    public function getPrependBadData()
    {
        $data = [];

        $data[] = [
            [],
            ['theme' => ['form' => true]],
            ['twig', ['form' => ['resources' => ['FlobFoundationBundle:Form:foundation_form_div_layout.html.twig']]]],
        ];

        $data[] = [
            ['KnpMenuBundle' => Argument::any()],
            ['theme' => ['knp_menu' => true]],
            ['knp_menu', ['twig' => ['template' => 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig']]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any()],
            ['theme' => ['knp_menu' => true]],
            ['knp_menu', ['twig' => ['template' => 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig']]],
        ];

        $data[] = [
            ['KnpPaginatorBundle' => Argument::any()],
            ['theme' => ['knp_paginator' => true]],
            ['knp_paginator', ['template' => ['pagination' => 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig']]],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any()],
            ['theme' => ['knp_paginator' => true]],
            ['knp_paginator', ['template' => ['pagination' => 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig']]],
        ];

        $data[] = [
            ['WhiteOctoberPagerfantaBundle' => Argument::any()],
            ['theme' => ['pagerfanta' => true]],
            ['white_october_pagerfanta', ['default_view' => 'foundation']],
        ];

        $data[] = [
            ['TwigBundle' => Argument::any()],
            ['theme' => ['pagerfanta' => true]],
            ['white_october_pagerfanta', ['default_view' => 'foundation']],
        ];

        return $data;
    }

    /**
     * @dataProvider getPrependBadData
     *
     * @param array $bundles
     * @param array $configurations
     * @param array $prependConfig
     */
    public function testPrependBad($bundles, $configurations, $prependConfig)
    {
        $container = $this->prophesize('Symfony\Component\DependencyInjection\ContainerBuilder');

        $container->getParameter('kernel.bundles')->willReturn($bundles)->shouldBeCalled();
        $container->getExtensionConfig('flob_foundation')->willReturn([$configurations])->shouldBeCalled();
        $container->prependExtensionConfig()->shouldBeCalledTimes(0);

        $extension = new FlobFoundationExtension();
        try {
            $extension->prepend($container->reveal());
        } catch (\Exception $e) {
            $this->assertInstanceOf('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException', $e);
        }
    }
}
