<?php

/* Button Shortcode -

Usage:

[button id="purchase-button" style="padding: 10px 20px;" color="green" type="rounded" size="large" href="http://targeturl.com" align="left" target="_blank"]Green Button[/button]

Parameters -

id - The element id (optional).
style - Inline CSS styling (optional)
class - Custom CSS class name (optional)
color - Color of the button. Available colors are black, blue, cyan, green, orange, pink, red, teal, theme and trans.
align - Alignment of the button and text alignment of the button title displayed.
type - Can be rounded or left blank.
size - Can be large, small or left blank for normal sized button.
href - The URL to which button should point to. The user is taken to this destination when the button is clicked.
target - The HTML anchor target. Can be _self (default) or _blank which opens a new window to the URL specified when the button is clicked.

*/

if (!function_exists('mo_button_shortcode')) {

    function mo_button_shortcode($atts, $content = null) {
        extract(shortcode_atts(
            array(
                'style' => null,
                'color' => '',
                'custom_color' => '',
                'align' => false,
                'id' => false,
                'type' => '',
                'icon' => false,
                'class' => '',
                'href' => '',
                'target' => '_self',
                'size' => ''
            ),
            $atts));

        $color = ' ' . esc_attr($color);
        if (!empty($type))
            $type = ' ' . esc_attr($type);
        if (!empty($size))
            $size = ' ' . esc_attr($size);
        $button_text = trim($content);
        $id = $id ? ' id ="' . esc_attr($id) . '"' : '';

        $color_style = $custom_color ? ' background-color:' . esc_attr($custom_color) . '; border-color:' . esc_attr($custom_color) . ';"' : '';

        $style = $style ? ' style="' . esc_attr($style) . $color_style . '"' : '';

        if ($icon)
            $icon = '<i class="' . esc_attr($icon) . '"></i>';

        $button_content = '<a' . $id . ' class= "button ' . esc_attr($class) . $color . $type . $size . '"' . $style . ' href="' . esc_url($href) . '" target="' . esc_attr($target) . '">' . $icon . $button_text . '</a>';

        if (!empty($align))
            $button_content = '<div class="button-wrap" style="text-align:' . esc_attr($align) . ';float:' . esc_attr($align) . ';">' . $button_content . '</div>';

        return $button_content;
    }
}

add_shortcode('button', 'mo_button_shortcode');

?>