<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Application\Model\AbstractTable;
use Application\Service\ResponseService;

class DeliveryAddressTable extends AbstractTable
{
	public function __construct(TableGateway $tableGateway, ResponseService $responseService)
	{
		parent::__construct($tableGateway, $responseService);
	}

	public function filterArrayWhere($arrParams = array())
	{
		return array(
                'client'   => isset($arrParams['client']) ? $arrParams['client'] : null,
                'street'   => isset($arrParams['street']) ? $arrParams['street'] : null,
                'number'   => isset($arrParams['number']) ? $arrParams['number'] : null,
                'district' => isset($arrParams['district']) ? $arrParams['district'] : null,
            );
	}
}