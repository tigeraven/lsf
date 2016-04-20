<?php

/**
 * Team Admin Manager - Handle the custom post types and admin functions for team_profile plans
 *
 *
 * @package Fusion
 */
class LM_Team_Admin {

    private static $instance;

    /**
     * Constructor method for the LM_Team_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the LM_Team_Admin class.
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
     * Init method for the LM_Team_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        add_action('add_meta_boxes', array(
            $this,
            'add_team_profile_meta_boxes'
        ));
        add_action('save_post', array(
            &$this,
            'save_team_profile'
        ), 10, 2);

        // Provide data for the columns of team_profile custom post type.
        add_action("manage_team_posts_custom_column", array(
            $this,
            "manage_team_profile_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-team_columns', array(
            $this,
            'edit_team_profile_columns'
        ));

    }

    // Change only the team_profile link attributes, rest like date, title etc. will take the default values
    function manage_team_profile_columns($column, $post_id) {
        global $post;
        switch ($column) {
            case 'team_category':
                echo get_the_term_list($post_id, 'department', '', ', ', '');
                break;
            case 'team_thumbnail':
                if (has_post_thumbnail())
                    the_post_thumbnail(array(
                        80,
                        80
                    ));
                break;
            case 'team_position':
                echo esc_html(get_post_meta($post_id, '_lm_position', true));
                break;
            case 'team_order':
                echo $post->menu_order;
                break;
        }
    }


    function edit_team_profile_columns($columns) {

        $columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => __('Team Member Name', 'lm-tools'),
            'team_thumbnail' => __('Thumbnail', 'lm-tools'),
            'team_position' => __('Position', 'lm-tools'),
            'team_category' => __('Department', 'lm-tools'),
            'team_order' => __('Team Order', 'lm-tools')
        );

        return $columns;
    }


    function add_team_profile_meta_boxes() {

        add_meta_box(
            'lm_team_profile_box', __('Team Information', 'lm-tools'), array(
                $this,
                'render_team_profile_metabox'
            ), 'team', 'normal', 'high'
        );
    }

    function render_team_profile_metabox($post, $box) {

        $team_profile_position = get_post_meta($post->ID, '_lm_position', true);
        $team_profile_email = get_post_meta($post->ID, '_lm_email', true);
        $team_profile_twitter = get_post_meta($post->ID, '_lm_twitter', true);
        $team_profile_linkedin = get_post_meta($post->ID, '_lm_linkedin', true);
        $team_profile_facebook = get_post_meta($post->ID, '_lm_facebook', true);
        $team_profile_dribbble = get_post_meta($post->ID, '_lm_dribbble', true);
        $team_profile_googleplus = get_post_meta($post->ID, '_lm_googleplus', true);
        $team_profile_instagram = get_post_meta($post->ID, '_lm_instagram', true);

        wp_nonce_field(basename(__FILE__), 'lm_team_profile_info_nonce'); ?>

        <div class="lm-metabox-wrap">
            <div class="lm-metabox">
                <label
                    for="team_profile_position"><?php echo __('Team Member Position:', 'lm-tools'); ?></label>

                <div class="description"><?php echo __('Enter the position of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_position" name="team_profile_position" type="text"
                       value="<?php echo esc_html($team_profile_position); ?>"/>
            </div>
            <div class="lm-metabox">
                <label
                    for="team_profile_email"><?php echo __('Member Email Address:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('Enter the email address of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_email" name="team_profile_email" type="text"
                       value="<?php echo esc_html($team_profile_email); ?>"/>
            </div>
            <div class="lm-metabox">
                <label
                    for="team_profile_twitter"><?php echo __('Twitter Profile URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the Twitter page of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_twitter" name="team_profile_twitter" type="text"
                       value="<?php echo esc_url($team_profile_twitter); ?>"/>
            </div>
            <div class="lm-metabox">
                <label
                    for="team_profile_linkedin"><?php echo __('LinkedIn Profile URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the LinkedIn profile of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_linkedin" name="team_profile_linkedin" type="text"
                       value="<?php echo esc_url($team_profile_linkedin); ?>"/>
            </div>
            <div class="lm-metabox">
                <label
                    for="team_profile_facebook"><?php echo __('Facebook Page URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the Facebook page of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_facebook" name="team_profile_facebook" type="text"
                       value="<?php echo esc_url($team_profile_facebook); ?>"/>
            </div>
            <div class="lm-metabox">
                <label
                    for="team_profile_dribbble"><?php echo __('Dribbble Profile URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the Dribbble profile of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_dribbble" name="team_profile_dribbble" type="text"
                       value="<?php echo esc_url($team_profile_dribbble); ?>"/>
            </div>
            <div class="lm-metabox">
                <label
                    for="team_profile_googleplus"><?php echo __('GooglePlus Page URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the Google Plus page of the team member.', 'lm-tools') ?></div>
                <input id="team_profile_googleplus" name="team_profile_googleplus" type="text"
                       value="<?php echo esc_url($team_profile_googleplus); ?>"/>
            </div>
            <div class="lm-metabox">
                <label for="team_profile_instagram"><?php echo __('Instagram Page URL:', 'lm-tools'); ?></label>

                <div
                    class="description"><?php echo __('URL of the Instagram feed for the team member.', 'lm-tools') ?></div>
                <input id="team_profile_instagram" name="team_profile_instagram" type="text"
                       value="<?php echo esc_url($team_profile_instagram); ?>"/>
            </div>
        </div>

    <?php
    }

    function save_team_profile($post_id) {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['lm_team_profile_info_nonce']) || !wp_verify_nonce($_POST['lm_team_profile_info_nonce'], basename(__FILE__)))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;

        $post = get_post($post_id);
        if ($post->post_type == 'team') {
            //Save the value to a custom field for the post
            if (isset($_POST['team_profile_position']))
                update_post_meta($post_id, '_lm_position', esc_html($_POST['team_profile_position']));

            if (isset($_POST['team_profile_email']))
                update_post_meta($post_id, '_lm_email', esc_html($_POST['team_profile_email']));

            if (isset($_POST['team_profile_twitter']))
                update_post_meta($post_id, '_lm_twitter', esc_url($_POST['team_profile_twitter']));

            if (isset($_POST['team_profile_linkedin']))
                update_post_meta($post_id, '_lm_linkedin', esc_url($_POST['team_profile_linkedin']));

            if (isset($_POST['team_profile_facebook']))
                update_post_meta($post_id, '_lm_facebook', esc_url($_POST['team_profile_facebook']));

            if (isset($_POST['team_profile_dribbble']))
                update_post_meta($post_id, '_lm_dribbble', esc_url($_POST['team_profile_dribbble']));

            if (isset($_POST['team_profile_googleplus']))
                update_post_meta($post_id, '_lm_googleplus', esc_url($_POST['team_profile_googleplus']));

            if (isset($_POST['team_profile_instagram']))
                update_post_meta($post_id, '_lm_instagram', esc_url($_POST['team_profile_instagram']));
        }
        return $post_id;
    }

}