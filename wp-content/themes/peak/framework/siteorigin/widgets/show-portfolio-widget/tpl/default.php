<?php
/**
 * @var $number_of_columns
 * @var $post_count
 * @var $image_size
 * @var $filterable
 * @var $no_margin
 * @var $portfolio_link
 * @var $link_text
 * @var $layout_mode
 */


echo do_shortcode('[show_portfolio number_of_columns="' . $number_of_columns . '" post_count="' . $post_count . '" image_size="' . $image_size . '" filterable="' . ($filterable ? 'true' : 'false') . '" no_margin="' . ($no_margin ? 'true' : 'false') . '" portfolio_link="' . $portfolio_link . '" link_text="' . $link_text . '" layout_mode="' . $layout_mode . '" ]');

