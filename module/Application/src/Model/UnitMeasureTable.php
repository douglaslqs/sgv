<?php
namespace Application\Model;

use Application\Model\AbstractTable;
use Zend\Db\TableGateway\TableGateway;
use Application\Service\ResponseService;

class UnitMeasureTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, ResponseService $responseService)
	{
		parent::__construct($tableGateway, $responseService);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'name' => isset($arrParams['name']) ? $arrParams['name'] : null,
            );
	}
}