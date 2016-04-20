<?php

/*
Widget Name: Piechart
Description: Display a piechart for a percentage statistic with a title in the middle.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Piechart_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-piechart",
            __("Piechart", "mo_theme"),
            array(
                "description" => __("Displays a piechart for a percentage statistic with a title in the middle of the piechart displayed. The piechart animates to indicate the percentage specified.", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),
            array(
                "title" => array(
                    "type" => "text",
                    "description" => __("The text for the title displayed at the center of the piechart.", "mo_theme"),
                    "label" => __("Title", "mo_theme"),
                    "default" => __("Repeat Customers", "mo_theme"),
                ),
                "percent" => array(
                    "type" => "number",
                    "description" => __("The percentage value for the piechart.", "mo_theme"),
                    "label" => __("Percent", "mo_theme"),
                    "default" => 70,
                ),
                "bar_color" => array(
                    "type" => "color",
                    "description" => __("The custom color for the piechart rounded bar.(optional)", "mo_theme"),
                    "label" => __("Bar Color", "mo_theme"),
                ),
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "percent" => $instance["percent"],
            "title" => $instance["title"],
            "bar_color" => $instance["bar_color"],
        );
    }

}
siteorigin_widget_register("mo-piechart", __FILE__, "MO_Piechart_Widget");

