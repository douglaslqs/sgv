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
     * Auth manager.
     * @var Administrator\Service\AuthManager
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
    private $sessionUser;
    private $clientTable;
    private $userTable;

    /**
     * Constructor.
     */
    public function __construct($userTable, $clientTable, $authManager, $authService)
    {
        $this->userTable = $userTable;
        $this->clientTable = $clientTable;
        $this->authManager = $authManager;
        $this->authService = $authService;
    }

    public function loginAction()
    {
        //Verify if session active
        if ($this->authService->getIdentity()) {
            return $this->redirect()->toUrl("/administrator/index");
        }
        // Store login status.
        $status = false;
        $message = null;
        //VARIFICAR SE CLIENTE EXISTE EM BANCO DE DADOS CLIENT E SETAR O BANCO DELE NA SESSAO
        $paramsRoute = $this->params()->fromRoute();
        if (isset($paramsRoute['id']) && !empty($paramsRoute['id'])) {
            if(!$this->sessionUser->offsetExists('client')) {
                //$arrClient = $this->clientTable->fetchRow(array("document" => $paramsRoute['id']));
                //$this->sessionUser->offsetSet('email', $arrClient['name']);
                $this->sessionUser->offsetSet('client', $paramsRoute['id']);
            }
        } else {
            $this->sessionUser->getManager()->getStorage()->clear('user');
            $message = "Você precisa informar o id cliente no endereco da página";
        }
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
                    //CREATE SESSIONS VALUE
                    $arrUser = $this->userTable->fetchRow(array("email" => $data['email']));
                    $this->sessionUser->offsetSet('email', $arrUser['email']);
                    $this->sessionUser->offsetSet('name', $arrUser['name']);
                    return $this->redirect()->toUrl("/administrator/index");
                } else {
                    $message = "E-mail e/ou senha inválida";
                    $status = true;
                }
            }
        }
        $arrView = array(
            'form' => $this->form,
            'paramsRoute' => isset($paramsRoute['id']) ? $paramsRoute['id'] : null,
            'status' => $status,
            'message' => $message,
        );
    	$view = new ViewModel($arrView);
	    $view->setTerminal(true);
	    return $view;
    }

    public function logoutAction()
    {
        $this->authService->clearIdentity();
        $idClient = $this->sessionUser->offsetGet('client');
        $this->sessionUser->getManager()->getStorage()->clear();
    	return $this->redirect()->toUrl("login/".$idClient);
    }

    public function sessionExpiredAction()
    {
        $idClient = $this->sessionUser->offsetGet('client');
        $arrView = array(
            'form' => $this->form,
            'paramsRoute' => $idClient,
            'status' => false,
            'message' => "Session Expired",
        );
        $view = new ViewModel($arrView);
        $view->setTerminal(true);
        $view->setTemplate('administrator/auth/login.phtml');
        return $view;
    }

    public function setForm(\Administrator\Form\LoginForm $form)
    {
        $this->form = $form;
    }

    /**
     * Set object Container Session User
     * @param Container $sessionUser Conteiner session user
     */
    public function setSessionUser(\Zend\Session\Container $sessionUser)
    {
        $this->sessionUser = $sessionUser;
    }

    public function setLogger(\Application\Service\LoggerService $logger)
    {
        $this->logger = $logger;
    }
}
