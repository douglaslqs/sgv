<?php
namespace Application\Model\Entity;

class RoleResourceAllowEntity
{
	public $role;
	public $module;
	public $controller;
	public $action;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->role = isset($data['role']) ? $data['role'] : null;
		$this->module = isset($data['module']) ? $data['module'] : null;
		$this->controller = isset($data['controller']) ? $data['controller'] : null;
		$this->action = isset($data['action']) ? $data['action'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}