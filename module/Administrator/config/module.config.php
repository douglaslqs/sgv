<?php
namespace Administrator;

use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            Controller\AuthController::class => Controller\Factory\AuthFactory::class,
        ],
        'aliases' => [
            'index' => Controller\IndexController::class,
            'auth' => Controller\AuthController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'administrator' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/administrator',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  =>  [
                    'default'   =>[
                        'type'  =>  Segment::class,
                        'options'   =>  [
                            'route' =>  '/[:controller[/][[/]:action[/]][[/]:id]]',
                            'constraints'   =>  [
                                'controller'    =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'        =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id1'           =>  '[0-9_-]*'
                            ],
                            'defaults'  =>  [
                                'action'     => 'index',
                            ],
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
    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class=>Service\Factory\AuthenticationFactory::class,
            Service\AuthManagerService::class=>Service\Factory\AuthManagerFactory::class,
            Service\AuthAdapterService::class=>Service\Factory\AuthAdapterFactory::class,
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'Administrator' => __DIR__ . '/../view',
        ],
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'administrator/index/index' => __DIR__ . '/../view/administrator/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
    ],
];
