<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'user' => 'User\Controller\IndexController',
                'profiles' => 'User\Controller\ProfilesController',
                'portfolio' => 'User\Controller\PortfolioController',
                'resume' => 'User\Controller\ResumeController',
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'User' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);
