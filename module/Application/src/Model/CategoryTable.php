<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;
use Application\Service\PaginatorService;

class CategoryTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, PaginatorService $pgService)
	{
		parent::__construct($tableGateway, $pgService);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'name' => isset($arrParams['name']) ? $arrParams['name'] : null,
                'name_parent'=>isset($arrParams['name_parent']) ? $arrParams['name_parent'] : null,
            );
	}
}