<?php
namespace Application\Model\Entity;

class ImageProductEntity
{
	public $date_register;
	public $product;
	public $mark;
	public $type;
	public $image;
	public $active;
	public $date_update;

	public function exchangeArray($data)
	{
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
		$this->product = isset($data['product']) ? $data['product'] : null;
		$this->mark = isset($data['mark']) ? $data['mark'] : null;
		$this->type = isset($data['type']) ? $data['type'] : null;
		$this->image = isset($data['image']) ? $data['image'] : null;
		$this->active = isset($data['active']) ? $data['active'] : null;
		$this->date_update = isset($data['date_update']) ? $data['date_update'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}