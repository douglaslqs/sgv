<?php

/**
*
*/
namespace Administrator\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Administrator\Form\LoginForm;
use Application\Model\UserTable;
use Administrator\Controller\Controller;
use Application\Service\LoggerService;
use Administrator\Service\AuthManagerService;
use Zend\Authentication\AuthenticationService;
use Administrator\Model\ClientTable;
use Zend\Session\Container;

class AuthFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $authenticateService = $container->get(AuthenticationService::class);
	    $authManager = $container->get(AuthManagerService::class);
	    $clientTable = $container->get(ClientTable::class);
	    $userTable = $container->get(UserTable::class);
	    $controller = new $requestedName($userTable,$clientTable,$authManager,$authenticateService);
	    $controller->setLogger($container->get(LoggerService::class));
	    $controller->setForm(new LoginForm());
	    $controller->setSessionUser(new Container('user'));
	    return $controller;
	}
}