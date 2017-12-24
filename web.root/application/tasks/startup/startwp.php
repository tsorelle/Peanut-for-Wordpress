<?php
require __DIR__."\..\..\..\wp-load.php";
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/23/2017
 * Time: 7:24 AM
 */
function startPeanutTasks($user,$pwd) {
    $user = wp_signon([
        'user_login' => $user,
        'user_password' => $pwd
    ],false);

    if(is_wp_error($user)){
        exit("Error: task user sign in failed.");
    }
}