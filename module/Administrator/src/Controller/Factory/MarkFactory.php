<?php

/**
*
*/
namespace Administrator\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Service\LoggerService;
use Administrator\Service\ApiRequestService;

class MarkFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $controller = new $requestedName($container->get(ApiRequestService::class));
	    $controller->setLogger($container->get(LoggerService::class));
	    return $controller;
	}
}