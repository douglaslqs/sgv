<?php
namespace Application\Model\Entity;

class MeasureEntity
{
	public $name;
	public $unit_measure;
	public $active;
	public $date_register;

	public function exchangeArray($data)
	{
		$this->name = isset($data['name']) ? $data['name'] : null;
		$this->unit_measure = isset($data['unit_measure']) ? $data['unit_measure'] : null;
		$this->active = isset($data['active']) ? $data['active'] : null;
		$this->date_register = isset($data['date_register']) ? $data['date_register'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}