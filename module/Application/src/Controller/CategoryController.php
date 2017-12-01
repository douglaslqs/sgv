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
    private $categoryTable;
    private $form;

    public function __construct(CategoryTable $categoryTable)
    {
        $this->categoryTable = $categoryTable;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function indexAction()
    {
       	return new JsonModel(array("ação não encontrada"));
    }

    public function getAction()
    {
       	$request = $this->getRequest();
        if($request->isGet()){            
            $arrParams = $request->getQuery()->toArray();
            try {
                if(!empty($arrParams)){
                    $arrParams = array_change_key_case($arrParams, CASE_LOWER);
                    $category = $this->categoryTable->fetchAll($arrParams)->toArray();
                } else {
                    $category = $this->categoryTable->fetchAll()->toArray();
                }
                if(!empty($category)){
                    $arrReturn['data'] = $category;
                    $arrReturn['message']['responseMessage'] = "Successful request";
                } else {
                    $arrReturn['message']['responseMessage'] = "The query returned empty";
                }
                $this->response->setStatusCode(200);
                $this->response->setContent('Success');
                $arrReturn['message']['responseType'] = "Success";
            } catch (Exception $e) {
                $arrReturn['message']['responseType'] = "Erro";
                $arrReturn['message']['responseMessage'] = "A error uncurred: " .$e->getMessage();
                $this->response->setStatusCode(404);
                $this->response->setContent('Error');
            }            
        } else{
            $arrReturn['message']['responseType'] = "Erro";
            $arrReturn['message']['responseMessage'] = "Waiting for a POST method";
            $this->response->setStatusCode(400);
            $this->response->setContent('Error');
        }
        return new JsonModel($arrReturn);
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $arrParams = $request->getPost()->toArray();
            $arrParams = array_change_key_case($arrParams, CASE_LOWER);
            $this->form->setData($arrParams);
            if ($this->form->isValid()) {
                $category = $this->categoryTable->fetchRow($arrParams['name']);                
                if (!isset($category->name)) {
                    $returnInsert = $this->categoryTable->insert($arrParams);
                    $this->response->setStatusCode(200);
                    $this->response->setContent('Success');
                    $arrReturn['message']['responseType'] = "Success";
                    $arrReturn['message']['responseMessage'] = "Successful request";
                } else {
                    $arrReturn['message']['responseType'] = "Erro";
                    $arrReturn['message']['responseMessage'] = "Category already exists";
                    $this->response->setStatusCode(400);
                    $this->response->setContent('Error');
                }
            } else {
                $arrReturn['message']['responseType'] = "Erro";
                $arrReturn['message']['responseMessage'] = "Required parameter not found";
                $this->response->setStatusCode(400);
                $this->response->setContent('Error');
            }
        } else {
            $arrReturn['message']['responseType'] = "Erro";
            $arrReturn['message']['responseMessage'] = "Waiting for a POST method";
            $this->response->setStatusCode(400);
            $this->response->setContent('Error');
        }
        return new JsonModel($arrReturn);
    }

    public function updateAction()
    {
        //Metodo PUT;
    	parse_str($this->getRequest()->getContent(), $output);        
        return new JsonModel($output);
    }
}
