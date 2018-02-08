<?php
namespace Application\Service;

/**
 *
 * @author Douglas Santos <douglasrock15@hotmail.com>
 *
 */
class ResponseService
{

	const CODE_TOKEN_INVALID = -1;
	const CODE_SUCCESS = 0;
	const CODE_ERROR = 1;
	const CODE_NOT_PARAMS_VALIDATED = 2;
	const CODE_QUERY_EMPTY = 3;
	const CODE_METHOD_INCORRECT = 4;
	const CODE_ALREADY_EXISTS = 5;

	const MESSAGE_SUCCESS = "Successful request";
	const MESSAGE_ERROR = "A error uncurred";
	const MESSAGE_QUERY_EMPTY = "The query returned empty";
	const MESSAGE_NOT_PARAMS_VALIDATED = "Required parameter not found";
	const MESSAGE_METHOD_INCORRECT = "Sending method incorrect";
	const MESSAGE_ALREADY_EXISTS = "Item already exists";

	const TYPE_ERROR = "ERROR";
	const TYPE_SUCCESS = "SUCCESS";
	const TYPE_WARNING = "WARNING";

	private $response;
	private $data;

	public function __construct()
	{
		$this->response = array();
	}


	private function setMessageAndTypeByCode($code)
	{
		switch ($code) {
			case self::CODE_SUCCESS :
				$this->response['message'] = self::MESSAGE_SUCCESS;
				$this->response['type']    = self::TYPE_SUCCESS;
				break;
			case self::CODE_ERROR :
				$this->response['message'] = self::MESSAGE_ERROR;
				$this->response['type']    = self::TYPE_ERROR;
				break;
			case self::CODE_QUERY_EMPTY :
				$this->response['message'] = self::MESSAGE_QUERY_EMPTY;
				$this->response['type']    = self::TYPE_WARNING;
				break;
			case self::CODE_NOT_PARAMS_VALIDATED :
				$this->response['message'] = self::MESSAGE_NOT_PARAMS_VALIDATED;
				$this->response['type']    = self::TYPE_WARNING;
				break;
			case self::CODE_METHOD_INCORRECT :
				$this->response['message'] = self::MESSAGE_METHOD_INCORRECT;
				$this->response['type']    = self::TYPE_ERROR;
				break;
			case self::CODE_ALREADY_EXISTS :
				$this->response['message'] = self::MESSAGE_ALREADY_EXISTS;
				$this->response['type']    = self::TYPE_WARNING;
				break;
			default:
				$this->response['message'] = self::MESSAGE_ERROR;
				$this->response['type']    = self::TYPE_ERROR;
				break;
		}
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		$this->data;
	}

	public function setMessage($message)
	{
		$this->response['message'] = $message;
	}

	public function getMessage()
	{
		$this->response['message'];
	}

	public function getResponse()
	{
		$this->response;
	}

	public function setCode($code)
	{
		$this->response['code'] = $code;
		$this->setMessageAndTypeByCode($code);
	}

	public function getCode()
	{
		$this->response['code'];
	}

	public function setType($type)
	{
		$this->response['type'] = $type;
	}

	public function getType()
	{
		$this->response['type'];
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}