<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Application\Model\ProductTable;
use Application\Service\ResponseService;
use Application\Service\LoggerService as Logger;

class ProductController extends AbstractRestfulController
{
    private $productTable;
    private $form;
    private $responseService;
    private $filterService;
    private $logger;

    public function __construct(ResponseService $responseService, ProductTable $productTable)
    {
        $this->responseService = $responseService;
        $this->productTable = $productTable;
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
                $product = $this->productTable->fetch($arrParams);
                if(!empty($product)){
                    $this->responseService->setData($product);
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

    public function indexAction()
    {
       	return new JsonModel(array("ação não encontrada"));
    }

    public function addAction()
    {
    	return new JsonModel(array("addProduto"));
    }

    public function updateAction()
    {
    	return new JsonModel(array("updateProduto"));
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
