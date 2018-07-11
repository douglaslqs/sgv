<?php

/**
*
*/
namespace Administrator\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Administrator\Form\LoginForm;
use Administrator\Controller\Controller;
use Application\Service\LoggerService;

class LoginFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $controller = new $requestedName($responseService, $table);
	    $controller->setLogger($container->get(LoggerService::class));
	    $controller->setForm(new LoginForm());
	    return $controller;
	}
}