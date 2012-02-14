<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'gallery' => 'Gallery\Controller\IndexController',
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'Gallery' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
