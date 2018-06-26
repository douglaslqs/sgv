<?php
/** Return instance of object AclService
* @author Douglas Santos <douglasrock15@hotmail.com>
* @param ServiceLocatorInterface $serviceLocator
* @return \Application\Service\AclService
*/
namespace Application\Service\Factory;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Model\RoleResourceAllowTable;

class AclFactory implements FactoryInterface
{
   public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $role = 'store';//deixar o Service achar o role atraves do select ou sessão?
        $table = $container->get(RoleResourceAllowTable::class);
        return new $requestedName($table, $role);
    }

}