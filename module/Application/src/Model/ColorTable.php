<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class ColorTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'name' => isset($arrParams['name']) ? $arrParams['name'] : null,
            );
	}
}