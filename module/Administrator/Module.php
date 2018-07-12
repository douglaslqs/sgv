<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Administrator\Model\Entity\ClientEntity;
use Administrator\Model\ClientTable;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
        //VERIFICA SE USUÁRIO ESTÁ LOGADO
    	$app = $e->getApplication();
        $app->getEventManager()->attach(
            'dispatch',
            function($e) {
                $app = $e->getApplication();
	            $routeMatch = $e->getRouteMatch();
                $authService = $app->getServiceManager()->get(\Zend\Authentication\AuthenticationService::class);
                if (empty($authService->getIdentity()) && $routeMatch->getParam('controller') != 'auth') {
                    $url = $e->getRouter ()->assemble(array("controller" => "auth"),array('name' => 'administrator'));
                    $response = $e->getResponse ();
                            $response->setHeaders($response->getHeaders()->addHeaderLine('Location','/administrator/auth/session-expired'));
                            $response->setStatusCode(302);
                            $response->sendHeaders();
                            exit ();
                }
                $viewModel = $e->getViewModel();
	            $viewModel->setVariable('controller', $routeMatch->getParam('controller'));
	            $viewModel->setVariable('action', $routeMatch->getParam('action'));
                $sessionUser = new \Zend\Session\Container('user');
                $viewModel->setVariable('username', $sessionUser->offsetGet('name'));
	        },
	        -100
	    );
    }

     public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
				'Administrator\Model\ClientTable' =>  function($sm) {
    				$tableGateway = $sm->get('ClientTableGateway');
    				return new ClientTable($tableGateway);
    			},
    			'ClientTableGateway' => function ($sm) {
    				$dbAdapter = $sm->get('client-adapter');
    				$resultSetPrototype = new ResultSet();
    				$resultSetPrototype->setArrayObjectPrototype(new ClientEntity());
    				return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
    			},
    		)
    	);
    }
}
