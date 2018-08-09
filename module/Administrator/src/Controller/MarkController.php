<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MarkController extends AbstractActionController
{
    private $logger;

   public function indexAction()
   {
		return array();
   }

    public function setLogger(\Application\Service\LoggerService $logger)
    {
        $this->logger = $logger;
    }
}
