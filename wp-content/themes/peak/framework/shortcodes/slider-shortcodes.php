<?php
/* Responsive Slider Shortcode -

Use this shortcode to create a slider out of any HTML content. All it requires a UL element with children to show.

Usage:

[responsive_slider type="testimonials2" animation="slide" control_nav="true" direction_nav=false pause_on_hover="true" slideshow_speed=4500]

<ul>
	<li>Slide 1 content goes here.</li>
	<li>Slide 2 content goes here.</li>
	<li>Slide 3 content goes here.</li>
</ul>

[/responsive_slider]


Parameters -

type (string) - Constructs and sets a unique CSS class for the slider. (optional).
slideshow_speed - 5000 (number). Set the speed of the slideshow cycling, in milliseconds
animation_speed - 600 (number). Set the speed of animations, in milliseconds.
animation - fade (string). Select your animation type, "fade" or "slide".
pause_on_action - true (boolean). Pause the slideshow when interacting with control elements, highly recommended.
pause_on_hover - true (boolean). Pause the slideshow when hovering over slider, then resume when no longer hovering.
direction_nav - true (boolean). Create navigation for previous/next navigation? (true/false)
control_nav - true (boolean). Create navigation for paging control of each slide? Note: Leave true for manual_controls usage.
easing - swing (string). Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
loop - true (boolean). Should the animation loop?
slideshow - true (boolean). Animate slider automatically without user intervention.
controls_container - (string). Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.
manualControls - (string). Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.
style - (string) - The inline CSS applied to the slider container DIV element.
*/

$tab_count = 0;
$tabs = array();

function mo_responsive_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'type' => 'flex',
            'slideshow_speed' => 5000,
            'animation_speed' => 600,
            'animation' => 'fade',
            'pause_on_action' => 'false',
            'pause_on_hover' => 'true',
            'direction_nav' => 'true',
            'direction' => 'horizontal',
            'control_nav' => 'true',
            'easing' => 'swing',
            'loop' => 'true',
            'slideshow' => 'true',
            'sync' => false,
            'controls_container' => false,
            'manual_controls' => false,
            'style' => '',
            'id' => false
        ),
        $atts));

    $output = '';

    $slider_container = esc_attr($type) . '-slider-container';

    if (!empty($id)) {
        $slider_selector = '#' . esc_attr($id) . '.' . $slider_container;
    }
    else {
        $slider_selector = '.' . $slider_container;
    }

    if (empty($controls_container)) {
        $controls_container = $slider_selector;
    }
    $namespace = 'flex';

    $output .= '<script type="text/javascript">' . "\n";

    if (!empty($sync))
        $output .= 'jQuery(window).load(function () {';
    else
        $output .= 'jQuery(document).ready(function($) {';

    $output .= 'jQuery(\'' . $slider_selector . ' .flexslider\').flexslider({';
    $output .= 'animation: "' . esc_attr($animation) . '",';
    $output .= 'slideshowSpeed: ' . intval($slideshow_speed) . ',';
    $output .= 'animationSpeed: ' . intval($animation_speed) . ',';
    $output .= 'namespace: "' . esc_attr($namespace) . '-",';
    $output .= 'pauseOnAction:' . esc_attr($pause_on_action) . ',';
    $output .= 'pauseOnHover: ' . esc_attr($pause_on_hover) . ',';
    $output .= 'controlNav: ' . esc_attr($control_nav) . ',';
    $output .= 'directionNav: ' . esc_attr($direction_nav) . ',';
    $output .= 'direction: "' . esc_attr($direction) . '",';
    $output .= 'prevText: ' . '"<span class=\"icon-angle-left\"></span>",';
    $output .= 'nextText: ' . '"<span class=\"icon-angle-right\"></span>",';
    $output .= 'smoothHeight: false,';
    $output .= 'animationLoop: ' . esc_attr($loop) . ',';
    $output .= 'slideshow: ' . esc_attr($slideshow) . ',';
    $output .= 'easing: "' . esc_attr($easing) . '",';
    if (!empty($sync))
        $output .= 'sync: "' . esc_attr($sync) . '",';
    if (!empty($manual_controls)) {
        $output .= 'manualControls: "' . esc_attr($manual_controls) . '",';
        $output .= 'controlsContainer: "' . esc_attr($controls_container) . '"';
    }
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    $output .= '<div ' . ($id ? 'id="' . esc_attr($id) . '"' : '') . ' class="' . $slider_container . ($type == "flex" ? ' loading' : '') . '"' . $style . '>';

    $output .= '<div class="flexslider">';

    $styled_list = '<ul class="slides">';

    $slider_content = do_shortcode(mo_remove_wpautop($content));

    $output .= str_replace('<ul>', $styled_list, $slider_content);

    $output .= '</div><!-- flexslider -->';
    $output .= '</div><!-- ' . $slider_container . ' -->';

    return $output;
}

add_shortcode('responsive_slider', 'mo_responsive_slider_shortcode');

/**
 * @param $slider_content
 * @return array
 */

/* Tab Slider Shortcode -

Use this shortcode to create a smooth tab slider out of any HTML content.

Usage:

[tab_slider slideshow=false animation=slide direction_nav=false]

	[tab_slide tab_name="Slide 1"]Slide 1 content goes here.[/tab_slide]
	[tab_slide tab_name="Slide 2"]Slide 2 content goes here.[/tab_slide]
	[tab_slide tab_name="Slide 3"]Slide 3 content goes here.[/tab_slide]

[/tab_slider]


Parameters -

type (string) - Constructs and sets a unique CSS class for the slider. (optional).
slideshow - false (boolean). Animate slider automatically without user intervention. The slideshow is not enabled by default since the user is expected to navigate manually using the tabs.
slideshow_speed - 5000 (number). Set the speed of the slideshow cycling, in milliseconds. Takes effect only if slideshow is set to true.
animation_speed - 600 (number). Set the speed of animations, in milliseconds.
animation - slide (string). Select your animation type, "fade" or "slide".
easing - swing (string). Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
loop - true (boolean). Should the animation loop? Takes effect only if slideshow is set to true.
style - (string) - The inline CSS applied to the slider container DIV element.
*/

function mo_tab_slider_shortcode($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'id' => false,
            'type' => 'tab',
            'slideshow' => 'false',
            'slideshow_speed' => 5000,
            'animation_speed' => 600,
            'animation' => 'slide',
            'easing' => 'swing',
            'loop' => 'true',
            'style' => '',
            'sync' => false
        ),
        $atts));

    global $tab_count, $tabs;

    $tab_count = 0; //count reset for next tab slider

    $output = '';

    $slider_container = esc_attr($type) . '-slider-container';
    $namespace = 'flex';

    $id_selector = empty($id) ? '' : ('#' . esc_attr($id));

    $controls_container = $id_selector . " .tab-list";

    $output .= '<script type="text/javascript">' . "\n";
    if (!empty($sync))
        $output .= 'jQuery(window).load(function () {';
    else
        $output .= 'jQuery(document).ready(function($) {';
    $output .= 'jQuery(\'' . $id_selector . '.' . $slider_container . ' .flexslider\').flexslider({';
    $output .= 'animation: "' . esc_attr($animation) . '",';
    $output .= 'slideshowSpeed: ' . intval($slideshow_speed) . ',';
    $output .= 'animationSpeed: ' . intval($animation_speed) . ',';
    $output .= 'namespace: "' . $namespace . '-",';
    $output .= 'controlNav: true,';
    $output .= 'directionNav: false,';
    $output .= 'smoothHeight: false,';
    $output .= 'animationLoop: ' . esc_attr($loop) . ',';
    $output .= 'slideshow: ' . esc_attr($slideshow) . ',';
    $output .= 'easing: "' . esc_attr($easing) . '",';
    if (!empty($sync))
        $output .= 'sync: "' . $sync . '",';
    $output .= 'manualControls: "' . $controls_container . ' li a",';
    $output .= 'controlsContainer: "' . $controls_container . '"';
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";


    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    if (!empty($id))
        $id = ' id="' . esc_attr($id) . '"';

    $output .= '<div' . $id . ' class="' . $slider_container . ($type == "flex" ? ' loading' : '') . '"' . $style . '>';

    // First process the tab slides before outputting anything so that we can build the tabs list
    $slides_content = do_shortcode(mo_remove_wpautop($content));

    if (is_array($tabs)) {
        $output .= '<ul class="tab-list">';
        foreach ($tabs as $key => $value) {
            $output .= '<li><a href="#' . $key . '">' . $value . '</a></li>';
        }
        $output .= '</ul>';
    }

    $output .= '<div class="flexslider">';

    $output .= '<ul class="slides">';

    $output .= $slides_content;

    $output .= '</ul><!-- .slides -->';

    $output .= '</div><!-- .flexslider -->';

    $output .= '</div><!-- .' . $slider_container . ' -->';

    return $output;
}

add_shortcode('tab_slider', 'mo_tab_slider_shortcode');

/* Tab Slide Shortcode -

Use this shortcode to create a tab slide as part of a [tab_slider] shortcode.

Usage:

[tab_slider slideshow=false animation=slide direction_nav=false]

	[tab_slide tab_name="Slide 1"]Slide 1 content goes here.[/tab_slide]
	[tab_slide tab_name="Slide 2"]Slide 2 content goes here.[/tab_slide]
	[tab_slide tab_name="Slide 3"]Slide 3 content goes here.[/tab_slide]

[/tab_slider]


Parameters -

tab_name (string) - The name of the tab. Can be HTML too.
id -  (string). The id to be applied to the slide LI element (optional).
class -  (string). The class to be applied to the slide LI element (optional).
style - (string) - The inline CSS applied to the slide LI element (optional).
*/
function mo_tab_slide_shortcode($atts, $content = null) {
    extract(shortcode_atts(
        array(
            'tab_icon' => '',
            'tab_name' => false,
            'id' => false,
            'class' => '',
            'style' => false
        ),
        $atts));

    global $tab_count, $tabs;

    $output = '';

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    if (!empty($id))
        $id = ' id="' . esc_attr($id) . '"';

    if (!empty($tab_name)) {
        if (!empty($tab_icon)) {
            $tab_icon = '<i class="' . esc_attr($tab_icon) . '"></i>';
        }
        $tabs[$tab_count] = $tab_icon . '<span class="tab-title">' . htmlspecialchars_decode(esc_html($tab_name)) . '</span>';
        $tab_count++;
    }
    else {
        $tabs[$tab_count] = esc_html__('Tab ', 'peak') . ($tab_count + 1);
        $tab_count++;
    }

    $output .= '<li ' . $id . ' class="slide ' . esc_attr($class) . '"' . $style . '>';

    $output .= do_shortcode(mo_remove_wpautop($content));

    $output .= '</li><!-- .slide -->';

    return $output;
}

add_shortcode('tab_slide', 'mo_tab_slide_shortcode');


/*

Responsive Carousel Shortcode -

Use this shortcode to create a carousel out of any HTML content. All it requires is a set of DIV elements to show. Each of the DIV element is an item in the carousel.

Usage:

[responsive_carousel id="stats-carousel" navigation="false" pagination="true" items=3 items_tablet=2 items_tablet_small=1 items_desktop_small=3 items_desktop=3]

[wrap]Slide 1 content goes here.[/wrap]

[wrap]Slide 2 content goes here.[/wrap]

[wrap]Slide 3 content goes here.[/wrap]

[/responsive_carousel]


Parameters -

id (string) - The element id to be set for the wrapper element created (optional)..
pagination_speed - 800 (number). Pagination speed in milliseconds
slide_speed - 200 (number). Slide speed in milliseconds.
rewind_speed - 1000 (number). Rewind speed in milliseconds.
stop_on_hover - true (boolean). Stop autoplay on mouse hover.
auto_play - false (boolean/number) - Change to any integrer for example autoPlay : 5000 to play every 5 seconds. If you set autoPlay: true default speed will be 5 seconds.
scroll_per_page - false (boolean) - Scroll per page not per item. This affect next/prev buttons and mouse/touch dragging.
navigation - false (boolean) - Display "next" and "prev" buttons.
pagination - true (boolean) - Show pagination.
items - 5 (number) - This variable allows you to set the maximum amount of items displayed at a time with the widest browser width
items_desktop - (number) This variable allows you to set the maximum amount of items displayed at a time with the desktop browser width (<1200px)
items_desktop_small - (number) - This variable allows you to set the maximum amount of items displayed at a time with the smaller desktop browser width(<980px).
items_tablet - (number) - This variable allows you to set the maximum amount of items displayed at a time with the tablet browser width(<769px).
items_tablet_small  - (number) - This variable allows you to set the maximum amount of items displayed at a time with the smaller tablet browser width
items_mobile  - (number) - This variable allows you to set the maximum amount of items displayed at a time with the smartphone mobile browser width(<480px).
layout_class - (string) The CSS class to be set for the wrapper div for the carousel. Useful if you need to do some custom styling of our own (rounded, hexagon images etc.) for the displayed items.

*/

function mo_responsive_carousel($atts, $content = null) {
    $args = shortcode_atts(
        array(
            'id' => '',
            'pagination_speed' => 800,
            'slide_speed' => 200,
            'rewind_speed' => 1000,
            'stop_on_hover' => 'true',
            'auto_play' => 'false',
            'scroll_per_page' => 'false',
            'navigation' => 'false',
            'pagination' => 'true',
            'items' => 5,
            'items_desktop' => false,
            'items_desktop_small' => false,
            'items_tablet' => false,
            'items_tablet_small' => false,
            'items_mobile' => false,
            'layout_class' => 'image-grid',
        ),
        $atts);

    extract($args);

    $output = '';

    $controls_container = 'carousel-container';

    if (!empty($id)) {
        $selector = '#' . esc_attr($id);
        $id = 'id ="' . esc_attr($id) . '"';
    }
    else {
        $selector = '.' . $controls_container;
    }

    $output .= '<script type="text/javascript">' . "\n";
    $output .= 'jQuery(window).load(function($) {';
    $output .= 'jQuery(\'' . $selector . ' .slides\').owlCarousel({';
    $output .= 'navigation: ' . esc_attr($navigation) . ',';
    $output .= 'navigationText: ["<i class=\"icon-uniF489\"></i>","<i class=\"icon-uniF488\"></i>"],';
    $output .= 'scrollPerPage: ' . esc_attr($scroll_per_page) . ',';

    $output .= 'items: ' . intval($items) . ',';
    if (!empty($items_desktop))
        $output .= 'itemsDesktop: [1199,' . intval($items_desktop) . '],';
    if (!empty($items_desktop_small))
        $output .= 'itemsDesktopSmall: [979,' . intval($items_desktop_small) . '],';
    if (!empty($items_tablet))
        $output .= 'itemsTablet: [768,' . intval($items_tablet) . '],';
    if (!empty($items_tablet_small))
        $output .= 'itemsTabletSmall: [640,' . intval($items_tablet_small) . '],';
    if (!empty($items_mobile))
        $output .= 'itemsMobile: [479,' . intval($items_mobile) . '],';

    $output .= 'autoPlay: ' . esc_attr($auto_play) . ',';
    $output .= 'stopOnHover: ' . esc_attr($stop_on_hover) . ',';
    $output .= 'pagination: ' . esc_attr($pagination) . ',';
    $output .= 'rewindSpeed: ' . intval($rewind_speed) . ',';
    $output .= 'slideSpeed: ' . intval($slide_speed) . ',';
    $output .= 'paginationSpeed: "' . intval($pagination_speed) . '"';
    $output .= '})';
    $output .= '});' . "\n";
    $output .= '</script>' . "\n";

    $output .= '<div class="carousel-wrap">';

    $output .= '<div ' . $id . ' class="' . $controls_container . '">';

    $output .= '<div class="slides ' . esc_attr($layout_class) . ' owl-carousel">';

    $output .= mo_remove_wpautop($content);

    $output .= '</div><!-- .slides -->';

    $output .= '</div><!-- ' . $controls_container . ' -->';

    $output .= '</div><!-- carousel-wrap -->';

    return $output;
}

add_shortcode('responsive_carousel', 'mo_responsive_carousel');

/* Device Slider Shortcode -

Use this shortcode to create a image slider part of a container that looks like a browser, smartphone, tablet or a desktop. Possible sliders are

[device_slider],[browser_slider], [imac_slider], [macbook_slider], [ipad_slider], [iphone_slider], [galaxys4_slider], [htcone_slider].

The image URLs are provided via a comma separated list of URLs pointing to the images.

Usage:

[browser_slider
animation="slide"
browser_url="http://portfoliotheme.org/extinct"
direction_nav=true
control_nav=false
slideshow_speed=4000
animation_speed=600
pause_on_action=true
pause_on_hover=true
easing="swing"
style="margin-bottom:20px;"
image_urls="http://portfoliotheme.org/peak/wp-content/uploads/2014/03/web-slide3.jpg,http://portfoliotheme.org/peak/wp-content/uploads/2014/03/web-slide1.jpg,http://portfoliotheme.org/peak/wp-content/uploads/2014/03/web-slide2.jpg,http://portfoliotheme.org/peak/wp-content/uploads/2014/03/web-slide4.jpg"]


Parameters -


style - (string) - The inline CSS applied to the slider container DIV element.
device - iphone (string) - The device type - valid values are iphone, galaxys4, htcone, ipad, imac, macbook, browser.
slideshow_speed - 5000 (number). Set the speed of the slideshow cycling, in milliseconds
animation_speed - 600 (number). Set the speed of animations, in milliseconds.
animation - fade (string). Select your animation type, "fade" or "slide".
pause_on_action - true (boolean). Pause the slideshow when interacting with control elements, highly recommended.
pause_on_hover - true (boolean). Pause the slideshow when hovering over slider, then resume when no longer hovering.
direction_nav - true (boolean). Create navigation for previous/next navigation? (true/false)
control_nav - true (boolean). Create navigation for paging control of each slide? Note: Leave true for manual_controls usage.
easing - swing (string). Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!
loop - true (boolean). Should the animation loop?
image_urls (string) - Comma separated list of URLs pointing to the images.
browser_url (string) - If the device specified is browser or if [browser_slider], this provides the URL to be displayed in the address bar of the browser.
*/


function mo_device_slider_shortcode($atts) {
    extract(shortcode_atts(
        array(
            'slideshow_speed' => 5000,
            'device' => 'iphone',
            /* valid values - iphone, galaxys4, htcone, ipad */
            'animation_speed' => 600,
            'animation' => 'fade',
            'pause_on_action' => 'false',
            'pause_on_hover' => 'true',
            'direction_nav' => 'true',
            'control_nav' => 'true',
            'easing' => 'swing',
            'loop' => 'true',
            'controls_container' => false,
            'sync' => false,
            'manual_controls' => false,
            'style' => '',
            'image_urls' => '',
            'browser_url' => '',
            'id' => false,
            'phone_color' => 'black'
            /* valid values - black,white,gold */
        ),
        $atts));

    $output = '';


    // Check if one or more image URLs are specified, else no point continuing
    if (empty($image_urls))
        return $output;

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    $output .= '<div class="' . esc_attr($device) . '-slider-container smartphone-slider"' . $style . '>';

    if ($device === 'browser' && !empty($browser_url))
        $output .= '<div class="address-bar">' . esc_url($browser_url) . '</div>';

    if ($device == 'iphone') {
        $device_image = $device . '-' . $phone_color . '-slider-stage.png';
    }
    else {
        $device_image = $device . '-slider-stage.png';
    }

    $output .= '<img src="' . get_template_directory_uri() . '/images/sliders/' . esc_attr($device_image) . '" alt="' . esc_attr($device) . ' Slider"/>';

    /* Start: Construct the slider */
    $slider = '[responsive_slider ';
    $slider .= 'id="' . esc_attr($id) . '" ';
    $slider .= 'direction_nav=' . esc_attr($direction_nav) . ' ';
    $slider .= 'control_nav=' . esc_attr($control_nav) . ' ';
    $slider .= 'animation=' . esc_attr($animation) . ' ';
    $slider .= 'type=flex ';
    $slider .= 'slideshow_speed=' . intval($slideshow_speed) . ' ';
    $slider .= 'animation_speed=' . intval($animation_speed) . ' ';
    $slider .= 'pause_on_action=' . esc_attr($pause_on_action) . ' ';
    $slider .= 'pause_on_hover=' . esc_attr($pause_on_hover) . ' ';
    $slider .= 'loop=' . esc_attr($loop) . ' ';
    $slider .= 'easing=' . esc_attr($easing) . ' ';
    if (!empty($sync))
        $slider .= 'sync= "' . esc_attr($sync) . '" ';
    if (!empty($manual_controls))
        $slider .= 'manual_controls= "' . esc_attr($manual_controls) . '" ';
    if (!empty($controls_container))
        $slider .= 'controls_container= "' . esc_attr($controls_container) . '"';
    $slider .= ']';
    $slider .= '<ul>';
    $image_urls = explode(',', esc_html($image_urls));
    foreach ($image_urls as $image_url) {
        $slider .= '<li><div class="img-wrap"><img alt="App Slide" src="';
        $slider .= esc_url($image_url);
        $slider .= '"></div></li>';
    }
    $slider .= '</ul>';
    $slider .= '[/responsive_slider]';
    /* END: Construct the slider */

    $output .= do_shortcode(mo_remove_wpautop($slider));
    $output .= '</div>';

    return $output;
}

function mo_galaxys4_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'galaxys4'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_htcone_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'htcone'), $atts);
    return mo_device_slider_shortcode($atts);
}


function mo_ipad_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'ipad'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_macbook_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'macbook'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_imac_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'imac'), $atts);
    return mo_device_slider_shortcode($atts);
}

function mo_browser_slider_shortcode($atts) {
    $atts = array_merge(array('device' => 'browser'), $atts);
    return mo_device_slider_shortcode($atts);
}

add_shortcode('iphone_slider', 'mo_device_slider_shortcode');

add_shortcode('galaxys4_slider', 'mo_galaxys4_slider_shortcode');

add_shortcode('htcone_slider', 'mo_htcone_slider_shortcode');

add_shortcode('ipad_slider', 'mo_ipad_slider_shortcode');

add_shortcode('macbook_slider', 'mo_macbook_slider_shortcode');

add_shortcode('imac_slider', 'mo_imac_slider_shortcode');

add_shortcode('browser_slider', 'mo_browser_slider_shortcode');

add_shortcode('smartphone_slider', 'mo_device_slider_shortcode');

add_shortcode('device_slider', 'mo_device_slider_shortcode');
