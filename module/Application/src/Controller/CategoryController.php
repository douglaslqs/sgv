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
use Application\Service\ResponseService;

class CategoryController extends AbstractRestfulController
{
    private $categoryTable;
    private $form;
    private $responseService;

    public function __construct(ResponseService $responseService, CategoryTable $categoryTable)
    {
        $this->responseService = $responseService;
        $this->categoryTable = $categoryTable;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function indexAction()
    {
       	return new JsonModel('Bem vindo!');
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
                    $this->responseService->setData($category);
                    $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                } else {
                    $this->responseService->setCode(ResponseService::CODE_QUERY_EMPTY);
                }
            } catch (Exception $e) {
                $this->responseService->setCode(ResponseService::CODE_ERROR);
                //gravar log aqui $e->getMessage();
            }
        } else {
            $this->responseService->setCode(ResponseService::CODE_METHOD_INCORRECT);
        }
        return new JsonModel($this->responseService->getArrayCopy());
    }

    public function addAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $arrParams = $request->getPost()->toArray();
            $arrParams = array_change_key_case($arrParams, CASE_LOWER);
            try {
                $this->form->setData($arrParams);
                if ($this->form->isValid()) {
                    $category = $this->categoryTable->fetchRow($arrParams['name']);
                    if (!isset($category->name)) {
                        $returnInsert = $this->categoryTable->insert($arrParams);
                        if ($returnInsert !== 1) {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            //Gravar Log
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        }
                    } else {
                        $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                    }
                } else {
                    $this->responseService->setCode(ResponseService::CODE_NOT_PARAMS_VALIDATED);
                }
            } catch (Exception $e) {
                $this->responseService->setCode(ResponseService::CODE_ERROR);
                //Gravar Log
            }
        } else {
            $this->responseService->setCode(ResponseService::CODE_METHOD_INCORRECT);
        }
        return new JsonModel($this->responseService->getArrayCopy());
    }

    public function updateAction()
    {
        //Metodo PUT; só funcionou com x-www-form-urlencoded
    	parse_str($this->getRequest()->getContent(), $output);
        return new JsonModel($output);
    }
}
