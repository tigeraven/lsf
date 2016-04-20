<?php
/**
 * @var $posts_query
 * @var $image_size
 * @var $number_of_columns
 * @var $no_margin
 * @var $hide_thumbnail
 * @var $display_title
 * @var $display_summary
 * @var $show_excerpt
 * @var $excerpt_count
 * @var $show_meta
 */

$defaults = array(
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
    'no_margin' => false,
    'layout_mode' => 'fitRows'
);

$data_input = array(
    'image_size' => $image_size,
    'excerpt_count' => $excerpt_count,
    'number_of_columns' => $number_of_columns,
    'show_meta' => ($show_meta ? 'true' : 'false'),
    'display_title' => ($display_title ? 'true' : 'false'),
    'display_summary' => ($display_summary ? 'true' : 'false'),
    'show_excerpt' => ($show_excerpt ? 'true' : 'false'),
    'hide_thumbnail' => ($hide_thumbnail ? 'true' : 'false'),
    'no_margin' => ($no_margin ? 'true' : 'false')

);
$data_input['query_args'] = siteorigin_widget_post_selector_process_query($posts_query);

$snippets_args = array_merge($defaults, $data_input);

echo mo_get_post_snippets($snippets_args);