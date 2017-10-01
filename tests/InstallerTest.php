<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 8/14/2017
 * Time: 9:02 AM
 */

use PHPUnit\Framework\TestCase;
use Tops\wordpress\WordpressPeanutInstaller;

class InstallerTest extends TestCase
{
    public function testGetInstallerInstance() {
        $actual = \Peanut\sys\PeanutInstaller::GetInstaller();
        $this->assertNotNull($actual);
        $this->assertInstanceOf('\Peanut\sys\PeanutInstaller',$actual);
    }
}


