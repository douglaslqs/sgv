<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\ClientTable;
use Application\Form\ClientForm;
use Application\Service\ResponseService;
use Application\Service\FilterService;
use Application\Service\LoggerService;

class ClientFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $table = $container->get(ClientTable::class);
	    $responseService = $container->get(ResponseService::class);
	    $controller = new $requestedName($responseService, $table);
	    $controller->setLogger($container->get(LoggerService::class));
	    $controller->setFilterService($container->get(FilterService::class));
	    $controller->setForm(new ClientForm());
	    $bcrypt = new \Zend\Crypt\Password\Bcrypt();
	    $controller->setBcrypt($bcrypt);
	    return $controller;
	}
}