<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/23/2017
 * Time: 7:08 AM
 */
// If remote address not in $_SERVER, we are running a test in dev environment.
// Otherwise running script on server.  Ensure no remote access.
if (isset($_SERVER['REMOTE_ADDR']) && ($_SERVER['SERVER_ADDR'] !== @$_SERVER['REMOTE_ADDR'])) {
    $error = 'Remote script login attempted. Script: '.$_SERVER['SCRIPT_NAME'].' Remote IP: '.$_SERVER['REMOTE_ADDR'];
    exit($error);
}
if (empty($_SERVER['DOCUMENT_ROOT'])) {
    // for testing cases
    $scriptName = $_SERVER['PHP_SELF'];
    $_SERVER['DOCUMENT_ROOT'] = substr($scriptName,0,strlen($scriptName) -25);
}

$pnut_task_settings=parse_ini_file($_SERVER['DOCUMENT_ROOT'].'/application/config/settings.ini',true);
if ($pnut_task_settings === false) {
    exit("Error: no application settings found.");
}
$pnut_task_user = @$pnut_task_settings['site']['taskuser'];
$pnut_task_pw = @$pnut_task_settings['site']['taskpw'];
if (empty($pnut_task_user) || empty($pnut_task_pw)) {
    exit("Error: No task credentials found in application settings.");
}
$pnut_task_cms = @$pnut_task_settings['site']['cms'];
if (empty($pnut_task_pw)) {
    exit('Error: No site/cms in settings.ini');
}

require $_SERVER['DOCUMENT_ROOT'].'/application/tasks/startup/start'.$pnut_task_cms.'.php';
startPeanutTasks($pnut_task_user,$pnut_task_pw);
$taskmanager = new \Peanut\PeanutTasks\TaskManager();
$taskmanager->executeTasks();


