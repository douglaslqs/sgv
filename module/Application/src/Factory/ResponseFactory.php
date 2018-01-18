<?php

/**
* 
*/
namespace Application\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\ResponseService;

class ResponseFactory implements FactoryInterface
{
	public function __invoke()
	{
	    return new ResponseService();
	}
}