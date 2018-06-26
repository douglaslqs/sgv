<?php
namespace Application\Model\Entity;

class AllowEntity
{
	public $action;
	public $description;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->action = isset($data['action']) ? $data['action'] : null;
		$this->description = isset($data['description']) ? $data['description'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}