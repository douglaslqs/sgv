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

	public function fetch($arrFilter = array())
	{
		try {
		    $sql = $this->tableGateway->getSql();
			$select = $sql->select()->where($arrFilter);
			// output query
			//echo $sql->getSqlStringForSqlObject($select);exit;
			$resultSet = $this->tableGateway->selectWith($select)->toArray();
		} catch (Exception $e) {
			$resultSet = $e->getMessage();
		}
		return $resultSet;
	}

	public function fetchRow($arrFilter)
	{
		try {
		    $sql = $this->tableGateway->getSql();
			$select = $sql->select()->where($arrFilter);
			// output query
			//echo $sql->getSqlStringForSqlObject($select);
			$resultSet = $this->tableGateway->selectWith($select)->toArray();
		} catch (Exception $e) {
			$resultSet = $e->getMessage();
		}
		return $resultSet;
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

	public function update($arrSet, $arrWhere)
	{
		try {
		    // Here is the catch
		    $update = $this->tableGateway->getSql()->update();
		    //var_dump($arrWhere);exit;
		    $update->set($arrSet);
		    $update->where($arrWhere);
		    // Execute the query
		    return $this->tableGateway->updateWith($update);
			
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}