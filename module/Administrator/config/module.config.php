<?php
namespace Administrator;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\AdministratorController::class => InvokableFactory::class,
        ],
        'aliases' => [
            'index' => Controller\AdministratorController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'administrator' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/administrator',
                    'defaults' => [
                        'controller' => Controller\AdministratorController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  =>  [
                    'default'   =>[
                        'type'  =>  Segment::class,
                        'options'   =>  [
                            'route' =>  '/[:controller[/][[/]:action][/:id]]',
                            'constraints'   =>  [
                                'controller'    =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id1'           =>  '[0-9_-]*'
                            ],
                            'defaults'  =>  [],
                        ],
                    ],
                ],
            ],

            /*'administrator' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/administrator[/][/:controller][/][/:action][/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ], */
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Administrator' => __DIR__ . '/../view',
        ],
    ],
];
