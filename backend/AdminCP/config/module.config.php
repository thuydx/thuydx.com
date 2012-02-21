<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'admincp' => 'AdminCP\Controller\IndexController',
                'admincp-content-type' => 'AdminCP\Controller\TypeController',
                'admincp-content-status' => 'AdminCP\Controller\StatusController',
                'admincp-content' => 'AdminCP\Controller\ContentController',
                'admincp-category' => 'AdminCP\Controller\CategoryController',
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
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'AdminCP' => __DIR__ . '/../views',
                        ),
                    ),
                    'broker'    => 'Zend\View\HelperBroker',
                ),
            ),
            'Zend\View\HelperBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
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
