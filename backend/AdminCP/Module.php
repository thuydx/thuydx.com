<?php

namespace AdminCP;

use Zend\Module\Manager,
    Zend\EventManager\Event,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'onBootstrap'));
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function initializeView($e)
    {
        $app          = $e->getParam('application');
        $basePath     = $app->getRequest()->getBasePath();    
        $locator      = $app->getLocator();
        $renderer     = $locator->get('Zend\View\Renderer\PhpRenderer');
        
        $renderer->doctype()->setDoctype('HTML5');
        $renderer->plugin('url')->setRouter($app->getRouter());
        $renderer->plugin('basePath')->setBasePath($basePath);
        
        // We can get at the view model here if we need to use logic to set
        // the layout template for instance by doing this:
        
        // $viewModel = $application->getMvcEvent()->getViewModel();
        // $viewModel->setTemplate('layout/layout');
        
//         $config      = $e->getParam('config');
//         $container = $renderer->placeholder('view_config');
//         foreach ($config->view as $var => $value) {
//             $container->{$var} = $value;
//         }
    }
    
    public function onBootstrap(Event $e)
    {
        $app = $e->getParam('application');
        $app->events()->attach('dispatch', array($this, 'onDispatch'), -100);
    }
    
    public function onDispatch($e)
    {
        $matches = $e->getRouteMatch();
        $controller = $matches->getParam('controller');
        //echo "<pre>"; var_dump($controller); die();
        if (strpos($controller, strtolower(__NAMESPACE__)) !== 0) {
            // not a controller from this module
            return;
        }
    
        // Do module specific bootstrapping here
    
        // Set the layout template for every action in this module
        $viewModel = $e->getViewModel();
        $viewModel->setTemplate('layout/adminlayout');
    }    
}
