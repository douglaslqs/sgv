<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\UnitMeasureTable;
use Application\Form\UnitMeasureForm;
use Application\Controller\UnitMeasureController;
use Application\Service\ResponseService;
use Application\Service\FilterService;
use Application\Service\LoggerService;

class UnitMeasureFactory implements FactoryInterface
{
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $table = $container->get(UnitMeasureTable::class);
	    $responseService = $container->get(ResponseService::class);
	    $controller = new $requestedName($responseService, $table);
	    $controller->setLogger($container->get(LoggerService::class));
	    $controller->setFilterService($container->get(FilterService::class));
	    $controller->setForm(new UnitMeasureForm());
	    return $controller;
	}
}