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
    private $typeReturn = 'json';
    private $strUri;
    private $objClient;

    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const TYPE_RETURN_PAGINATOR = 'paginator';
    const BASE_URL = 'http://sgv.local/store/';


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->objRequest = new Request();
        $this->objClient = new Client();
    }

    /**
     * Efetue request to API
     * @return array data returned api
     */
    public function request()
    {
        $arrHeader = array('Authorization' => '123456');
        $this->objRequest->setUri(self::BASE_URL.$this->getUri());
        $this->objRequest->setMethod($this->getMethod());

        if ($this->getTypeReturn() !== 'json') {
            $arrParams = $this->getParameters();
            $arrParams['p_type_return'] = $this->getTypeReturn();
            $this->setParameters($arrParams);
        }

        if ($this->getMethod() === self::METHOD_POST) {
            $this->objRequest->setPost(new Parameters($this->getParameters()));
        } else {
            //$arrHeader['Content-Type'] = 'application/json; charset=UTF-8';
            $this->objRequest->setQuery(new Parameters($this->getParameters()));
        }
        $this->objRequest->getHeaders()->addHeaders($arrHeader);
        //var_dump($this->objRequest->getQuery());exit;
        $response = $this->objClient->dispatch($this->objRequest);
        $data = json_decode($response->getBody(), true);
        if ($this->getTypeReturn() !== 'json') {
            $object = (object)$data['data'];
            $data['data'] = $object;
        }
        //var_dump($object);exit;
        return $data;
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

    public function setTypeReturn($typeReturn)
    {
        $this->typeReturn = $typeReturn;
    }

    public function getTypeReturn()
    {
        return $this->typeReturn;
    }
}