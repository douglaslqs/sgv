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
use Application\Model\Entity\MarkEntity;
use Application\Model\MarkTable;
use Application\Service\ResponseService;
use Application\Service\LoggerService;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    const VERSION = '3.0.2';

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        $application = $e->getApplication();
        $em = $application->getEventManager();
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, array($this, 'onRenderError'));

        /**
         * Tratamento para verificar se o usuário tem acesso ao banco de dados
         * Verificamos o $username para saber se o token é valido ou se nao existe token
         */
        $serviceManager = $application->getServiceManager();
        $config = $serviceManager->get('Config');
        $usernameDb = $config['db']['adapters']['store-adapter']['username'];
        if(!isset($usernameDb)){
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_TOKEN_INVALID);
            $responseService->setMessage("Invalid Access Token!");
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            $e->setViewModel($view);
        }
        if ($usernameDb === false) {
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
                $exception = $e->getParam('exception');
                if (!empty($exception)) {
                    $messageError = $e->getParam('exception')->getMessage();
                    $loggerService = $e->getApplication()->getServiceManager()->get(LoggerService::class);
                    $loggerService->setMethodAndLine(__METHOD__, __LINE__);
                    $loggerService->save(LoggerService::LOG_APPLICATION, LoggerService::CRITICAL ,"Msg Error: ".$messageError);

                    $responseService->setMessage($responseService->getMessage()." - DETAILS ERROR: ".$messageError);
                }
                $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
                $e->setViewModel($view);
            }
        }
    }

    /*public function onRoute(MvcEvent $e)
    {

    }

    public function onDispatch(MvcEvent $e)
    {

    } */

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
    		)
    	);
    }
}
