<?php
return array(
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
                'wds' => 'Wds\Controller\IndexController',
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
                                
            'AdminCP\Controller\IndexController' => array(
                'parameters' => array(
                	'content' => 'AdminCP\Model\Content',
                ),
            ),
                
            'AdminCP\Model\Business\Content' => array(
                'parameters' => array(
                	'config' => 'Zend\Db\Adapter\PdoMysql',
                )
            ),   
                
            'Zend\Db\Adapter\PdoMysql' => array(
            	'parameters' => array(
            		'config' => array(
            			'host' => '127.0.0.1',
            			'username' => 'thuydx',
            			'password' => 'thuydx@thuydx.com',
            			'dbname' => 'thuydx_blog',
            		),
            	),
            ),    
            // Setup the View layer
            'Zend\View\Resolver\AggregateResolver' => array(
                'injections' => array(
                    'Zend\View\Resolver\TemplateMapResolver',
                    'Zend\View\Resolver\TemplatePathStack',
                ),
            ),    
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                    ),
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
                    'renderTrees' => false,
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
                    'broker'   => 'Zend\View\HelperBroker',
                ),
            ),
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/layout',
                ),
            ),
            'Zend\Mvc\View\ExceptionStrategy' => array(
                'parameters' => array(
                    'displayExceptions' => true,
                    'exceptionTemplate'          => 'error/index',
                ),
            ),
            'Zend\Mvc\View\RouteNotFoundStrategy' => array(
                'parameters' => array(
                    'displayNotFoundReason' => true,
                    'displayExceptions'     => true,
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
                                    'controller' => 'Wds\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/',
                                'defaults' => array(
                                    'controller' => 'Wds\Controller\IndexController',
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
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'ckeditor' => 'AdminCP\View\Helper\CKEditor',
                    ),
                ),
            ),                
        ),
    ),
);
