<?php

/**
*
*/
namespace Administrator\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Administrator\Form\LoginForm;
use Application\Model\Entity\UserEntity;
use Administrator\Controller\Controller;
use Application\Service\LoggerService;
use Administrator\Service\AuthManagerService;
use Zend\Authentication\AuthenticationService;
use Administrator\Model\ClientTable;

class AuthFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $authenticateService = $container->get(AuthenticationService::class);
	    $authManager = $container->get(AuthManagerService::class);
	    $clientTable = $container->get(ClientTable::class);
	    $controller = new $requestedName(new UserEntity(),$clientTable,$authManager,$authenticateService);
	    $controller->setLogger($container->get(LoggerService::class));
	    $controller->setForm(new LoginForm());
	    return $controller;
	}
}