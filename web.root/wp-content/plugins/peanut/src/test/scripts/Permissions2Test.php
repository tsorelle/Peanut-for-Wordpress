<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/28/2017
 * Time: 12:09 PM
 */

namespace PeanutTest\scripts;


use Tops\sys\TStrings;
use Tops\wordpress\WordpressPermissionsManager;
use Tops\sys\TUser;

class Permissions2Test extends TestScript
{

    public function execute()
    {
        // run logged in as tester then try others for expected fail


        $user = TUser::getCurrent();
        $name = $user->getUserName();
        print "Succeed if user is 'tester'\n";
        print "Running test as: $name\n";

        $manager = new WordpressPermissionsManager();

        $actual = $manager->verifyPermission(Permissions1Test::TestPermissionName);
        $this->assert($actual,'Not authorized, or tester not loggedin');

        $roleName = TStrings::convertNameFormat(Permissions1Test::TestRoleName,TStrings::keyFormat);
        $actual = $user->isMemberOf(Permissions1Test::TestRoleName);
        $this->assert($actual,'Not member of role.');

        $permissionName = TStrings::convertNameFormat(Permissions1Test::TestPermissionName,TStrings::wordCapsFormat);
        $actual = $user->isAuthorized($permissionName);
        $this->assert($actual,'Not authorized, or not loggedin');

        // run permisions3 to clean up
        print "Try other logins and finally run permission3 to cleanup";
    }
}