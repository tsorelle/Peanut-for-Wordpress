<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/28/2017
 * Time: 12:09 PM
 */

namespace PeanutTest\scripts;


use Tops\wordpress\WordpressPermissionsManager;

class PermissionscleanupTest extends TestScript
{

    public function execute()
    {
        // run logged in as admin

        $manager = new WordpressPermissionsManager();
        $roles = $manager->getRoles();
        $count = sizeof($roles);
        $this->assert($count > 0, 'No roles returned');

        $manager->removeRole(PermissionsTest::TestRoleName);

        $roles = $manager->getRoles();
        $actual = sizeof($roles);
        $expected = $count - 1;
        $this->assertEquals($expected,$actual,'Test not removed');
    }
}