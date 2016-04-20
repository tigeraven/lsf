<?php

/**
 * Gets a number of posts and displays them as options
 * @param  array $query_args Optional. Overrides defaults.
 * @return array             An array of options that matches the CMB2 options array
 */


if (!function_exists('lm_get_post_options')) {
    function lm_get_post_options($query_args) {

        $args = wp_parse_args($query_args, array(
            'post_type' => 'post',
            'numberposts' => 10,
        ));

        $posts = get_posts($args);

        $post_options = array();

        $post_options[''] = '- None -'; // allow for none to be selected

        if ($posts) {
            foreach ($posts as $post) {
                $post_options[$post->ID] = $post->post_title;
            }
        }

        return $post_options;
    }
}