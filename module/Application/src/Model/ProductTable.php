<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class ProductTable
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

	public function fetch($arrFilter = array(), $limit = null)
	{
		try {
		    $sql = $this->tableGateway->getSql();


		    $where = new \Zend\Db\Sql\Where();

			// Alternatively, a shortcut
			$where->like('name', '%'.$arrFilter['name'].'%'); // Alternatively, a shortcut.
			$where->orLike('category', '%'.$arrFilter['name'].'%');

			/*$where->addPredicate(
			    new \Zend\Db\Sql\Predicate\Like('my_field', '%test%')
			); */

			$sql->select()->where(array(
					new \Zend\Db\Sql\Predicate\PredicateSet(array(
						new \Zend\Db\Sql\Predicate\Like('name', '%'.$arrFilter['name'].'%'),
						new \Zend\Db\Sql\Predicate\Like('category', '%'.$arrFilter['category'].'%'),
				),
				\Zend\Db\Sql\Predicate\PredicateSet::COMBINED_BY_OR
				)
			));


			$select = $sql->select()->where($where);
			if (!empty($limit)) {
				$select->limit(1);
			}
			// output query
			return $sql->getSqlStringForSqlObject($select);exit;
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
			if (!empty($limit)) {
				$select->limit(1);
			}
			// output query
			//return $sql->getSqlStringForSqlObject($select);exit;
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
		if (empty($arrSet)) return 0;
		try {
		    // Here is the catch
		    $update = $this->tableGateway->getSql()->update();
		    //var_dump($arrWhere);exit;
		    $update->set($arrSet);
		    $update->where($arrWhere);
		    //output query
			//echo $this->tableGateway->getSql()->getSqlStringForSqlObject($update);exit;
		    // Execute the query
		    return $this->tableGateway->updateWith($update);

		} catch (Exception $e) {
			return $e->getMessage();
		}
	}
}