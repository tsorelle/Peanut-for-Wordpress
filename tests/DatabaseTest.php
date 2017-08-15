<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 8/15/2017
 * Time: 9:31 AM
 */

namespace Peanut\testing;

use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private function ClearCaches() {
        \Tops\sys\TObjectContainer::ClearCache();
        \Tops\db\TDatabase::ClearCache();
    }


    public function testDatabaseConfig() {
        $actual = \Tops\db\TDatabase::getDbConfigurationForTest();
        $this->assertNotEmpty($actual);
        $this->assertNotEmpty($actual->connections);
        $keyExists=array_key_exists('wordpress',$actual->connections);
        $this->assertTrue($keyExists);
        $props = $actual->connections['wordpress'];
        $propCount = sizeof($props);
        $expected = 3;
        $this->assertEquals($expected, $propCount);


    }

}
