<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterInterface;
use Application\Model\Entity\CategoryEntity;
use Application\Model\CategoryTable;
use Application\Model\Entity\ProductEntity;
use Application\Model\ProductTable;
use Application\Model\Entity\ColorProductEntity;
use Application\Model\ColorProductTable;
use Application\Model\Entity\RoleResourceAllowEntity;
use Application\Model\RoleResourceAllowTable;
use Application\Model\Entity\RoleEntity;
use Application\Model\RoleTable;
use Application\Model\Entity\AllowEntity;
use Application\Model\AllowTable;
use Application\Model\Entity\UserEntity;
use Application\Model\UserTable;
use Application\Model\Entity\ResourceEntity;
use Application\Model\ResourceTable;
use Application\Model\Entity\ImageProductEntity;
use Application\Model\ImageProductTable;
use Application\Model\Entity\ProductOrderEntity;
use Application\Model\ProductOrderTable;
use Application\Model\Entity\DeliveryAddressEntity;
use Application\Model\DeliveryAddressTable;
use Application\Model\Entity\ClientEntity;
use Application\Model\ClientTable;
use Application\Model\Entity\OrderEntity;
use Application\Model\OrderTable;
use Application\Model\Entity\StockEntity;
use Application\Model\StockTable;
use Application\Model\Entity\MarkEntity;
use Application\Model\MarkTable;
use Application\Model\Entity\ColorEntity;
use Application\Model\ColorTable;
use Application\Model\Entity\UnitMeasureEntity;
use Application\Model\UnitMeasureTable;
use Application\Model\Entity\MeasureEntity;
use Application\Model\MeasureTable;
use Application\Service\ResponseService;
use Application\Service\LoggerService;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    const VERSION = '3.0.2';

    private $usernameDb;

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_ROUTE, array($this, 'onRoute'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, array($this, 'onRenderError'));

        /**
         * Tratamento para verificar se o usuário tem acesso ao banco de dados
         * Verificamos o $username para saber se o token é valido ou se nao existe token
         */
        $serviceManager = $application->getServiceManager();
        $config = $serviceManager->get('Config');
        $this->usernameDb = $config['db']['adapters']['store-adapter']['username'];
        if(!isset($this->usernameDb)){
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_TOKEN_INVALID);
            $responseService->setMessage("Invalid Access Token!");
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            $e->setViewModel($view);
        }
        if ($this->usernameDb === false) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_TOKEN_INVALID);
            $responseService->setMessage("Access Token Not Found!");
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            $e->setViewModel($view);
        }
    }

    public function onRenderError(\Zend\Mvc\MvcEvent $e)
    {
        $response = $e->getResponse();
        $cod = $response->getStatusCode();
        $messageError = $response->getReasonPhrase();
        $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
        if (empty($responseService->getCode())) {
            if ($cod === 404) {
                $responseService->setCode(ResponseService::CODE_ERROR);
                $responseService->setMessage("Page not Found. Check the url!");
                $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
                $e->setViewModel($view);
            } else if ($cod !== 200) {
                $loggerService = $e->getApplication()->getServiceManager()->get(LoggerService::class);
                $loggerService->setMethodAndLine(__METHOD__, __LINE__);
                $loggerService->save(LoggerService::LOG_APPLICATION, LoggerService::CRITICAL ,"COD STATUS: ".$cod." - MSG ERROR: ".$messageError);

                $responseService->setCode(ResponseService::CODE_ERROR);
                $responseService->setMessage("An error unknow occurred! Cod. error: ".$cod." - MSG ERROR: ".$messageError);
            }
        }
        $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
        $e->setViewModel($view);
    }

    public function onDispatchError(\Zend\Mvc\MvcEvent $e)
    {
        if ($e->isError()) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            if (empty($responseService->getCode())) {
                $responseService->setCode(ResponseService::CODE_ERROR);
                $responseService->setMessage("Verify all params and url router then try again!");
                $loggerService = $e->getApplication()->getServiceManager()->get(LoggerService::class);
                $exception = $e->getParam('exception');
                if (!empty($exception)) {
                    $messageError = $e->getParam('exception')->getMessage();
                    $loggerService->setMethodAndLine(__METHOD__, __LINE__);
                    $loggerService->save(LoggerService::LOG_APPLICATION, LoggerService::CRITICAL ,"Msg Error: ".$messageError);
                    $responseService->setMessage($responseService->getMessage()." - DETAILS ERROR: ".$messageError);
                } else if ($e->getError()) {
                    $loggerService->setMethodAndLine(__METHOD__, __LINE__);
                    $loggerService->save(LoggerService::LOG_APPLICATION, LoggerService::ALERT ,"Msg Error: ".$e->getError());
                    $responseService->setMessage($responseService->getMessage()." - DETAILS ERROR: ".$e->getError());
                }
                $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
                $e->setViewModel($view);
            }
        }
    }

    public function onRoute(\Zend\Mvc\MvcEvent $e)
    {

        if(isset($this->usernameDb) && $this->usernameDb !== false){
            //FORCE HTTPS
            // Get request URI
            /*$uri = $event->getRequest()->getUri();
            $scheme = $uri->getScheme();
            if ($scheme != 'https'){
                $uri->setScheme('https');
                $response=$event->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $uri);
                $response->setStatusCode(301);
                $response->sendHeaders();
                return $response;
            } */

            $objServiceManager = $e->getApplication()->getServiceManager();
            $objAclService = $objServiceManager->get(Service\AclService::class);
            $arrRouteParams = $e->getRouteMatch()->getParams();

            $strControllerName = $arrRouteParams['controller'];
            $strActionName = $arrRouteParams['action'];

            $strModuleController = $e->getRouteMatch()->getMatchedRouteName().'/'.$strControllerName;

            if (!empty($objAclService->getRole()) && $objAclService->getRole() != 'admin') {
                if (!$objAclService->getObjAcl()->hasResource($strModuleController) || !$objAclService->getObjAcl()->isAllowed($objAclService->getRole(), $strModuleController, $strActionName)) {
                    $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
                    $responseService->setCode(ResponseService::CODE_ACCESS_DENIED);
                    echo json_encode($responseService->getArrayCopy());exit;
                    //$view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
                    //return $e->setViewModel($view);exit;
                }
            }
        }
    }
    /*
    public function onDispatch(MvcEvent $e)
    {

    }
    */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
				'Application\Model\CategoryTable' =>  function($sm) {
    				$tableGateway = $sm->get('CategoryTableGateway');
    				return new CategoryTable($tableGateway);
    			},
    			'CategoryTableGateway' => function ($sm) {
    				$dbAdapter = $sm->get('store-adapter');
    				$resultSetPrototype = new ResultSet();
    				$resultSetPrototype->setArrayObjectPrototype(new CategoryEntity());
    				return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
    			},
                'Application\Model\ProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductTableGateway');
                    return new ProductTable($tableGateway);
                },
                'ProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProductEntity());
                    return new TableGateway('product', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\MarkTable' =>  function($sm) {
                    $tableGateway = $sm->get('MarkTableGateway');
                    return new MarkTable($tableGateway);
                },
                'MarkTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new MarkEntity());
                    return new TableGateway('mark', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\UnitMeasureTable' =>  function($sm) {
                    $tableGateway = $sm->get('UnitMeasureTableGateway');
                    return new UnitMeasureTable($tableGateway);
                },
                'UnitMeasureTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UnitMeasureEntity());
                    return new TableGateway('unit_measure', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\MeasureTable' =>  function($sm) {
                    $tableGateway = $sm->get('MeasureTableGateway');
                    return new MeasureTable($tableGateway);
                },
                'MeasureTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new MeasureEntity());
                    return new TableGateway('measure', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ColorTable' =>  function($sm) {
                    $tableGateway = $sm->get('ColorTableGateway');
                    return new ColorTable($tableGateway);
                },
                'ColorTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ColorEntity());
                    return new TableGateway('color', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ClientTable' =>  function($sm) {
                    $tableGateway = $sm->get('ClientTableGateway');
                    return new ClientTable($tableGateway);
                },
                'ClientTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ClientEntity());
                    return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\OrderTable' =>  function($sm) {
                    $tableGateway = $sm->get('OrderTableGateway');
                    return new OrderTable($tableGateway);
                },
                'OrderTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new OrderEntity());
                    return new TableGateway('order', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\StockTable' =>  function($sm) {
                    $tableGateway = $sm->get('StockTableGateway');
                    return new StockTable($tableGateway);
                },
                'StockTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new StockEntity());
                    return new TableGateway('stock', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ColorProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('ColorProductTableGateway');
                    return new ColorProductTable($tableGateway);
                },
                'ColorProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ColorProductEntity());
                    return new TableGateway('color_product', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ProductOrderTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProductOrderTableGateway');
                    return new ProductOrderTable($tableGateway);
                },
                'ProductOrderTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ProductOrderEntity());
                    return new TableGateway('product_order', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\DeliveryAddressTable' =>  function($sm) {
                    $tableGateway = $sm->get('DeliveryAddressTableGateway');
                    return new DeliveryAddressTable($tableGateway);
                },
                'DeliveryAddressTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new DeliveryAddressEntity());
                    return new TableGateway('delivery_address', $dbAdapter, null, $resultSetPrototype);
                },
                'Application\Model\ImageProductTable' =>  function($sm) {
                    $tableGateway = $sm->get('ImageProductTableGateway');
                    return new ImageProductTable($tableGateway);
                },
                'ImageProductTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ImageProductEntity());
                    return new TableGateway('image_product',$dbAdapter,null,$resultSetPrototype);
                },
                'Application\Model\RoleResourceAllowTable' =>  function($sm) {
                    $tableGateway = $sm->get('RoleResourceAllowTableGateway');
                    return new RoleResourceAllowTable($tableGateway);
                },
                'RoleResourceAllowTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new RoleResourceAllowEntity());
                    return new TableGateway('role_resource_allow',$dbAdapter,null,$resultSetPrototype);
                },
                'Application\Model\RoleTable' =>  function($sm) {
                    $tableGateway = $sm->get('RoleTableGateway');
                    return new RoleTable($tableGateway);
                },
                'RoleTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new RoleEntity());
                    return new TableGateway('role',$dbAdapter,null,$resultSetPrototype);
                },
                'Application\Model\ResourceTable' =>  function($sm) {
                    $tableGateway = $sm->get('ResourceTableGateway');
                    return new ResourceTable($tableGateway);
                },
                'ResourceTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ResourceEntity());
                    return new TableGateway('resource',$dbAdapter,null,$resultSetPrototype);
                },
                'Application\Model\AllowTable' =>  function($sm) {
                    $tableGateway = $sm->get('AllowTableGateway');
                    return new AllowTable($tableGateway);
                },
                'AllowTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new AllowEntity());
                    return new TableGateway('allow',$dbAdapter,null,$resultSetPrototype);
                },
                'Application\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    return new UserTable($tableGateway);
                },
                'UserTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('store-adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserEntity());
                    return new TableGateway('user',$dbAdapter,null,$resultSetPrototype);
                },
    		)
    	);
    }
}
