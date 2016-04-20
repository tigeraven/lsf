<?php

/* Page List Shortcode -

Displays a list of pages.

Usage:

[recent_posts post_count=5 hide_thumbnail="false" show_meta="false" excerpt_count=70 image_size="small"]

Parameters -

post_count - 5 (number) - Number of posts to display
hide_thumbnail false (boolean) - Display thumbnail or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 50 (number) The total number of characters of excerpt to display.
image_size - small (string) - Can be mini, small, medium, large, full, square.

*/
function mo_page_list_shortcode($atts) {

    $args = shortcode_atts(array(
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'thumbnail'
    ), $atts);
    extract($args);

    $args['query_args'] = array('posts_per_page' => intval($post_count), 'ignore_sticky_posts' => 1, 'post-type' => 'page');

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('page_list', 'mo_page_list_shortcode');


/* Recent Posts Shortcode -

Displays the most recent blog posts sorted by date of posting.

Usage:

[recent_posts post_count=5 hide_thumbnail="false" show_meta="false" excerpt_count=70 image_size="small"]

Parameters -

post_count - 5 (number) - Number of posts to display
hide_thumbnail false (boolean) - Display thumbnail or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 50 (number) The total number of characters of excerpt to display.
image_size - small (string) - Can be mini, small, medium, large, full, square.

*/
function mo_recent_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'thumbnail'
    ), $atts);
    extract($args);

    $args['query_args'] = array('posts_per_page' => intval($post_count), 'ignore_sticky_posts' => 1);

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('recent_posts', 'mo_recent_posts_shortcode');


/* Popular Posts Shortcode -

Displays the most popular blog posts. Popularity is based on by number of comments posted on the blog post. The higher the number of comments, the more popular the blog post.

Usage:

[popular_posts post_count=5 hide_thumbnail="false" show_meta="false" excerpt_count=70 image_size="small"]

Parameters -

post_count - 5 (number) - Number of posts to display
hide_thumbnail false (boolean) - Display thumbnail or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 50 (number) The total number of characters of excerpt to display.
image_size - small (string) - Can be mini, small, medium, large, full, square.

*/
function mo_popular_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'thumbnail'
    ), $atts);
    extract($args);

    $args['query_args'] = array('orderby' => 'comment_count', 'posts_per_page' => intval($post_count), 'ignore_sticky_posts' => 1);

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('popular_posts', 'mo_popular_posts_shortcode');

/* Category Posts Shortcode -

Displays the blog posts belonging to one or more categories.

Usage:

[category_posts category_slugs="nature,lifestyle" post_count=5 hide_thumbnail="false" show_meta="false" excerpt_count=70 image_size="small"]

Parameters -

category_slugs - (string) The comma separated list of category slugs whose posts need to be displayed.
post_count - 5 (number) - Number of posts to display
hide_thumbnail false (boolean) - Display thumbnail or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 50 (number) The total number of characters of excerpt to display.
image_size - small (string) - Can be mini, small, medium, large, full, square.

*/
function mo_category_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'category_slugs' => '',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'thumbnail'
    ), $atts);
    extract($args);

    $args['query_args'] = array('category_name' => esc_attr($category_slugs), 'posts_per_page' => intval($post_count), 'ignore_sticky_posts' => 1);

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('category_posts', 'mo_category_posts_shortcode');

/* Tag Posts Shortcode -

Displays the blog posts with one or more tags specified as a parameter to the shortcode.

Usage:

[tag_posts tag_slugs="growth,motivation" post_count=5 hide_thumbnail="false" show_meta="false" excerpt_count=70 image_size="small"]

Parameters -

tag_slugs - (string) The comma separated list of tag slugs whose posts need to be displayed.
post_count - 5 (number) - Number of posts to display
hide_thumbnail false (boolean) - Display thumbnail or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 50 (number) The total number of characters of excerpt to display.
image_size - small (string) - Can be mini, small, medium, large, full, square.

*/
function mo_tag_posts_shortcode($atts) {

    $args = shortcode_atts(array(
        'tag_slugs' => '',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'thumbnail'
    ), $atts);
    extract($args);

    $args['query_args'] = array('tag' => esc_attr($tag_slugs), 'posts_per_page' => intval($post_count), 'ignore_sticky_posts' => 1);

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('tag_posts', 'mo_tag_posts_shortcode');

/* Custom Post Types Shortcode -

Displays the posts of one or more custom post types.

Usage:

[show_custom_post_types post_types="portfolio,post" post_count=5 hide_thumbnail="false" show_meta="false" excerpt_count=70 image_size="small"]

Parameters -

post_types - post (string) The comma separated list of post types whose posts need to be displayed.
post_count - 5 (number) - Number of posts to display
hide_thumbnail false (boolean) - Display thumbnail or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 50 (number) The total number of characters of excerpt to display.
image_size - small (string) - Can be mini, small, medium, large, full, square.

*/
function mo_show_custom_post_types_shortcode($atts) {
    $args = shortcode_atts(array(
        'post_types' => 'post',
        'post_count' => '5',
        'hide_thumbnail' => false,
        'show_meta' => false,
        'excerpt_count' => '50',
        'image_size' => 'thumbnail',
        'post_ids' => ''
    ), $atts);
    extract($args);

    $custom_post_types = explode(",", esc_attr($post_types)); // return me an array of post types

    if (!empty($post_ids)) {
        $post_ids = explode(",", esc_attr($post_ids));
    }

    $args['query_args'] = array('post_type' => $custom_post_types, 'posts_per_page' => intval($post_count), 'ignore_sticky_posts' => 1, 'post__in' => $post_ids);

    $output = mo_get_thumbnail_post_list($args);

    return $output;
}

add_shortcode('show_custom_post_types', 'mo_show_custom_post_types_shortcode');


/* Post Snippets Shortcode - See http://portfoliotheme.org/peak/portfolio-shortcodes/ ‎for examples.

Displays the post snippets of blog posts or another custom post types with featured images. The post snippets are displayed in a grid fashion like a typical portfolio page or grid based blog page.

The number_of_columns parameter helps decide on the number of columns of posts/custom post types to display for each row displayed. Total number of posts displayed is derived from post_count parameter value.

This shortcode is quite powerful when used with custom post types and with filters based on custom taxonomy/terms specified as arguments.

Usage:

[show_post_snippets layout_class="rounded-images" post_type="portfolio" number_of_columns=3 post_count=6 image_size='medium' excerpt_count=100 display_title="true" display_summary="true" show_excerpt="true" hide_thumbnail="false"]

With taxonomy and terms specified, the portfolio items can be drawn from a specific portfolio category as shown below.

[show_post_snippets number_of_columns=3 post_count=6 image_size='large' terms="inspiration,technology" taxonomy="portfolio_category" post_type="portfolio"]

Parameters -

post_type -  (string) The custom post type whose posts need to be displayed. Examples include post, portfolio, team etc.
post_count - 4 (number) - Number of posts to display
image_size - medium (string) - Can be mini, small, medium, large, full, square.
title - (string) Display a header title for the post snippets.
layout_class - (string) The CSS class to be set for the list element (UL) displaying the post snippets. Useful if you need to do some custom styling of our own (rounded, hexagon images etc.) for the displayed items.
number_of_columns - 4 (number) - The number of columns to display per row of the post snippets
display_title - false (boolean) - Specify if the title of the post or custom post type needs to be displayed below the featured image
display_summary - false (boolean) - Specify if the excerpt or summary content of the post/custom post type needs to be displayed below the featured image thumbnail.
show_excerpt - true (boolean) - Display excerpt for the post/custom post type. Has no effect if display_summary is set to false. If show_excerpt is set to false and display_summary is set to true, the content of the post is displayed truncated by the WordPress <!--more--> tag. If more tag is not specified, the entire post content is displayed.
excerpt_count - 100 (number) - Applicable only to excerpts. The excerpt displayed is truncated to the number of characters specified with this parameter.
hide_thumbnail false (boolean) - Display thumbnail image or hide the same.
show_meta - false (boolean) Display meta information like the author, date of publishing and number of comments.
excerpt_count - 100 (number) The total number of characters of excerpt to display.
taxonomy - (string) Custom taxonomy to be used for filtering the posts/custom post types displayed.
terms - (string) The terms of taxonomy specified.
no_margin - false (boolean) - If set to true, no margins are maintained between the columns. Helps to achieve the popular packed layout.
*/

function mo_show_post_snippets_shortcode($atts) {
    $args = shortcode_atts(array(
        'post_type' => null,
        'post_count' => 4,
        'image_size' => 'medium',
        'title' => null,
        'layout_class' => '',
        'excerpt_count' => 100,
        'number_of_columns' => 4,
        'show_meta' => false,
        'display_title' => false,
        'display_summary' => false,
        'show_excerpt' => true,
        'hide_thumbnail' => false,
        'row_line_break' => true,
        'terms' => '',
        'taxonomy' => 'category',
        'no_margin' => false,
        'layout_mode' => 'fitRows'
    ), $atts);

    $output = mo_get_post_snippets($args);

    return $output;

}

add_shortcode('show_post_snippets', 'mo_show_post_snippets_shortcode');

/* Show Portfolio shortcode -

Helps to display a portfolio page style display of portfolio items with JS powered portfolio category filter. Packed layout option is also available.

Usage:

[show_portfolio number_of_columns=4 post_count=12 image_size='small' filterable=true no_margin=true]

Parameters -

post_count - 9 (number) - Total number of portfolio items to display
number_of_columns - 3 (number) - The number of columns to display per row of the portfolio items
image_size - medium (string) - Can be mini, small, medium, large, full, square.
filterable - true (boolean) The portfolio items will be filterable based on portfolio categories if set to true.
no_margin - false (boolean) If set to true, no margins are maintained between the columns. Helps to achieve the popular packed layout.
*/
function mo_show_portfolio($atts) {

    /* Do not continue if the Livemesh Tools plugin is not loaded */
    if (!class_exists('LM_Framework')) {
        return mo_display_plugin_error();
    }

    $args = shortcode_atts(array(
        'number_of_columns' => 3,
        'image_size' => 'medium',
        'post_count' => 9,
        'filterable' => true,
        'no_margin' => false,
        'portfolio_link' => false,
        'link_text' => 'Our Work',
        'layout_mode' => 'fitRows'
    ), $atts);

    $output = '<div id="showcase-full-width">';

    $args['posts_per_page'] = intval($args['post_count']);

    $output .= mo_get_filterable_portfolio_content($args);

    $output .= '</div>';

    return $output;
}

add_shortcode('show_portfolio', 'mo_show_portfolio');

/* Show Gallery shortcode -

Helps to display a gallery page style display of gallery items with JS powered gallery category filter. Packed layout option is also available.

Usage:

[show_gallery number_of_columns=4 post_count=12 image_size='small' filterable=true no_margin=false]

Parameters -

post_count - 9 (number) - Number of gallery items to display
number_of_columns - 4 (number) - The number of columns to display per row of the gallery items
image_size - medium (string) - Can be mini, small, medium, large, full, square.
filterable - true (boolean) The gallery items will be filterable based on gallery categories if set to true.
no_margin - false (boolean) If set to true, no margins are maintained between the columns. Helps to achieve the popular packed layout.
*/
function mo_show_gallery($atts) {

    /* Do not continue if the Livemesh Tools plugin is not loaded */
    if (!class_exists('LM_Framework')) {
        return mo_display_plugin_error();
    }

    $args = shortcode_atts(array(
        'number_of_columns' => 3,
        'image_size' => 'medium',
        'post_count' => 9,
        'filterable' => true,
        'no_margin' => false,
        'layout_mode' => 'fitRows'
    ), $atts);

    $output = '<div id="showcase-full-width">';

    $args['posts_per_page'] = intval($args['post_count']);

    $output .= mo_get_filterable_gallery_content($args);

    $output .= '</div>';

    return $output;
}

add_shortcode('show_gallery', 'mo_show_gallery');

/* Show campaigns shortcode -

Helps to display a campaigns page composed of campaign items with JS powered campaign category filter.

Usage:

[show_campaigns number_of_columns=4 post_count=12 image_size='small' filterable=true]

Parameters -

post_count - 9 (number) - Total number of campaign items to display
number_of_columns - 3 (number) - The number of columns to display per row of the campaign items
image_size - medium (string) - Can be mini, small, medium, large, full, square.
filterable - true (boolean) The campaign items will be filterable based on campaign categories if set to true.
*/
function mo_show_campaigns($atts) {

    /* Do not continue if the Livemesh Tools plugin is not loaded */
    if (!class_exists('LM_Framework')) {
        return mo_display_plugin_error();
    }

    $args = shortcode_atts(array(
        'number_of_columns' => 3,
        'image_size' => 'large',
        'post_count' => 9,
        'filterable' => true,
        'no_margin' => false,
        'layout_mode' => 'fitRows'
    ), $atts);

    $output = '<div id="showcase-full-width">';

    $args['posts_per_page'] = intval($args['post_count']);

    $output .= mo_get_filterable_campaign_content($args);

    $output .= '</div>';

    return $output;
}

add_shortcode('show_campaigns', 'mo_show_campaigns');


function mo_post_listing_shortcode($atts) {
    $args = shortcode_atts(array(
        'post_count' => 4,
        'terms' => '',
        'taxonomy' => 'category'
    ), $atts);

    $output = mo_get_post_listing($args);

    return $output;

}

add_shortcode('post_listing', 'mo_post_listing_shortcode');



