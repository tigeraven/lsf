<?php

/**
 * Gallery Admin Manager - Handle the custom post types and admin functions for gallery_item plans
 *
 *
 * @package Fusion
 */
class LM_Gallery_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Gallery_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Gallery_Admin class.
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
     * Init method for the LM_Gallery_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        // Provide data for the columns of gallery_item custom post type.
        add_action("manage_gallery_item_posts_custom_column", array(
            $this,
            "manage_gallery_item_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-gallery_item_columns', array(
            $this,
            'edit_gallery_item_columns'
        ));

    }

    // Change only the gallery_item link attributes, rest like date, title etc. will take the default values
    function manage_gallery_item_columns($column, $post_id) {

        global $post;

        switch ($column) {
            case 'gallery_category':
                echo get_the_term_list($post_id, 'gallery_category', '', ', ', '');
                break;
            case 'gallery_thumbnail':
                if (has_post_thumbnail())
                    the_post_thumbnail(array(
                        80,
                        80
                    ));
                break;
        }
    }


    function edit_gallery_item_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Gallery Title', 'lm-tools'),
            'gallery_thumbnail' => __('Thumbnail', 'lm-tools'),
            'gallery_category' => __('Category', 'lm-tools')
        );

        return $columns;
    }

}