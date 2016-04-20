<?php

/*
Widget Name: Hero Section
Description: Full width hero section or segment with options to set parallax or video backgrounds.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Hero_Section_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-hero-section",
            __("Hero Section", "mo_theme"),
            array(
                "description" => __("Full width section or segment with options to set parallax or video backgrounds. For best results, choose Full Width Stretched as the layout for any row containing this widget.", "mo_theme"),
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
                    "description" => __("The id of the wrapper HTML element created by the section", "mo_theme"),
                    "label" => __("Id", "mo_theme"),
                ),
                "class" => array(
                    "type" => "text",
                    "description" => __("The CSS class of the HTML element wrapping the content.", "mo_theme"),
                    "label" => __("Class", "mo_theme"),
                    "default" => __("dark-bg", "mo_theme"),
                ),
                "style" => array(
                    "type" => "text",
                    "description" => __("Any inline styling you would like to apply to the section. You may want to override the default top/bottom padding, provide custom markup for backgrounds etc.", "mo_theme"),
                    "label" => __("Style", "mo_theme"),
                ),
                "text" => array(
                    "type" => "tinymce",
                    "description" => __("The hero segment content.", "mo_theme"),
                    "label" => __("Hero section content", "mo_theme"),
                    "default" => __("Hero section content goes here.", "mo_theme"),
                ),
                "background_color" => array(
                    "type" => "color",
                    "description" => __("The background color to be applied to the segment.", "mo_theme"),
                    "label" => __("Background color", "mo_theme"),
                ),
                'bg_type' => array(
                    'type' => 'radio',
                    'label' => __('Background Type', 'mo_theme'),
                    'default' => 'image',
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('bg_type')
                    ),
                    'options' => array(
                        'image' => __('Image', 'mo_theme'),
                        'youtube' => __('YouTube Video', 'mo_theme'),
                    )
                ),
                "background_image" => array(
                    "type" => "media",
                    "description" => __("Background image for the section. If YouTube video background option is chosen, this image will be used as a placeholder image for the video.", "mo_theme"),
                    "label" => __("Background image", "mo_theme"),
                ),
                "parallax_background" => array(
                    "type" => "checkbox",
                    "description" => __("Specify if the background is a parallax one. On mobile devices and browser window size less than 1100px, the parallax effect is disabled.", "mo_theme"),
                    "label" => __("Parallax background", "mo_theme"),
                    "default" => true,
                    'state_handler' => array(
                        'bg_type[image]' => array('show'),
                        '_else[bg_type]' => array('hide'),
                    ),
                ),
                "background_speed" => array(
                    "type" => "slider",
                    "description" => __("Speed at which the parallax background moves with user scrolling the page. If the value assigned to this property is 0, the background acts like the one whose background-attachment property is set to fixed and hence does not scroll at all. A value of 1 implies the background scrolls with the page in equal increments ( same effect as background-attachment: scroll). To obtain best results, experiment with multiple values to test the parallax effect.", "mo_theme"),
                    "label" => __("Parallax Background speed", "mo_theme"),
                    'min' => 0,
                    'max' => 100,
                    'default' => 40,
                    'state_handler' => array(
                        'bg_type[image]' => array('show'),
                        '_else[bg_type]' => array('hide'),
                    ),
                ),
                "background_pattern" => array(
                    "type" => "media",
                    "description" => __("As an alternative to background image option above, choose background image which acts like a pattern. This image is repeated horizontally as well as vertically to help occupy the entire segment width.", "mo_theme"),
                    "label" => __("Background pattern", "mo_theme"),
                ),
                "youtube_bg_url" => array(
                    "type" => "text",
                    'sanitize' => 'url',
                    "description" => __("The URL of the YouTube video to be used as the background for the section. (ex: http://www.youtube.com/watch?v=PzjwAAskt4o) ", "mo_theme"),
                    "label" => __("YouTube Background Video URL", "mo_theme"),
                    'state_handler' => array(
                        'bg_type[youtube]' => array('show'),
                        '_else[bg_type]' => array('hide'),
                    ),
                ),
                "youtube_bg_quality" => array(
                    "type" => "select",
                    "label" => __("YouTube Background Quality", "mo_theme"),
                    'default' => 'highres',
                    'options' => array(
                        'highres' => __('High Resolution', 'mo_theme'),
                        'default' => __('Default', 'mo_theme'),
                        'small' => __('Small', 'mo_theme'),
                        'medium' => __('Medium', 'mo_theme'),
                        'large' => __('Large', 'mo_theme'),
                        'hd720' => __('HD 720p', 'mo_theme'),
                        'hd1080' => __('HD 1080p', 'mo_theme'),
                    ),
                    'state_handler' => array(
                        'bg_type[youtube]' => array('show'),
                        '_else[bg_type]' => array('hide'),
                    ),
                ),
                "youtube_bg_opacity" => array(
                    "type" => "slider",
                    "description" => __("Specify the opacity of the YouTube background video.", "mo_theme"),
                    "label" => __("YouTube Background Opacity", "mo_theme"),
                    'min' => 0,
                    'max' => 100,
                    'default' => 50,
                    'state_handler' => array(
                        'bg_type[youtube]' => array('show'),
                        '_else[bg_type]' => array('hide'),
                    ),
                ),
                "youtube_bg_aspect_ratio" => array(
                    "type" => "select",
                    "description" => __("The aspect ratio of the YouTube background video.", "mo_theme"),
                    "label" => __("YouTube Background Aspect Ratio", "mo_theme"),
                    'default' => '16/9',
                    'options' => array(
                        '16/9' => __('16/9', 'mo_theme'),
                        'auto' => __('Auto', 'mo_theme'),
                        '4/3' => __('4/3', 'mo_theme'),
                    ),
                    'state_handler' => array(
                        'bg_type[youtube]' => array('show'),
                        '_else[bg_type]' => array('hide'),
                    ),
                ),


                'overlay_settings' => array(
                    'type' => 'section',
                    'label' => __('Overlay Settings', 'livemesh-so-widgets'),
                    'fields' => array(
                        "overlay_color" => array(
                            "type" => "color",
                            "description" => __("The color of the overlay to be applied on the background.", "mo_theme"),
                            "label" => __("Overlay color", "mo_theme"),
                        ),
                        "overlay_opacity" => array(
                            "type" => "number",
                            "description" => __("The opacity of the overlay color applied on the background.", "mo_theme"),
                            "label" => __("Overlay opacity", "mo_theme"),
                            'min' => 0,
                            'max' => 100,
                            'default' => 60,
                        ),
                        "overlay_pattern" => array(
                            "type" => "media",
                            "description" => __("The image which can act as a pattern displayed on top of the background.", "mo_theme"),
                            "label" => __("Overlay pattern", "mo_theme"),
                        ),
                    )
                )
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "id" => $instance["id"],
            "class" => $instance["class"],
            "style" => $instance["style"],
            "text" => $instance["text"],
            "bg_type" => $instance["bg_type"],
            "background_color" => $instance["background_color"],
            "background_image" => $instance["background_image"],
            "parallax_background" => $instance["parallax_background"],
            "background_speed" => $instance["background_speed"],
            "background_pattern" => $instance["background_pattern"],
            "youtube_bg_url" => $instance["youtube_bg_url"],
            "youtube_bg_quality" => $instance["youtube_bg_quality"],
            "youtube_bg_opacity" => $instance["youtube_bg_opacity"],
            "youtube_bg_aspect_ratio" => $instance["youtube_bg_aspect_ratio"],

            "overlay_color" => (isset($instance["overlay_settings"]["overlay_color"]) ? $instance["overlay_settings"]["overlay_color"] : ''),
            "overlay_opacity" => (isset($instance["overlay_settings"]["overlay_opacity"]) ? $instance["overlay_settings"]["overlay_opacity"] : 60),
            "overlay_pattern" => (isset($instance["overlay_pattern"]["overlay_color"]) ? $instance["overlay_pattern"]["overlay_color"] : 0),
        );
    }

}

siteorigin_widget_register("mo-hero-section", __FILE__, "MO_Hero_Section_Widget");

