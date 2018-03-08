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

	public function fetchAll($arrFilter = null)
	{
		try {
		    $sql = $this->tableGateway->getSql();
			$select = $sql->select()->where($arrFilter);
			// output query
			//echo $sql->getSqlStringForSqlObject($select);exit;
			$resultSet = $this->tableGateway->selectWith($select);
		} catch (Exception $e) {
			$resultSet = $e->getMessage();
		}
		return $resultSet;
	}

	public function fetchRow($name)
	{
		try {
			$resultSet = $this->tableGateway->select(array("name" => $name));
		} catch (Exception $e) {
			$resultSet = $e->getMessage();
		}
		return $resultSet->current();
	}

	public function insert($arrData)
	{
		try {
			$resultSet = $this->tableGateway->insert($arrData);
		} catch (Exception $e) {
			$resultSet = $e->getMessage();
		}
		return $resultSet;
	}
}