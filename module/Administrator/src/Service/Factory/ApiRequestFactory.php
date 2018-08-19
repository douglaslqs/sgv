<?php
namespace Administrator\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * The factory responsible for creating of apirequest service.
 */
class ApiRequestFactory implements FactoryInterface
{
    /**
     * This method creates the Zend\Authentication\AuthenticationService service
     * and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        // Create the service and inject dependencies into its constructor.
        return new $requestedName;
    }
}