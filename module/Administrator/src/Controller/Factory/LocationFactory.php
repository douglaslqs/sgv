<?php

/**
*
*/
namespace Administrator\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Service\LoggerService;

class LocationFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $controller = new $requestedName($container->get(\Zend\I18n\Translator\TranslatorInterface::class));
	    $controller->setLogger($container->get(LoggerService::class));
	    return $controller;
	}
}