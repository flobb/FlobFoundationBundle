<?php

namespace Flob\Bundle\FoundationBundle\Tests\DependencyInjection;

use Flob\Bundle\FoundationBundle\DependencyInjection\FlobFoundationExtension;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;
use Prophecy\Argument;

class FlobFoundationExtensionTest extends BaseTestCase
{
    /**
     * Provide load right cases
     *
     * @return array
     */
    public function getLoadRightData()
    {
        $data = array();

        // All defaults
        $configuration = array();
        $bundles = array(
            'FrameworkBundle'   => Argument::any(),
            'TwigBundle'        => Argument::any(),
        );
        $services = array(
            array('flob_foundation.form.slider.class', 'Flob\Bundle\FoundationBundle\Form\Type\SliderType'),
            array('flob_foundation.form.switch.class', 'Flob\Bundle\FoundationBundle\Form\Type\SwitchType'),
            array('flob_foundation.form.button_group.class', 'Flob\Bundle\FoundationBundle\Form\Type\ButtonGroupType'),
            array('flob_foundation.form.button_bar.class', 'Flob\Bundle\FoundationBundle\Form\Type\ButtonBarType'),
        );
        $definitions = array(
            'flob_foundation.form.slider',
            'flob_foundation.form.switch',
            'flob_foundation.form.button_group',
            'flob_foundation.form.button_bar',
        );

        $data[] = array($configuration, $bundles, $services, $definitions);

        // Add KNP Menu bundle
        $bundles['KnpMenuBundle'] = 'Knp\Bundle\MenuBundle\KnpMenuBundle';
        $services[] = array('flob.menu_extension.class', 'Flob\Bundle\FoundationBundle\Twig\MenuExtension');
        $services[] = array('flob.menu_extension.template', 'FlobFoundationBundle:Menu:foundation_breadcrumb.html.twig');
        $definitions[] = 'flob.menu_extension';
        $data[] = array($configuration, $bundles, $services, $definitions);

        // Add the conf for KNP Menu bundle
        $configuration[0]['theme']['knp_menu'] = true;
        $configuration[0]['template']['knp_menu'] = 'YourBundle:YourFolder:menutemplate.html.twig';
        $data[] = array($configuration, $bundles, $services, $definitions);

        // Add KNP Paginator bundle
        $bundles['KnpPaginatorBundle'] = 'Knp\Bundle\PaginatorBundle\KnpPaginatorBundle';
        $data[] = array($configuration, $bundles, $services, $definitions);

        // Add the conf for KNP paginator bundle
        $configuration[0]['theme']['knp_paginator'] = true;
        $configuration[0]['template']['knp_paginator'] = 'YourBundle:YourFolder:paginatortemplate.html.twig';
        $data[] = array($configuration, $bundles, $services, $definitions);

        // Add WhiteOctober Pagerfanta bundle
        $bundles['WhiteOctoberPagerfantaBundle'] = 'WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle';
        $services[] = array('flob.pagerfanta.template.foundation.class', 'Flob\Bundle\FoundationBundle\Pagerfanta\View\Template\FoundationTemplate');
        $services[] = array('flob.pagerfanta.view.foundation.class', 'Pagerfanta\View\DefaultView');
        $definitions[] = 'flob.pagerfanta.template.foundation';
        $definitions[] = 'flob.pagerfanta.view.foundation';
        $data[] = array($configuration, $bundles, $services, $definitions);

        // Add the conf for WhiteOctober Pagerfanta bundle
        $configuration[0]['theme']['pagerfanta'] = true;
        $configuration[0]['template']['pagerfanta'] = 'YourPagerFantaTemplate';
        $data[] = array($configuration, $bundles, $services, $definitions);

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
     * Provide preprend right cases
     *
     * @return array
     */
    public function getPrependRightData()
    {
        $data = array();

        $data[] = array(
            array(),
            array(),
            array(),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any()),
            array('theme' => array('form' => true)),
            array('twig', array('form' => array('resources' => array('FlobFoundationBundle:Form:foundation_form_div_layout.html.twig')))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any()),
            array('theme' => array('form' => true), 'template' => array('form' => 'test')),
            array('twig', array('form' => array('resources' => array('test')))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any(), 'KnpMenuBundle' => Argument::any()),
            array('theme' => array('knp_menu' => true)),
            array('knp_menu', array('twig' => array('template' => 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig'))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any(), 'KnpMenuBundle' => Argument::any()),
            array('theme' => array('knp_menu' => true), 'template' => array('knp_menu' => 'test')),
            array('knp_menu', array('twig' => array('template' => 'test'))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any(), 'KnpPaginatorBundle' => Argument::any()),
            array('theme' => array('knp_paginator' => true)),
            array('knp_paginator', array('template' => array('pagination' => 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig'))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any(), 'KnpPaginatorBundle' => Argument::any()),
            array('theme' => array('knp_paginator' => true), 'template' => array('knp_paginator' => 'test')),
            array('knp_paginator', array('template' => array('pagination' => 'test'))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any(), 'WhiteOctoberPagerfantaBundle' => Argument::any()),
            array('theme' => array('pagerfanta' => true)),
            array('white_october_pagerfanta', array('default_view' => 'foundation')),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any(), 'WhiteOctoberPagerfantaBundle' => Argument::any()),
            array('theme' => array('pagerfanta' => true), 'template' => array('pagerfanta' => 'test')),
            array('white_october_pagerfanta', array('default_view' => 'test')),
        );

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
        $container->getExtensionConfig('flob_foundation')->willReturn(array($configurations))->shouldBeCalled();

        if (isset($prependConfig[0])) {
            $container->prependExtensionConfig($prependConfig[0], $prependConfig[1])->shouldBeCalled();
        }

        $extension = new FlobFoundationExtension();
        $extension->prepend($container->reveal());
    }

    /**
     * Provide preprend bad cases
     *
     * @return array
     */
    public function getPrependBadData()
    {
        $data = array();

        $data[] = array(
            array(),
            array('theme' => array('form' => true)),
            array('twig', array('form' => array('resources' => array('FlobFoundationBundle:Form:foundation_form_div_layout.html.twig')))),
        );

        $data[] = array(
            array('KnpMenuBundle' => Argument::any()),
            array('theme' => array('knp_menu' => true)),
            array('knp_menu', array('twig' => array('template' => 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig'))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any()),
            array('theme' => array('knp_menu' => true)),
            array('knp_menu', array('twig' => array('template' => 'FlobFoundationBundle:Menu:foundation_knp_menu.html.twig'))),
        );

        $data[] = array(
            array('KnpPaginatorBundle' => Argument::any()),
            array('theme' => array('knp_paginator' => true)),
            array('knp_paginator', array('template' => array('pagination' => 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig'))),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any()),
            array('theme' => array('knp_paginator' => true)),
            array('knp_paginator', array('template' => array('pagination' => 'FlobFoundationBundle:Pagination:foundation_sliding.html.twig'))),
        );

        $data[] = array(
            array('WhiteOctoberPagerfantaBundle' => Argument::any()),
            array('theme' => array('pagerfanta' => true)),
            array('white_october_pagerfanta', array('default_view' => 'foundation')),
        );

        $data[] = array(
            array('TwigBundle' => Argument::any()),
            array('theme' => array('pagerfanta' => true)),
            array('white_october_pagerfanta', array('default_view' => 'foundation')),
        );

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
        $container->getExtensionConfig('flob_foundation')->willReturn(array($configurations))->shouldBeCalled();
        $container->prependExtensionConfig()->shouldBeCalledTimes(0);

        $extension = new FlobFoundationExtension();
        try {
            $extension->prepend($container->reveal());
        } catch (\Exception $e) {
            $this->assertInstanceOf('Symfony\Component\Config\Definition\Exception\InvalidConfigurationException', $e);
        }
    }
}
