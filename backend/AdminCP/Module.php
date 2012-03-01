<?php

namespace AdminCP;

use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

class Module implements AutoloaderProvider
{
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
        $app          = $e->getParam('admincp');
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
        
        $config      = $e->getParam('config');
        $container = $renderer->placeholder('view_config');
        foreach ($config->view as $var => $value) {
            $container->{$var} = $value;
        }
    }
}
