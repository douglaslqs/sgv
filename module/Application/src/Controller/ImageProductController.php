<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Model\ImageProductTable;
use Application\Service\ResponseService;
use Application\Service\LoggerService as Logger;

class ImageProductController extends AbstractRestfulController
{
    private $imageProductTable;
    private $form;
    private $responseService;
    private $filterService;
    private $logger;

    public function __construct(ResponseService $responseService, ImageProductTable $imageProductTable)
    {
        $this->responseService = $responseService;
        $this->imageProductTable = $imageProductTable;
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
                }
                $imageProduct = $this->imageProductTable->fetch($arrParams);
                if(!empty($imageProduct)){
                    $this->responseService->setData($imageProduct);
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
            $arrFiles = $request->getFiles()->toArray();
            $arrParams = array_change_key_case($arrParams, CASE_LOWER);
            $arrFiles = array_change_key_case($arrFiles, CASE_LOWER);
            try {
                $boolUpdate = false;
                $this->form->addInputFilter($boolUpdate);
                $this->form->setData(array_merge($arrParams,$arrFiles));
                if ($this->form->isValid()) {
                    $img = file_get_contents($arrFiles['image']['tmp_name']);
                    $img64 = base64_encode($img);
                    $arrParams = $this->filterService->setData($arrParams)->getData();
                    $arrParams['image'] = $img64;
                    $arrParams['name'] = $arrFiles['image']['name'];
                    $arrParams['type'] = $arrFiles['image']['type'];
                    $imageProduct = $this->imageProductTable->fetchRow($arrParams);
                    if (empty($imageProduct)) {
                        $returnInsert = $this->imageProductTable->insert($arrParams);
                        if ($returnInsert !== 1) {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::ALERT,$returnInsert);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        }
                    } else {
                        if (is_array($imageProduct)) {
                            $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::WARNING,$imageProduct);
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
            $arrFiles = $request->getFiles()->toArray();
            $arrParams = array_change_key_case($arrParams, CASE_LOWER);
            $arrFiles = array_change_key_case($arrFiles, CASE_LOWER);
            try {
                $boolUpdate = true;
                $this->form->addInputFilter($boolUpdate);
                $this->form->setData(array_merge($arrParams,$arrFiles));
                if ($this->form->isValid()) {
                    $arrParams = $this->filterService->setData($arrParams)->getData();
                    $imageProduct = $this->imageProductTable->fetchRow($arrParams);
                    if (is_array($imageProduct) && !empty($imageProduct)) {
                        if (!empty($arrFiles)) {
                            $img = file_get_contents($arrFiles['new_image']['tmp_name']);
                            $img64 = base64_encode($img);
                            $arrSet['image'] = $img64;
                            $arrSet['name'] = $arrFiles['new_image']['name'];
                            $arrSet['type'] = $arrFiles['new_image']['type'];
                        }
                        $arrWhere = $this->filterService->getArrayWhere();
                        $returnUpdate = $this->imageProductTable->update($arrSet,$arrWhere);
                        if (is_numeric($returnUpdate)) {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::ALERT,$returnUpdate);
                        }
                    } else {
                        if (is_array($imageProduct)) {
                            $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::WARNING,$imageProduct);
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
