<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Db\ResultSet\ResultSet;
use Application\Model\Entity\CategoryEntity;
use Application\Model\CategoryTable;
use Zend\Db\TableGateway\TableGateway;


class Module
{
    const VERSION = '3.0.2';

    /*public function onBootstrap(MvcEvent $e)
    {

    }

    public function onRoute(MvcEvent $e)
    {

    }

    public function onDispatch(MvcEvent $e)
    {

    } */

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
    	return array(
    		'factories' => array(
				'Application\Model\CategoryTable' =>  function($sm) {
	    				$tableGateway = $sm->get('CategoryTableGateway');
	    				$table = new CategoryTable($tableGateway);
	    				return $table;
	    			},
    			'CategoryTableGateway' => function ($sm) {
    				$dbAdapter = $sm->get('config')['db']['adapters']['store'];
    				$resultSetPrototype = new ResultSet();
    				$resultSetPrototype->setArrayObjectPrototype(new CategoryEntity());
    				return new TableGateway('category', $dbAdapter, null, $resultSetPrototype);
    			},
    		)
    	);
    }
}
