<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Service\ResponseService;

abstract class AbstractTable
{
	protected $tableGateway;
	protected $pgService;

	abstract public function filterArrayWhere();

	public function __construct(TableGateway $tableGateway, ResponseService $responseService)
	{
		$this->tableGateway = $tableGateway;
		$this->pgService = $responseService->getPgService();
	}

	public function getTableGateWay()
	{
		return $this->tableGateway;
	}

	public function getPaginatorService()
	{
		return $this->pgService;
	}

	public function fetch($arrFilter = array())
	{
		try {
		    $sql = $this->tableGateway->getSql();
			if (!empty($arrFilter)) {
				$arrLikes = array();
				foreach ($arrFilter as $key => $value) {
					if (strpos($key, 'p_') !== 0) {
						array_push($arrLikes,new \Zend\Db\Sql\Predicate\Like($key,$value.'%'));
					}
			    }
			    if (!empty($arrLikes)) {
					$combined = \Zend\Db\Sql\Predicate\PredicateSet::COMBINED_BY_OR;
					if(isset($arrFilter['p_combined'])) {
						$combined =  \Zend\Db\Sql\Predicate\PredicateSet::COMBINED_BY_AND;
						unset($arrFilter['p_combined']);
					}
					$select = $sql->select()->where(array(
							new \Zend\Db\Sql\Predicate\PredicateSet($arrLikes,
							$combined
						)
					));
			    } else {
			    	$select = $sql->select();
			    }
			} else {
				$select = $sql->select();
			}
			//Clone para fazer o count e setar last page do paginator
			$selectCount = clone $select;
			$selectCount = $selectCount->columns(array('count' => new \Zend\Db\Sql\Expression('COUNT(1)')));
			$statement = $sql->prepareStatementForSqlObject($selectCount);
			$totalRows = (int)$statement->execute()->current()['count'];

			$offset = $this->getPaginatorService()->getRangeIni();
			$acceptRange = $this->getPaginatorService()->getInterval();
			if ($offset > -1) {
				$select->limit($acceptRange)->offset($offset);
			} else {
				$select->limit($acceptRange)->offset(0);
			}
			// output query
			//return $sql->getSqlStringForSqlObject($select);exit;
			$resultSet = $this->tableGateway->selectWith($select);
			$totalData = $resultSet->count();

			//Set total rows and link last on paginator
			$this->getPaginatorService()->setTotalData($totalData);
			$currentLink = $this->getPaginatorService()->getLinkSelf();
			$newRangeIni = $totalRows-$acceptRange;
			$newRangeIni = $newRangeIni < 0 ? 0 : $newRangeIni;
			$newRangeEnd = $totalRows < $acceptRange ? $acceptRange : $totalRows;
			$rangeEnd = $this->getPaginatorService()->getRangeEnd();
			$linkLast = str_replace('p_range='.$offset.'-'.$rangeEnd, 'p_range='.$newRangeIni.'-'.$newRangeEnd, $currentLink);
			$this->getPaginatorService()->setLinkLast($linkLast);
			//***//

			$resultSet = $resultSet->toArray();
		} catch (Exception $e) {
			$resultSet = $e->getMessage();
		}
		return $resultSet;
	}

	public function fetchRow($arrParams)
	{
		try {
			$arrFilter = $this->filterArrayWhere($arrParams);
			$arrFilter = array_filter($arrFilter);
		    $sql = $this->tableGateway->getSql();
			$select = $sql->select()->where($arrFilter);
			// output query
			//return $sql->getSqlStringForSqlObject($select);exit;
			$arrResult = $this->tableGateway->selectWith($select)->toArray();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		if (!empty($arrResult)) {
			return $arrResult[0];
		}
		return $arrResult;
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
		    $update = $this->tableGateway->getSql()->update();
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