<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Administrator\Service\ApiRequestService;

class MarkController extends AbstractActionController
{
    private $logger;
    private $objApiRequest;

    const URL_GET    = 'mark/get';
    const URL_ADD    = 'mark/add';
    const URL_UPDATE = 'mark/update';

    public function __construct(ApiRequestService $objApiRequest)
    {
    	$this->objApiRequest = $objApiRequest;
    }

   	public function indexAction()
   	{
        $this->objApiRequest->setUri(self::URL_GET);
        $arrResponse = array();
        try {
            $arrResponse = $this->objApiRequest->request();
        } catch (Exception $e) {
            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
            $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
        }
        $view = new ViewModel($arrResponse);
        return $view;
   	}

    public function getAction()
    {
        $this->objApiRequest->setUri(self::URL_GET);
        $this->objApiRequest->setParameters($_POST);
        $arrResponse = array();
        try {
            $arrResponse = $this->objApiRequest->request();
        } catch (Exception $e) {
            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
            $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
        }
        echo json_encode($arrResponse);exit;
    }

    public function addAction()
    {
        $this->objApiRequest->setUri(self::URL_ADD);
        $this->objApiRequest->setParameters($_POST);
        $this->objRequest->setMethod(ApiRequestService::METHOD_POST);
        $arrResponse = array();
        try {
            $arrResponse = $this->objApiRequest->request();
        } catch (Exception $e) {
            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
            $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
            $arrResponse['message'] = $e->getMessage();
        }
        echo json_encode($arrResponse);exit;
    }

    public function updateAction()
    {
        $this->objApiRequest->setUri(self::URL_UPDATE);
        $this->objApiRequest->setParameters($_POST);
        $this->objApiRequest->setMethod(ApiRequestService::METHOD_POST);
        $arrResponse = array();
        try {
            $arrResponse = $this->objApiRequest->request();
        } catch (Exception $e) {
            $this->logger->setMethodAndLine(__METHOD__, __LINE__);
            $this->logger->save(Logger::LOG_APPLICATION, Logger::CRITICAL ,$e->getMessage());
            $arrResponse['message'] = $e->getMessage();
        }
        echo json_encode($arrResponse);exit;
    }

    public function setLogger(\Application\Service\LoggerService $logger)
    {
        $this->logger = $logger;
    }
}
