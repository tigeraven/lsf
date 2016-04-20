<?php

/**
 * Pricing Admin Manager - Handle the custom post types and admin functions for pricing plans
 *
 *
 * @package Fusion
 */
class LM_Pricing_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Pricing_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Pricing_Admin class.
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
     * Init method for the LM_Pricing_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('add_meta_boxes', array(
            $this,
            'add_pricing_meta_boxes'
        ));
        add_action('save_post', array(
            &$this,
            'save_pricing'
        ), 10, 2);

        // Provide data for the columns of pricing custom post type.
        add_action("manage_pricing_posts_custom_column", array(
            $this,
            "manage_pricing_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-pricing_columns', array(
            $this,
            'edit_pricing_columns'
        ));

    }

    // Change only the pricing link attributes, rest like date, title etc. will take the default values
    function manage_pricing_columns($column, $post_id) {
        global $post;
        switch ($column) {
            case 'pricing-plan-price-tag':
                echo esc_html(get_post_meta($post_id, '_lm_price_tag', true));
                break;
            case 'pricing-plan-url':
                echo esc_url(get_post_meta($post_id, '_lm_pricing_url', true));
                break;
            case 'pricing-tagline':
                echo esc_html(get_post_meta($post_id, '_lm_pricing_tagline', true));
                break;
            case 'pricing-image':
                $image_url = esc_url(get_post_meta($post_id, '_lm_pricing_img', true));
                if (!empty($image_url))
                    echo '<img alt="' . $post->post_title . '" src="' . $image_url . '" />';
                break;
            case 'pricing-plan-order':
                echo $post->menu_order;
                break;

        }
    }


    function edit_pricing_columns($columns) {
        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Pricing Plan Name', 'lm-tools'),
            'pricing-plan-price-tag' => __('Price Tag', 'lm-tools'),
            'pricing-tagline' => __('Tagline', 'lm-tools'),
            'pricing-image' => __('Image', 'lm-tools'),
            'pricing-plan-url' => __('Pricing Plan URL', 'lm-tools'),
            'pricing-plan-order' => __('Pricing Plan Order', 'lm-tools')
        );

        return $columns;
    }


    function add_pricing_meta_boxes() {

        add_meta_box(
            'lm_pricing_box', __('Pricing Information', 'lm-tools'), array(
                $this,
                'render_pricing_metabox'
            ), 'pricing', 'normal', 'high'
        );
    }

    function render_pricing_metabox($post, $box) {

        $price_tag = get_post_meta($post->ID, '_lm_price_tag', true);
        $pricing_tagline = get_post_meta($post->ID, '_lm_pricing_tagline', true);
        $pricing_img = get_post_meta($post->ID, '_lm_pricing_img', true);
        $pricing_button_url = get_post_meta($post->ID, '_lm_pricing_url', true);
        $pricing_button_text = get_post_meta($post->ID, '_lm_pricing_button_text', true);
        $highlight_pricing = get_post_meta($post->ID, '_lm_highlight_pricing', true);

        wp_nonce_field(basename(__FILE__), 'lm_pricing_info_nonce'); ?>

        <div class="lm-metabox-wrap">
            <div class="lm-metabox">
                <label for="price_tag"><?php echo __('Price Tag:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Enter the price tag for the pricing plan. HTML is accepted.', 'lm-tools') ?></div>
                <input id="price_tag" name="price_tag" type="text" value="<?php echo esc_html($price_tag); ?>"/>
            </div>

            <div class="lm-metabox">
                <label for="pricing_tagline"><?php echo __('Tagline Text:', 'lm-tools'); ?></label>

                <div class="description"><?php echo __('Provide any taglines like "Most Popular", "Best Value", "Best Selling", "Most
                    Flexible" etc. that you would like to use for this pricing plan.', 'lm-tools') ?></div>
                <input id="pricing_tagline" name="pricing_tagline" type="text"
                       value="<?php echo esc_html($pricing_tagline); ?>"/>
            </div>

            <div class="lm-metabox">
                <label for="pricing_img"><?php echo __('Pricing Image URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Choose the custom image that represents this pricing plan, if any.', 'lm-tools') ?></div>
                <input id="pricing_img" name="pricing_img" type="text"
                       value="<?php echo esc_url($pricing_img); ?>"/>
            </div>

            <div class="lm-metabox">
                <label
                    for="pricing_button_url"><?php echo __('URL for the Pricing link/button:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Provide the target URL for the link or the button shown for this pricing plan.', 'lm-tools') ?></div>
                <input id="pricing_button_url" name="pricing_button_url" type="text"
                       value="<?php echo esc_url($pricing_button_url); ?>"/>
            </div>

            <div class="lm-metabox">
                <label
                    for="pricing_button_text"><?php echo __('Text for Pricing Link/Button:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Provide the text for the link or the button shown for this pricing plan.', 'lm-tools') ?></div>
                <input id="pricing_button_text" name="pricing_button_text" type="text"
                       value="<?php echo esc_html($pricing_button_text); ?>"/>
            </div>

            <div class="lm-metabox">
                <label
                    for="highlight_pricing"><?php echo __('Highlight Pricing Plan:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Specify if you want to highlight the pricing plan.', 'lm-tools') ?></div>
                <input type="checkbox"
                       name="highlight_pricing" <?php echo (!empty($highlight_pricing)) ? 'checked="checked"' : '' ?>
                       value="Yes"><?php echo __('Yes', 'lm-tools') ?>
            </div>
        </div>

    <?php
    }

    function save_pricing($post_id) {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['lm_pricing_info_nonce']) || !wp_verify_nonce($_POST['lm_pricing_info_nonce'], basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;

        $post = get_post($post_id);
        if ($post->post_type == 'pricing') {
            //Save the value to a custom field for the post
            if (isset($_POST['price_tag']))
                update_post_meta($post_id, '_lm_price_tag', esc_html($_POST['price_tag']));

            if (isset($_POST['pricing_tagline']))
                update_post_meta($post_id, '_lm_pricing_tagline', esc_html($_POST['pricing_tagline']));

            if (isset($_POST['pricing_img']))
                update_post_meta($post_id, '_lm_pricing_img', esc_url($_POST['pricing_img']));

            if (isset($_POST['pricing_button_url']))
                update_post_meta($post_id, '_lm_pricing_url', esc_url($_POST['pricing_button_url']));

            if (isset($_POST['pricing_button_text']))
                update_post_meta($post_id, '_lm_pricing_button_text', esc_html($_POST['pricing_button_text']));

            if (isset($_POST['highlight_pricing']))
                update_post_meta($post_id, '_lm_highlight_pricing', esc_html($_POST['highlight_pricing']));
            else {
                delete_post_meta($post_id, '_lm_highlight_pricing');
            }
        }
        return $post_id;
    }

}