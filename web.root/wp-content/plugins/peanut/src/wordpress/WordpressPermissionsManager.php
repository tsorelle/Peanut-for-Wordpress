<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/12/2017
 * Time: 7:29 AM
 */

namespace Tops\wordpress;

require_once(\Tops\sys\TPath::getFileRoot().'/wp-admin/includes/user.php');

use Tops\db\model\repository\PermissionsRepository;
use Tops\sys\IPermissionsManager;
use Tops\sys\TPermission;
use Tops\sys\TUser;

class WordpressPermissionsManager implements IPermissionsManager
{

    /***********  Wordpress functions **************************/
    /**
     * @param string $roleName
     * @return bool
     */
    public function addRole($roleName,$roleDescription=null)
    {
        if (empty($roleDescription)) {
            $roleDescription = $roleName;
        }
        $result = add_role($roleName, __($roleDescription), array('read' => true));
        return $result !== null;
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function removeRole($roleName)
    {
        if( get_role($roleName) ){
            remove_role($roleName);
            return true;
        }
        return false;
    }


    /**
     * @return string[]
     */
    public function getRoles()
    {
        $roleObjects = \get_editable_roles();
        unset($roleObjects['administrator']);
        return array_keys($roleObjects);
    }


    /******** Tops functions **********************/

    /**
     * @var PermissionsRepository
     */
    private $permissionsRepository;

    private function getRepository()
    {
        if (!isset($this->permissionsRepository)) {
            $this->permissionsRepository = new PermissionsRepository();
        }
        return $this->permissionsRepository;
    }


    /**
     * @return TPermission[]
     */
    public function getPermissions()
    {
        return $this->getRepository()->getAll();
    }

    public function getPermission($permissionName)
    {
        return $this->getRepository()->getPermission($permissionName);
    }

    /**
     * @param string $roleName
     * @param string $permissionName
     * @return bool
     */
    public function assignPermission($roleName, $permissionName)
    {
        $this->getRepository()->assignPermission($roleName,$permissionName);
    }

    public function addPermission($name, $description)
    {
        $username = TUser::getCurrent()->getUserName();
        $this->getRepository()->addPermission($name,$description,$username);
    }


    /**
     * @param string $roleName
     * @param string $permissionName
     * @return bool
     */
    public function revokePermission($roleName, $permissionName)
    {
        $this->getRepository()->revokePermission($roleName,$permissionName);
    }
}