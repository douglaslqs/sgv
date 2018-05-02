<?php
namespace Application\Model\Entity;

class ColorProductEntity
{
	public $color;
	public $category;
	public $product;
	public $category_parent;
	public $mark;

	public function exchangeArray($data)
	{
		$this->color = isset($data['color']) ? $data['color'] : null;
		$this->product = isset($data['product']) ? $data['product'] : null;
		$this->category = isset($data['category']) ? $data['category'] : null;
		$this->category_parent = isset($data['category_parent']) ? $data['category_parent'] : null;
		$this->mark = isset($data['mark']) ? $data['mark'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}