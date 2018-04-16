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
			if (!empty($arrFilter)) {
				$arrLikes = array();
				foreach ($arrFilter as $key => $value) {
					array_push($arrLikes,new \Zend\Db\Sql\Predicate\Like($key,'%'.$value.'%'));
			    }
				$select = $sql->select()->where(array(
						new \Zend\Db\Sql\Predicate\PredicateSet($arrLikes,
					\Zend\Db\Sql\Predicate\PredicateSet::COMBINED_BY_OR
					)
				));
			} else {
				$select = $sql->select()->where($arrFilter);
			}
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

	public function fetchRow($arrParams)
	{
		try {
			$arrFilter = array(
                'name' => isset($arrParams['name']) ? $arrParams['name'] : null,
                'category' => isset($arrParams['category']) ? $arrParams['category'] : null,
                'category_parent'=>isset($arrParams['category_parent']) ? $arrParams['category_parent'] : null,
                'mark' => isset($arrParams['mark']) ? $arrParams['mark'] : null,
                'unit_measure' => isset($arrParams['unit_measure']) ? $arrParams['unit_measure'] : null,
            );
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