<?php
namespace Application\Model\Entity;

class MarkEntity
{
	public $name;
	public $name_parent;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->name = isset($data['name']) ? $data['name'] : null;
		$this->active = isset($data['active']) ? $data['active'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}