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
        if (TUser::getCurrent()->isAuthenticated()) {
            exit('Log out before running test');
        }
        /*
                password ignored in Drupal
                $actual = TUser::SignIn($username,'bad password');
                $this->assert($actual === false,'Sign in result should have been false');
        */

        $actual = TUser::SignIn('unknownuser','bad password');
        $this->assert($actual === false,'Sign in result should have been false');

        $expected = !TUser::getCurrent()->isAuthenticated();
        $this->assert($expected,'Expected anonymous');

        $actual = TUser::SignIn($username,'M6tJb@1*yoIf97cFCQlDFmwJ');
        $this->assert($actual,'Not logged in');
        $actual = TUser::getCurrent()->getUserName();
        $this->assertEquals($username,$actual,'Wrong user is current');
    }
}