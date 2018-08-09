<?php
namespace Administrator\Service;

use Zend\Http\Request;
use Zend\Http\Client;
use Zend\Stdlib\Parameters;

class ApiRequestService
{
    private $objRequest;
    private $arrParameters;
    private $arrUrl;
    private $strMethod = 'GET';
    private $strUri;
    private $objClient;

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->objRequest = new Request();
        $this->objClient = new Client();
        $this->objRequest->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
        ));
    }

    /**
     * Efetue request to API
     * @return array data returned api
     */
    public function request()
    {
        $this->objRequest->setUri($this->getUri());
        $this->objRequest->setMethod($this->getMethod());
        if ($this->getMethod === self::METHOD_POST) {
            $this->objRequest->setPost(new Parameters($this->getParameters()));
        } else {
            $this->objRequest->setGet(new Parameters($this->getParameters()));
        }
        $response = $this->objClient->dispatch($this->objRequest);
        return json_decode($response->getBody(), true);
    }

    public function setUri($strUri)
    {
        $this->strUri = $strUri;
    }

    public function getUri()
    {
        return $strUri;
    }

    public function setMethod($strMethod)
    {
        $this->strMethod = $strMethod;
    }

    public function getMethod()
    {
        return $strMethod;
    }

    public function setParameters(array $arrParameters)
    {
        $this->arrParameters = $arrParameters;
    }

    public function getParameters()
    {
        return $this->arrParameters;
    }
}