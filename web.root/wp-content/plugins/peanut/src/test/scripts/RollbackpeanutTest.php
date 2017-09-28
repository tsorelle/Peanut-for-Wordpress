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
        $cap = 'administer_mailboxes';


        $wpRoles = wp_roles();
        $roleName= 'peanut_administrator';
        $ok = current_user_can($cap);
        $this->assert($ok,'Cannot do it');

        /*        $roleDescription = 'Peanut Administrator';
                $wpRoles = wp_roles();
                $result = $wpRoles->add_role($roleName, __($roleDescription), array('read' => true));*/

/*        $role = $wpRoles->get_role($roleName);
        if ($this->assertNotNull($role,'Role')) {
            $role->add_cap($cap);
            // $role->remove_cap($cap);
            var_dump($role);
        };*/


//        // $manager = new WordpressPermissionsManager();
//        $wpRoles->remove_role('Peanut Administrator');
//        $wpRoles->remove_role('Administrator for Peanut Features');
//        $wpRoles->remove_role('peanut_administrator');

    }
}