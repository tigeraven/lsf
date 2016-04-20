<?php
/**
 * @var $id
 * @var $pagination_speed
 * @var $slide_speed
 * @var $rewind_speed
 * @var $stop_on_hover
 * @var $auto_play
 * @var $scroll_per_page
 * @var $pagination
 * @var $navigation
 * @var $items
 * @var $items_mobile
 * @var $items_tablet
 * @var $items_tablet_small
 * @var $items_desktop_small
 * @var $items_desktop
 * @var $elements
 */


$shortcode = '[responsive_carousel id="' . $id . '" pagination_speed="' . $pagination_speed . '" slide_speed="' . $slide_speed . '" rewind_speed="' . $rewind_speed . '" stop_on_hover="' . ($stop_on_hover ? 'true' : 'false')  . '" auto_play="' . $auto_play . '" scroll_per_page="' . ($scroll_per_page ? 'true' : 'false') . '" pagination="' . ($pagination ? 'true' : 'false') . '" navigation="' . ($navigation ? 'true' : 'false') . '" items="' . $items . '" items_mobile="' . $items_mobile . '" items_tablet="' . $items_tablet . '" items_tablet_small="' . $items_tablet_small . '" items_desktop_small="' . $items_desktop_small . '" items_desktop="' . $items_desktop . '" ]';

foreach ($elements as $element):

    $shortcode .= '<div>';

    $shortcode .= $element['text'];

    $shortcode .= '</div>';

endforeach;

$shortcode .= '[/responsive_carousel]';

echo do_shortcode($shortcode);