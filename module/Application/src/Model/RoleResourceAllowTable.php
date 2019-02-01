<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;
use Application\Service\PaginatorService;

class RoleResourceAllowTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, PaginatorService $pgService)
	{
		parent::__construct($tableGateway, $pgService);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'role' => isset($arrParams['role']) ? $arrParams['role'] : null,
                'module' => isset($arrParams['module']) ? $arrParams['module'] : null,
                'controller' => isset($arrParams['controller']) ? $arrParams['controller'] : null,
                'action' => isset($arrParams['action']) ? $arrParams['action'] : null,
            );
	}
}