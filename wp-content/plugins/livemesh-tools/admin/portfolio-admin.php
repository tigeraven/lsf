<?php

/**
 * Portfolio Admin Manager - Handle the custom post types and admin functions for portfolio items
 *
 *
 * @package Fusion
 */
class LM_Portfolio_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Portfolio_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Portfolio_Admin class.
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
     * Init method for the LM_Portfolio_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('add_meta_boxes', array(
            $this,
            'add_portfolio_meta_boxes'
        ));
        add_action('save_post', array(
            &$this,
            'save_portfolio'
        ));

        // Provide data for the columns of portfolio custom post type.
        add_action("manage_portfolio_posts_custom_column", array(
            $this,
            "custom_portfolio_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the 
        // sense that this applies to list instead of single custom post edit window. 
        add_filter('manage_edit-portfolio_columns', array(
            $this,
            'edit_portfolio_columns'
        ));

    }

    function edit_portfolio_columns($columns) {

        $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Portfolio Name', 'lm-tools'),
            'portfolio_image' => __('Portfolio Image', 'lm-tools'),
            'portfolio_link' => __('Portfolio Link', 'lm-tools'),
            'portfolio_client' => __('Portfolio Client', 'lm-tools'),
            'portfolio_services' => __('Portfolio Services', 'lm-tools'),
            'portfolio_column_size' => __('Thumbnail Size', 'lm-tools')
        );

        $columns = array_merge($new_columns, $columns);

        return $columns;
    }


    // Change only the portfolio link attributes, rest like date, title etc. will take the default values
    function custom_portfolio_columns($column, $post_id) {
        switch ($column) {
            case "portfolio_link":
                $portfolio_link = get_post_meta($post_id, '_portfolio_link_field', true);
                echo esc_url($portfolio_link);
                break;
            case "portfolio_image":
                if (has_post_thumbnail())
                    the_post_thumbnail(array(
                        80,
                        80
                    ));
                break;
            case "portfolio_client":
                $portfolio_client = get_post_meta($post_id, '_portfolio_client_field', true);
                echo esc_html($portfolio_client);
                break;
            case "portfolio_services":
                $portfolio_services = get_post_meta($post_id, '_portfolio_services_field', true);
                echo esc_html($portfolio_services);
                break;
            case "portfolio_date":
                $portfolio_date = get_post_meta($post_id, '_portfolio_date_field', true);
                echo esc_html($portfolio_date);
                break;
            case "portfolio_column_size":
                $portfolio_column_size = get_post_meta($post_id, '_portfolio_column_size_field', true);
                echo esc_attr($portfolio_column_size);
                break;
        }
    }

    function add_portfolio_meta_boxes() {

        add_meta_box(
            'portfolio_box', __('Portfolio Information', 'lm-tools'), array(
                $this,
                'render_portfolio_metabox'
            ), 'portfolio', 'normal', 'high'
        );
    }

    function render_portfolio_metabox($post) {

        $portfolio_column_size = get_post_meta($post->ID, '_portfolio_column_size_field', true);

        $portfolio_link = get_post_meta($post->ID, '_portfolio_link_field', true);
        $portfolio_services = get_post_meta($post->ID, '_portfolio_services_field', true);
        $portfolio_client = get_post_meta($post->ID, '_portfolio_client_field', true);
        $portfolio_date = get_post_meta($post->ID, '_portfolio_date_field', true);

        $portfolio_info = get_post_meta($post->ID, '_portfolio_info_field', true);

        wp_nonce_field(basename(__FILE__), 'lm_portfolio_info_nonce'); ?>

        <div class="lm-metabox-wrap">

            <div class="lm-metabox">
                <label for="portfolio_columns"><?php echo __('Project Thumbnail Size', 'lm-tools'); ?></label>

                <div class="description"><?php echo __('The column size of the project as seen in the portfolio showcase with masonry layout.', 'lm-tools') ?></div>
                <select id="portfolio_column_size" name="portfolio_column_size">
                    <option<?php if($portfolio_column_size == "1"){echo " selected=\"selected\"";} ?> value="1">1</option>
                    <option<?php if($portfolio_column_size == "2"){echo " selected=\"selected\"";} ?> value="2">2</option>
                    <option<?php if($portfolio_column_size == "3"){echo " selected=\"selected\"";} ?> value="3">3</option>
                    <option<?php if($portfolio_column_size == "4"){echo " selected=\"selected\"";} ?> value="4">4</option>
                    <option<?php if($portfolio_column_size == "5"){echo " selected=\"selected\"";} ?> value="5">5</option>
                    <option<?php if($portfolio_column_size == "6"){echo " selected=\"selected\"";} ?> value="6">6</option>
                    <option<?php if($portfolio_column_size == "7"){echo " selected=\"selected\"";} ?> value="7">7</option>
                    <option<?php if($portfolio_column_size == "8"){echo " selected=\"selected\"";} ?> value="8">8</option>
                    <option<?php if($portfolio_column_size == "9"){echo " selected=\"selected\"";} ?> value="9">9</option>
                    <option<?php if($portfolio_column_size == "10"){echo " selected=\"selected\"";} ?> value="10">10</option>
                    <option<?php if($portfolio_column_size == "11"){echo " selected=\"selected\"";} ?> value="11">11</option>
                    <option<?php if($portfolio_column_size == "12"){echo " selected=\"selected\"";} ?> value="12">12</option>
                </select>
            </div>

            <div class="lm-metabox">
                <label for="portfolio_link"><?php echo __('Project URL', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the project executed for the client.', 'lm-tools') ?></div>
                <input id="portfolio_link" name="portfolio_link" type="text"
                       value="<?php echo esc_url($portfolio_link); ?>"/>
            </div>

            <div class="lm-metabox">
                <label for="portfolio_services"><?php echo __('Services Offered', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('The services offered as part the client project.', 'lm-tools') ?></div>
                <input id="portfolio_services" name="portfolio_services" type="text"
                       value="<?php echo esc_html($portfolio_services); ?>"/>
            </div>

            <div class="lm-metabox">
                <label for="portfolio_client"><?php echo __('Client', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Name of the client for whom the project was executed.', 'lm-tools') ?></div>
                <input id="portfolio_client" name="portfolio_client" type="text"
                       value="<?php echo esc_html($portfolio_client); ?>"/>
            </div>

            <div class="lm-metabox">
                <label for="portfolio_date"><?php echo __('Project Date', 'lm-tools'); ?></label>

                <div class="description"><?php echo __('Date of the client project.', 'lm-tools') ?></div>
                <input id="portfolio_date" name="portfolio_date" type="text"
                       value="<?php echo esc_html($portfolio_date); ?>"/>
            </div>

            <div class="lm-metabox">
                <label
                    for="portfolio_info"><?php echo __('Additional Project Notes (HTML accepted)', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Any additional description of the project executed.', 'lm-tools') ?></div>
                <textarea rows="8" cols="85" id="portfolio_info"
                          name="portfolio_info"><?php echo esc_html($portfolio_info); ?></textarea>
            </div>
        </div>

    <?php
    }

    function save_portfolio($post_id) {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['lm_portfolio_info_nonce']) || !wp_verify_nonce($_POST['lm_portfolio_info_nonce'], basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;


        $post = get_post($post_id);
        if ($post->post_type == 'portfolio') {
            //Save the value to a custom field for the post
            update_post_meta($post_id, '_portfolio_column_size_field', esc_attr($_POST['portfolio_column_size']));

            update_post_meta($post_id, '_portfolio_link_field', esc_url($_POST['portfolio_link']));
            update_post_meta($post_id, '_portfolio_services_field', esc_html($_POST['portfolio_services']));
            update_post_meta($post_id, '_portfolio_client_field', esc_html($_POST['portfolio_client']));
            update_post_meta($post_id, '_portfolio_date_field', esc_html($_POST['portfolio_date']));
            update_post_meta($post_id, '_portfolio_info_field', esc_html($_POST['portfolio_info']));
        }
        return $post_id;
    }

}