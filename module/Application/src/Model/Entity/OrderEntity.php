<?php
namespace Application\Model\Entity;

class OrderEntity
{
	public $client;
	public $date_register;
	public $subtotal;
	public $freight;
	public $total;
	public $payment_method;
	public $status;
	public $date_payment;
	public $delivery;

	public function exchangeArray($data)
	{
		$this->client          = isset($data['client']) ? $data['client'] : null;
		$this->date_register  = isset($data['date_register']) ? $data['date_register'] : null;
		$this->subtotal       = isset($data['subtotal']) ? $data['subtotal'] : null;
		$this->freight        = isset($data['freight']) ? $data['freight'] : null;
		$this->total          = isset($data['total']) ? $data['total'] : null;
		$this->payment_method = isset($data['payment_method']) ? $data['payment_method'] : null;
		$this->status         = isset($data['status']) ? $data['status'] : null;
		$this->date_payment   = isset($data['date_payment']) ? $data['date_payment'] : null;
		$this->delivery       = isset($data['delivery']) ? $data['delivery'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}