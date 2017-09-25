<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/12/2017
 * Time: 10:13 AM
 */

namespace PeanutTest\scripts;


use Tops\wordpress\WordpressPermissionsManager;

class RollbackpeanutTest extends TestScript
{

    public function execute()
    {

        $manager = new WordpressPermissionsManager();
        $manager->removeRole('peanutAdmin');
        $manager->removeRole('mailAdmin');

    }
}