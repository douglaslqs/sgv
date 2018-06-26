<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class UserTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'email' => isset($arrParams['email']) ? $arrParams['email'] : null,
                'role' => isset($arrParams['role']) ? $arrParams['role'] : null,
            );
	}
}