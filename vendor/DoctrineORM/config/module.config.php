<?php
return array(
    'doctrine_orm_module' => array(
        'annotation_file' => __DIR__ . '/../../Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php',
        'use_annotations' => true,
    ),
    'di' => array(
        'definition' => array(
            'class' => array(
                'Memcache' => array(
                    'addServer' => array(
                        'host' => array('type' => false, 'required' => true),
                        'port' => array('type' => false, 'required' => true),
                    )
                ),
                'DoctrineORM\Factory\EntityManager' => array(
                    'instantiator' => array('DoctrineORM\Factory\EntityManager', 'get'),
                    'methods' => array(
                        'get' => array(
                            'conn' => array('type' => 'DoctrineORM\Doctrine\ORM\Connection', 'required' => true)
                        )
                    )
                ),
            ),
        ),
        'instance' => array(
            'alias' => array(
                // entity manager
                'doctrine_em' => 'DoctrineORM\Factory\EntityManager',
                'orm_em'      => 'doctrine_em',
                
                // configuration
                'orm_config'       => 'DoctrineORM\Doctrine\ORM\Configuration',
                'orm_connection'   => 'DoctrineORM\Doctrine\ORM\Connection',
                'orm_driver_chain' => 'DoctrineORM\Doctrine\ORM\DriverChain',
                'orm_evm'          => 'DoctrineORM\Doctrine\Common\EventManager',
                
                // services
                'doctrine_service' => 'DoctrineORM\Service\Service',
                
                // caching
                'doctrine_memcache'       => 'Memcache',
                'doctrine_cache_apc'      => 'Doctrine\Common\Cache\ApcCache',
                'doctrine_cache_array'    => 'Doctrine\Common\Cache\ArrayCache',
                'doctrine_cache_memcache' => 'Doctrine\Common\Cache\MemcacheCache',                    
            ),
            'doctrine_memcache' => array(
                'parameters' => array(
                    'host' => '127.0.0.1',
                    'port' => '11211'
                )
            ),
            'doctrine_cache_memcache' => array(
                'parameters' => array(
                    'memcache' => 'doctrine_memcache'
                )
            ),                
            'orm_config' => array(
                'parameters' => array(
                    'opts' => array(
                        'auto_generate_proxies'     => true,
                        'proxy_dir'                 => __DIR__ . '/../../../data/proxy',
                        'proxy_namespace'           => 'DoctrineORM\Proxy',
                        'entity_namespaces'         => array(),
                        'custom_datetime_functions' => array(),
                        'custom_numeric_functions'  => array(),
                        'custom_string_functions'   => array(),
                        'custom_hydration_modes'    => array(),
                        'named_queries'             => array(),
                        'named_native_queries'      => array(),
                    ),
                    'metadataDriver' => 'orm_driver_chain',
                    'metadataCache'  => 'doctrine_cache_array',
                    'queryCache'     => 'doctrine_cache_array',
                    'resultCache'    => null,
                    'logger'         => null,
                )
            ),
            'orm_connection' => array(
                'parameters' => array(
                    'params' => array(
                        'driver'   => 'pdo_mysql',
                        'host'     => 'localhost',
                        'port'     => '3306', 
                        'user'     => 'testuser',
                        'password' => 'testpassword',
                        'dbname'   => 'testdbname',
                    ),
                    'config' => 'orm_config',
                    'evm'    => 'orm_evm',
                    'pdo'    => null
                )
            ),
            'orm_driver_chain' => array(
                'parameters' => array(
                    'drivers' => array(),
                    'cache' => 'doctrine_cache_array'
                )
            ),
            'orm_evm' => array(
                'parameters' => array(
                    'opts' => array(
                        'subscribers' => array()
                    )
                )
            ),
            'doctrine_em' => array(
                'parameters' => array(
                    'conn' => 'orm_connection',
                )
            ),
        )
    )
);
