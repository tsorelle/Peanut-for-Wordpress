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

    public function execute()
    {

        $manager = new WordpressPermissionsManager();

        $roles = $manager->getRoles();
        $count = sizeof($roles);
        $this->assert($count > 0, 'No roles returned');

        $manager->addRole('qnut_test','Peanut tester');
        $roles = $manager->getRoles();
        $actual = sizeof($roles);
        $expected = $count + 1;
        $this->assertEquals($expected,$actual,'Test not added');

        $manager->removeRole('qnut_test');
        $roles = $manager->getRoles();
        $actual = sizeof($roles);
        $expected = $count;
        $this->assertEquals($expected,$actual,'Test not removed');

    }
}