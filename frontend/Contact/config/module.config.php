<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'contact' => 'Contact\Controller\IndexController',
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'Contact' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);
