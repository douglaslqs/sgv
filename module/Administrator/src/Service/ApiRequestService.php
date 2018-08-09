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

    const BASE_URL = 'http://sgv.local/store/';


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->objRequest = new Request();
        $this->objClient = new Client();
        $this->objRequest->getHeaders()->addHeaders(array(
            'Content-Type' => 'application/json; charset=UTF-8',
            'Authorization' => '123456',
        ));
    }

    /**
     * Efetue request to API
     * @return array data returned api
     */
    public function request()
    {
        $this->objRequest->setUri(self::BASE_URL.$this->getUri());
        $this->objRequest->setMethod($this->getMethod());
        if ($this->getMethod() === self::METHOD_POST) {
            $this->objRequest->setPost(new Parameters($this->getParameters()));
        } else {
            //$this->objRequest->setQuery(new Parameters($this->getParameters()));
        }
        //var_dump($this->objRequest->getQuery());exit;
        $response = $this->objClient->dispatch($this->objRequest);
        return json_decode($response->getBody(), true);
    }

    public function setUri($strUri)
    {
        $this->strUri = $strUri;
    }

    public function getUri()
    {
        return $this->strUri;
    }

    public function setMethod($strMethod)
    {
        $this->strMethod = $strMethod;
    }

    public function getMethod()
    {
        return $this->strMethod;
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