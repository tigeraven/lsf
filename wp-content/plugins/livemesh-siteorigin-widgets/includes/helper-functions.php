<?php

// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;

if (!function_exists('lsow_get_terms')) {

    function lsow_get_terms($taxonomy) {

        global $wpdb;

        $term_coll = array();

        if (taxonomy_exists($taxonomy)) {
            $terms = get_terms($taxonomy); // Get all terms of a taxonomy

            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_coll[$term->term_id] = $term->name;
                }
            }
        }
        else {

            $qt = 'SELECT * FROM ' . $wpdb->terms . ' AS t INNER JOIN ' . $wpdb->term_taxonomy . ' AS tt ON t.term_id = tt.term_id WHERE tt.taxonomy =  "' . $taxonomy . '" AND tt.count > 0 ORDER BY  t.term_id DESC LIMIT 0 , 30';

            $terms = $wpdb->get_results($qt, ARRAY_A);

            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $term_coll[$term['term_id']] = $term['name'];
                }
            }
        }

        return $term_coll;
    }
}

if (!function_exists('lsow_get_chosen_terms')) {

    function lsow_get_chosen_terms($query_args) {

        $chosen_terms = array();
        $taxonomy_filter = '';

        $query_args = wp_parse_args($query_args);

        if (!empty($query_args) && !empty($query_args['tax_query'])) {
            $terms_query = explode(',', $query_args['tax_query']);
            foreach ($terms_query as $term_query) {
                list($taxonomy, $term_slug) = explode(':', $term_query);

                if (empty($taxonomy) || empty($term_slug))
                    continue;
                $chosen_terms[] = get_term_by('slug', $term_slug, $taxonomy);
                $taxonomy_filter = $taxonomy;
            }
        }
        return array($chosen_terms, $taxonomy_filter);
    }
}


if (!function_exists('lsow_entry_terms_list')) {

    function lsow_entry_terms_list($taxonomy = 'category', $separator = ', ', $before = ' ', $after = ' ') {
        global $post;

        $output = '<span class="lsow-' . $taxonomy . '-list">';
        $output .= get_the_term_list($post->ID, $taxonomy, $before, $separator, $after);
        $output .= '</span>';

        return $output;
    }
}

if (!function_exists('lsow_get_posts')) {

    function lsow_get_posts() {

        $list = array();

        $args = $args = array(
            'posts_per_page' => -1,
            'offset' => 0,
            'category' => '',
            'category_name' => '',
            'orderby' => 'date',
            'order' => 'DESC',
            'include' => '',
            'exclude' => '',
            'meta_key' => '',
            'meta_value' => '',
            'post_type' => 'post',
            'post_mime_type' => '',
            'post_parent' => '',
            'author' => '',
            'post_status' => 'publish',
            'suppress_filters' => true
        );

        $posts = get_posts($args);

        if (!empty ($posts)) {
            foreach ($posts as $post) {
                $list[$post->ID] = $post->post_title;
            }
        }

        return $list;
    }
}

if (!function_exists('lsow_get_taxonomy_info')) {

    function lsow_get_taxonomy_info($taxonomy) {
        $output = '';
        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if (!empty($terms) && !is_wp_error($terms)) {
            $output .= '<span class="lsow-terms">';
            $term_count = 0;
            foreach ($terms as $term) {
                if ($term_count != 0)
                    $output .= ', ';
                $output .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';
                $term_count = $term_count + 1;
            }
            $output .= '</span>';
        }
        return $output;
    }
}

if (!function_exists('lsow_entry_published')) {

    function lsow_entry_published($format = "M d, Y") {

        $published = '<span class="published"><abbr title="' . sprintf(get_the_time(esc_html__('l, F, Y, g:i a', 'livemesh-so-widgets'))) . '">' . sprintf(get_the_time($format)) . '</abbr></span>';

        return $published;

        $link = '<span class="published">' . '<a href="' . get_day_link(get_the_time(esc_html__('Y', 'livemesh-so-widgets')), get_the_time(esc_html__('m', 'livemesh-so-widgets')), get_the_time(esc_html__('d', 'livemesh-so-widgets'))) . '" title="' . sprintf(get_the_time(esc_html__('l, F, Y, g:i a', 'livemesh-so-widgets'))) . '">' . '<span class="updated">' . get_the_time($format) . '</span>' . '</a></span>';

        return $link;
    }
}

if (!function_exists('lsow_entry_author')) {

    function lsow_entry_author() {
        $author = '<span class="author vcard">' . esc_html__('By ', 'livemesh-so-widgets'). '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author_meta('display_name')) . '">' . esc_html(get_the_author_meta('display_name')) . '</a></span>';
        return $author;
    }
}

/** Isotope filtering support for Portfolio pages * */

if (!function_exists('lsow_get_taxonomy_terms_filter')) {

    function lsow_get_taxonomy_terms_filter($taxonomy, $chosen_terms = array()) {

        $output = '';

        if (empty($chosen_terms))
            $terms = get_terms($taxonomy);
        else
            $terms = $chosen_terms;

        if (!empty($terms) && !is_wp_error($terms)) {

            $output .= '<div class="lsow-taxonomy-filter">';

            $output .= '<div class="lsow-filter-item segment-0 lsow-active"><a data-value="*" href="#">' . esc_html__('All', 'livemesh-so-widgets') . '</a></div>';

            $segment_count = 1;
            foreach ($terms as $term) {

                $output .= '<div class="lsow-filter-item segment-' . intval($segment_count) . '"><a href="#" data-value=".term-' . intval($term->term_id) . '" title="' . esc_html__('View all items filed under ', 'livemesh-so-widgets') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a></div>';

                $segment_count++;
            }

            $output .= '</div>';

        }

        return $output;
    }
}

/* Return the css class name to help achieve the number of columns specified */

if (!function_exists('lsow_get_column_class')) {

    function lsow_get_column_class($column_size = 3, $no_margin = false) {

        $style_class = 'lsow-threecol';

        $no_margin = lsow_to_boolean($no_margin); // make sure it is not string

        $column_styles = array(
            1 => 'lsow-twelvecol',
            2 => 'lsow-sixcol',
            3 => 'lsow-fourcol',
            4 => 'lsow-threecol',
            5 => 'lsow-onefifthcol',
            6 => 'lsow-twocol',
            12 => 'lsow-onecol'
        );

        if (array_key_exists($column_size, $column_styles) && !empty($column_styles[$column_size])) {
            $style_class = $column_styles[$column_size];
        }

        $style_class = $no_margin ? ($style_class . ' lsow-zero-margin') : $style_class;

        return $style_class;
    }
}

/*
* Converting string to boolean is a big one in PHP
*/
if (!function_exists('lsow_to_boolean')) {

    function lsow_to_boolean($value) {
        if (!isset($value))
            return false;
        if ($value == 'true' || $value == '1')
            $value = true;
        elseif ($value == 'false' || $value == '0')
            $value = false;
        return (bool)$value; // Make sure you do not touch the value if the value is not a string
    }
}

// get all registered taxonomies
if (!function_exists('lsow_get_taxonomies_map')) {
    function lsow_get_taxonomies_map() {
        $map = array();
        $taxonomies = get_taxonomies();
        foreach ($taxonomies as $taxonomy) {
            $map [$taxonomy] = $taxonomy;
        }
        return $map;
    }
}