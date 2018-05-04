<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class ProductOrderTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'client' => isset($arrParams['client']) ? $arrParams['client'] : null,
                'date_register' => isset($arrParams['date_register']) ? $arrParams['date_register'] : null,
                'product' => isset($arrParams['product']) ? $arrParams['product'] : null,
                'category' => isset($arrParams['category']) ? $arrParams['category'] : null,
                'category_parent'=>isset($arrParams['category_parent']) ? $arrParams['category_parent'] : null,
                'mark' => isset($arrParams['mark']) ? $arrParams['mark'] : null,
            );
	}
}