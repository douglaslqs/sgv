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

    public function __construct(ApiRequestService $objApiRequest)
    {
    	$this->objApiRequest = $objApiRequest;
    }

   	public function indexAction()
   	{
   		var_dump($this->objApiRequest);exit;
		return array();
   	}

    public function setLogger(\Application\Service\LoggerService $logger)
    {
        $this->logger = $logger;
    }
}
