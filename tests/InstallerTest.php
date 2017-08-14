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
    public function testDbConfig() {
        $helper = new WordpressPeanutInstaller();
        $config = $helper->getNativeDbConfiguration();
        $this->assertNotEmpty($config);
        $this->assertNotEmpty($config->user);
        $this->assertNotEmpty($config->pwd);
        $this->assertNotEmpty($config->database);
    }

    public function testGetInstallerInstance() {
        $actual = \Peanut\sys\PeanutInstaller::GetInstaller();
        $this->assertNotNull($actual);
        $this->assertInstanceOf('Tops\wordpress\WordpressPeanutInstaller',$actual);
    }

    public function testUpdateConfigAddSection() {
        $installer = \Peanut\sys\PeanutInstaller::GetInstaller();
        $configFile = \Tops\sys\TPath::getConfigPath().'database.ini';
        $tmpFile = __DIR__.'/files/tmp/database.ini';
        copy($configFile,$tmpFile);
        $id = 'unit-test';
        try {
            $installer->SetDatabaseConfiguration($id);
            $ini = parse_ini_file($configFile,true);
            $this->assertEquals($id,$ini['settings']['default']);
            $this->assertNotEmpty($ini[$id]);
            $this->assertEquals(3,sizeof($ini[$id]));
        }
        finally {
            copy($tmpFile,$configFile);
        }



    }

    public function testUpdateConfigAddSectionNotDefault() {
        $installer = \Peanut\sys\PeanutInstaller::GetInstaller();
        $configFile = \Tops\sys\TPath::getConfigPath().'database.ini';
        $ini = parse_ini_file($configFile,true);
        $default = $ini['settings']['default'];
        $tmpFile = __DIR__.'/files/tmp/database.ini';
        copy($configFile,$tmpFile);
        $id = 'unit-test';
        try {
            $installer->SetDatabaseConfiguration($id,false);
            $ini = parse_ini_file($configFile,true);
            $this->assertEquals($default,$ini['settings']['default']);
            $this->assertNotEmpty($ini[$id]);
            $this->assertEquals(3,sizeof($ini[$id]));
        }
        finally {
            copy($tmpFile,$configFile);
        }

    }


    public function testUpdateConfigExistingSection() {
        $installer = \Peanut\sys\PeanutInstaller::GetInstaller();
        $configFile = \Tops\sys\TPath::getConfigPath().'database.ini';
        $tmpFile = __DIR__.'/files/tmp/database.ini';
        copy($configFile,$tmpFile);
        $id = 'bookstore';
        try {
            $installer->SetDatabaseConfiguration($id);
            $ini = parse_ini_file($configFile,true);
            $this->assertEquals($id,$ini['settings']['default']);
            $this->assertNotEmpty($ini[$id]);
            $this->assertEquals(3,sizeof($ini[$id]));
            $actual = $ini[$id]['user'];
            $this->assertNotTrue($actual == '(user name here)');
            $actual = $ini[$id]['user'];
            $this->assertNotTrue($actual == '(password here)');
        }
        finally {
            copy($tmpFile,$configFile);
        }



    }
    public function testUpdateConfigFromScratch() {
        $installer = \Peanut\sys\PeanutInstaller::GetInstaller();
        $configFile = \Tops\sys\TPath::getConfigPath().'database.ini';
        $tmpFile = __DIR__.'/files/tmp/database.ini';
        copy($configFile,$tmpFile);
        unlink($configFile);
        $id = 'unit-test';
        try {
            $installer->SetDatabaseConfiguration($id);
            $ini = parse_ini_file($configFile,true);
            $this->assertEquals($id,$ini['settings']['default']);
            $this->assertNotEmpty($ini[$id]);
            $this->assertEquals(3,sizeof($ini[$id]));
        }
        finally {
            copy($tmpFile,$configFile);
        }



    }
}


