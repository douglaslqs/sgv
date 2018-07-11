<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Result;
use Zend\Uri\Uri;

class LoginController extends AbstractActionController
{
    private $form;
    private $logger;

    public function indexAction()
    {
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }
        $this->form->get('redirect_url')->setValue($redirectUrl);

        // Store login status.
        $isLoginError = false;
        // Check if user has submitted the form
        if ($this->getRequest()->isPost()) {
            // Fill in the form with POST data
            $data = $this->params()->fromPost();
            $this->form->setData($data);
            // Validate form
            if($this->form->isValid()) {
                // Get filtered and validated data
                $data = $this->form->getData();
                // Perform login attempt.
                $result = $this->authManager->login($data['email'],
                        $data['password'], $data['remember_me']);
                // Check result.
                if ($result->getCode()==Result::SUCCESS) {
                    // Get redirect URL.
                    $redirectUrl = $this->params()->fromPost('redirect_url', '');
                    if (!empty($redirectUrl)) {
                        // The below check is to prevent possible redirect attack
                        // (if someone tries to redirect user to another domain).
                        $uri = new Uri($redirectUrl);
                        if (!$uri->isValid() || $uri->getHost()!=null)
                            throw new \Exception('Incorrect redirect URL: ' . $redirectUrl);
                    }
                    // If redirect URL is provided, redirect the user to that URL;
                    // otherwise redirect to Home page.
                    if(empty($redirectUrl)) {
                        return $this->redirect()->toRoute('home');
                    } else {
                        $this->redirect()->toUrl($redirectUrl);
                    }
                } else {
                    $isLoginError = true;
                }
            }
        }

        $arrView = array(
            'form' => $this->form,
            'isLoginError' => $isLoginError,
            'redirectUrl' => $redirectUrl
        );
    	$view = new ViewModel($arrView);
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

    public function setForm($form)
    {
        $this->form = $form;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }
}
