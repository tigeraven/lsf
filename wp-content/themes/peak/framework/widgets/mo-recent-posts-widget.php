<?php
/**
 * Plugin Name: Livemesh Framework Recent Posts
 * Plugin URI: http://portfoliotheme.org/
 * Description: A widget that displays the recent posts with thumbnails and excerpts for the user.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


class MO_Recent_Posts_Widget extends MO_Widget {

    /**
     * Widget setup.
     */
    function MO_Recent_Posts_Widget() {

        parent::init();

        /* Widget settings. */
        $widget_ops = array('classname' => 'recent-posts-widget', 'description' => esc_html__('A widget that displays the recent posts with thumbnails.', 'peak'));

        /* Widget control settings. */
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'mo-recent-posts-widget');

        /* Create the widget. */
        $this->WP_Widget('mo-recent-posts-widget', esc_html__('Recent Posts Widget', 'peak'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = esc_html(apply_filters('widget_title', $instance['title']));
        $post_count = intval($instance['post_count']);

        $loop = new WP_Query(array('posts_per_page' => $post_count, 'ignore_sticky_posts' => 1, 'orderby' => 'date', 'order' => 'DESC'));

        if ($loop->have_posts()) {

            /* Before widget (defined by themes). */
            echo wp_kses_post($before_widget);

            /* Display the widget title if one was input (before and after defined by themes). */
            if (trim($title) != '')
                echo wp_kses_post($before_title . $title . $after_title);

            $args = array(
                'show_meta' => ($instance['show_meta'] ? true : false),
                'hide_thumbnail' => ($instance['hide_thumbnail'] ? true : false),
                'excerpt_count' => intval($instance['excerpt_count']),
                'loop' => $loop
            );

            echo mo_get_thumbnail_post_list($args);

            /* After widget (defined by themes). */
            echo wp_kses_post($after_widget);
        } //endif
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags for title and name to remove HTML (important for text inputs). */
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['post_count'] = sanitize_text_field($new_instance['post_count']);
        $instance['excerpt_count'] = sanitize_text_field($new_instance['excerpt_count']);

        // no stripping tags for checkbox content
        $instance['hide_thumbnail'] = !empty($new_instance['hide_thumbnail']) ? 1 : 0;
        $instance['show_meta'] = !empty($new_instance['show_meta']) ? 1 : 0;

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array('title' => esc_html__('Recent Posts', 'peak'), 'post_count' => '5', 'excerpt_count' => '100', 'hide_thumbnail' => false, 'show_meta' => false);
        $instance = wp_parse_args((array) $instance, $defaults);

        $show_meta = isset($instance['show_meta']) ? (bool) $instance['show_meta'] : false;

        $hide_thumbnail = isset($instance['hide_thumbnail']) ? (bool) $instance['hide_thumbnail'] : false;
        ?>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget Title:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('post_count')); ?>"><?php esc_html_e('Post Count:', 'peak'); ?></label>
            <input type="text" class="smallfat" id="<?php echo esc_attr($this->get_field_id('post_count')); ?>" name="<?php echo esc_attr($this->get_field_name('post_count')); ?>" value="<?php echo esc_attr($instance['post_count']); ?>" />
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id('hide_thumbnail')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_thumbnail')); ?>" <?php checked($hide_thumbnail); ?>/>
            <label for="<?php echo esc_attr($this->get_field_id('hide_thumbnail')); ?>"><?php esc_html_e('Hide Thumbnail?', 'peak'); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('excerpt_count')); ?>"><?php esc_html_e('Length of Summary:', 'peak'); ?></label>
            <input type="text" class="smallfat" id="<?php echo esc_attr($this->get_field_id('excerpt_count')); ?>" name="<?php echo esc_attr($this->get_field_name('excerpt_count')); ?>" value="<?php echo esc_attr($instance['excerpt_count']); ?>" />
            <small>(0 for no excerpt)</small>
        </p>

        <p>
            <input class="checkbox" type="checkbox" id="<?php echo esc_attr($this->get_field_id('show_meta')); ?>" name="<?php echo esc_attr($this->get_field_name('show_meta')); ?>" <?php checked($show_meta); ?>/>
            <label for="<?php echo esc_attr($this->get_field_id('show_meta')); ?>"><?php esc_html_e('Show Post Meta?', 'peak'); ?></label>
        </p>

        <?php
    }

}
?>