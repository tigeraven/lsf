<?php

/*
Widget Name: Livemesh Piecharts
Description: Display one or more piecharts depicting a percentage value in a multi-column grid.
Author: LiveMesh
Author URI: http://portfoliotheme.org
*/

class LSOW_Piechart_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lsow-piecharts',
            __('Livemesh Piecharts', 'livemesh-so-widgets'),
            array(
                'description' => __('Display statistics or skills as a percentage piechart.', 'livemesh-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => 'http://portfoliotheme.org/widgets-bundle/piechart-widget-documentation/'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'livemesh-so-widgets'),
                ),

                'piecharts' => array(
                    'type' => 'repeater',
                    'label' => __('Piecharts', 'livemesh-so-widgets'),
                    'item_name' => __('Piechart', 'livemesh-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='piecharts-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'stats_title' => array(
                            'type' => 'text',
                            'label' => __('Stats Title', 'livemesh-so-widgets'),
                            'description' => __('The title for the piechart', 'livemesh-so-widgets'),
                        ),

                        'percentage' => array(
                            'type' => 'text',
                            'label' => __('Percentage Value', 'livemesh-so-widgets'),
                            'description' => __('The percentage value for the stats.', 'livemesh-so-widgets'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        'bar_color' => array(
                            'type' => 'color',
                            'label' => __('Bar color', 'livemesh-so-widgets'),
                            'default' => '#f94213'
                        ),

                        'track_color' => array(
                            'type' => 'color',
                            'label' => __('Track color', 'livemesh-so-widgets'),
                            'default' => '#dddddd'
                        ),

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __( 'Piecharts per row', 'livemesh-so-widgets' ),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),
                    )
                ),

            )
        );
    }

    function initialize() {

        $this->register_frontend_scripts(
            array(
                array(
                    'lsow-waypoints',
                    LSOW_PLUGIN_URL . 'assets/js/jquery.waypoints' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    LSOW_VERSION
                ),
                array(
                    'lsow-stats',
                    LSOW_PLUGIN_URL . 'assets/js/jquery.stats' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery'),
                    LSOW_VERSION
                ),
            )
        );


        $this->register_frontend_scripts(
            array(
                array(
                    'lsow-piecharts',
                    plugin_dir_url(__FILE__) . 'js/piechart' . SOW_BUNDLE_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
            array(
                'lsow-piecharts',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'piecharts' => !empty($instance['piecharts']) ? $instance['piecharts'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('lsow-piecharts', __FILE__, 'LSOW_Piechart_Widget');