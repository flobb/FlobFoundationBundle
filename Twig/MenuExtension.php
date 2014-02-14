<?php

namespace FlorianBelhomme\Bundle\FoundationBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Knp\Menu\ItemInterface;
use Knp\Menu\MenuItem;
use Knp\Menu\Twig\Helper;

class MenuExtension extends \Twig_Extension
{
    
    protected $container;
    protected $helper;
    
    /**
     * Constructor
     *
     * @param Symfony\Component\DependencyInjection\ContainerInterface $container
     * @param Knp\Menu\Twig\Helper $helper
     */
    public function __construct(ContainerInterface $container, Helper $helper)
    {
        $this->container = $container;
        $this->helper = $helper;
    }
    
    public function getFunctions()
    {
        return array(
            'fbfb_breadcrumb_render' => new \Twig_Function_Method($this, 'renderBreadcrumb', array('is_safe' => array('html')))
        );
    }

    /**
     * Renders a menu as a breadcrumb
     *
     * @param string
     * @param array $options
     * @return string
     */
    public function renderBreadcrumb($menu, array $options = array())
    {
        
        $knpHelper = $this->container->get('knp_menu.helper');
        
        if (!$menu instanceof ItemInterface) {
            $path = array();
            if (is_array($menu)) {
                if (empty($menu)) {
                    throw new \InvalidArgumentException('The array cannot be empty');
                }
                $path = $menu;
                $menu = array_shift($path);
            }
        
            $menu = $this->helper->get($menu, $path);
        }
        
        if ($menu instanceof MenuItem) {
            $breadcrumbs = $menu->getCurrentItem()->getBreadcrumbsArray();
        }
        else {
            $breadcrumbs = $menu;
        }
        
        $template = ((!empty($options['template']))?$options['template']:$this->container->getParameter('florian_belhomme_foundation.template.breadcrumb'));
        if (!$template instanceof \Twig_Template) {
            $template = $this->container->get('twig')->loadTemplate($template);
        }
        
        return $template->renderBlock('root', array('breadcrumbs' => $breadcrumbs, 'options' => $options));
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'fbfb_menu';
    }
}
