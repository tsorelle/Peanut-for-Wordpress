<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 9/29/2017
 * Time: 7:23 AM
 */

namespace PeanutTest\scripts;


use SebastianBergmann\CodeCoverage\Report\Xml\Tests;

class QuickTest extends TestScript
{

    public function execute()
    {
        $user = wp_get_current_user();
        var_dump($user);
    }
}