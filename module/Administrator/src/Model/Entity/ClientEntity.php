<?php
namespace Administrator\Model\Entity;

class ClientEntity
{
	public $document;
	public $email;
	public $name;
	public $cep;
	public $phone_primary;
	public $phone_segundary;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->document          = isset($data['document']) ? $data['document'] : null;
		$this->email             = isset($data['email']) ? $data['email'] : null;
		$this->name              = isset($data['name']) ? $data['name'] : null;
		$this->cep               = isset($data['cep']) ? $data['cep'] : null;
		$this->phone_primary     = isset($data['phone_primary']) ? $data['phone_primary'] : null;
		$this->phone_segundary   = isset($data['phone_segundary']) ? $data['phone_segundary'] : null;
		$this->date_register     = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}