<?php

/*
Widget Name: Show Campaigns
Description: Display campaigns in a multi-column grid, filterable by campaign categories.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Show_Campaigns_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-show-campaigns",
            __("Show Campaigns", "mo_theme"),
            array(
                "description" => __("Display campaigns in a multi-column grid, filterable by campaign categories", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),
            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", "mo_theme"),
                ),
                "number_of_columns" => array(
                    "type" => "slider",
                    "description" => __("Number of campaigns to display per row. ", "mo_theme"),
                    "label" => __("Number of columns", "mo_theme"),
                    "min" => 1,
                    "max" => 5,
                    "integer" => true,
                    "default" => 4,
                ),
                "post_count" => array(
                    "type" => "number",
                    "description" => __("Total number of campaigns to display.", "mo_theme"),
                    "label" => __("Post count", "mo_theme"),
                    "default" => 12,
                ),
                "image_size" => array(
                    "type" => "select",
                    "description" => __("The size of the image displayed for campaigns list.", "mo_theme"),
                    "label" => __("Image size", "mo_theme"),
                    "options" => array(
                        "thumbnail" => __("Thumbnail", "mo_theme"),
                        "medium" => __("Medium", "mo_theme"),
                        "medium-thumb" => __("Standard", "mo_theme"),
                        "square-thumb" => __("Square", "mo_theme"),
                        "large" => __("Large", "mo_theme"),
                        "full" => __("Full", "mo_theme"),
                    ),
                    "default" => "medium"
                ),
                "filterable" => array(
                    "type" => "checkbox",
                    "description" => __("The campaign items will be filterable based on campaign categories if checked.", "mo_theme"),
                    "label" => __("Filterable?", "mo_theme"),
                    "default" => true,
                ),
                "layout_mode" => array(
                    "type" => "select",
                    "description" => __("Layout mode for display of campaigns. ", "mo_theme"),
                    "label" => __("Layout Mode", "mo_theme"),
                    "options" => array(
                        "fitRows" => __("Fit Rows", "mo_theme"),
                        "masonry" => __("Masonry", "mo_theme"),
                    )
                ),
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "number_of_columns" => $instance["number_of_columns"],
            "post_count" => $instance["post_count"],
            "image_size" => $instance["image_size"],
            "filterable" => $instance["filterable"],
            "layout_mode" => $instance["layout_mode"],
        );
    }

}
siteorigin_widget_register("mo-show-campaigns", __FILE__, "MO_Show_Campaigns_Widget");