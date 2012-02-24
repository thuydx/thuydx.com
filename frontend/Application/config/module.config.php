<?php
return array(
    'layout'                => 'layout/layout.phtml',
    'display_exceptions'    => true,
    'di' => array(
        'definition' => array(
            'class' => array(
                'Zend\Mvc\Router\RouteStack' => array(
                    'instantiator' => array(
                        'Zend\Mvc\Router\Http\TreeRouteStack',
                        'factory'
                    ),
                ),
            ),
        ),
        'instance' => array(
            'alias' => array(
                'index' => 'Application\Controller\IndexController',
                'article' => 'Application\Controller\ArticleController',
                'category' => 'Application\Controller\CategoryController',
                'error' => 'Application\Controller\ErrorController',
//                 'view'  => 'Zend\View\PhpRenderer',

            ),                
            // Inject the plugin broker for controller plugins into
            // the action controller for use by all controllers that
            // extend it.
            'Zend\Mvc\Controller\ActionController' => array(
                'parameters' => array(
                    'broker'       => 'Zend\Mvc\Controller\PluginBroker',
                ),
            ),
            'Zend\Mvc\Controller\PluginBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\Mvc\Controller\PluginLoader',
                ),
            ),
            'Application\Controller\IndexController' => array(
				'parameters' => array(
                	'content' => 'AdminCP\Model\Business\Content',
                ),
            ),
            'Application\Controller\ArticleController' => array(
				'parameters' => array(
                	'content' => 'AdminCP\Model\Business\Content',
                ),
            ),
            'Application\Controller\CategoryController' => array(
				'parameters' => array(
                	'content' => 'AdminCP\Model\Business\Content',
                	'category' => 'AdminCP\Model\Business\Category',
                ),
            ),                		
            // Setup the View layer
            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),    
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'application' => __DIR__ . '/../view',
                    ),
                ),
            ),
            // Setup phpRenderer    
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                ),
            ),
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'baseTemplate' => 'layout/layout',
                ),
            ),
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'template'          => 'error/index',
                ),
            ),
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'notFoundTemplate' => 'error/404',
                ),
            ),
            // Setup the router and routes
            'Zend\Mvc\Router\RouteStack' => array(
                'parameters' => array(
                    'routes' => array(
                        'default' => array(
                            'type'    => 'Zend\Mvc\Router\Http\Segment',
                            'options' => array(
                                'route'    => '/[:controller[/:action]]',
                                'constraints' => array(
                                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                ),
                                'defaults' => array(
                                    'controller' => 'Application\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/',
                                'defaults' => array(
                                    'controller' => 'Application\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'baseUrl' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => 'http://thuydx.com',
                                'defaults' => array(
                                    'controller' => 'index',
                                    'action'     => 'index',
                                ),
                            ),
                        ),                            
                    ),
                ),
            ),
        ),
    ),
);
