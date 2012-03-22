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
                'admincp' => 'AdminCP\Controller\IndexController',
                'admincp-content-type' => 'AdminCP\Controller\TypeController',
                'admincp-content-status' => 'AdminCP\Controller\StatusController',
                'admincp-content' => 'AdminCP\Controller\ContentController',
                'admincp-category' => 'AdminCP\Controller\CategoryController',
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
                	'contentType' => 'AdminCP\Model\ContentType',
                	'contentDetail' => 'AdminCP\Model\ContentDetail',
                	'contentStatus' => 'AdminCP\Model\ContentStatus',
                	'category' => 'AdminCP\Model\Category',
                	'categoryDetail' => 'AdminCP\Model\CategoryDetail',
                	'categoryAssociations' => 'AdminCP\Model\CategoryAssociations',
                ),
            ),
            'AdminCP\Controller\TypeController' => array(
            	'parameters' => array(
                	'contentType' => 'AdminCP\Model\Business\ContentType'
				),
            ),
            'AdminCP\Controller\StatusController' => array(
            	'parameters' => array(
                	'contentStatus' => 'AdminCP\Model\Business\ContentStatus'
				),
            ),
            'AdminCP\Controller\CategoryController' => array(
            	'parameters' => array(
                	'category' => 'AdminCP\Model\Business\Category',
				),
            ),    

            'AdminCP\Controller\ContentController' => array(
            	'parameters' => array(
            		'content' => 'AdminCP\Model\Business\Content',
            		'contentType' => 'AdminCP\Model\Business\ContentType',
            		'contentStatus' => 'AdminCP\Model\Business\ContentStatus',
            		'categories' => 'AdminCP\Model\Business\Category',
                ),
            ),

            'AdminCP\Model\Business\Content' => array(
                'parameters' => array(
                	'adapter' => 'Zend\Db\Adapter\Adapter',
                )
            ),
            'AdminCP\Model\Business\ContentType' => array(
                'parameters' => array(
                	'adapter' => 'Zend\Db\Adapter\Adapter',
                )
            ),
            'AdminCP\Model\Business\ContentStatus' => array(
                'parameters' => array(
                	'adapter' => 'Zend\Db\Adapter\Adapter',
                )
            ),
            'AdminCP\Model\Business\Category' => array(
                'parameters' => array(
                	'adapter' => 'Zend\Db\Adapter\Adapter',
                )
            ),                
            'Zend\Db\Adapter\Adapter' => array(
                'parameters' => array(
                    'driver' => array(
                        'driver' => 'Pdo',
                        'dsn'            => 'mysql:dbname=thuydx_blog;hostname=localhost',
                        'username'       => 'thuydx',
                        'password'       => 'thuydx@thuydx.com',
                        'driver_options' => array(
                                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                        ),
                    ),
                )
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
                        'layout/layout' => __DIR__ . '/../view/layout/adminlayout.phtml',
                    ),
                ),
            ),            
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'AdminCP' => __DIR__ . '/../view',
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
                                    'controller' => 'AdminCP\Controller\IndexController',
                                    'action'     => 'index',
                                ),
                            ),
                        ),
                        'home' => array(
                            'type' => 'Zend\Mvc\Router\Http\Literal',
                            'options' => array(
                                'route'    => '/',
                                'defaults' => array(
                                    'controller' => 'AdminCP\Controller\IndexController',
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
