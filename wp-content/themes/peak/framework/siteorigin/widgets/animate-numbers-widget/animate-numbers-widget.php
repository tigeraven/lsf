<?php

/*
Widget Name: Animate Numbers
Description: Animate from a starting value to a end number when the user scrolls to this section.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/


class MO_Animate_Numbers_Widget extends SiteOrigin_Widget {
    function __construct() {
        parent::__construct(
            "mo-animate-numbers",
            __("Animate Numbers", "mo_theme"),
            array(
                "description" => __("Animate from a starting value to a end number when the user scrolls to this section.", "mo_theme"),
                "panels_icon" => "dashicons dashicons-minus",
            ),
            array(),

            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", "mo_theme"),
                ),

                'animate_numbers' => array(
                    'type' => 'repeater',
                    'label' => __('Animating Numbers', 'mo_theme'),
                    'item_name' => __('Animating Number', 'mo_theme'),
                    'item_label' => array(
                        'selector' => "[id*='animate_numbers-stats_title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'stats_title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'mo_theme'),
                            'description' => __('The title for the stats', 'mo_theme'),
                        ),

                        'start_value' => array(
                            'type' => 'number',
                            'label' => __('Start Value', 'mo_theme'),
                            'description' => __('The start value for the stats.', 'mo_theme'),
                            "default" => 87,
                        ),

                        'stop_value' => array(
                            'type' => 'number',
                            'label' => __('Stop Value', 'mo_theme'),
                            'description' => __('The stop value for the stats.', 'mo_theme'),
                            "default" => 2648,
                        ),

                        'icon' => array(
                            'type' => 'text',
                            'label' => __('Stats Icon', 'mo_theme'),
                            'description' => __('The font icon to be displayed for the statistic being displayed, chosen from the list of icons listed at <a href="http://portfoliotheme.org/wp-content/uploads/fusion-icons/demo.html" target="_blank">http://portfoliotheme.org/wp-content/uploads/fusion-icons/demo.html</a>.', 'mo_theme'),
                            "default" => 'icon-infinite'
                        ),

                        'prefix' => array(
                            'type' => 'text',
                            'label' => __('Prefix', 'mo_theme'),
                            'description' => __('The prefix string for the animate number stats. Examples include currency symbols like $ to indicate a monetary value.', 'mo_theme'),
                        ),

                        'suffix' => array(
                            'type' => 'text',
                            'label' => __('Suffix', 'mo_theme'),
                            'description' => __('The suffix string for the animate number stats. Examples include strings like hr for hours or m for million.', 'mo_theme'),
                        ),
                    )
                ),

            )
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'animate_numbers' => !empty($instance['animate_numbers']) ? $instance['animate_numbers'] : array(),
        );
    }

}
siteorigin_widget_register("mo-animate-numbers", __FILE__, "MO_Animate_Numbers_Widget");

