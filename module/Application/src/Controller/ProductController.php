<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ProductController extends AbstractRestfulController
{
    public function indexAction()
    {
       	return new JsonModel(array("ação não encontrada"));
    }

    public function getAction()
    {
       	return new JsonModel(array("getProduto"));
    }

    public function addAction()
    {
    	return new JsonModel(array("addProduto"));	
    }

    public function updateAction()
    {
    	return new JsonModel(array("updateProduto"));	
    }
}
