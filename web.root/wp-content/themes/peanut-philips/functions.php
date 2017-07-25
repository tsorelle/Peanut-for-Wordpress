<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 6/21/2017
 * Time: 6:55 AM
 */
function peanut_enqueue_styles() {
    $parent_style = 'philips-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'peanut-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version'));
}
add_action( 'wp_enqueue_scripts', 'peanut_enqueue_styles' );
