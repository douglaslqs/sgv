<?php
namespace Application\Model\Entity;

class CategoryEntity
{
	public $name;
	
	public function exchangeArray($data)
	{
		$this->name = isset($data['name']) ? $data['name'] : null;		
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}