<?php
return array(
    'layout'                => 'layout/layout.phtml',
    'display_exceptions'    => true,
    'di'                    => array(
        'instance' => array(
            'alias' => array(
                'index' => 'Application\Controller\IndexController',
                'article' => 'Application\Controller\ArticleController',
                'category' => 'Application\Controller\CategoryController',
                'error' => 'Application\Controller\ErrorController',
                'view'  => 'Zend\View\PhpRenderer',
                
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
//             'AdminCP\Model\Business\Content' => array(
//             	'parameters' => array(
//             		'config' => 'Zend\Db\Adapter\Mysqli',
//             	)
//             ),
//             'Zend\Db\Adapter\Mysqli' => array(
//             	'parameters' => array(
//             		'config' => array(
//             			'host' => '127.0.0.1',
//             			'username' => 'root',
//             			'password' => '#xuan@thuy85',
//             			'dbname' => 'thuydx_blog',
//             		),
//            		),
// 			),
                		
            // Setup the PhpRenderer
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options'  => array(
                        'script_paths' => array(
                            'application' => __DIR__ . '/../view',
                        ),
                    ),
                ),
            ),
        ),
    ),
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
                    'controller' => 'index',
                    'action'     => 'index',
                ),
            ),
        ),
        'home' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => '/',
                'defaults' => array(
                    'controller' => 'index',
                    'action'     => 'index',
                ),
            ),
        ),
        'baseUrl' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route'    => 'http://blog.wds.com.vn',
                'defaults' => array(
                    'controller' => 'index',
                    'action'     => 'index',
                ),
            ),
        ),
    ),
);
