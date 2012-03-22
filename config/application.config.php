<?php
return array(
    'modules' => array(
        'AdminCP',
        'Gallery',
        'Application',
        //'DoctrineModule',
        //'DoctrineORM',
    ),
    'module_listener_options' => array( 
        'config_cache_enabled' => false,
        'cache_dir'            => 'data/cache',
        'module_paths' => array(
            './frontend',
            './backend',
            './vendor',
        ),
    ),
);
