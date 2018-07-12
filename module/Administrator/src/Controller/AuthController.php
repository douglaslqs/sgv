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
use Zend\Session\Container;

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
        // Store login status.
        $status = false;
        $message = null;
        $redirectUrl = (string)$this->params()->fromQuery('redirectUrl', '');
        if (strlen($redirectUrl)>2048) {
            $message = "Too long redirectUrl argument passed";
        }
        $this->form->get('redirect_url')->setValue($redirectUrl);

        //VARIFICAR SE CLIENTE EXISTE EM BANCO DE DADOS CLIENT E SETAR O BANCO DELE NA SESSAO
        $sessionUser = new Container('user');
        $paramsRoute = $this->params()->fromRoute();
        if (isset($paramsRoute['id']) && !empty($paramsRoute['id'])) {
            if(!$sessionUser->offsetExists('client')) {
                //$arrClient = $this->clientTable->fetchRow(array("document" => $paramsRoute['id']));
                //$sessionUser->offsetSet('email', $arrClient['name']);
                $sessionUser->offsetSet('client', $paramsRoute['id']);
            }
        } else {
            $sessionUser->getManager()->getStorage()->clear('user');
            $message = "Você precisa informar o id cliente na URL";
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
                if (is_string($result)) {
                    //Derrubar sessão e criar outra.
                    $message = "Este usuário já possui uma sessão ativa.";
                } else {
                    // Check result.
                    if ($result->getCode()==Result::SUCCESS) {
                        //CREATA SESSIONS VALUE
                        $arrUser = $this->userTable->fetchRow(array("email" => $data['email']));
                        $sessionUser->offsetSet('email', $arrUser[0]['email']);
                        $sessionUser->offsetSet('name', $arrUser[0]['name']);
                        // Get redirect URL.
                        $redirectUrl = $this->params()->fromPost('redirect_url', '');
                        // otherwise redirect to Home page.
                        if(empty($redirectUrl)) {
                            //return $this->redirect()->toRoute('index');
                            return $this->redirect()->toUrl("/administrator/index");
                        } elseif (!empty($redirectUrl)) {
                            // The below check is to prevent possible redirect attack
                            // (if someone tries to redirect user to another domain).
                            $uri = new Uri($redirectUrl);
                            if (!$uri->isValid() || $uri->getHost()!=null)
                                $message = 'Incorrect redirect URL: ' . $redirectUrl;
                        } else {
                            // If redirect URL is provided, redirect the user to that URL;
                            return $this->redirect()->toUrl($redirectUrl);
                        }
                    } else {
                        $message = "E-mail e/ou senha inválida";
                        $status = true;
                    }
                }
            }
        }

        $arrView = array(
            'form' => $this->form,
            'paramsRoute' => isset($paramsRoute['id']) ? $paramsRoute['id'] : null,
            'status' => $status,
            'message' => $message,
            'redirectUrl' => $redirectUrl
        );
    	$view = new ViewModel($arrView);
	    $view->setTerminal(true);
	    return $view;
    }

    public function logoutAction()
    {
        $this->authService->clearIdentity();
        $sessionUser = new Container('user');
        $idClient = $sessionUser->offsetGet('client');
        $sessionUser->getManager()->getStorage()->clear();
    	return $this->redirect()->toUrl("login/".$idClient);
    }

    public function sessionExpiredAction()
    {
        $sessionUser = new Container('user');
        return array('idClient' => $sessionUser->offsetGet('client'));
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
