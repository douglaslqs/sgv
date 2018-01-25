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
    }

    public function onRenderError(\Zend\Mvc\MvcEvent $e)
    {        
        $response = $e->getApplication()->getResponse();        
        $cod = $response->getStatusCode();
        $response = $e->getApplication()->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
        if ($cod === 404) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_ERROR);
            $responseService->setMessage("Page not Found. Check the url!");
            $view = new \Zend\View\Model\JsonModel($responseService->getArrayCopy());
            echo $view->serialize();exit;
        } else if ($cod !== 200) {
            $responseService = $e->getApplication()->getServiceManager()->get(ResponseService::class);
            $responseService->setCode(ResponseService::CODE_ERROR);
            $responseService->setMessage("An error unknow occurred! Cod. error: ".$cod);
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
            $responseService->setMessage("Verify all params and url router!");            
            if (!empty($exception)) {
                $responseService->setMessage($responseService->getMessage()."-".$e->getParam('exception')->getMessage());
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
                    return new Application\Service\LoogerService();
                }
    		)
    	);
    }
}
