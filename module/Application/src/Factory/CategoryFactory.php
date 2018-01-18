<?php

/**
*
*/
namespace Application\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\CategoryTable;
use Application\Form\CategoryForm;
use Application\Controller\CategoryController;
use Application\Service\ResponseService;

class CategoryFactory implements FactoryInterface
{

	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $categoryTable = $container->get(CategoryTable::class);
	    $categoryControler = new CategoryController(new ResponseService(), $categoryTable);
	    $categoryControler->setForm(new CategoryForm());
	    return $categoryControler;
	}
}