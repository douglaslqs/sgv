<?php
namespace Application\Model\Entity;

class CategoryEntity
{
	public $name;
	public $name_parent;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->name = isset($data['name']) ? $data['name'] : null;
		$this->name_parent = isset($data['name_parent']) ? $data['name_parent'] : null;
		$this->active = isset($data['active']) ? $data['active'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}