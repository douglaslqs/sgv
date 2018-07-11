<?php
/**
 * @link      http://github.com/zendframework/Administrator for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Administrator;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(\Zend\Mvc\MvcEvent $e)
    {
    	$app = $e->getApplication();
	    $app->getEventManager()->attach(
	        'dispatch',
	        function($e) {
	            $routeMatch = $e->getRouteMatch();
	            $viewModel = $e->getViewModel();
	            $viewModel->setVariable('controller', $routeMatch->getParam('controller'));
	            $viewModel->setVariable('action', $routeMatch->getParam('action'));
	        },
	        -100
	    );
    }
}
