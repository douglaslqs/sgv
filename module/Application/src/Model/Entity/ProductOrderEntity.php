<?php
namespace Application\Model\Entity;

class ProductOrderEntity
{
	public $client;
	public $date_register;
	public $product;
	public $value_unitary;
	public $qty;

	public function exchangeArray($data)
	{
		$this->client = isset($data['client']) ? $data['client'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
		$this->product = isset($data['product']) ? $data['product'] : null;
		$this->value_unitary = isset($data['value_unitary']) ? $data['value_unitary'] : null;
		$this->qty = isset($data['qty']) ? $data['qty'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}