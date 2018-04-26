<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class OrderTable extends AbstractTable
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
            );
	}
}