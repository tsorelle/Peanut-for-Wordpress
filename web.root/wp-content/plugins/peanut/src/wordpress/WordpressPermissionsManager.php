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
use Tops\sys\TStrings;
use Tops\sys\TUser;
use WP_Roles;
use function wp_roles;

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
        $roleKey = TStrings::convertNameFormat($roleName,TStrings::keyFormat);
        $roleDescription = TStrings::convertNameFormat($roleName,TStrings::wordCapsFormat);
        // wordpress does not use role descriptions

        $result = wp_roles()->add_role($roleKey, __($roleDescription), array('read' => true));
        return $result !== null;
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function removeRole($roleName)
    {
        $roleName = TStrings::convertNameFormat($roleName,TStrings::keyFormat);
        $wpRoles = wp_roles();
        $role = $this->getWpRole($roleName);
        if( !empty($role)){
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

    /**
     * @return TPermission[]
     */
    public function getPermissions()
    {
        return []; // not implemented
    }

    public function getPermission($permissionName)
    {
        return null; // not implemented
    }

    private function getWpRole($roleName) {
        $roleKey = TStrings::convertNameFormat($roleName,TStrings::keyFormat);
        return wp_roles()->get_role($roleKey);
    }

    /**
     * @param string $roleName
     * @param string $permissionName
     * @return bool
     */
    public function assignPermission($roleName, $permissionName)
    {
        $role = $this->getWpRole($roleName);
        $permissionKey = TStrings::convertNameFormat($permissionName,TStrings::keyFormat);
        $role->add_cap($permissionKey);
        return true;
    }

    public function addPermission($name, $description)
    {
        // not implemented permissions added by assignment
    }


    /**
     * @param string $roleName
     * @param string $permissionName
     * @return bool
     */
    public function revokePermission($roleName, $permissionName)
    {
        $role = $this->getWpRole($roleName);
        $permissionKey = TStrings::convertNameFormat($permissionName,TStrings::keyFormat);
        $role->remove_cap($permissionKey);
        return true;
    }

    public function removePermission($name)
    {
        // not implemented. permissions removed on revocation
    }

    public function verifyPermission($permissionName)
    {
        $permissionKey = TStrings::convertNameFormat($permissionName,TStrings::keyFormat);
        return current_user_can($permissionKey);
    }
}