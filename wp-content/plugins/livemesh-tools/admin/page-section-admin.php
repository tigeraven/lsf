<?php

/**
 * Page_Section Admin Manager - Handle the custom post types and admin functions for page_section plans
 *
 *
 * @package Fusion
 */
class LM_Page_Section_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Page_Section_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Page_Section_Admin class.
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
     * Init method for the LM_Page_Section_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('add_meta_boxes', array(
            $this,
            'add_page_section_meta_boxes'
        ));
        add_action('save_post', array(
            &$this,
            'save_page_section'
        ), 10, 2);

        // Provide data for the columns of page_section custom post type.
        add_action("manage_page_section_posts_custom_column", array(
            $this,
            "manage_page_section_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-page_section_columns', array(
            $this,
            'edit_page_section_columns'
        ));

    }

    // Change only the page_section link attributes, rest like date, title etc. will take the default values
    function manage_page_section_columns($column, $post_id) {

        global $post;
        switch ($column) {
            case 'page_section_order':
                echo $post->menu_order;
                break;
        }
    }


    function edit_page_section_columns($columns) {

        $new_columns = array(

            'page_section_order' => __('Order', 'lm-tools')
        );

        $columns = array_merge($columns, $new_columns);

        return $columns;
    }

    function add_page_section_meta_boxes() {

        add_meta_box(
            'lm_page_section_box', __('Team Information', 'lm-tools'), array(
                $this,
                'render_page_section_metabox'
            ), 'page_section', 'normal', 'high'
        );
    }

    function render_page_section_metabox($post, $box) {

        $page_section_desc = get_post_meta($post->ID, '_lm_page_section_desc', true);

        wp_nonce_field(basename(__FILE__), 'lm_page_section_info_nonce'); ?>

        <div class="lm-metabox-wrap">
            <div class="lm-metabox">
                <label
                    for="page_section_desc"><?php echo __('Page Section Description:', 'lm-tools'); ?></label>

                <div class="description"><?php echo htmlspecialchars_decode(__('Enter a short description for this page section. This description for the page
                    sections is shown in the page edit window for single page site template pages.<p>When composing a
                        single page, this optional description comes handy in identifying a page section when there are
                        many similar page sections or when title is too short to provide any clue about the function or
                        purpose of the page section.', 'lm-tools')) ?></div>
                <textarea rows="8" cols="85" id="page_section_desc"
                          name="page_section_desc"><?php echo esc_html($page_section_desc); ?></textarea>
            </div>

        </div>

    <?php
    }

    function save_page_section($post_id) {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['lm_page_section_info_nonce']) || !wp_verify_nonce($_POST['lm_page_section_info_nonce'], basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;

        $post = get_post($post_id);
        if ($post->post_type == 'page_section') {
            //Save the value to a custom field for the post
            if (isset($_POST['page_section_desc']))
                update_post_meta($post_id, '_lm_page_section_desc', esc_html($_POST['page_section_desc']));
        }
        return $post_id;
    }

}