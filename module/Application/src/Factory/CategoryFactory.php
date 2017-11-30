<?php

/**
* 
*/
namespace Application\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\CategoryTable;
use Application\Controller\CategoryController;

class CategoryFactory implements FactoryInterface
{
	
	public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
	{
	    $categoryTable = $container->get(CategoryTable::class);
	    return new CategoryController($categoryTable);
	}
}