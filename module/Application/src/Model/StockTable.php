<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;
use Application\Service\ResponseService;

class StockTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, ResponseService $responseService)
	{
		parent::__construct($tableGateway, $responseService);
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