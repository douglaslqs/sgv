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

class AuthController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Auth manager.
     * @var User\Service\AuthManager
     */
    private $authManager;

    /**
     * Auth service.
     * @var \Zend\Authentication\AuthenticationService
     */
    private $authService;

    /**
     * User manager.
     * @var User\Service\UserManager
     */
    private $form;
    private $logger;
    private $clientTable;

    /**
     * Constructor.
     */
    public function __construct($entityManager, $clientTable, $authManager, $authService)
    {
        $this->entityManager = $entityManager;
        $this->clientTable = $clientTable;
        $this->authManager = $authManager;
        $this->authService = $authService;
    }

    public function loginAction()
    {
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            throw new \Exception("Too long redirectUrl argument passed");
        }
        $this->form->get('redirect_url')->setValue($redirectUrl);

        //VARIFICAR SE CLIENTE EXISTE EM BANCO DE DADOS CLIENT E SETAR O BANCO DELE NA SESSAO
        $paramsRoute = $this->params()->fromRoute();
        if (isset($paramsRoute['id']) && !empty($paramsRoute['id'])) {
            $arrClient = $this->clientTable->fetchRow(array("document" => $paramsRoute['id']));
            if(!isset($_SESSION))
            {
                session_start();
            }
            $_SESSION['client'] = $paramsRoute['id'];
        } else {
            unset($_SESSION['client']);
            session_destroy();
        }

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
                        $data['password'], $data['remember']);
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
                        return $this->redirect()->toUrl($redirectUrl);
                    }
                } else {
                    var_dump("CREDENCIAL INVALIDA");exit;
                    $isLoginError = true;
                }
            }
        }

        $arrView = array(
            'form' => $this->form,
            'paramsRoute' => isset($paramsRoute['id']) ? $paramsRoute['id'] : null,
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
