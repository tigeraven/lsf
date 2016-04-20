<?php
/**
 * Plugin Name: Livemesh Framework Author Bio Widget
 * Plugin URI: http://portfoliotheme.org/
 * Description: A widget that displays author biographical information.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


class MO_Author_Widget extends MO_Widget {

    /**
     * Widget setup.
     */
    function MO_Author_Widget() {

        parent::init();

        /* Widget settings. */
        $widget_ops = array('classname' => 'author-widget', 'description' => esc_html__('A widget that displays the post author information.', 'peak'));

        /* Widget control settings. */
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'mo-author-widget');

        /* Create the widget. */
        $this->WP_Widget('mo-author-widget', esc_html__('Author Widget', 'peak'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args); // Display arguments including before_title, after_title, before_widget, and after_widget

        /* Author information does not make sense on archive and home page */
        if (!is_singular())
            return;

        global $post;

        /* Our variables from the widget settings. */
        $title = esc_html(apply_filters('widget_title', $instance['title']));

        $avatar_size = intval($instance['avatar_size']);

        $sidebar_name = $args['name'];

        // Can happen on an 404 page
        if (!isset($post))
            return;

        /* Before widget (defined by themes). */
        echo wp_kses_post($before_widget);

        /* Display the widget title if one was input (before and after defined by themes). */
        /* Do not populate title for "after singular" sidebar in single posts */
        if (!empty($title)) {
            if ($sidebar_name != 'After Singular') {
                echo wp_kses_post($before_title . $title . $after_title);
            }
        }

        $author = $post->post_author;

        $author_email = sanitize_email(get_the_author_meta('user_email', $author));
        $author_name = esc_html(get_the_author_meta('display_name', $author));
        $author_desc = esc_html(get_the_author_meta('description', $author));

        $author_posts_url = get_author_posts_url($author);

        $avatar = get_avatar($author, $avatar_size);

        $twitter_url = esc_url(get_the_author_meta('twitter', $author));
        $facebook_url = esc_url(get_the_author_meta('facebook', $author));
        $linkedin_url = esc_url(get_the_author_meta('linkedin', $author));
        $googleplus_url = esc_url(get_the_author_meta('googleplus', $author));
        $flickr_url = esc_url(get_the_author_meta('flickr', $author));


        ?>
        <div id="author-widget" class="clearfix">

            <div class="avatar-wrap">
                <a href="<?php echo esc_url($author_posts_url); ?>"
                   title="Read all posts of <?php echo esc_attr($author_name); ?>"><?php echo wp_kses_post($avatar); ?></a>
            </div>

            <div class='author'>
                <a href="<?php echo esc_url($author_posts_url); ?>" title="Read all posts of <?php echo esc_attr($author_name); ?>"><h4 class='author-name'><?php echo esc_html($author_name); ?></h4></a>
                <div class='author-desc'><?php echo wp_kses_post($author_desc); ?></div>
                <ul class='social-list clearfix'>
                    <?php
                    if ($twitter_url)
                        echo "<li><a class=\"twitter\" href=\"$twitter_url\" title=\"Follow $author_name on Twitter\"><i class=\"icon-twitter5\"></i></a></li>";
                    if ($facebook_url)
                        echo "<li><a class=\"facebook\" href=\"$facebook_url\" title=\"Follow $author_name on Facebook\"><i class=\"icon-facebook5\"></i></a></li>";
                    if ($linkedin_url)
                        echo "<li><a class=\"linkedin\" href=\"$linkedin_url\" title=\"Follow $author_name on Linkedin\"><i class=\"icon-linkedin4\"></i></a></li>";
                    if ($googleplus_url)
                        echo "<li><a class=\"googleplus\" href=\"$googleplus_url\" title=\"Follow $author_name on Google Plus\"><i class=\"icon-googleplus2\"></i></a></li>";
                    if ($flickr_url)
                        echo "<li><a class=\"flickr\" href=\"$flickr_url\" title=\"Follow $author_name on Flickr\"><i class=\"icon-flickr5\"></i></a></li>";
                    ?>
                </ul>
            </div>
        </div>

        <?php

        /* After widget (defined by themes). */
        echo wp_kses_post($after_widget);
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags for title to remove HTML (important for text inputs). */
        $instance['title'] = sanitize_text_field($new_instance['title']);

        $instance['avatar_size'] = sanitize_text_field($new_instance['avatar_size']);

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array(
            'title' => '',
            'avatar_size' => '96',
        );
        $instance = wp_parse_args((array)$instance, $defaults); ?>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Widget Title:(optional)', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>"/>
        </p>

        <p>
            <label
                for="<?php echo esc_attr($this->get_field_id('avatar_size')); ?>"><?php esc_html_e('Avatar Size:', 'peak'); ?></label>
            <select class="smallfat" id="<?php echo esc_attr($this->get_field_id('avatar_size')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('avatar_size')); ?>">
                <option <?php selected($instance['avatar_size'], 64); ?>>64</option>
                <option <?php selected($instance['avatar_size'], 80); ?>>80</option>
                <option <?php selected($instance['avatar_size'], 100); ?>>100</option>
                <option <?php selected($instance['avatar_size'], 128); ?>>128</option>
            </select>
        </p>

    <?php
    }
}

?>