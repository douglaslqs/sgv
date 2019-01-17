<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;

class ProductCategoryTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway)
	{
		parent::__construct($tableGateway);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
            'category_name' => isset($arrParams['category_name']) ? $arrParams['category_name'] : null,
            'category_name_parent'=>isset($arrParams['category_name_parent']) ? $arrParams['category_name_parent'] : null,
            'product_name' => isset($arrParams['product_name']) ? $arrParams['product_name'] : null,
            'product_mark' => isset($arrParams['product_mark']) ? $arrParams['product_mark'] : null,
        );
	}
}