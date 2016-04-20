<?php
/**
 * @var $id
 * @var $class
 * @var $style
 * @var $bg_type
 * @var $text
 * @var $background_color
 * @var $background_image
 * @var $parallax_background
 * @var $background_speed
 * @var $background_pattern
 * @var $youtube_bg_url
 * @var $youtube_bg_quality
 * @var $youtube_bg_opacity
 * @var $youtube_bg_aspect_ratio
 * @var $overlay_color
 * @var $overlay_opacity
 * @var $overlay_pattern
 */

$youtube_bg_opacity = $youtube_bg_opacity / 100;

$overlay_opacity = $overlay_opacity / 100;

$background_image = siteorigin_widgets_get_attachment_image_src( $background_image, 'full');

if (!empty ($background_image))
    $background_image = $background_image[0];

$background_pattern = siteorigin_widgets_get_attachment_image_src( $background_pattern, 'full');

if (!empty ($background_pattern))
    $background_pattern = $background_pattern[0];

$overlay_pattern = siteorigin_widgets_get_attachment_image_src( $overlay_pattern, 'full');

if (!empty ($overlay_pattern))
    $overlay_pattern = $overlay_pattern[0];

if ($bg_type === 'youtube' && !empty($youtube_bg_url))
    $shortcode = '[segment id="' . $id . '" class="' . $class . '" style="' . $style . '" background_color="' . $background_color . '" background_image="' . $background_image . '" parallax_background=false background_pattern="' . $background_pattern . '" youtube_bg_url="' . $youtube_bg_url . '" youtube_bg_quality="' . $youtube_bg_quality . '" youtube_bg_opacity="' . $youtube_bg_opacity . '" youtube_bg_aspect_ratio="' . $youtube_bg_aspect_ratio . '" overlay_color="' . $overlay_color . '" overlay_opacity="' . $overlay_opacity . '" overlay_pattern="' . $overlay_pattern . '" ]';
else
    $shortcode = '[segment id="' . $id . '" class="' . $class . '" style="' . $style . '" background_color="' . $background_color . '" background_image="' . $background_image . '" parallax_background="' . ($parallax_background ? 'true' : 'false') . '" background_speed="' . $background_speed . '" background_pattern="' . $background_pattern . '" overlay_color="' . $overlay_color . '" overlay_opacity="' . $overlay_opacity . '" overlay_pattern="' . $overlay_pattern . '" ]';


$shortcode .= $text;

$shortcode .= '[/segment]';

echo do_shortcode($shortcode);