<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/23/2017
 * Time: 8:51 AM
 */

namespace Tops\wordpress;



use Tops\db\model\repository\PermissionsRepository;

class WordpressRoles
{
    public static function roleNameToMachineName($roleName) {
        if (strpos($roleName,' ') !== false) {
            return strtolower(str_replace(' ','_',$roleName));
        }
        return $roleName;
    }

    /**
     * @param string $roleName
     * @param null $roleDescription
     * @return bool
     */
    public static function addRole($roleName)
    {
        $roleDescription = $roleName;
        $roleName = self::roleNameToMachineName($roleName);
        $wpRoles = wp_roles();
        $result = $wpRoles->add_role($roleName, __($roleDescription), array('read' => true));
        return $result !== null;
    }

    /**
     * @param $roleName
     * @param $repository PermissionsRepository
     * @return bool
     */
    public static function removeRole($roleName, $repository)
    {
        // $roleName = self::roleNameToMachineName($roleName);
        $wpRoles = wp_roles();
        if( $wpRoles->get_role($roleName) ){
            try {
                $repository->removeRolePermissions($roleName);
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
    public static function getRoles()
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


}