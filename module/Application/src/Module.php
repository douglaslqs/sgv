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
        if ($cod === 404) {
            $arrReturn['message']['responseType'] = "Erro";
            $arrReturn['message']['responseMessage'] = "Page not Found. Check the url!";
            $view = new \Zend\View\Model\JsonModel($arrReturn);
            echo $view->serialize();exit;
        }
    }

    public function onDispatchError(\Zend\Mvc\MvcEvent $e)
    {
        if ($e->isError()) {
            $exception = $e->getParam('exception');
            $arrReturn['message']['responseMessage'] = "Verify all params and url router!";
            $arrReturn['message']['responseType'] = "Erro";
            if (!empty($exception)) {
                $arrReturn['message']['responseMessage'] .= $e->getParam('exception')->getMessage();
            }
            $response = $e->getApplication()->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type', 'application/json');
            $jsonModel = new \Zend\View\Model\JsonModel($arrReturn);            
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
    		)
    	);
    }
}
