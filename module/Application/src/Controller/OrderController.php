<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Model\OrderTable;
use Application\Service\ResponseService;
use Application\Service\LoggerService as Logger;

class OrderController extends AbstractRestfulController
{
    private $orderTable;
    private $form;
    private $responseService;
    private $filterService;
    private $logger;

    public function __construct(ResponseService $responseService, OrderTable $orderTable)
    {
        $this->responseService = $responseService;
        $this->orderTable = $orderTable;
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
                $order = $this->orderTable->fetch($arrParams);
                if(!empty($order)){
                    $this->responseService->setData($order);
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
                $boolUpdate = false;
                $this->form->addInputFilter($boolUpdate);
                $this->form->setData($arrParams);
                if ($this->form->isValid()) {
                    $arrParams = $this->filterService->setData($arrParams)->getData();
                    $order = $this->orderTable->fetchRow($arrParams);
                    if (empty($order)) {
                        $returnInsert = $this->orderTable->insert($arrParams);
                        if ($returnInsert !== 1) {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::ALERT,$returnInsert);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        }
                    } else {
                        if (is_array($order)) {
                            $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::WARNING,$order);
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
                $boolUpdate = true;
                $this->form->addInputFilter($boolUpdate);
                $this->form->setData($arrParams);
                if ($this->form->isValid()) {
                    $arrParams = $this->filterService->setData($arrParams)->getData();
                    $order = $this->orderTable->fetchRow($arrParams);
                    if (is_array($order) && !empty($order)) {
                        $arrSet = $this->filterService->getArraySet();
                        $arrWhere = $this->filterService->getArrayWhere();
                        $returnUpdate = $this->orderTable->update($arrSet,$arrWhere);
                        if (is_numeric($returnUpdate)) {
                            $this->responseService->setCode(ResponseService::CODE_SUCCESS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::ALERT,$returnUpdate);
                        }
                    } else {
                        if (is_array($order)) {
                            $this->responseService->setCode(ResponseService::CODE_ALREADY_EXISTS);
                        } else {
                            $this->responseService->setCode(ResponseService::CODE_ERROR);
                            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
                            $this->logger->save(Logger::LOG_APPLICATION,Logger::WARNING,$order);
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
