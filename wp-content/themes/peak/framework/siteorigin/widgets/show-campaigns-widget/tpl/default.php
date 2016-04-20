<?php
/**
 * @var $number_of_columns
 * @var $post_count
 * @var $image_size
 * @var $filterable
 * @var $layout_mode
 */


echo do_shortcode('[show_campaigns number_of_columns="' . $number_of_columns . '" post_count="' . $post_count . '" image_size="' . $image_size . '" filterable="' . ($filterable ? 'true' : 'false') . '" layout_mode="' . $layout_mode . '" ]');

