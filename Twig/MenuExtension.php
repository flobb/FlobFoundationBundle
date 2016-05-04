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
     * @param Helper            $menuHelper
     * @param Matcher           $matcher
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
     * Function list of the extension.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'flob_breadcrumb_render',
                [$this, 'renderAsBreadcrumb'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    /**
     * Render an array or KNP menu as foundation breadcrumb.
     *
     * @param ItemInterface|string $menu
     * @param array                $options
     *
     * @return mixed
     */
    public function renderAsBreadcrumb($menu, array $options = [])
    {
        $options = array_merge(['template' => $this->defaultTemplate], $options);

        if ((!is_array($menu)) && (!$menu instanceof ItemInterface)) {
            $path = [];
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
                new \ArrayIterator([$menu])
            ), \RecursiveIteratorIterator::SELF_FIRST
        );
        $itemFilterIterator = new CurrentItemFilterIterator($treeIterator, $this->matcher);
        $itemFilterIterator->rewind();

        // Watch for a current item
        $current = $itemFilterIterator->current();

        $manipulator = new MenuManipulator();
        if ($current instanceof ItemInterface) {
            // Extract the items for the breadcrumb
            $breadcrumbs = $manipulator->getBreadcrumbsArray($current);
        } else {
            // Current item could not be located, we only send the first item
            $breadcrumbs = $manipulator->getBreadcrumbsArray($menu);
        }

        // Load the template if needed
        if (!$options['template'] instanceof \Twig_Template) {
            $options['template'] = $this->twig->loadTemplate($options['template']);
        }

        // renderBlock is @internal, other solution for this ?
        return $options['template']->renderBlock('root', ['breadcrumbs' => $breadcrumbs, 'options' => $options]);
    }
}
