<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 8/14/2017
 * Time: 7:48 AM
 */

namespace Tops\wordpress;


use Peanut\sys\PeanutInstaller;
use Tops\sys\TPath;

class WordpressPeanutInstaller extends PeanutInstaller
{

    private function parseConfigDefinition($line) {
        $line = trim($line);
        $prefix = substr($line,0,6);
        if (strlen($line) > 7 && substr($line,0,6) == 'define' ) {
            $parts = explode(');', $line);
            // $line = substr($parts[0], 6);
            $line = str_replace("'", '', substr($parts[0], 7));
            $parts = explode(',', $line);
            if (sizeof($parts) > 1) {
                $result = new \stdClass();
                $result->key = trim($parts[0]);
                $result->value = trim($parts[1]);
                return $result;
            }
        }
        return false;
    }
    public function getNativeDbConfiguration()
    {
        $result = new \stdClass();
        $foundCount = 0;

        $configfile = TPath::getFileRoot().'wp-config.php';
        $lines = file($configfile);
        foreach($lines as $line) {
            $def = $this->parseConfigDefinition($line);
            if ($def === false) {
                continue;
            }
            switch ($def->key) {
                case 'DB_NAME' :
                    $result->database = $def->value;
                    $foundCount++;
                    break;

                case 'DB_USER' :
                    $result->user = $def->value;
                    $foundCount++;
                    break;
                case 'DB_PASSWORD' :
                    $result->pwd = $def->value;
                    $foundCount++;
                    break;
                case 'DB_HOST' :
                    if ($def->value != 'localhost') {
                        $result->server = $def->value;
                    }
                    break;
            }
            if ($foundCount == 4) {
                break;
            }
        }

        return ($foundCount > 2 ?  $result : false);

    }
    public function testGetNativeDbConfiguration()
    {
        return $this->getNativeDbConfiguration();
    }
}