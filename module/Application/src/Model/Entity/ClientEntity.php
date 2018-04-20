<?php
namespace Application\Model\Entity;

class ClientEntity
{
	public $email;
	public $type;
	public $document;
	public $password;
	public $name;
	public $phone_primary;
	public $phone_segundary;
	public $tribute_info;
	public $state_register;
	public $receive_marketing;
	public $street;
	public $number;
	public $reference;
	public $complement;
	public $district;
	public $city;
	public $country;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->email             = isset($data['email']) ? $data['email'] : null;
		$this->type              = isset($data['type']) ? $data['type'] : null;
		$this->document          = isset($data['document']) ? $data['document'] : null;
		$this->password          = isset($data['password']) ? $data['password'] : null;
		$this->name              = isset($data['name']) ? $data['name'] : null;
		$this->phone_primary     = isset($data['phone_primary']) ? $data['phone_primary'] : null;
		$this->phone_segundary   = isset($data['phone_segundary']) ? $data['phone_segundary'] : null;
		$this->tribute_info      = isset($data['tribute_info']) ? $data['tribute_info'] : null;
		$this->state_register    = isset($data['state_register']) ? $data['state_register'] : null;
		$this->receive_marketing = isset($data['receive_marketing']) ? $data['receive_marketing'] : null;
		$this->street            = isset($data['street']) ? $data['street'] : null;
		$this->number            = isset($data['number']) ? $data['number'] : null;
		$this->reference         = isset($data['reference']) ? $data['reference'] : null;
		$this->complement        = isset($data['complement']) ? $data['complement'] : null;
		$this->district          = isset($data['district']) ? $data['district'] : null;
		$this->city              = isset($data['city']) ? $data['city'] : null;
		$this->country           = isset($data['country']) ? $data['country'] : null;
		$this->date_register     = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}