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

class MarkFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $controller = new $requestedName;
	    $controller->setLogger($container->get(LoggerService::class));
	    return $controller;
	}
}