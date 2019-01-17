<?php
namespace Application\Model\Entity;

class ColorProductEntity
{
	public $color;
	public $product;
	public $mark;

	public function exchangeArray($data)
	{
		$this->color = isset($data['color']) ? $data['color'] : null;
		$this->product = isset($data['product']) ? $data['product'] : null;
		$this->mark = isset($data['mark']) ? $data['mark'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}