<?php

/**
 * Campaign Admin Manager - Handle the custom post types and admin functions for campaign plans
 * Utilizes CMB2 library for metabox creation.
 *
 *
 * @package Fusion
 */
class LM_Campaign_Admin {

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
            'register_campaign_metaboxes'
        ));

    }

    function register_campaign_metaboxes() {

        $cmb_demo = new_cmb2_box(array(
            'id' => '_lm_campaign_metaboxes',
            'title' => __('Campaign Details', 'lm-tools'),
            'object_types' => array('campaign',),
            // Post type
        ));

        $cmb_demo->add_field(array(
            'name' => __('Campaign Info', 'lm-tools'),
            'desc' => __('Provide the HTML that needs to be displayed in the campaign info box', 'lm-tools'),
            'id' => '_lm_campaign_info',
            'type' => 'textarea',
        ));

        if (post_type_exists('give_forms')) {
            $cmb_demo->add_field(array(
                'name' => __('Donate Form', 'lm-tools'),
                'desc' => __('Specify the donation form for the campaign created using Give WordPress Donation plugin.', 'lm-tools'),
                'id' => '_lm_campaign_form',
                'type' => 'select',
                'options' => lm_get_post_options(array(
                    'post_type' => 'give_forms',
                    'numberposts' => -1
                )),
            ));
        }

        $cmb_demo->add_field(array(
            'name' => __('End Date', 'lm-tools'),
            'desc' => __('Provide the end date/time for the campaign', 'lm-tools'),
            'id' => '_lm_campaign_end_date',
            'type' => 'text_datetime_timestamp',
        ));
    }

}