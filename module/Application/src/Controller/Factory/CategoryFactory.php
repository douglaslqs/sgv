<?php

/**
*
*/
namespace Application\Controller\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\CategoryTable;
use Application\Form\CategoryForm;
use Application\Controller\CategoryController;
use Application\Service\ResponseService;
use Application\Service\FilterService;
use Application\Service\LoggerService;

class CategoryFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $categoryTable = $container->get(CategoryTable::class);
	    $responseService = $container->get(ResponseService::class);
	    $categoryController = new $requestedName($responseService, $categoryTable);
	    $categoryController->setLogger($container->get(LoggerService::class));
	    $categoryController->setFilterService($container->get(FilterService::class));
	    $categoryController->setForm(new CategoryForm());
	    return $categoryController;
	}
}