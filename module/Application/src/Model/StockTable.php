<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class StockTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'product' => isset($arrParams['product']) ? $arrParams['product'] : null,
                'mark' => isset($arrParams['mark']) ? $arrParams['mark'] : null,
                'measure' => isset($arrParams['measure']) ? $arrParams['measure'] : null,
                'unit_measure' => isset($arrParams['unit_measure']) ? $arrParams['unit_measure'] : null,
                'color' => isset($arrParams['color']) ? $arrParams['color'] : null,
            );
	}
}