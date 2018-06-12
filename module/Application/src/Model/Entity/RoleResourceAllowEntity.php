<?php
namespace Application\Model\Entity;

class RoleResourceAllowEntity
{
	public $role;
	public $module_controller;
	public $action;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->role = isset($data['role']) ? $data['role'] : null;
		$this->module_controller = isset($data['module_controller']) ? $data['module_controller'] : null;
		$this->action = isset($data['action']) ? $data['action'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}