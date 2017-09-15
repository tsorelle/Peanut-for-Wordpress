<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/15/2017
 * Time: 1:00 PM
 */

namespace PeanutTest\scripts;


use Tops\wordpress\WordpressPermissionsManager;

class CleanforinstallTest extends TestScript
{

    public function execute()
    {
        $manager = new WordpressPermissionsManager();

        $manager->removeRole('qnut_test');
        $manager->removeRole('peanutAdmin');
        $manager->removeRole('mailAdmin');
    }
}