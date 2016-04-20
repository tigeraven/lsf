<?php

/**
 * Event Admin Manager - Handle the custom post types and admin functions for the events calendar
 * Utilizes CMB2 library for metabox creation.
 *
 *
 * @package Livemesh Tools
 */
class LM_Event_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Campaign_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Campaign_Admin class.
     *

     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * Prevent cloning of this singleton
     *

     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Init method for the LM_Campaign_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('cmb2_init', array(
            $this,
            'register_event_metaboxes'
        ));

    }

    function register_event_metaboxes() {


        if (current_theme_supports('campaigns')) {

            $cmb_demo = new_cmb2_box(array(
                'id' => '_lm_event_metaboxes',
                'title' => __('Campaign Details', 'lm-tools'),
                'object_types' => array('tribe_events'),
                // Post type
            ));

            $cmb_demo->add_field(array(
                'name' => __('Campaign', 'lm-tools'),
                'desc' => __('Specify the campaign, if any, for which the event has been created.', 'lm-tools'),
                'id' => '_lm_campaign_event',
                'type' => 'select',
                'options' => lm_get_post_options(array(
                    'post_type' => 'campaign',
                    'numberposts' => -1
                )),
            ));
        }
    }

}