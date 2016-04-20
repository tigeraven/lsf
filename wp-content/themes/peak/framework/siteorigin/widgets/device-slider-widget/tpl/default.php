<?php
/**
 * @var $style
 * @var $id
 * @var $animation
 * @var $device
 * @var $phone_color
 * @var $browser_url
 * @var $direction_nav
 * @var $control_nav
 * @var $slideshow_speed
 * @var $animation_speed
 * @var $pause_on_action
 * @var $pause_on_hover
 * @var $easing
 * @var $slides
 */

$image_urls = array();

foreach ($slides as $slide):

    $slider_image = siteorigin_widgets_get_attachment_image_src(
        $slide['slider_image'],
        'full',
        !empty($slide['slider_image_fallback']) ? $slide['slider_image_fallback'] : ''
    );
    if (!empty( $slider_image ))
        $image_urls[] = $slider_image[0];

endforeach;

$image_urls = implode(',', $image_urls);

echo do_shortcode('[device_slider id="' . $id . '" style="' . $style . '" animation="' . $animation . '" device="' . $device . '" phone_color="' . $phone_color . '" browser_url="' . $browser_url . '" direction_nav="' . ($direction_nav ? 'true' : 'false') . '" control_nav="' . ($control_nav ? 'true' : 'false') . '" slideshow_speed="' . $slideshow_speed . '" animation_speed="' . $animation_speed . '" pause_on_action="' . ($pause_on_action ? 'true' : 'false') . '" pause_on_hover="' . ($pause_on_hover ? 'true' : 'false') . '" easing="' . $easing . '" image_urls="' . $image_urls . '" ]');

