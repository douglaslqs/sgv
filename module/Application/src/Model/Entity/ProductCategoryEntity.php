<?php
namespace Application\Model\Entity;

class ProductCategoryEntity
{
	public $product_name;
	public $product_mark;
	public $category_name;
	public $category_name_parent;

	public function exchangeArray($data)
	{
		$this->product_name = isset($data['product_name']) ? $data['product_name'] : null;
		$this->product_mark = isset($data['product_mark']) ? $data['product_mark'] : null;
		$this->category_name = isset($data['category_name']) ? $data['category_name'] : null;
		$this->category_name_parent = isset($data['category_name_parent']) ? $data['category_name_parent'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}