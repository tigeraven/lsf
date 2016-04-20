<?php

/*
Widget Name: Responsive Carousel
Description: Create a touch friendly responsive carousel of a collection of HTML content.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Responsive_Carousel_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-responsive-carousel",
            __("Responsive Carousel", "mo_theme"),
            array(
                "description" => __("Create a responsive carousel of a collection of HTML content.", "mo_theme"),
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
                    "description" => __("The element id to be set for the wrapper element created. (optional).", "mo_theme"),
                    "label" => __("Id", "mo_theme"),
                    "default" => __("stats-carousel", "mo_theme"),
                ),

                'elements' => array(
                    'type' => 'repeater',
                    'label' => __('HTML Elements', 'mo_theme'),
                    'item_name' => __('HTML Element', 'mo_theme'),
                    'item_label' => array(
                        'selector' => "[id*='elements-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'mo_theme'),
                            'description' => __('The title to identify the HTML element', 'mo_theme'),
                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'label' => __('HTML element', 'mo_theme'),
                            'description' => __('The HTML content for the carousel item.', 'mo_theme'),
                        ),
                    )
                ),


                'settings' => array(
                    'type' => 'section',
                    'label' => __('Carousel Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        "pagination_speed" => array(
                            "type" => "number",
                            "description" => __("Pagination speed in milliseconds", "mo_theme"),
                            "label" => __("Pagination speed", "mo_theme"),
                            "default" => 800,
                        ),
                        "slide_speed" => array(
                            "type" => "number",
                            "description" => __("Slide speed in milliseconds.", "mo_theme"),
                            "label" => __("Slide speed", "mo_theme"),
                            "default" => 200,
                        ),
                        "rewind_speed" => array(
                            "type" => "number",
                            "description" => __("Rewind speed in milliseconds.", "mo_theme"),
                            "label" => __("Rewind speed", "mo_theme"),
                            "default" => 1000,
                        ),
                        "stop_on_hover" => array(
                            "type" => "checkbox",
                            "description" => __("Stop autoplay on mouse hover?", "mo_theme"),
                            "label" => __("Stop on hover?", "mo_theme"),
                            "default" => true,
                        ),
                        "auto_play" => array(
                            "type" => "text",
                            "description" => __("Change to any integer for example autoPlay : 5000 to play every 5 seconds. If you set text true default speed will be 5 seconds. Set to text false to disable autoplay.", "mo_theme"),
                            "label" => __("Auto play", "mo_theme"),
                            "default" => 'true',
                        ),
                        "scroll_per_page" => array(
                            "type" => "checkbox",
                            "description" => __("Scroll per page and not per item. This affect next/prev buttons and mouse/touch dragging.", "mo_theme"),
                            "label" => __("Scroll per page?", "mo_theme"),
                            "default" => false,
                        ),
                        "pagination" => array(
                            "type" => "checkbox",
                            "description" => __("Show pagination?", "mo_theme"),
                            "label" => __("Pagination?", "mo_theme"),
                            "default" => true,
                        ),
                        "navigation" => array(
                            "type" => "checkbox",
                            "description" => __("Display next and prev buttons?", "mo_theme"),
                            "label" => __("Navigation?", "mo_theme"),
                            "default" => false,
                        ),
                    )
                ),


                'responsive_settings' => array(
                    'type' => 'section',
                    'label' => __('Responsive Settings', 'livemesh-so-widgets'),
                    'fields' => array(
                        "items" => array(
                            "type" => "slider",
                            "description" => __("Maximum amount of items displayed at a time with the widest browser width.", "mo_theme"),
                            "label" => __("Items", "mo_theme"),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),
                        "items_desktop" => array(
                            "type" => "slider",
                            "description" => __("Maximum amount of items displayed at a time with the desktop browser width (<1200px).", "mo_theme"),
                            "label" => __("Items desktop", "mo_theme"),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),
                        "items_desktop_small" => array(
                            "type" => "slider",
                            "description" => __("Maximum amount of items displayed at a time with the smaller desktop browser width(<980px).", "mo_theme"),
                            "label" => __("Items desktop_small", "mo_theme"),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),
                        "items_tablet" => array(
                            "type" => "slider",
                            "description" => __("Maximum amount of items displayed at a time with the tablet browser width(<769px).", "mo_theme"),
                            "label" => __("Items tablet", "mo_theme"),
                            'min' => 1,
                            'max' => 4,
                            'integer' => true,
                            'default' => 2
                        ),
                        "items_tablet_small" => array(
                            "type" => "slider",
                            "description" => __("Maximum amount of items displayed at a time with the smaller tablet browser width.", "mo_theme"),
                            "label" => __("Items tablet_small", "mo_theme"),
                            'min' => 1,
                            'max' => 3,
                            'integer' => true,
                            'default' => 2
                        ),
                        "items_mobile" => array(
                            "type" => "slider",
                            "description" => __("Maximum amount of items displayed at a time with the smartphone mobile browser width(<480px).", "mo_theme"),
                            "label" => __("Items mobile", "mo_theme"),
                            'min' => 1,
                            'max' => 3,
                            'integer' => true,
                            'default' => 1
                        ),
                    )
                )
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "id" => $instance["id"],

            "pagination_speed" => $instance["settings"]["pagination_speed"],
            "slide_speed" => $instance["settings"]["slide_speed"],
            "rewind_speed" => $instance["settings"]["rewind_speed"],
            "stop_on_hover" => $instance["settings"]["stop_on_hover"],
            "auto_play" => $instance["settings"]["auto_play"],
            "scroll_per_page" => $instance["settings"]["scroll_per_page"],
            "pagination" => $instance["settings"]["pagination"],
            "navigation" => $instance["settings"]["navigation"],

            "items" => $instance["responsive_settings"]["items"],
            "items_mobile" => $instance["responsive_settings"]["items_mobile"],
            "items_tablet" => $instance["responsive_settings"]["items_tablet"],
            "items_tablet_small" => $instance["responsive_settings"]["items_tablet_small"],
            "items_desktop_small" => $instance["responsive_settings"]["items_desktop_small"],
            "items_desktop" => $instance["responsive_settings"]["items_desktop"],


            'elements' => !empty($instance['elements']) ? $instance['elements'] : array(),
        );
    }

}

siteorigin_widget_register("mo-responsive-carousel", __FILE__, "MO_Responsive_Carousel_Widget");

