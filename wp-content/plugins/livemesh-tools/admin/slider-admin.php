<?php

/**
 * Slider Admin Manager - Handle the custom post types and admin functions for sliders
 *
 *
 * @package Fusion
 */
class LM_Slider_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Slider_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Slider_Admin class.
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
     * Init method for the LM_Slider_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('add_meta_boxes', array(
            $this,
            'add_showcase_slide_meta_boxes'
        ));

        add_action('save_post', array(
            &$this,
            'save_showcase_slide'
        ));

        // Provide data for the columns of team_profile custom post type.
        add_action("manage_showcase_slide_posts_custom_column", array(
            $this,
            "custom_showcase_slide_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-showcase_slide_columns', array(
            $this,
            'edit_showcase_slide_columns'
        ));

    }

    /* ------------------------------------------ Showcase Slider ------------------------------------------------------------------ */


    function edit_showcase_slide_columns($columns) {

        $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Showcase Slide Name', 'lm-tools'),
            'showcase_slide_link' => __('Showcase Slide Link', 'lm-tools')
        );

        $columns = array_merge($new_columns, $columns);

        return $columns;
    }


    /* Change only the showcase_slide link attributes, rest like date, title etc. will take the default values */
    function custom_showcase_slide_columns($column, $post_id) {
        switch ($column) {
            case "showcase_slide_link":
                $showcase_slide_link = get_post_meta($post_id, '_slide_link_field', true);
                echo $showcase_slide_link;
                break;
        }
    }

    function add_showcase_slide_meta_boxes() {

        add_meta_box(
            'showcase_slide_box', __('Showcase Slide Information', 'lm-tools'), array(
                $this,
                'render_showcase_slide_metabox'
            ), 'showcase_slide', 'normal', 'high'
        );
    }

    function render_showcase_slide_metabox($post) {
        $showcase_slide_link = get_post_meta($post->ID, '_slide_link_field', true);

        $showcase_slide_info = get_post_meta($post->ID, '_slide_info_field', true);

        wp_nonce_field(basename(__FILE__), 'lm_showcase_slide_nonce'); ?>

        <div class="lm-metabox-wrap">
            <div class="lm-metabox">
                <label
                    for="showcase_slide_link"><?php echo __('Showcase Slider Item Link:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('The URL to which the slide should link to.', 'lm-tools') ?></div>
                <input id="showcase_slide_link" name="showcase_slide_link" type="text"
                       value="<?php echo esc_url($showcase_slide_link); ?>"/>
            </div>

            <div class="lm-metabox">
                <label
                    for="showcase_slide_info"><?php echo __('Showcase Slide Information (HTML accepted):', 'lm-tools'); ?></label>

                <div class="description"><?php echo __('Specify the text that is displayed as the description below the title. The
                    title of the post is the slider title.', 'lm-tools') ?></div>
                <textarea rows="6" cols="65" id="showcase_slide_info"
                          name="showcase_slide_info"><?php echo esc_html($showcase_slide_info); ?></textarea>
            </div>
        </div>

    <?php
    }

    function save_showcase_slide($post_id) {
        /* Verify the nonce before proceeding. */
        if (!isset($_POST['lm_showcase_slide_nonce']) || !wp_verify_nonce($_POST['lm_showcase_slide_nonce'], basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;

        $post = get_post($post_id);
        if ($post->post_type == 'showcase_slide') {
            //Save the value to a custom field for the post
            update_post_meta($post_id, '_slide_link_field', esc_url($_POST['showcase_slide_link']));
            update_post_meta($post_id, '_slide_info_field', esc_html($_POST['showcase_slide_info']));
        }
        return $post_id;
    }

}