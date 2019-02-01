<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;
use Application\Service\PaginatorService;

class UserTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, PaginatorService $pgService)
	{
		parent::__construct($tableGateway, $pgService);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'email' => isset($arrParams['email']) ? $arrParams['email'] : null,
            );
	}
}