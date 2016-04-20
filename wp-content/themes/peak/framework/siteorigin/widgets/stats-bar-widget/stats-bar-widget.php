<?php

/*
Widget Name: Stats Bar
Description: Display an animated line bar to indicate the percentage.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Stats_Bar_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-stats-bar",
            __("Stats Bar", "mo_theme"),
            array(
                "description" => __("Display an animated line bar to indicate the percentage.", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),
            array(
                "title" => array(
                    "type" => "text",
                    "description" => __("The title to be displayed above the stats line bar.", "mo_theme"),
                    "label" => __("Stats title", "mo_theme"),
                    "default" => __("Web Design 87%", "mo_theme"),
                ),
                "value" => array(
                    "type" => "number",
                    "description" => __("The percentage value for the stats to be displayed.", "mo_theme"),
                    "label" => __("Value", "mo_theme"),
                    "default" => 87,
                ),
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "title" => $instance["title"],
            "value" => $instance["value"],
        );
    }

}
siteorigin_widget_register("mo-stats-bar", __FILE__, "MO_Stats_Bar_Widget");

