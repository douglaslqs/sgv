<?php
namespace Application\Model\Entity;

class ProductEntity
{
	public $name;
	public $mark;
	public $unit_measure;
	public $price_purchase;
	public $price;
	public $height;
	public $width;
	public $lenght;
	public $abstract;
	public $about;
	public $active;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->name = isset($data['name']) ? $data['name'] : null;
		$this->mark = isset($data['mark']) ? $data['mark'] : null;
		$this->unit_measure = isset($data['unit_measure']) ? $data['unit_measure'] : null;
		$this->price_purchase = isset($data['price_purchase']) ? $data['price_purchase'] : null;
		$this->price = isset($data['price']) ? $data['price'] : null;
		$this->height = isset($data['height']) ? $data['height'] : null;
		$this->width = isset($data['width']) ? $data['width'] : null;
		$this->lenght = isset($data['lenght']) ? $data['lenght'] : null;
		$this->abstract = isset($data['abstract']) ? $data['abstract'] : null;
		$this->about = isset($data['about']) ? $data['about'] : null;
		$this->active = isset($data['active']) ? $data['active'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}