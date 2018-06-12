<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class RoleResourceAllowTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'role' => isset($arrParams['role']) ? $arrParams['role'] : null,
                'module_controller' => isset($arrParams['module_controller']) ? $arrParams['module_controller'] : null,
                'action' => isset($arrParams['action']) ? $arrParams['action'] : null,
            );
	}
}