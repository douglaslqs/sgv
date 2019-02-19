<?php
namespace Application\Service;

/**
 *
 * @author Douglas Santos <douglasrock15@hotmail.com>
 *
 */

class ResponseService
{
	const CODE_ACCESS_DENIED = -2;
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
	const MESSAGE_NOT_PARAMS_VALIDATED = "Required parameter not found or invalid value";
	const MESSAGE_METHOD_INCORRECT = "Sending method incorrect";
	const MESSAGE_ALREADY_EXISTS = "Item already exists or search reference not exists";
	const MESSAGE_ACCESS_DENIED = "Access Denied";

	const TYPE_ERROR = "ERROR";
	const TYPE_SUCCESS = "SUCCESS";
	const TYPE_INFO = "INFO";
	const TYPE_ALERT = "ALERT";
	const TYPE_WARNING = "WARNING";

	private $response;
	private $pagination;
	private $data;
	private $pgService;

	public function __construct(PaginatorService $paginator)
	{
		$this->pgService = $paginator;
		$this->response = array(
			'code'=> null,
			'message' => null,
			'type' => null,
		);
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
				$this->response['type']    = self::TYPE_INFO;
				break;
			case self::CODE_NOT_PARAMS_VALIDATED :
				$this->response['message'] = self::MESSAGE_NOT_PARAMS_VALIDATED;
				$this->response['type']    = self::TYPE_ALERT;
				break;
			case self::CODE_METHOD_INCORRECT :
				$this->response['message'] = self::MESSAGE_METHOD_INCORRECT;
				$this->response['type']    = self::TYPE_WARNING;
				break;
			case self::CODE_ALREADY_EXISTS :
				$this->response['message'] = self::MESSAGE_ALREADY_EXISTS;
				$this->response['type']    = self::TYPE_INFO;
				break;
			case self::CODE_ACCESS_DENIED :
				$this->response['message'] = self::MESSAGE_ACCESS_DENIED;
				$this->response['type']    = self::TYPE_ERROR;
				break;
			default:
				$this->response['message'] = self::MESSAGE_ERROR;
				$this->response['type']    = self::TYPE_ERROR;
				break;
		}
	}

	public function getPagination()
	{
		return $this->pagination;
	}

	public function getPgService()
	{
		return $this->pgService;
	}

	public function setData($data)
	{
		$this->data = $data;
	}

	public function getData()
	{
		return $this->data;
	}

	public function setMessage($message)
	{
		$this->response['message'] = $message;
	}

	public function getMessage()
	{
		return $this->response['message'];
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function setCode($code)
	{
		$this->response['code'] = $code;
		$this->setMessageAndTypeByCode($code);
	}

	public function getCode()
	{
		return $this->response['code'];
	}

	public function setType($type)
	{
		$this->response['type'] = $type;
	}

	public function getType()
	{
		return $this->response['type'];
	}

	public function getArrayCopy()
	{
		$this->pagination = $this->pgService->getArrayCopy();
		$arrReturn = get_object_vars($this);
		unset($arrReturn['pgService']);
		return $arrReturn;
	}

}