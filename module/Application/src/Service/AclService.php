<?php
namespace Application\Service;

use Application\Model\AbstractTable;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\Permissions\Acl\Role\GenericRole;

class AclService
{
    private $table;
    private $roleResourceAllowTable;
    private $objAcl;
    private $strRole;

    public function __construct(AbstractTable $table, $strRole)
    {
        $this->table = $table;
        $this->strRole = $strRole;
        $this->objAcl = new Acl();
        $this->getObjAcl()->addRole(new GenericRole($this->getRole()));
        $this->setResourcesAndAllows();
    }

    /** Define resources and permissions in the object Acl.
     * @author Douglas Santos <douglasrock15@hotmail.com>
     * @return void
     */
    private function setResourcesAndAllows()
    {
        $sql = $this->table->getTableGateway()->getSql();
        $select = $sql->select()->where(array('role' => $this->getRole()));
        $resultSet = $this->table->getTableGateway()->selectWith($select)->toArray();
        foreach ($resultSet as $key => $value) {
            $resource = $value['module'].'/'.$value['controller'];
            if(!$this->getObjAcl()->hasResource($resource)) {
                $this->getObjAcl()->addResource(new GenericResource($resource));
                $select = $sql->select()->where(array('role'=> $this->getRole(), 'module'=>$value['module'],'controller'=>$value['controller']));
                $resultSetAllow = $this->table->getTableGateway()->selectWith($select)->toArray();
                $arrAllow = array();
                foreach ($resultSetAllow as $k => $v) {
                    $arrAllow[$v['action']] = $v['action'];
                }
                $this->getObjAcl()->allow($this->getRole(), $resource, $arrAllow);
            }
        }
    }

    /** Return role defined in this object
     * @author Douglas Santos <douglasrock15@hotmail.com>
     * @return string
     */
    public function getRole()
    {
        return $this->strRole;
    }

    /** Return the instance of object Acl
     * @author Douglas Santos <douglasrock15@hotmail.com>
     * @return \Zend\Permissions\Acl\Acl
     */
    public function getObjAcl()
    {
        return $this->objAcl;
    }

    /** Return instance of RoleResourceAllowTable
     * @author Douglas Santos <douglasrock15@hotmail.com>
     * @return RoleResourceAllowTable
     */
    /*
    private function getRoleResourceAllowTable()
    {
        if(empty($this->roleResourceAllowTable))
            $this->roleResourceAllowTable = $this->table->get("Intranet\Model\RoleResourceAllowTable");
        return $this->roleResourceAllowTable;
    }
    */
}