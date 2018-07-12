<?php
namespace Application\Model\Entity;

class UserEntity
{
	public $email;
	public $role;
	public $password;
	public $name;
	public $phone;
	public $active;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->email             = isset($data['email']) ? $data['email'] : null;
		$this->role              = isset($data['role']) ? $data['role'] : null;
		$this->password          = isset($data['password']) ? $data['password'] : null;
		$this->name              = isset($data['name']) ? $data['name'] : null;
		$this->phone		     = isset($data['phone']) ? $data['phone'] : null;
		$this->active		     = isset($data['active']) ? $data['active'] : null;
		$this->date_register     = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}