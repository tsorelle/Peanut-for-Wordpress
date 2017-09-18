<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/12/2017
 * Time: 7:29 AM
 */

namespace Tops\wordpress;

// require_once(\Tops\sys\TPath::getFileRoot().'/wp-admin/includes/user.php');

use Tops\db\model\repository\PermissionsRepository;
use Tops\sys\IPermissionsManager;
use Tops\sys\TPermission;
use Tops\sys\TUser;
use WP_Roles;

class WordpressPermissionsManager implements IPermissionsManager
{


    /***********  Wordpress functions **************************/
    /**
     * @param string $roleName
     * @param null $roleDescription
     * @return bool
     */
    public function addRole($roleName,$roleDescription=null)
    {
        if (empty($roleDescription)) {
            $roleDescription = $roleName;
        }
        $wpRoles = wp_roles();
        $result = $wpRoles->add_role($roleName, __($roleDescription), array('read' => true));
        return $result !== null;
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function removeRole($roleName)
    {
        $wpRoles = wp_roles();
        if( $wpRoles->get_role($roleName) ){
            try {
                $this->getRepository()->removeRolePermissions($roleName);
            }
            catch (\Exception $ex) {
                // ignore sql exceptions that may occur if tables don't exist.
            }
            $wpRoles->remove_role($roleName);
            return true;
        }
        return false;
    }

    /**
     * @return \stdClass[]
     */
    public function getRoles()
    {
        $result = array();
        $roleObjects =  wp_roles()->roles;
            // \get_editable_roles();
        unset($roleObjects['administrator']);

        foreach ($roleObjects as $roleName => $roleObject) {
            $item = new \stdClass();
            $item->Name = $roleObject['name'];
            $item->Value = $roleName;
            $result[] = $item;
        }
        return $result;
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
        return $this->getRepository()->assignPermission($roleName,$permissionName);
    }

    public function addPermission($name, $description)
    {
        $username = TUser::getCurrent()->getUserName();
        $this->getRepository()->addPermission($name,$description,$username);
        return true;
    }


    /**
     * @param string $roleName
     * @param string $permissionName
     * @return bool
     */
    public function revokePermission($roleName, $permissionName)
    {
        return $this->getRepository()->revokePermission($roleName,$permissionName);
    }
}