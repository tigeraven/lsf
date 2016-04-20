<?php

/*
Widget Name: Vimeo Video
Description: Display a image placeholder with a play button for Vimeo video.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Vimeo_Video_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-vimeo-video",
            __("Vimeo Video", "mo_theme"),
            array(
                "description" => __("Displays a vimeo video placeholder with a play button. The video is played on clicking the play button.", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),
            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", "mo_theme"),
                ),
                "vimeo_video_id" => array(
                    "type" => "number",
                    "description" => __("The Vimeo video id part of Vimeo video URL. ", "mo_theme"),
                    "label" => __("Vimeo Video ID", "mo_theme"),
                    "default" => 20370519,
                ),
                "placeholder_id" => array(
                    "type" => "media",
                    "description" => __("The placeholder image for the video. ", "mo_theme"),
                    "label" => __("Placeholder Image", "mo_theme")
                ),
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "vimeo_video_id" => $instance["vimeo_video_id"],
            "placeholder_id" => $instance["placeholder_id"],
        );
    }

}

siteorigin_widget_register("mo-vimeo-video", __FILE__, "MO_Vimeo_Video_Widget");