<?php
namespace Application\Model\Entity;

class DeliveryAddressEntity
{
	public $client;
	public $street;
	public $number;
	public $reference;
	public $complement;
	public $district;
	public $city;
	public $state;
	public $country;
	public $main;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->client        = isset($data['client']) ? $data['client'] : null;
		$this->street        = isset($data['street']) ? $data['street'] : null;
		$this->number        = isset($data['number']) ? $data['number'] : null;
		$this->reference     = isset($data['reference']) ? $data['reference'] : null;
		$this->complement    = isset($data['complement']) ? $data['complement'] : null;
		$this->district      = isset($data['district']) ? $data['district'] : null;
		$this->city          = isset($data['city']) ? $data['city'] : null;
		$this->state       	 = isset($data['state']) ? $data['state'] : null;
		$this->country       = isset($data['country']) ? $data['country'] : null;
		$this->main          = isset($data['main']) ? $data['main'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}