<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overridding configuration values from modules, etc.  
 * You would place values in here that are agnostic to the environment and not 
 * sensitive to security. 
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source 
 * control, so do not include passwords or other sensitive information in this 
 * file.
 */

/**
 * Doctrine ORM Configuration
*
* If you have a ./configs/autoload/ directory set up for your project, you can
* drop this config file in it and change the values as you wish. This file is intended
* to be used with a standard Doctrine ORM setup. If you have something more advanced
* you may override the Zend\Di configuration manually (see module.config.php).
*/
$settings = array(
    // if disabled will not register annotations
    'use_annotations' => true,

    // if use_annotations (above) is set to true this file will be registered
    'annotation_file' => __DIR__ . '/../../vendor/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php',

    // enables production mode by disabling generation of proxies
    'production' => false,
     
    // sets the cache to use for metadata: one of 'array', 'apc', or 'memcache'
    'cache' => 'array',
     
    // only used if cache is set to memcache
    'memcache' => array(
        'host' => '127.0.0.1',
        'port' => '11211'
    ),
     
    // connection parameters
    'connection' => array(
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'port'     => '3306',
        'user'     => 'root',
        'password' => '#xuan@thuy85',
        'dbname'   => 'wds_cms_2012',
    ),

    // driver settings
    'driver' => array(
        'class'     => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
        'namespace' => 'Wds\Model\Entity',
        'paths'     => array('vendor/Wds/src/Wds/Model/Entities')
    ),

    // namespace aliases for annotations
    'namespace_aliases' => array(
    ),
);

/**
 * YOU DO NOT NEED TO EDIT BELOW THIS LINE.
 */
$cache = array('array', 'memcache', 'apc');
if (!in_array($settings['cache'], $cache)) {
    throw new InvalidArgumentException(sprintf(
            'cache must be one of: %s',
            implode(', ', $cache)
    ));
}
$settings['cache'] = 'doctrine_cache_' . $settings['cache'];

return array(
    'doctrine_orm_module' => array(
        'annotation_file' => $settings['annotation_file'],
        'use_annotations' => $settings['use_annotations'],
    ),
    'di' => array(
        'instance' => array(
            'doctrine_memcache' => array(
                'parameters' => $settings['memcache']
            ),
            'orm_config' => array(
                'parameters' => array(
                    'opts' => array(
                        'entity_namespaces' => $settings['namespace_aliases'],
                        'auto_generate_proxies' => !$settings['production']
                    ),
                    'metadataCache' => $settings['cache'],
                    'queryCache'    => $settings['cache'],
                    'resultCache'   => $settings['cache'],
                )
            ),
            'orm_connection' => array(
                'parameters' => array(
                    'params' => $settings['connection']
                ),
            ),
            'orm_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(
                        'application_annotation_driver' => $settings['driver']
                    ),
                    'cache' => $settings['cache']
                )
            ),
        ),
    ),
);
// return array(
//     'layout'                => 'layout/layout.phtml',
//     'display_exceptions'    => true,
//     'di'                    => array(
//         'instance' => array(
//             'alias' => array(
//                 'index' => 'Application\Controller\IndexController',
//                 'error' => 'Application\Controller\ErrorController',
//                 'view'  => 'Zend\View\PhpRenderer',
//             ),
//         ),
// 	),
// );
