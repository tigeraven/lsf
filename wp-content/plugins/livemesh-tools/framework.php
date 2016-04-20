<?php

/**
 * Main class for the Livemesh theme framework which does the orchestration.
 *
 * @package Livemesh_Framework
 */
class LM_Framework {


    /* Constructor for the class */

    function __construct() {

        add_action('plugins_loaded', array(
            &$this,
            'define_constants'
        ), 1);

        add_action('plugins_loaded', array(
            &$this,
            'i18n'
        ), 2);

        add_action('plugins_loaded', array(
            &$this,
            'load_cmb2'
        ), 3);

        add_action('plugins_loaded', array(
            &$this,
            'load_files'
        ), 4);

        add_action('plugins_loaded', array(
            &$this,
            'setup_plugin_functions'
        ), 5);

        add_action('after_setup_theme', array(
            $this,
            'load_files_after_setup_theme'
        ), 99);

        add_action('init', array(
            &$this,
            'init_plugin_functions'
        ), 1);

        add_action('init', array(
            $this,
            'init_admin_functions'
        ), 2);
    }

    /**
     * Define framework constants
     */
    function define_constants() {
        /* Set constant path to the plugin directory. */
        define('LM_DIR', trailingslashit(plugin_dir_path(__FILE__)));

        /* Set the constant path to the plugin directory URI. */
        define('LM_URI', trailingslashit(plugin_dir_url(__FILE__)));

        /* Set the constant path to the includes directory. */
        define('LM_INCLUDES', LM_DIR . trailingslashit('includes'));

        /* Set the constant path to the admin directory. */
        define('LM_ADMIN_DIR', LM_DIR . trailingslashit('admin'));

        /* Set the constant path to the admin directory. */
        define('LM_ADMIN_URI', LM_URI . trailingslashit('admin'));

    }

    function i18n() {

        /* Load the translation of the plugin. */
        load_plugin_textdomain('lm-tools', false, dirname(plugin_basename(__FILE__)) . '/languages/');

    }

    /**
     * Include Custom Metaboxes 2
     *
     */
    function load_cmb2() {

        if ( defined( 'CMB2_LOADED' ) ) {
            return;

        }
        require_once LM_DIR . '/cmb2/init.php';

    }

    /**
     * Include all the required functions
     *
     */
    function load_files() {

        /* Load the utility functions. */

        require_once LM_INCLUDES . 'register-post-types.php';
        require_once LM_INCLUDES . 'helper-functions.php';

        if (is_admin()) {
            require_once(LM_ADMIN_DIR . '/slider-admin.php');
            require_once(LM_ADMIN_DIR . '/page-section-admin.php');
            require_once(LM_ADMIN_DIR . '/portfolio-admin.php');
            require_once(LM_ADMIN_DIR . '/team-admin.php');
            require_once(LM_ADMIN_DIR . '/gallery-admin.php');
            require_once(LM_ADMIN_DIR . '/testimonials-admin.php');
            require_once(LM_ADMIN_DIR . '/pricing-admin.php');
        }

    }

    /**
     * Include all the required functions
     *
     */
    function load_files_after_setup_theme() {

        /* Load the utility functions. */

        if (is_admin()) {

            require_if_theme_supports('campaigns', LM_ADMIN_DIR . '/campaign-admin.php');
            require_if_theme_supports('events', LM_ADMIN_DIR . '/event-admin.php');
        }

    }

    function setup_plugin_functions() {

        $this->add_actions_filters();

    }

    /**
     * Enable Theme Features.
     *
     */
    function add_actions_filters() {

        add_action('admin_enqueue_scripts', array(
            &$this,
            'admin_enqueue_styles'
        ), 18);

    }

    function admin_enqueue_styles() {
        /* Register Style */
        wp_register_style('lm-admin-css', LM_ADMIN_URI . 'assets/css/admin.css');

        wp_enqueue_style('lm-admin-css');
    }

    function init_plugin_functions() {

        lm_register_custom_post_types();

    }

    /**
     * Enable Admin Features.
     */
    function init_admin_functions() {

        if (is_admin()) {


            $slider_admin = LM_Slider_Admin::getInstance();
            $slider_admin->initialize();

            $portfolio_admin = LM_Portfolio_Admin::getInstance();
            $portfolio_admin->initialize();

            $page_section_admin = LM_Page_Section_Admin::getInstance();
            $page_section_admin->initialize();

            $team_admin = LM_Team_Admin::getInstance();
            $team_admin->initialize();

            $pricing_admin = LM_Pricing_Admin::getInstance();
            $pricing_admin->initialize();

            $testimonials_admin = LM_Gallery_Admin::getInstance();
            $testimonials_admin->initialize();

            $gallery_admin = LM_Testimonials_Admin::getInstance();
            $gallery_admin->initialize();

            if (current_theme_supports('campaigns')) {
                $campaign_admin = LM_Campaign_Admin::getInstance();
                $campaign_admin->initialize();
            }

            if (current_theme_supports('events')) {
                $event_admin = LM_Event_Admin::getInstance();
                $event_admin->initialize();
            }

        }
    }

}