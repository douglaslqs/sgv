<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LoginController extends AbstractActionController
{
    public function indexAction()
    {
    	$view = new ViewModel();
	    $view->setTerminal(true);
	    return $view;
    }

    public function authAction()
    {
    	return $this->redirect()->toUrl("/administrator/index");
    }

    public function logoutAction()
    {
    	return $this->redirect()->toUrl("index");
    }
}
