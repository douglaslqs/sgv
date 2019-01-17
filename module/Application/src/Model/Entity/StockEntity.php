<?php
namespace Application\Model\Entity;

class StockEntity
{
	public $product;
	public $mark;
	public $measure;
	public $unit_measure;
	public $color;
	public $qty;
	public $date_register;
	public $date_update;

	public function exchangeArray($data)
	{
		$this->product = isset($data['product']) ? $data['product'] : null;
		$this->mark = isset($data['mark']) ? $data['mark'] : null;
		$this->measure = isset($data['measure']) ? $data['measure'] : null;
		$this->unit_measure = isset($data['unit_measure']) ? $data['unit_measure'] : null;
		$this->color = isset($data['color']) ? $data['color'] : null;
		$this->qty = isset($data['qty']) ? $data['qty'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
		$this->date_update = isset($data['date_update']) ? $data['date_update'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}