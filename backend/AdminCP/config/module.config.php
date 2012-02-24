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
                	'config' => 'Zend\Db\Adapter\PdoMysql',
                )
            ),
            'AdminCP\Model\Business\ContentType' => array(
                'parameters' => array(
                	'config' => 'Zend\Db\Adapter\PdoMysql',
                )
            ),
            'AdminCP\Model\Business\ContentStatus' => array(
                'parameters' => array(
                	'config' => 'Zend\Db\Adapter\PdoMysql',
                )
            ),
            'AdminCP\Model\Business\Category' => array(
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
            // Setup PhpRenderer    
            'Zend\View\Renderer\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\Resolver\AggregateResolver',
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
                        'admincp' => __DIR__ . '/../views',
                    ),
                    'baseTemplate' => 'layout/adminlayout',
                ),
            ),    
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'baseTemplate' => 'layout/layout',
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
