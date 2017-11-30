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
        //handle the dispatch error (exception)
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'handleError'));
        $em->attach(\Zend\Mvc\MvcEvent::EVENT_RENDER, array($this, 'onRenderError'));   
    }

    public function onRenderError(\Zend\Mvc\MvcEvent $e)
    {
        $response = $e->getApplication()->getResponse();
        $cod = $response->getStatusCode();
        if ($cod === 404) {
            $dataReturn['message']['responseType'] = "Erro";
            $dataReturn['message']['responseMessage'] = "Check the url! Error message: Page not Found";
            $view = new \Zend\View\Model\JsonModel($dataReturn);
            echo $view->serialize();exit();
        }
    }

    /**
     * Method for handling error
     */
    public function handleError(\Zend\Mvc\MvcEvent $e)
    {
        $exception = $e->getParam('exception');
        $dataReturn['message']['responseType'] = "Erro";
        $dataReturn['message']['responseMessage'] = "Verify all params and url router! Error message: ";
        if (!empty($exception)) {
            $msgException = $e->getParam('exception')->getMessage();
            $dataReturn['message']['responseMessage'] .= $e->getParam('exception')->getMessage();
        }
        $response = $e->getApplication()->getResponse();
        $response->setStatusCode(400);
        $response->setContent('Error');
        $view = new \Zend\View\Model\JsonModel($dataReturn);
        echo $view->serialize();exit();
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
