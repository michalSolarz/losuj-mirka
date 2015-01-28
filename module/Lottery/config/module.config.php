<?php
namespace Lottery;

return array(
    'controllers' => array(
        'invokables' => array(
            'Lottery\Controller\Main' => 'Lottery\Controller\MainController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'main' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/main[/][:action][/:hash]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'hash' => '[a-zA-Z0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Lottery\Controller\Main',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'lottery' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_entities'
                )
            )),
    )
);