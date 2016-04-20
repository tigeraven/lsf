<?php
/**
 * @var $id
 * @var $style
 * @var $class
 * @var $color
 * @var $custom_color
 * @var $size
 * @var $href
 * @var $align
 * @var $target
 * @var $text
 */


echo do_shortcode('[button id="' . $id . '" style="' . $style . '" class="' . $class . '" color="' . $color . '" custom_color="' . $custom_color . '" size="' . $size . '" href="' . $href . '" align="' . $align . '" target="' . ($target? '_blank': 'self') . '" ]'. $text . '[/button]');

