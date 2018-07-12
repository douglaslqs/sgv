<?php
namespace Administrator\Service;

use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Crypt\Password\Bcrypt;
use Application\Model\Entity\UserEntity;


class AuthManagerService
{

    private $authService;

    /**
     * Constructor.
     */
    public function __construct($authService)
    {
        $this->authService = $authService;
    }

    /**
     * Performs a login attempt. If $rememberMe argument is true, it forces the session
     * to last for one month (otherwise the session expires on one hour).
     */
    public function login($email, $password, $rememberMe)
    {
        // Check if user has already logged in. If so, do not allow to log in
        // twice.
        if ($this->authService->getIdentity()!=null) {
            //throw new \Exception('Already logged in! Email '. $this->authService->getIdentity());
            return $this->authService->getIdentity();
        }

        // Authenticate with login/password.
        $authAdapter = $this->authService->getAdapter();
        $authAdapter->setEmail($email);
        $authAdapter->setPassword($password);
        $result = $this->authService->authenticate();

        // If user wants to "remember him", we will make session to expire in
        // one month. By default session expires in 1 hour (as specified in our
        // config/global.php file).
        if ($result->getCode()==Result::SUCCESS && $rememberMe) {
            // Session cookie will expire in 1 month (30 days).
            $this->sessionManager->rememberMe(60*60*24*30);
        }

        return $result;
    }
}