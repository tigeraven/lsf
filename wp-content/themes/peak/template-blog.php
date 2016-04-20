<?php

/**
 * Template Name: Blog
 *
 * This is the blog template. 
 *
 * @package Peak
 * @subpackage Template
 */
get_header();

if(is_front_page()) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}

$query_args = array('posts_per_page' => intval(get_option('posts_per_page')), 'ignore_sticky_posts' => 0, 'paged' => $paged);

mo_display_archive_content($query_args);

get_sidebar();

get_footer();  
?>