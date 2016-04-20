<?php
/**
 * Plugin Name: Livemesh Framework Social Media Widget
 * Plugin URI: http://portfoliotheme.org/
 * Description: A widget that displays the social networks information
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

class MO_Social_Networks_Widget extends MO_Widget {

    /**
     * Widget setup.
     */
    function MO_Social_Networks_Widget() {

        parent::init();

        /* Widget settings. */
        $widget_ops = array('classname' => 'social-networks-widget', 'description' => esc_html__('A widget that displays the social network information for the website.', 'peak'));

        /* Widget control settings. */
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'mo-social-networks-widget');

        /* Create the widget. */
        $this->WP_Widget('mo-social-networks-widget', esc_html__('Social Networks Widget', 'peak'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        $facebook = esc_url($instance['facebook']);
        $twitter = esc_url($instance['twitter']);
        $linkedin = esc_url($instance['linkedin']);
        $youtube = esc_url($instance['youtube']);
        $flickr = esc_url($instance['flickr']);
        $googleplus = esc_url($instance['googleplus']);
        $instagram = esc_url($instance['instagram']);
        $pinterest = esc_url($instance['pinterest']);
        $dribbble = esc_url($instance['dribbble']);
        $vimeo = esc_url($instance['vimeo']);
        $rss = $instance['rss'];

        $title = esc_html(apply_filters('widget_title', $instance['title']));

        echo wp_kses_post($before_widget);

        if (trim($title) != '')
            echo wp_kses_post($before_title . $title . $after_title);

        $shortcode_text = '[social_list ';

        if (!empty($facebook))
            $shortcode_text .= 'facebook_url="' . esc_url($facebook) . '" ';
        if (!empty($twitter))
            $shortcode_text .= 'twitter_url="' . esc_url($twitter) . '" ';
        if (!empty($flickr))
            $shortcode_text .= 'flickr_url="' . esc_url($flickr) . '" ';
        if (!empty($youtube))
            $shortcode_text .= 'youtube_url="' . esc_url($youtube) . '" ';
        if (!empty($linkedin))
            $shortcode_text .= 'linkedin_url="' . esc_url($linkedin) . '" ';
        if (!empty($googleplus))
            $shortcode_text .= 'googleplus_url="' . esc_url($googleplus) . '" ';
        if (!empty($instagram))
            $shortcode_text .= 'instagram_url="' . esc_url($instagram) . '" ';
        if (!empty($pinterest))
            $shortcode_text .= 'pinterest_url="' . esc_url($pinterest) . '" ';
        if (!empty($dribbble))
            $shortcode_text .= 'dribbble_url="' . esc_url($dribbble) . '" ';
        if (!empty($vimeo))
            $shortcode_text .= 'vimeo_url="' . esc_url($vimeo) . '" ';

        if (!empty($rss))
            $shortcode_text .= 'include_rss=true';

        $shortcode_text .= ']';
        
        echo do_shortcode($shortcode_text);

        echo wp_kses_post($after_widget);
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = sanitize_text_field($new_instance['title']);

        $instance['facebook'] = esc_url_raw($new_instance['facebook']);
        $instance['twitter'] = esc_url_raw($new_instance['twitter']);
        $instance['linkedin'] = esc_url_raw($new_instance['linkedin']);
        $instance['flickr'] = esc_url_raw($new_instance['flickr']);
        $instance['youtube'] = esc_url_raw($new_instance['youtube']);
        $instance['googleplus'] = esc_url_raw($new_instance['googleplus']);
        $instance['instagram'] = esc_url_raw($new_instance['instagram']);
        $instance['pinterest'] = esc_url_raw($new_instance['pinterest']);
        $instance['dribbble'] = esc_url_raw($new_instance['dribbble']);
        $instance['vimeo'] = esc_url_raw($new_instance['vimeo']);

        $instance['rss'] = esc_url_raw($new_instance['rss']);

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        $defaults = array('title' => esc_html__('Find us online', 'peak'), 'facebook' => '', 'twitter' => '', 'linkedin' => '', 'flickr' => '', 'youtube' => '', 'googleplus' => '', 'instagram' => '', 'pinterest' => '', 'vimeo' => '', 'dribbble' => '', 'rss' => '');
        $instance = wp_parse_args((array) $instance, $defaults);
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>


        <p>
            <label for="<?php echo esc_attr($this->get_field_id('facebook')); ?>"><?php esc_html_e('Facebook URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('facebook')); ?>" name="<?php echo esc_attr($this->get_field_name('facebook')); ?>" value="<?php echo esc_url($instance['facebook']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('twitter')); ?>"><?php esc_html_e('Twitter URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('twitter')); ?>" name="<?php echo esc_attr($this->get_field_name('twitter')); ?>" value="<?php echo esc_url($instance['twitter']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('linkedin')); ?>"><?php esc_html_e('LinkedIn URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('linkedin')); ?>" name="<?php echo esc_attr($this->get_field_name('linkedin')); ?>" value="<?php echo esc_url($instance['linkedin']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('youtube')); ?>"><?php esc_html_e('YouTube URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('youtube')); ?>" name="<?php echo esc_attr($this->get_field_name('youtube')); ?>" value="<?php echo esc_url($instance['youtube']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('flickr')); ?>"><?php esc_html_e('Flickr URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('flickr')); ?>" name="<?php echo esc_attr($this->get_field_name('flickr')); ?>" value="<?php echo esc_url($instance['flickr']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('googleplus')); ?>"><?php esc_html_e('Google+ URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('googleplus')); ?>" name="<?php echo esc_attr($this->get_field_name('googleplus')); ?>" value="<?php echo esc_url($instance['googleplus']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram')); ?>"><?php esc_html_e('Instagram URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram')); ?>" value="<?php echo esc_url($instance['instagram']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('pinterest')); ?>"><?php esc_html_e('Pinterest URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('pinterest')); ?>" name="<?php echo esc_attr($this->get_field_name('pinterest')); ?>" value="<?php echo esc_url($instance['pinterest']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('dribbble')); ?>"><?php esc_html_e('Dribbble URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('dribbble')); ?>" name="<?php echo esc_attr($this->get_field_name('dribbble')); ?>" value="<?php echo esc_url($instance['dribbble']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('vimeo')); ?>"><?php esc_html_e('Vimeo URL:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('vimeo')); ?>" name="<?php echo esc_attr($this->get_field_name('vimeo')); ?>" value="<?php echo esc_url($instance['vimeo']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('rss')); ?>"><?php wp_kses_post(_e('RSS Feed URL <small>(leave blank to use default RSS feed URL)</small>:', 'peak')); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('rss')); ?>" name="<?php echo esc_attr($this->get_field_name('rss')); ?>" value="<?php echo esc_url($instance['rss']); ?>" />
        </p>

        <?php
    }

}
?>