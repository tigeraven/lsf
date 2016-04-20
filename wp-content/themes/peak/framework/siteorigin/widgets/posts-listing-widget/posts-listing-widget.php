<?php

/*
Widget Name: Post Listing
Description: Display a simple list of most recent blog posts
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Post_Listing_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-post-listing",
            __("Post Listing", "mo_theme"),
            array(
                "description" => __("Display a list of most recent blog posts", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),
            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", "mo_theme"),
                ),
                "post_count" => array(
                    "type" => "number",
                    "description" => __("Number of posts to display", "mo_theme"),
                    "label" => __("Post count", "mo_theme"),
                    "default" => 4,
                ),
                "taxonomy" => array(
                    "type" => "select",
                    "description" => __("The taxonomy for the blog posts like category or post_tag. ", "mo_theme"),
                    "label" => __("Taxonomy", "mo_theme"),
                    "options" => array(
                        "category" => __("Category", "mo_theme"),
                        "post_tag" => __("Post Tags", "mo_theme"),
                    )
                ),
                "terms" => array(
                    "type" => "text",
                    "description" => __("Comma separated slugs for the terms related to taxonomy chosen above. ", "mo_theme"),
                    "label" => __("Terms", "mo_theme"),
                    "default" => "",
                ),
            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            "post_count" => $instance["post_count"],
            "taxonomy" => $instance["taxonomy"],
            "terms" => $instance["terms"],
        );
    }

}
siteorigin_widget_register("mo-post-listing", __FILE__, "MO_Post_Listing_Widget");

