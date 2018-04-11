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
use Application\Service\LoggerService as Logger;

class CategoryController extends AbstractRestfulController
{
    private $categoryTable;
    private $form;
    private $responseService;
    private $filterService;
    private $logger;

    public function __construct(ResponseService $responseService, CategoryTable $categoryTable)
    {
        $this->responseService = $responseService;
        $this->categoryTable = $categoryTable;
    }


    public function indexAction()
    {
        return new JsonModel(array('Bem-vindo!'));
    }

    public function getAction()
    {
        $request = $this->getRequest();
        if($request->isGet()){
            $arrParams = $request->getQuery()->toArray();
            try {
                if(!empty($arrParams)){
                    $arrParams = array_change_key_case($arrParams, CASE_LOWER);
                }
                $category = $this->categoryTable->fetch($arrParams);
                if(!empty($category)){
                    $this->responseService->setData($category);
                    $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                } else {
                    $this->responseService->setCode(ResponseService::CODE_QUERY_EMPTY);
                }
            } catch (Exception $e) {
                $this->responseService->setCode(ResponseService::CODE_ERROR);
                $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
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
                    $arrParams = $this->filterService->setData($arrParams)->getData();
                    $category = $this->categoryTable->fetch(array('name' => $arrParams['name']));
                    $categoryParent = $this->categoryTable->fetch(array('name_parent' => $arrParams['name_parent']), 1);
                    if (empty($category) && is_array($categoryParent)) {
                        $returnInsert = $this->categoryTable->insert($arrParams);
                        if ($returnInsert !== 1) {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::ALERT,$returnInsert);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        }
                    } else {
                        if (is_array($category)) {
                            $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::WARNING,$category);
                        }
                    }
                } else {
                    $this->responseService->setData($this->form->getInputFilter()->getMessages());
                    $this->responseService->setCode(ResponseService::CODE_NOT_PARAMS_VALIDATED);
                }
            } catch (Exception $e) {
                $this->responseService->setCode(ResponseService::CODE_ERROR);
                $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
            }
        } else {
            $this->responseService->setCode(ResponseService::CODE_METHOD_INCORRECT);
        }
        return new JsonModel($this->responseService->getArrayCopy());
    }

    public function updateAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $arrParams = $request->getPost()->toArray();
            $arrParams = array_change_key_case($arrParams, CASE_LOWER);
            try {
                $this->form->setData($arrParams);
                //Neste caso, podemos utilizar o validador form. Ver a necessidade de um "formUpdate"
                if ($this->form->isValid()) {
                    $arrParams = $this->filterService->setData($arrParams)->getData();
                    $category = $this->categoryTable->fetch(array('name' => $arrParams['name'], 'name_parent' => $arrParams['name_parent']));
                    if (is_array($category) && !empty($category)) {
                        $arrSet = $this->filterService->getArraySet();
                        $arrWhere = $this->filterService->getArrayWhere();
                        $returnUpdate = $this->categoryTable->update($arrSet,$arrWhere);
                        if (is_numeric($returnUpdate)) {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::ALERT,$returnUpdate);
                        }
                    } else {
                        if (is_array($category)) {
                            $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::WARNING,$category);
                        }
                    }
                } else {
                    $this->responseService->setData($this->form->getInputFilter()->getMessages());
                    $this->responseService->setCode(ResponseService::CODE_NOT_PARAMS_VALIDATED);
                }
            } catch (Exception $e) {
                $this->responseService->setCode(ResponseService::CODE_ERROR);
                $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
            }
        }
        return new JsonModel($this->responseService->getArrayCopy());
    }

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function setFilterService($filterService)
    {
        $this->filterService = $filterService;
    }

    public function setLogger($objLogger)
    {
        $this->logger = $objLogger;
    }
}
