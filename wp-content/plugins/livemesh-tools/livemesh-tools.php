<?php
/**
 * Plugin Name: Livemesh Tools
 * Plugin URI: http://portfoliotheme.org
 * Description: This plugin captures the custom post types supported by themes released by Livemesh - http://themeforest.net/user/Livemesh
 * Version: 1.0.0
 * Author: Livemesh Themes
 * Author URI: http://portfoliotheme.org
 * License: GPL2
 */

/* Load the LiveMesh plugin framework. */
require_once untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/framework.php';
if (!isset($lm_tools)) {
    $lm_tools = new LM_Framework();
}