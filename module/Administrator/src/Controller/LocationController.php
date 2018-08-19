<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class LocationController extends AbstractActionController
{
	private $translator;
	private $logger;

    public function __construct($translate)
    {
        $this->translate = $translate;
    }

    public function indexAction()
    {
        $userLocale = $this->params()->fromQuery('locale');
        $redirect = $this->params()->fromQuery('redirect');
        switch ($userLocale) {
            case 'en_US':
                $userLocale = 'en_US';
                break;
            default :
                $userLocale = 'pt_BR';
        }
        $sessionUser = new \Zend\Session\Container('user');
        $sessionUser->locale = $userLocale;
        $this->redirect()->toUrl($redirect);
    }

    public function setLogger(\Application\Service\LoggerService $logger)
    {
        $this->logger = $logger;
    }
}
