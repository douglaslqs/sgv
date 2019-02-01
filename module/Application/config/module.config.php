<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Mvc\Controller\LazyControllerAbstractFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'store' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/store[/:controller][/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\ResponseService::class => Service\Factory\ResponseFactory::class,
            Service\PaginatorService::class=> Service\Factory\PaginatorFactory::class,
            Service\LoggerService::class   => Service\Factory\LoggerFactory::class,
            Service\FilterService::class   => Service\Factory\FilterFactory::class,
            Service\AclService::class      => Service\Factory\AclFactory::class,
        ],
    ],
    'controllers' => [
        'factories' => [
            /* controllers que não precisam de factory */
            Controller\IndexController::class             => InvokableFactory::class,
            /* factory padrao. Só precisa escrever o construtor do controller com a dependencia */
            //Controller\IndexController::class => LazyControllerAbstractFactory::class,
            /* factory criada na mão. */
            //Controller\IndexController::class => Factory\IndexControllerFactory::class,
            Controller\ProductController::class           => Controller\Factory\ProductFactory::class,
            Controller\CategoryController::class          => Controller\Factory\CategoryFactory::class,
            Controller\MarkController::class              => Controller\Factory\MarkFactory::class,
            Controller\UnitMeasureController::class       => Controller\Factory\UnitMeasureFactory::class,
            Controller\MeasureController::class           => Controller\Factory\MeasureFactory::class,
            Controller\ColorController::class             => Controller\Factory\ColorFactory::class,
            Controller\ClientController::class            => Controller\Factory\ClientFactory::class,
            Controller\OrderController::class             => Controller\Factory\OrderFactory::class,
            Controller\StockController::class             => Controller\Factory\StockFactory::class,
            Controller\ColorProductController::class      => Controller\Factory\ColorProductFactory::class,
            Controller\ImageProductController::class      => Controller\Factory\ImageProductFactory::class,
            Controller\ProductOrderController::class      => Controller\Factory\ProductOrderFactory::class,
            Controller\ProductCategoryController::class   => Controller\Factory\ProductCategoryFactory::class,
            Controller\DeliveryAddressController::class   => Controller\Factory\DeliveryAddressFactory::class,
            Controller\RoleController::class              => Controller\Factory\RoleFactory::class,
            Controller\ResourceController::class          => Controller\Factory\ResourceFactory::class,
            Controller\AllowController::class             => Controller\Factory\AllowFactory::class,
            Controller\RoleResourceAllowController::class => Controller\Factory\RoleResourceAllowFactory::class,
            Controller\UserController::class              => Controller\Factory\UserFactory::class,
        ],
        'aliases' => [
            //'index'            => 'Application\Controller\IndexController',
            'product'             => 'Application\Controller\ProductController',
            'product-category'    => 'Application\Controller\ProductCategoryController',
            'category'            => 'Application\Controller\CategoryController',
            'mark'                => 'Application\Controller\MarkController',
            'unit-measure'        => 'Application\Controller\UnitMeasureController',
            'measure'             => 'Application\Controller\MeasureController',
            'color'               => 'Application\Controller\ColorController',
            'client'              => 'Application\Controller\ClientController',
            'order'               => 'Application\Controller\OrderController',
            'stock'               => 'Application\Controller\StockController',
            'color-product'       => 'Application\Controller\ColorProductController',
            'product-order'       => 'Application\Controller\ProductOrderController',
            'delivery-address'    => 'Application\Controller\DeliveryAddressController',
            'image-product'       => 'Application\Controller\ImageProductController',
            'role'                => 'Application\Controller\RoleController',
            'resource'            => 'Application\Controller\ResourceController',
            'allow'               => 'Application\Controller\AllowController',
            'role-resource-allow' => 'Application\Controller\RoleResourceAllowController',
            'user'                => 'Application\Controller\UserController',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'strategies' => [
           'ViewJsonStrategy',
        ],
    ],
];
