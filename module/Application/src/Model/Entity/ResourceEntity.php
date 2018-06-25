<?php
namespace Application\Model\Entity;

class ResourceEntity
{
	public $module;
	public $controller;
	public $description;
	public $active;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->module = isset($data['module']) ? $data['module'] : null;
		$this->controller = isset($data['controller']) ? $data['controller'] : null;
		$this->description = isset($data['description']) ? $data['description'] : null;
		$this->active = isset($data['active']) ? $data['active'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}