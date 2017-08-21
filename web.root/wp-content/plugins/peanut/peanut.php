<?php
/**
 * @package peanut
 */
/*
Plugin Name: peanut
Plugin URI: https://github.com/tsorelle/Peanut-for-Wordpress
Description: Peanut framework supports KnockoutViewModels and TOPS Services
Version: 0.1
Author: Terry SoRelle
Author URI: https://github.com/tsorelle
License: GPLv2 or later
Text Domain: peanut
*/
use Tops\sys\TStrings;
use Peanut\sys\ViewModelManager;

add_action( 'init', 'peanut_initialize' );
function peanut_initialize() {
    $fileRoot = realpath(__DIR__.'/../../..');
    include_once ("$fileRoot/application/config/peanut-bootstrap.php");
    \Peanut\Bootstrap::initialize($fileRoot);
    session_start();
    \Tops\sys\TSession::Initialize();

    $request = \Tops\sys\TRequestBuilder::GetRequest();
    $pathInfo = $request->getPathInfo();
    // routing
    switch ($pathInfo) {
        case '/peanut/settings' :
            header('Content-type: application/json');
            include($fileRoot.'/application/config/settings.php');
            exit;
        case '/peanut/service/execute' :
            $response = \Tops\services\ServiceFactory::Execute();
            header('Content-type: application/json');
            print json_encode($response);
            exit;
            break;
        default :
            if (substr($pathInfo,0,8) == '/peanut/') {
                $content = \Peanut\sys\ViewModelPageBuilder::Build(substr($pathInfo,8));
                // $content = file_get_contents("$fileRoot/application/assets/templates/default-page.html");
                print $content;
                exit;
            }
            else {
                $vm = \Tops\wordpress\ViewModel::Initialize($request);
            }
            break;
    }
}

add_action( 'wp_enqueue_scripts', 'peanut_scripts' );
function peanut_scripts() {
    if (\Peanut\sys\ViewModelManager::hasVm()) {
        $currentTheme = wp_get_theme();
        $themeSection =  strtolower($currentTheme->name);
        $themeIni = \Tops\sys\TIniSettings::Create('themes.ini');
        $bootstrapLib = $themeIni->getValue('bootstrap.library',$themeSection);
        $dependencies = array ('peanut-head-load-js');
        if ($bootstrapLib !== false) {
            $dependencies[] = $bootstrapLib;
        }
        $dependencies[] = 'jquery';
        $optimized = \Tops\sys\TConfiguration::getBoolean('optimize','peanut',true);
        $loaderScript = $optimized ? 'dist/loader.min.js' : 'core/PeanutLoader.js';
        $dir = plugin_dir_url(__FILE__);
        $peanutVersion = ViewModelManager::GetPeanutVersion();
        wp_enqueue_script('peanut-head-load-js', plugin_dir_url(__FILE__).'js/libraries/head.load.js');
        wp_enqueue_script('peanut-knockout-js', plugin_dir_url(__FILE__).'js/libraries/knockout-3.4.2-debug.js');
        wp_enqueue_script('peanut-loader-js', plugin_dir_url(__FILE__).'pnut/'.$loaderScript,
            $dependencies, $peanutVersion, true);
    }
}

add_filter('the_content','peanut_content');
function peanut_content($input)
{
    /**
     * @var \Tops\wordpress\ViewModel
     */
    $vmInfo = \Peanut\sys\ViewModelManager::getViewModelInfo();
         // \Tops\wordpress\ViewModel::getViewModelInfo();
    if ($vmInfo !== false && $vmInfo->view != 'content') {
        $fileRoot = realpath(__DIR__.'/../../..');
        $content = file_get_contents($fileRoot . '/' . $vmInfo->view);
        $token = '[[peanut-view-here]]';
        if (stristr($input,$token)) {
            $content = str_replace($token,$content,$input);
        }
        return $content;
    }
    return $input;
}


