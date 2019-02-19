<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;
use Application\Service\ResponseService;

class RoleResourceAllowTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, ResponseService $responseService)
	{
		parent::__construct($tableGateway, $responseService);
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