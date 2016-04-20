<?php

/**
 * Testimonials Admin Manager - Handle the custom post types and admin functions for testimonial plans
 *
 *
 * @package Fusion
 */
class LM_Testimonials_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Testimonials_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Testimonials_Admin class.
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
     * Init method for the LM_Testimonials_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('add_meta_boxes', array(
            $this,
            'add_testimonial_meta_boxes'
        ));
        add_action('save_post', array(
            &$this,
            'save_testimonial'
        ), 10, 2);

        // Provide data for the columns of testimonial custom post type.
        add_action("manage_testimonials_posts_custom_column", array(
            $this,
            "manage_testimonials_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-testimonials_columns', array(
            $this,
            'edit_testimonials_columns'
        ));

    }

    // Change only the testimonial link attributes, rest like date, title etc. will take the default values
    function manage_testimonials_columns($column, $post_id) {
        global $post;
        switch ($column) {
            case 'testimonial':
                the_excerpt();
                break;
            case 'testimonial-client-image':
                if (has_post_thumbnail())
                    the_post_thumbnail(array(
                        80,
                        80
                    ));
                break;
            case 'testimonial-client-name':
                echo esc_html(get_post_meta($post_id, '_lm_client_name', true));
                break;
            case 'testimonial-client-details':
                echo esc_html(get_post_meta($post_id, '_lm_client_details', true));
                break;
            case 'testimonial-order':
                echo $post->menu_order;
                break;
        }
    }


    function edit_testimonials_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'lm-tools'),
            'testimonial' => __('Testimonial', 'lm-tools'),
            'testimonial-client-image' => __('Client\'s Image', 'lm-tools'),
            'testimonial-client-name' => __('Client\'s Name', 'lm-tools'),
            'testimonial-client-details' => __('Client Details', 'lm-tools'),
            'testimonial-order' => __('Testimonial Order', 'lm-tools')
        );

        return $columns;
    }


    function add_testimonial_meta_boxes() {

        add_meta_box(
            'lm_testimonials_box', __('Testimonials Information', 'lm-tools'), array(
                $this,
                'render_testimonials_metabox'
            ), 'testimonials', 'normal', 'high'
        );
    }

    function render_testimonials_metabox($post, $box) {

        $client_name = get_post_meta($post->ID, '_lm_client_name', true);
        $client_details = get_post_meta($post->ID, '_lm_client_details', true);

        wp_nonce_field(basename(__FILE__), 'lm_testimonials_info_nonce'); ?>

        <div class="lm-metabox-wrap">
            <div class="lm-metabox">
                <label for="client_name"><?php echo __('Client Name:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Enter the name of the client for the testimonial.', 'lm-tools') ?></div>
                <input id="client_name" name="client_name" type="text" value="<?php echo esc_html($client_name); ?>"/>
            </div>

            <div class="lm-metabox">
                <label for="client_details"><?php echo __('Client Details:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Enter additional details like position, business name, URL etc. for the source of the testimonial.', 'lm-tools') ?></div>
                <input id="client_details" name="client_details" type="text"
                       value="<?php echo esc_html($client_details); ?>"/>
            </div>
        </div>

    <?php
    }

    function save_testimonial($post_id) {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['lm_testimonials_info_nonce']) || !wp_verify_nonce($_POST['lm_testimonials_info_nonce'], basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;

        $post = get_post($post_id);
        if ($post->post_type == 'testimonials') {
            //Save the value to a custom field for the post
            if (isset($_POST['client_name']))
                update_post_meta($post_id, '_lm_client_name', esc_html($_POST['client_name']));

            if (isset($_POST['client_details']))
                update_post_meta($post_id, '_lm_client_details', esc_html($_POST['client_details']));

        }
        return $post_id;
    }

}