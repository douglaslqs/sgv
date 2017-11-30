<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoryTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function getTableGateWay()
	{
		return $this->tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function fetchRow($name)
	{
		$resultSet = $this->tableGateway->select(array("name" => $name));
		return $resultSet->current();
	}

	public function insert($arrData)
	{
		return $this->tableGateway->insert($arrData);
	}
}