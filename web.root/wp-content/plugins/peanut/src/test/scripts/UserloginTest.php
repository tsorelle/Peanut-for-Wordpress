<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/24/2017
 * Time: 4:47 AM
 */

namespace PeanutTest\scripts;


use Tops\sys\TUser;

class UserloginTest extends TestScript
{

    public function execute()
    {
        $username = 'ScriptMasterKF89289';
        $actual = TUser::SignIn('ScriptMasterKF89289','M6tJb@1*yoIf97cFCQlDFmwJ');
        $this->assert($actual,'Not logged in');
        $actual = TUser::getCurrent()->getUserName();
        $this->assertEquals($username,$actual,'Wrong user is current');
    }
}