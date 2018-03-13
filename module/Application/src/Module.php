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
            echo $view->serialize();exit;
        }
        if ($usernameDb === false) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_TOKEN_INVALID);
            $responseService->setMessage("Access Token Not Found!");
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            echo $view->serialize();exit;
        }
    }

    public function onRenderError(\Zend\Mvc\MvcEvent $e)
    {
        $response = $e->getApplication()->getResponse();
        $cod = $response->getStatusCode();
        $messageError = $response->getReasonPhrase();
        $response = $e->getApplication()->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        if ($cod === 404) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_ERROR);
            $responseService->setMessage("Page not Found. Check the url!");
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            echo $view->serialize();exit;
        } else if ($cod !== 200) {
            $loggerService = $e->getApplication()->getServiceManager()->get(LoggerService::class);
            $loggerService->setMethodAndLine(__METHOD__, __LINE__);
            $loggerService->save(LoggerService::LOG_APPLICATION, LoggerService::CRITICAL ,"COD STATUS: ".$cod." - MSG ERROR: ".$messageError);

            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_ERROR);
            $responseService->setMessage("An error unknow occurred! Cod. error: ".$cod." - MSG ERROR: ".$messageError);
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            echo $view->serialize();exit;
        }
    }

    public function onDispatchError(\Zend\Mvc\MvcEvent $e)
    {
        if ($e->isError()) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $exception = $e->getParam('exception');
            $responseService->setCode(ResponseService::CODE_ERROR);
            $responseService->setMessage("Verify all params and url router then try again!");
            if (!empty($exception)) {
                $messageError = $e->getParam('exception')->getMessage();
                $loggerService = $e->getApplication()->getServiceManager()->get(LoggerService::class);
                $loggerService->setMethodAndLine(__METHOD__, __LINE__);
                $loggerService->save(LoggerService::LOG_APPLICATION, LoggerService::CRITICAL ,"Msg Error: ".$messageError);

                $responseService->setMessage($responseService->getMessage()." - DETAILS ERROR: ".$messageError);
            }
            $response = $e->getApplication()->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $jsonModel = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            echo $jsonModel->serialize();exit;
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
	    				$table = new CategoryTable($tableGateway);
	    				return $table;
	    			},
    			'CategoryTableGateway' => function ($sm) {
    				$dbAdapter = $sm->get('store-adapter');
    				$resultSetPrototype = new ResultSet();
    				$resultSetPrototype->setArrayObjectPrototype(new CategoryEntity());
    				return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
    			},
                'Application\Service\ResponseService' => function($sm) {
                    return new Factory\ResponseFactory();
                },
                'Application\Service\LoggerService' => function($sm) {
                    return new Application\Service\LoggerService();
                }
    		)
    	);
    }
}
