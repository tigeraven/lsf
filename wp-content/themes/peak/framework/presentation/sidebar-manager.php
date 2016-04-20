<?php

/**
 * Sidebar Manager - Manages all the sidebars for us.
 *
 *
 * @package Livemesh_Framework
 */

if (!class_exists('MO_SidebarManager')) {

    class MO_SidebarManager {

        protected static $instance;
        protected $sidebar_names = array();
        protected $sidebar_descriptions = array();
        protected $footer_sidebar_names = array();
        protected $footer_sidebar_descriptions = array();
        protected $sidenav_sidebar_names = array();
        protected $sidenav_sidebar_descriptions = array();

        /**
         * Constructor method for the MO_SidebarManager class.
         *

         */
        protected function __construct() {

        }

        /**
         * Constructor method for the MO_SidebarManager class.
         *

         */
        public static function getInstance() {
            if (!isset(self::$instance)) {
                // Check if this is at least PHP 5.3 version
                if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                    $class = get_called_class();
                    self::$instance = new $class;
                }
                else {
                    $c = __CLASS__;
                    self::$instance = new $c;
                }
            }
            return self::$instance;
        }

        /**
         * Prevent cloning of this singleton
         *

         */
        public function __clone() {
            trigger_error('Clone is not allowed.', E_USER_ERROR);
        }

        /**
         * Init method for the MO_Slider_Manager class.
         * Called during theme setup.
         *
         */
        function initialize() {

            $this->init_sidebars();

            add_action('widgets_init', array(
                &$this,
                'register_sidebars'
            ));
        }

        private function init_sidebars() {
            $this->sidebar_names = array(
                'primary-post' => esc_html__('Post Sidebar', 'peak'),
                'primary-blog' => esc_html__('Blog Sidebar', 'peak'),
                'primary-page' => esc_html__('Page Sidebar', 'peak'),
                'primary-portfolio' => esc_html__('Portfolio Sidebar', 'peak'),
                'primary-gallery' => esc_html__('Gallery Sidebar', 'peak'),
                'primary-campaign' => esc_html__('Campaign Sidebar', 'peak'),
                'primary-event' => esc_html__('Event Sidebar', 'peak'),
                'after-singular-post' => esc_html__('After Singular Post', 'peak'),
                'after-singular-page' => esc_html__('After Singular Page', 'peak'),
                'header' => esc_html__('Header Area', 'peak')
            );

            // Allow others to enhance sidebars
            $this->sidebar_names = apply_filters('mo_sidebar_names', $this->sidebar_names);

            $this->footer_sidebar_names = array(
                'footer1' => esc_html__('Footer Widget Area One', 'peak'),
                'footer2' => esc_html__('Footer Widget Area Two', 'peak'),
                'footer3' => esc_html__('Footer Widget Area Three', 'peak'),
                'footer4' => esc_html__('Footer Widget Area Four', 'peak'),
                'footer5' => esc_html__('Footer Widget Area Five', 'peak'),
                'footer6' => esc_html__('Footer Widget Area Six', 'peak')
            );

            $this->sidebar_descriptions = array(
                'primary-post' => esc_html__('Sidebar displayed in single post', 'peak'),
                'primary-blog' => esc_html__('Sidebar displayed in post archive pages', 'peak'),
                'primary-page' => esc_html__('Sidebar displayed in pages', 'peak'),
                'primary-portfolio' => esc_html__('Sidebar displayed in the Portfolio archive pages', 'peak'),
                'primary-gallery' => esc_html__('Sidebar displayed in the Gallery pages', 'peak'),
                'primary-campaign' => esc_html__('Sidebar displayed in the single Campaign pages', 'peak'),
                'primary-event' => esc_html__('Sidebar displayed in the single Event pages', 'peak'),
                'after-singular-post' => esc_html__('Widgets placed after the single post content', 'peak'),
                'after-singular-page' => esc_html__('Widgets placed after the single page content', 'peak'),
                'header' => esc_html__('Widget content in the Header area. Typically custom HTML, buttons, social icons etc.', 'peak')
            );

            $this->sidebar_descriptions = apply_filters('mo_sidebar_descriptions', $this->sidebar_descriptions);

            $this->footer_sidebar_descriptions = array(
                'footer1' => esc_html__('Column 1 of Footer Widget Area', 'peak'),
                'footer2' => esc_html__('Column 2 of Footer Widget Area', 'peak'),
                'footer3' => esc_html__('Column 3 of Footer Widget Area', 'peak'),
                'footer4' => esc_html__('Column 4 of Footer Widget Area', 'peak'),
                'footer5' => esc_html__('Column 5 of Footer Widget Area', 'peak'),
                'footer6' => esc_html__('Column 6 of Footer Widget Area', 'peak')
            );

        }

        /**
         * Registers new sidebars for the theme.
         *
         */
        function register_sidebars() {

            //register footer sidebars
            foreach ($this->sidebar_names as $id => $name) {
                $this->register_sidebar($id, $name, $this->sidebar_descriptions[$id]);
            }

            //register footer sidebars
            foreach ($this->footer_sidebar_names as $id => $name) {
                $this->register_sidebar($id, $name, $this->footer_sidebar_descriptions[$id]);
            }

            //register sidenav sidebars
            foreach ($this->sidenav_sidebar_names as $id => $name) {
                $this->register_sidebar($id, $name, $this->sidenav_sidebar_descriptions[$id]);
            }

            // Get the custom sidebars defined by the users
            $sidebar_list = mo_get_theme_option('mo_sidebar_list');
            if (!empty($sidebar_list)) {
                foreach ($sidebar_list as $sidebar_item) {
                    $this->register_sidebar($sidebar_item['id'], $sidebar_item['title']);
                }
            }


        }

        function get_sidebar_element_id($sidebar_id) {
            // Go for same styling for both posts and pages for now
            $element_id = preg_replace(array(
                '/-post/',
                '/-page/',
                '/-blog/'
            ), '', $sidebar_id);
            $element_id = 'sidebar-' . $element_id;

            return $element_id;
        }

        function display_sidebar($sidebar_id, $style_class = '') {
            if (is_active_sidebar($sidebar_id)) {

                echo '<div id="' . $this->get_sidebar_element_id($sidebar_id) . '" class="sidebar clearfix ' . esc_attr($style_class) . '">';

                dynamic_sidebar($sidebar_id);

                echo '</div>';
            }
        }

        /* Check if any one of the six footer sidebars is active */
        function is_nav_area_active($sidebar = 'footer') {
            $sidebar_active = false;
            $count = 1;
            while (!$sidebar_active && $count <= 6) {
                $sidebar_active = is_active_sidebar($sidebar . $count++);
            }
            return $sidebar_active;
        }

        function get_sidebar_id_suffix() {
            $suffix = 'blog'; // default

            if (is_tax('portfolio_category') || is_post_type_archive('portfolio') || mo_is_portfolio_page())
                $suffix = 'portfolio';
            elseif (is_tax('gallery_category') || is_post_type_archive('gallery_item') || mo_is_gallery_page())
                $suffix = 'gallery';
            elseif (is_singular( array('campaign')))
                $suffix = 'campaign';
            elseif (is_singular( array('tribe_events')) || is_post_type_archive('tribe_events'))
                $suffix = 'event';
            elseif (is_archive() || is_404() || is_search() || is_page_template('template-blog.php'))
                $suffix = 'blog';
            elseif (is_single())
                $suffix = 'post';
            elseif (is_page())
                $suffix = 'page';

            return apply_filters('mo_sidebar_id_suffix', $suffix);
        }

        function get_primary_sidebar_id() {

            $my_sidebar_id = get_post_meta(get_queried_object_id(), 'mo_primary_sidebar_choice', true);

            if (!empty($my_sidebar_id) && $my_sidebar_id !== 'default')
                return $my_sidebar_id;
            else
                return 'primary-' . $this->get_sidebar_id_suffix();
        }

        function populate_sidebars($post_id = NULL) {

            $layout_manager = mo_get_layout_manager();

            if ($layout_manager->is_full_width_layout())
                return;


            if ($layout_manager->is_left_navigation())
                echo '<div class="sidebar-left-nav threecol">';
            elseif ($layout_manager->is_right_navigation())
                echo '<div class="sidebar-right-nav threecol last">';

            $this->display_sidebar($this->get_primary_sidebar_id(), 'fullwidth');

            echo '</div><!-- end sidebar-nav -->';


        }

        function populate_nav_sidebars($sidebar_prefix = 'footer') {

            $sidebar_columns = mo_get_theme_option('mo_' . $sidebar_prefix . '_columns', 3);
            if (is_numeric($sidebar_columns)):
                $style_class = mo_get_column_style($sidebar_columns);

                for ($i = 1; $i <= $sidebar_columns; $i++) {
                    if ($i != $sidebar_columns) {
                        $this->display_sidebar($sidebar_prefix . $i, $style_class);
                    }
                    else {
                        $this->display_sidebar($sidebar_prefix . $i, $style_class . ' last');
                    }
                }
            else:
                switch ($sidebar_columns):
                    case '1 + 2(3c)':
                        ?>
                        <?php $this->display_sidebar($sidebar_prefix . 1, 'fourcol'); ?>
                        <div class="eightcol last">
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 4, 'fourcol last'); ?>
                        </div>
                        <?php
                        break;
                    case '2(3c) + 1':
                        ?>
                        <div class="eightcol">
                            <?php $this->display_sidebar($sidebar_prefix . 1, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'fourcol last'); ?>
                        </div>
                        <?php $this->display_sidebar($sidebar_prefix . 4, 'fourcol last'); ?>
                        <?php
                        break;
                    case '1 + 2(4c)':
                        ?>
                        <?php $this->display_sidebar($sidebar_prefix . 1, 'fourcol'); ?>
                        <div class="eightcol last">
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'threecol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'threecol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 4, 'threecol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 5, 'threecol last'); ?>
                        </div>
                        <?php
                        break;
                    case '2(4c) + 1':
                        ?>
                        <div class="eightcol">
                            <?php $this->display_sidebar($sidebar_prefix . 1, 'threecol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'threecol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'threecol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 4, 'threecol last'); ?>
                        </div>
                        <?php $this->display_sidebar($sidebar_prefix . 5, 'fourcol last'); ?>
                        <?php
                        break;
                    case '1 + 1(2c)':
                        ?>
                        <?php $this->display_sidebar($sidebar_prefix . 1, 'sixcol'); ?>
                        <div class="sixcol last">
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'sixcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'sixcol last'); ?>
                        </div>
                        <?php
                        break;
                    case '1 + 1(3c)':
                        ?>
                        <?php $this->display_sidebar($sidebar_prefix . 1, 'sixcol'); ?>
                        <div class="sixcol last">
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 4, 'fourcol last'); ?>
                        </div>
                        <?php
                        break;
                    case '1(2c) + 1':
                        ?>
                        <div class="sixcol">
                            <?php $this->display_sidebar($sidebar_prefix . 1, 'sixcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'sixcol last'); ?>
                        </div>
                        <?php $this->display_sidebar($sidebar_prefix . 3, 'sixcol last'); ?>
                        <?php
                        break;
                    case '1(3c) + 1':
                        ?>
                        <div class="sixcol">
                            <?php $this->display_sidebar($sidebar_prefix . 1, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 2, 'fourcol'); ?>
                            <?php $this->display_sidebar($sidebar_prefix . 3, 'fourcol last'); ?>
                        </div>
                        <?php $this->display_sidebar($sidebar_prefix . 4, 'sixcol last'); ?>
                        <?php
                        break;
                endswitch;
            endif;
        }

        /**
         * @param $id
         * @param $name
         */
        function register_sidebar($id, $name, $desc = '') {

            if (!empty($id)) {
                register_sidebar(array(
                    'id' => $id,
                    'name' => $name,
                    'description' => $desc,
                    'before_widget' => '<aside id="%1$s" class="widget %2$s widget-%2$s"><div class="widget-wrap widget-inside">',
                    'after_widget' => '</div></aside>',
                    'before_title' => '<h3 class="widget-title"><span>',
                    'after_title' => '</span></h3>'
                ));
            }

        }

    }
}

/* Avoid defining global functions here - for child theme sake */

?>