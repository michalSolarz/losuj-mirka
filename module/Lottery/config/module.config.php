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
            'archives' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/archives[/][:action][/:page][/:limit]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[0-9]+',
                        'limit' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Lottery\Controller\Main',
                        'action' => 'archives',
                    ),
                ),
            ),
            'countPages' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/countPages[/][:action][/:limit]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'limit' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Lottery\Controller\Main',
                        'action' => 'countPages',
                        'limit' => 10,
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'lottery' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'paginationHelper' => 'Lottery\View\Helper\PaginationHelper'
        )
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