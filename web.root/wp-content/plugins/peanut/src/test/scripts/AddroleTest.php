<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 10/4/2017
 * Time: 6:35 AM
 */

namespace PeanutTest\scripts;


use Tops\sys\TPermissionsManager;
use Tops\sys\TStrings;
use Tops\sys\TUser;
use Tops\wordpress\TWordpressUser;
use Tops\wordpress\WordpressPermissionsManager;

class AddroleTest extends TestScript
{

    private $roles;
    private $continueTest = false;
    /**
     * @var WordpressPermissionsManager
     */
    private $manager;

    private function roleExists($value) {
        if (!isset($this->roles)) {
            if ($this->getRoleCount() === 0) {
                return false;
            }
        }
        $value = TStrings::convertNameFormat($value,TStrings::dashedFormat);
        foreach ($this->roles as $role) {
            if ($role->Value === $value) {
                return true;
            }
        }
        return false;
    }

    private function getRoleCount() {
        $this->roles = $this->manager->getRoles();
        $count = sizeof($this->roles);
        $this->assert($count > 0, 'No roles returned');
        return $count;
    }

    private function addRole($roleName,$roleCount,$fail=false) {
        $hasRole = $this->roleExists($roleName);
        $this->manager->addRole($roleName);
        $expected = $hasRole ? $roleCount : $roleCount + 1;
        $actual = $this->getRoleCount();
        $msg = ($expected == $actual) ?
             'duplicate role created' : 'role not added';
        $result = $this->assertEquals($expected,$actual,$msg);
        if ($fail && !$result) {
            exit;
        }
        $this->continueTest = $result;
        if ($result) {
            print  ($actual > $roleCount ?  "Role '$roleName' added.\n" : "Role '$roleName' exists.\n");
        }
        return $actual;
    }

    private function removeRole($roleName,$roleCount) {
        $this->manager->removeRole($roleName);
        $actual = $this->getRoleCount();
        print ( $actual < $roleCount ? "Role '$roleName' removed.\n" : "Role '$roleName' not removed.\n" );
        return $actual;
    }

    private function printRoles() {
        $roleObjects =  wp_roles()->roles;
        foreach ($roleObjects as $roleName => $roleObject) {
            $description = $roleObject['name'];
            print "Key: $roleName; Name: $description\n";
        }
        print "\n";
        $manager = TPermissionsManager::getPermissionManager();
        $roles = $manager->getRoles();
        print_r($roles);
    }

    public function execute()
    {
        $this->manager = new WordpressPermissionsManager();
        $roleCount = $this->getRoleCount();
        $expected = $roleCount;

        $testRole = 'test role';

        $roleCount = $this->addRole($testRole,$roleCount,true);
        $this->printRoles();
        $roleCount = $this->removeRole($testRole,$roleCount);
        $this->assertEquals($expected,$roleCount);


    }
}