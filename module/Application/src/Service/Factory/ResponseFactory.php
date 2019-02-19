<?php

/**
*
*/
namespace Application\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Service\PaginatorService;

class ResponseFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
    	$paginator = $container->get(PaginatorService::class);
        return new $requestedName($paginator);
    }

}