<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Model\CategoryTable;

class CategoryController extends AbstractRestfulController
{
    //private $categoryTable;

    public function __construct(CategoryTable $categoryTable)
    {
        $this->categoryTable = $categoryTable;
    }

    public function indexAction()
    {
       	return new JsonModel(array("ação não encontrada"));
    }

    public function getAction()
    {
       	return new JsonModel(array("getCategoria"));
    }

    public function addAction()
    {
        $categorias = $this->categoryTable->fetchAll();
        return new JsonModel($categorias->toArray());
        $request = $this->getRequest();
        if ($request->isPost()) {
            $this->response->setStatusCode(200);
            $this->response->setContent('Success');
            $dataReturn['message']['responseType'] = "Success";
            $dataReturn['message']['responseMessage'] = "Method POST";            
        } else {
            $dataReturn['message']['responseType'] = "Erro";
            $dataReturn['message']['responseMessage'] = "Waiting for a POST method";
            $this->response->setStatusCode(404);
            $this->response->setContent('Error');
        }
        return new JsonModel($dataReturn);
    }

    public function updateAction()
    {
        //Metodo PUT;
    	parse_str($this->getRequest()->getContent(), $output);        
        return new JsonModel($output);
    }
}
