<?php

namespace Flob\Bundle\FoundationBundle\Tests\Pagerfanta\View\Template;

use Flob\Bundle\FoundationBundle\Pagerfanta\View\Template\FoundationTemplate;
use Flob\Bundle\FoundationBundle\Tests\BaseTestCase;

class FoundationTemplateTest extends BaseTestCase
{
    /**
     * @var FoundationTemplate
     */
    private $template;

    public function setUp()
    {
        $this->template = new FoundationTemplate();
        $this->template->setRouteGenerator(function ($num) { return '#ROUTE#'.$num.'#ROUTE#'; });
    }

    public function tearDown()
    {
        $this->template = null;
    }

    public function testContainer()
    {
        $this->assertSame('<ul class="pagination">%pages%</ul>', $this->template->container());
    }

    public function testPage()
    {
        $page = 12;
        $this->assertSame('<li><a href="#ROUTE#'.$page.'#ROUTE#">'.$page.'</a></li>', $this->template->page($page));
    }

    public function testPageWithText()
    {
        $page = 12;
        $text = 'test';
        $this->assertSame('<li><a href="#ROUTE#'.$page.'#ROUTE#">'.$text.'</a></li>', $this->template->pageWithText($page, $text));
    }

    public function testPageWithTextAndClass()
    {
        $page = 12;
        $text = 'test';
        $class = 'testclass';
        $this->assertSame('<li class="'.$class.'"><a href="#ROUTE#'.$page.'#ROUTE#">'.$text.'</a></li>', $this->template->pageWithTextAndClass($page, $text, $class));
    }

    public function testPreviousDisabled()
    {
        $this->assertSame('<li class="first arrow unavailable"><a href=""><i class="fa fa-angle-left"></i></a></li>', $this->template->previousDisabled());
    }

    public function testPreviousDisabledClass()
    {
        $this->assertSame('first arrow unavailable', $this->template->previousDisabledClass());
    }

    public function testPreviousEnabled()
    {
        $page = 12;
        $this->assertSame('<li class="first arrow"><a href="#ROUTE#'.$page.'#ROUTE#"><i class="fa fa-angle-left"></i></a></li>', $this->template->previousEnabled($page));
    }

    public function testNextDisabled()
    {
        $this->assertSame('<li class="last arrow unavailable"><a href=""><i class="fa fa-angle-right"></i></a></li>', $this->template->nextDisabled());
    }

    public function testNextDisabledClass()
    {
        $this->assertSame('last arrow unavailable', $this->template->nextDisabledClass());
    }

    public function testNextEnabled()
    {
        $page = 12;
        $this->assertSame('<li class="last arrow"><a href="#ROUTE#'.$page.'#ROUTE#"><i class="fa fa-angle-right"></i></a></li>', $this->template->nextEnabled($page));
    }

    public function testFirst()
    {
        $this->assertSame('<li><a href="#ROUTE#1#ROUTE#">1</a></li>', $this->template->first());
    }

    public function testLast()
    {
        $page = 12;
        $this->assertSame('<li><a href="#ROUTE#'.$page.'#ROUTE#">'.$page.'</a></li>', $this->template->last($page));
    }

    public function testCurrent()
    {
        $page = 12;
        $this->assertSame('<li class="current"><a href="#ROUTE#'.$page.'#ROUTE#">'.$page.'</a></li>', $this->template->current($page));
    }

    public function testSeparator()
    {
        $this->assertSame('<li class="unavailable"><a href="">&hellip;</a></li>', $this->template->separator());
    }
}
