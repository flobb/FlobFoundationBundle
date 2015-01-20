<?php

namespace Flob\Bundle\FoundationBundle\Twig;

use Knp\Menu\ItemInterface;
use Knp\Menu\Iterator\CurrentItemFilterIterator;
use Knp\Menu\Iterator\RecursiveItemIterator;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Twig\Helper;
use Knp\Menu\Util\MenuManipulator;

class MenuExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    protected $defaultTemplate;

    /**
     * @var Helper
     */
    protected $menuHelper;

    /**
     * @var Matcher
     */
    protected $matcher;

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @param \Twig_Environment $twig
     * @param Helper $menuHelper
     * @param Matcher $matcher
     * @param $defaultTemplate
     */
    public function __construct(\Twig_Environment $twig, Helper $menuHelper, Matcher $matcher, $defaultTemplate)
    {
        $this->twig = $twig;
        $this->menuHelper = $menuHelper;
        $this->matcher = $matcher;
        $this->defaultTemplate = $defaultTemplate;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'flob_menu';
    }

    /**
     * Function list of the extension
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'flob_breadcrumb_render' => new \Twig_Function_Method($this, 'renderAsBreadcrumb', array('is_safe' => array('html'))),
        );
    }

    /**
     * Render an array or KNP menu as foundation breadcrumb
     *
     * @param ItemInterface|string $menu
     * @param array $options
     * @return mixed
     */
    public function renderAsBreadcrumb($menu, array $options = array())
    {
        $options = array_merge(array('template' => $this->defaultTemplate), $options);

        if ((!is_array($menu)) && (!$menu instanceof ItemInterface)) {
            $path = array();
            if (is_array($menu)) {
                if (empty($menu)) {
                    throw new \InvalidArgumentException('The array cannot be empty');
                }
                $path = $menu;
                $menu = array_shift($path);
            }

            $menu = $this->menuHelper->get($menu, $path);
        }

        // Look into the menu to fetch the current item
        $treeIterator = new \RecursiveIteratorIterator(
            new RecursiveItemIterator(
                new \ArrayIterator(array($menu))
            ), \RecursiveIteratorIterator::SELF_FIRST
        );
        $itemFilterIterator = new CurrentItemFilterIterator($treeIterator, $this->matcher);
        $itemFilterIterator->rewind();

        // Extract the items for the breadcrumb
        $manipulator = new MenuManipulator();
        $breadcrumbs = $manipulator->getBreadcrumbsArray($itemFilterIterator->current());

        // Load the template if needed
        if (!$options['template'] instanceof \Twig_Template) {
            $options['template'] = $this->twig->loadTemplate($options['template']);
        }

        return $options['template']->renderBlock('root', array('breadcrumbs' => $breadcrumbs, 'options' => $options));
    }
}
