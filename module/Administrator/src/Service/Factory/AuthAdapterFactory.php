<?php
namespace Administrator\Service\Factory;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Model\UserTable;

/**
 * The factory responsible for creating of authadapter service.
 */
class AuthAdapterFactory implements FactoryInterface
{
    /**
     * This method creates the Authadapter service
     * and returns its instance.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $table = $container->get(UserTable::class);
        // Create the service and inject dependencies into its constructor.
        return new $requestedName($table);
    }
}