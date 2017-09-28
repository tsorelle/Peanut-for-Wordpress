<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/28/2017
 * Time: 12:09 PM
 */

namespace PeanutTest\scripts;


use Tops\wordpress\WordpressPermissionsManager;

class Permissions2Test extends TestScript
{

    public function execute()
    {
        // run logged in as tester
        $manager = new WordpressPermissionsManager();

        $actual = $manager->verifyPermission(PermissionsTest::TestPermissionName);
        $this->assert($actual,'Not authorized, or tester not loggedin');


    }
}