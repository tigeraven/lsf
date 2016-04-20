<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

add_action('wp_loaded', 'child_create_objects', 11);

function child_create_objects() {

}

$shortcodes_path = get_stylesheet_directory() . '/framework/shortcodes/';

include_once($shortcodes_path . 'contact-shortcodes.php');

?>