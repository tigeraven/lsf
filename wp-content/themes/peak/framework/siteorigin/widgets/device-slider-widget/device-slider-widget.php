<?php

/*
Widget Name: Device Slider
Description: Create a browser, smartphone, tablet or a desktop slider
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Device_Slider_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-device-slider",
            __("Device Slider", "mo_theme"),
            array(
                "description" => __("Create a image slider part of a container that looks like a browser, smartphone, tablet or a desktop", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),
            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", "mo_theme"),
                ),
                "id" => array(
                    "type" => "text",
                    "description" => __("The ID for the slider container DIV element", "mo_theme"),
                    "label" => __("ID", "mo_theme"),
                    "default" => "",
                ),
                "style" => array(
                    "type" => "text",
                    "description" => __("The inline CSS applied to the slider container DIV element", "mo_theme"),
                    "label" => __("Style", "mo_theme"),
                    "default" => "",
                ),
                "device" => array(
                    "type" => "select",
                    "description" => __("The device type for the slider.", "mo_theme"),
                    "label" => __("Device", "mo_theme"),
                    "options" => array(
                        "iphone" => __("iPhone", "mo_theme"),
                        "galaxys4" => __("Samsung Galaxy S", "mo_theme"),
                        "htcone" => __("HTC One", "mo_theme"),
                        "ipad" => __("iPad", "mo_theme"),
                        "imac" => __("iMac", "mo_theme"),
                        "macbook" => __("MacBook", "mo_theme"),
                        "browser" => __("Web Browser", "mo_theme"),
                    ),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('device')
                    ),
                ),
                "phone_color" => array(
                    "type" => "select",
                    "label" => __("Phone Color", "mo_theme"),
                    "options" => array(
                        "black" => __("Black", "mo_theme"),
                        "white" => __("White", "mo_theme"),
                        "gold" => __("Gold", "mo_theme"),
                    ),
                    'state_handler' => array(
                        'device[iphone]' => array('show'),
                        '_else[device]' => array('hide'),
                    ),
                ),
                "browser_url" => array(
                    "type" => "text",
                    "description" => __("If the device specified is browser, this provides the URL to be displayed in the address bar of the browser.", "mo_theme"),
                    "label" => __("Browser url", "mo_theme"),
                    "default" => __("http://portfoliotheme.org/", "mo_theme"),
                    'state_handler' => array(
                        'device[browser]' => array('show'),
                        '_else[device]' => array('hide'),
                    ),
                ),

                'slides' => array(
                    'type' => 'repeater',
                    'label' => __('Image Slides', 'mo_theme'),
                    'item_name' => __('Slide', 'mo_theme'),
                    'item_label' => array(
                        'selector' => "[id*='slides-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'mo_theme'),
                            'description' => __('The title to identify the image slide.', 'mo_theme'),
                        ),
                        'slider_image' => array(
                            'type' => 'media',
                            'library' => 'image',
                            'label' => __('Slide Image', 'mo_theme'),
                            'fallback' => true,
                        ),
                    ),
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Slider Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        "animation" => array(
                            "type" => "select",
                            "description" => __("Select your animation type", "mo_theme"),
                            "label" => __("Animation", "mo_theme"),
                            "options" => array(
                                "slide" => __("Slide", "mo_theme"),
                                "fade" => __("Fade", "mo_theme"),
                            ),
                            "default" => "slide",
                        ),
                        "direction_nav" => array(
                            "type" => "checkbox",
                            "description" => __("Create navigation for previous/next navigation?", "mo_theme"),
                            "label" => __("Direction navigation?", "mo_theme"),
                            "default" => true,
                        ),
                        "control_nav" => array(
                            "type" => "checkbox",
                            "description" => __("Create navigation for paging control of each slide? ", "mo_theme"),
                            "label" => __("Control navigation?", "mo_theme"),
                            "default" => false,
                        ),
                        "slideshow_speed" => array(
                            "type" => "number",
                            "description" => __("Set the speed of the slideshow cycling, in milliseconds", "mo_theme"),
                            "label" => __("Slideshow speed", "mo_theme"),
                            "default" => 5000,
                        ),
                        "animation_speed" => array(
                            "type" => "number",
                            "description" => __("Set the speed of animations, in milliseconds.", "mo_theme"),
                            "label" => __("Animation speed", "mo_theme"),
                            "default" => 600,
                        ),
                        "pause_on_action" => array(
                            "type" => "checkbox",
                            "description" => __("Pause the slideshow when interacting with control elements", "mo_theme"),
                            "label" => __("Pause on action?", "mo_theme"),
                            "default" => true,
                        ),
                        "pause_on_hover" => array(
                            "type" => "checkbox",
                            "description" => __("Pause the slideshow when hovering over slider, then resume when no longer hovering.", "mo_theme"),
                            "label" => __("Pause on hover?", "mo_theme"),
                            "default" => true,
                        ),
                        "easing" => array(
                            "type" => "select",
                            "description" => __("Determines the easing method used in jQuery transitions", "mo_theme"),
                            "label" => __("Easing", "mo_theme"),
                            "options" => array(
                                "swing" => __("Swing", "mo_theme"),
                                "linear" => __("Linear", "mo_theme"),
                            ),
                            "default" => "swing",
                        ),
                    )
                )
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "style" => $instance["style"],
            "id" => $instance["id"],
            "device" => $instance["device"],
            "phone_color" => $instance["phone_color"],
            "browser_url" => $instance["browser_url"],

            "animation" => $instance["settings"]["animation"],
            "direction_nav" => $instance["settings"]["direction_nav"],
            "control_nav" => $instance["settings"]["control_nav"],
            "slideshow_speed" => $instance["settings"]["slideshow_speed"],
            "animation_speed" => $instance["settings"]["animation_speed"],
            "pause_on_action" => $instance["settings"]["pause_on_action"],
            "pause_on_hover" => $instance["settings"]["pause_on_hover"],
            "easing" => $instance["settings"]["easing"],

            "slides" => !empty($instance["slides"]) ? $instance["slides"] : array()
        );
    }

}

siteorigin_widget_register("mo-device-slider", __FILE__, "MO_Device_Slider_Widget");

