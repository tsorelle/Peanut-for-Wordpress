<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/12/2017
 * Time: 10:13 AM
 */

namespace PeanutTest\scripts;


use Tops\wordpress\WordpressPermissionsManager;

class PermissionsTest extends TestScript
{

    const TestPermissionName = 'Can do testing';
    const TestRoleName = 'Test role';
    public function execute()
    {

        $manager = new WordpressPermissionsManager();

        $roles = $manager->getRoles();

        $count = sizeof($roles);
        $this->assert($count > 0, 'No roles returned');

        $testRoleName = self::TestRoleName;
        $testPermissionName = self::TestPermissionName;

        $manager->addRole($testRoleName);
        $roles = $manager->getRoles();
        $actual = sizeof($roles);
        $expected = $count + 1;
        $this->assertEquals($expected,$actual,'Test not added');


        $roles = $manager->getRoles();
        //    var_dump($roles);
        //   print "\n\n";


        $manager->assignPermission($testRoleName,$testPermissionName);

        // check results and run Permisisons test 2;



    }
}