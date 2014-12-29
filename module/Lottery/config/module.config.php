<?php
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
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/main[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Lottery\Controller\Main',
                        'action'     => 'index',
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
);