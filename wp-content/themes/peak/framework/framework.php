<?php

/**
 * Main class for the Livemesh theme framework which does the orchestration.
 *
 * @package Livemesh_Framework
 */
class MO_Framework {

    protected $theme_options;
    protected $theme_extender;
    protected $layout_manager;
    protected $sidebar_manager;
    protected $context;
    protected $image_sizes;

    /* Constructor for the class */

    function __construct() {

        $this->define_constants();

        $this->init_option_tree();

        $this->init_siteorigin_pagebuilder();

        add_action('after_setup_theme', array(
            &$this,
            'i18n'
        ), 8);

        add_action('after_setup_theme', array(
            &$this,
            'enable_theme_features'
        ), 9);

        add_action('after_setup_theme', array(
            &$this,
            'load_functions'
        ), 10);

        add_action('after_setup_theme', array(
            &$this,
            'setup_theme_functions'
        ), 11);

        add_action('init', array(
            &$this,
            'initialize_theme'
        ), 10);
    }

    function init_siteorigin_pagebuilder() {


        add_filter('siteorigin_widgets_widget_folders', array($this, 'add_widgets_collection'));

        add_filter('siteorigin_panels_widget_dialog_tabs', array($this, 'add_widget_tabs'), 20);

        add_filter('siteorigin_panels_widgets', array($this, 'add_bundle_groups'), 11);

        add_filter('siteorigin_panels_row_style_fields', array($this, 'row_style_fields'));

        add_filter('siteorigin_panels_row_style_attributes', array($this, 'row_style_attributes'), 10, 2);

        // Filtering specific attributes
        add_filter('siteorigin_panels_css_cell_margin_bottom', array($this, 'filter_cell_bottom_margin'), 10, 2);

        add_filter('siteorigin_widgets_default_active', array($this, 'activate_theme_widgets'));

    }

    function add_widgets_collection($folders) {
        $folders[] = MO_FRAMEWORK_DIR . '/siteorigin/widgets/';
        return $folders;
    }


    // Placing all widgets under the 'SiteOrigin Widgets' Tab
    function add_widget_tabs($tabs) {
        $tabs[] = array(
            'title' => __('Livemesh Theme Widgets', 'mo_theme'),
            'filter' => array(
                'groups' => array('livemesh-widgets')
            )
        );
        return $tabs;
    }


    // Adding group for all Widgets
    function add_bundle_groups($widgets) {
        foreach ($widgets as $class => &$widget) {
            if (preg_match('/MO_(.*)_Widget/', $class, $matches)) {
                $widget['groups'] = array('livemesh-widgets');
            }
        }
        return $widgets;
    }

    function row_style_fields($fields) {
        // Add the attribute fields

        $fields['row_id'] = array(
            'name' => __('Row ID for styling', 'mo_theme'),
            'type' => 'text',
            'group' => 'attributes',
            'description' => __('An ID for the row for styling purposes.', 'mo_theme'),
            'priority' => 4,
        );

        return $fields;
    }

    function row_style_attributes($attributes, $args) {

        // Do not set id if already set. Hope to get rid of this in future when page builder has this function
        if (!empty($args['row_id']) && empty($attributes['id'])) {
            $attributes['id'] = $args['row_id'];
        }

        return $attributes;
    }

    /* Set the bottom margin same as that specified for container row - typically 0px for all Livemesh themes content */
    function filter_cell_bottom_margin($margin, $grid) {
        if (!empty($grid['style']['bottom_margin'])) {
            $margin = $grid['style']['bottom_margin'];
        }
        return $margin;
    }



    function activate_theme_widgets($default_widgets) {

        $theme_widgets = array(

            "heading-widget" => true,
            "show-campaigns-widget" => true,
            "button-widget" => true,
            "vimeo-video-widget" => true,
            "action-call-widget" => true,
            "custom-posts-widget" => true,
            "posts-listing-widget" => true,
            "contact-form-widget" => true,
            "pricing-plans-widget" => true,
            "show-portfolio-widget" => true,
            "show-gallery-widget" => true,
            "social-list-widget" => true,
            "team-widget" => true,
            "toggle-widget" => true,
            "testimonials-slider-widget" => true,
            "piechart-widget" => true,
            "stats-bar-widget" => true,
            "animate-numbers-widget" => true,
            "responsive-slider-widget" => true,
            "responsive-carousel-widget" => true,
            "show-post-snippets-widget" => true,
            "device-slider-widget" => true,
            "tabs-widget" => true,
            "hero-section-widget" => true,

        );

        return wp_parse_args($theme_widgets, $default_widgets);

    }

    function init_option_tree() {
        /**
         * Option Tree Settings
         * Optional: set 'ot_show_pages' filter to false.
         * This will hide the settings & documentation pages.
         */
        add_filter('ot_show_pages', '__return_true');
        //add_filter('ot_show_pages', '__return_false');

        /**
         * Optional: set 'ot_show_new_layout' filter to false.
         * This will hide the "New Layout" section on the Theme Options page.
         */
        add_filter('ot_show_new_layout', '__return_true');

        /**
         * Required: set 'ot_theme_mode' filter to true.
         */
        add_filter('ot_theme_mode', '__return_true');

        /* Do not show the options import. The settings data import will be shown though. */
        add_filter('ot_show_settings_import', '__return_false');

        /* Do not show the options export. The settings data export will be shown though. */
        add_filter('ot_show_settings_export', '__return_false');

        /* Do not show documentation for option tree */
        add_filter('ot_show_docs', '__return_false');

        /* Do not show the options UI which enables users to define new options */
        add_filter('ot_show_options_ui', '__return_false');

        /*  Filter the HTML in textareas options to avoid scripts */
        add_filter('ot_allow_unfiltered_html', '__return_false');

        /* Make sure the page sections are ordered by menu order instead of title */
        add_filter('ot_type_custom_post_type_checkbox_query', array(
            &$this,
            'sort_page_section_selection_list'
        ), 10, 2);

        /*  Filter the HTML in textareas options to avoid malicious scripts */
        add_filter('ot_validate_setting', array(
            &$this,
            'validate_options_data'
        ), 10, 3);


        /**
         * Required: include OptionTree.
         */
        require_once(MO_FRAMEWORK_DIR . '/option-tree/ot-loader.php');


        /**
         * Theme Options - if file exists, loads the options
         */
        include_once(MO_FRAMEWORK_DIR . '/extensions/theme-options.php');

    }

    function validate_options_data($input, $type, $field_id) {

        if (in_array($type, array(
            'css',
            'javascript',
            'text',
            'textarea',
            'textarea-simple'
        ))
        ) {

            $input = wp_kses_post($input);
        }

        return $input;

    }

    function i18n() {

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain('peak', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once($locale_file);

    }


    /**
     * Define framework constants
     */
    function define_constants() {

        /* Sets the path to the parent theme directory. */
        define('MO_THEME_DIR', get_template_directory());

        /* Sets the path to the parent theme directory URI. */
        define('MO_THEME_URL', get_template_directory_uri());

        /* Sets the path to the core Livemesh Framework directory. */
        define('MO_FRAMEWORK_DIR', get_template_directory() . '/framework');

        /* Sets the path to the theme scripts directory. */
        define('MO_SCRIPTS_URL', MO_THEME_URL . '/js');

        /* Sets the path to the theme third party library scripts directory. */
        define('MO_SCRIPTS_LIB_URL', MO_THEME_URL . '/js/libs');

        /* Sets the path to the theme images directory. */
        define('MO_IMAGES_URL', MO_THEME_URL . '/images');
    }

    /**
     * All the context related functions. An extensible array of key value pairs
     */
    function has_context($context_key) {
        return (isset($this->context[$context_key]));
    }

    function set_context($context_key, $context_value) {
        $this->context[$context_key] = $context_value;
    }

    function get_context($context_key) {
        if ($this->has_context($context_key))
            return $this->context[$context_key];
        return false;
    }

    function get_image_sizes() {

        if (!isset($this->image_sizes)) {

            $this->image_sizes = array(
                'medium-thumb' => array(
                    550,
                    400
                ),
                'square-thumb' => array(
                    450,
                    450
                )
            );

        }
        return $this->image_sizes;
    }

    /**
     * Declare theme options global var for reuse everywhere - reduces db calls
     */
    function init_theme_options() {
        $this->theme_options = get_option('option_tree');
    }

    function get_theme_option($option, $default = null, $single = true) {
        /* Allow posts to override global options. Quite powerful. Use get_queried_object_id
        since we are interested in only the ID of current post/page being rendered. */
        $option_value = get_post_meta(get_queried_object_id(), $option, $single);

        if (!$option_value) {

            if (function_exists('ot_get_option')) {
                $option_value = ot_get_option($option, $default);
            }
            else {
                $option_value = get_option($option);
            }
        }

        if (isset($option_value))
            return $option_value;

        return $default;
    }

    /**
     * Include all the required functions
     *
     */
    function load_functions() {

        if (class_exists('woocommerce')) {
            require_once(MO_THEME_DIR . '/woocommerce/integrations.php');
            require_once(MO_THEME_DIR . '/woocommerce/cart.php');
            require_once(MO_THEME_DIR . '/woocommerce/sidebar.php');
        }

        /* Load the utility functions. */

        require_once(MO_FRAMEWORK_DIR . '/extensions/framework-extender.php');
        include_once(MO_FRAMEWORK_DIR . '/extensions/init-options.php');
        require_once(MO_FRAMEWORK_DIR . '/extensions/loop-pagination.php');
        include_once(MO_FRAMEWORK_DIR . '/extensions/aq_resizer.php');
        include_once(MO_FRAMEWORK_DIR . '/extensions/class-tgm-plugin-activation.php');
        /* The stylizer generates css based on options chosen by the user in theme options panel */
        include_once(MO_FRAMEWORK_DIR . '/extensions/skin.php');
        include_once(MO_FRAMEWORK_DIR . '/extensions/stylizer.php');

        require_once(MO_FRAMEWORK_DIR . '/functions/utility-functions.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/header-title-area.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/page-customization.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/campaign-functions.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/gallery-functions.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/portfolio-functions.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/post-functions.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/images-videos.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/commenting.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/thumbnail-functions.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/blog-content.php');
        require_once(MO_FRAMEWORK_DIR . '/functions/breadcrumbs.php');

        require_once(MO_FRAMEWORK_DIR . '/partials/sitemap.php');

        require_once(MO_FRAMEWORK_DIR . '/presentation/layout-manager.php');
        require_once(MO_FRAMEWORK_DIR . '/presentation/sidebar-manager.php');
        require_once(MO_FRAMEWORK_DIR . '/presentation/slider-manager.php');
        require_once(MO_FRAMEWORK_DIR . '/presentation/metabox-manager.php');


        $widgets_path = MO_FRAMEWORK_DIR . '/widgets/';

        require_once($widgets_path . 'mo-widget.php');

        include_once($widgets_path . 'mo-popular-posts-widget.php');
        include_once($widgets_path . 'mo-recent-posts-widget.php');
        include_once($widgets_path . 'mo-author-widget.php');
        include_once($widgets_path . 'mo-featured-posts-widget.php');
        include_once($widgets_path . 'mo-related-posts-widget.php');
        include_once($widgets_path . 'mo-social-networks-widget.php');
        include_once($widgets_path . 'mo-contact-info-widget.php');

        $shortcodes_path = MO_FRAMEWORK_DIR . '/shortcodes/';

        include_once($shortcodes_path . 'typography-shortcodes.php');
        include_once($shortcodes_path . 'video-shortcodes.php');
        include_once($shortcodes_path . 'column-shortcodes.php');
        include_once($shortcodes_path . 'divider-shortcodes.php');
        include_once($shortcodes_path . 'box-shortcodes.php');
        include_once($shortcodes_path . 'image-shortcodes.php');
        include_once($shortcodes_path . 'tabs-shortcodes.php');
        include_once($shortcodes_path . 'posts-shortcodes.php');
        include_once($shortcodes_path . 'button-shortcodes.php');
        include_once($shortcodes_path . 'contact-shortcodes.php');
        include_once($shortcodes_path . 'social-shortcodes.php');
        include_once($shortcodes_path . 'team-shortcodes.php');
        include_once($shortcodes_path . 'testimonials-shortcodes.php');
        include_once($shortcodes_path . 'pricing-shortcodes.php');
        include_once($shortcodes_path . 'protected-content-shortcodes.php');
        include_once($shortcodes_path . 'slider-shortcodes.php');
        include_once($shortcodes_path . 'miscellaneous-shortcodes.php');

    }

    function setup_theme_functions() {

        $this->init_theme_options();

        /* Initialize all the helper classes */
        $this->layout_manager = mo_get_layout_manager();
        $this->layout_manager->initialize();

        $this->slider_manager = mo_get_slider_manager();
        $this->slider_manager->initialize();

        $this->theme_extender = mo_get_framework_extender();
        $this->theme_extender->initialize();

        $this->sidebar_manager = mo_get_sidebar_manager();
        $this->sidebar_manager->initialize();

        $this->context = array(); // Will be set by pages

        $this->add_actions_filters();

        $this->remove_actions_filters();

        $this->setup_admin_features();

    }

    function initialize_theme() {

        $this->register_menus();

        $this->register_thumbs();

    }

    /**
     * Enable Admin Features.
     */
    function setup_admin_features() {

        /* Sets the path to the directory containing admin enhancements. */
        define('MO_ADMIN_DIR', get_template_directory() . '/framework/admin');

        if (is_admin()) {

            require_once(MO_ADMIN_DIR . '/page-admin.php');
            $page_section_admin = MO_Page_Admin::getInstance();
            $page_section_admin->initialize();

            require_once(MO_ADMIN_DIR . '/shortcodes/livemesh-shortcodes.php');
        }
    }

    /**
     * Enable Theme Features.
     *
     */
    function add_actions_filters() {

        /* Load all JS required by the theme */
        add_action('wp_enqueue_scripts', array(
            &$this,
            'enqueue_scripts'
        ));
        add_action('wp_enqueue_scripts', array(
            &$this,
            'enqueue_styles'
        ));

        add_action('wp_footer', array(
            &$this,
            'enqueue_additional_scripts'
        ));

        add_action('admin_enqueue_scripts', array(
            &$this,
            'admin_enqueue_scripts'
        ));
        add_action('admin_enqueue_scripts', array(
            &$this,
            'admin_enqueue_styles'
        ), 18);

        /* Register widgets. */
        add_action('widgets_init', array(
            &$this,
            'register_widgets'
        ), 11);

        /* Make text widgets and term descriptions shortcode aware. */
        add_filter('widget_text', 'do_shortcode');
        add_filter('term_description', 'do_shortcode');

        add_action('wp_enqueue_scripts', array(
            &$this,
            'enqueue_plugin_styles'
        ), 12); // load after all the plugins
        add_action('wp_enqueue_scripts', array(
            &$this,
            'enqueue_custom_styles'
        ), 12); // load skins and custom CSS after custom plugin styles

        add_action('wp_enqueue_scripts', array(
            &$this,
            'mo_init_custom_css'
        ), 15); // load as late as possible

        if (!function_exists('_wp_render_title_tag')) {
            add_action('wp_head', array(
                &$this,
                'theme_slug_render_title'
            ));
        }

        add_action('give_payment_receipt_after_table', array(
            &$this,
            'display_campaign_details'
        ), 10, 1);

        add_action('tribe_events_single_event_after_the_content', array(
            &$this,
            'display_campaign_for_event'
        ));

        if (is_admin())
            add_action('wp_ajax_update-page-section-order', array(
                &$this,
                'save_page_section_order'
            ));

    }

    /**
     * Remove Filters/Actions from plugins.
     *
     */
    function remove_actions_filters() {

        /* Prevent the Post Types Order plugin from overriding theme queries */
        remove_filter('posts_orderby', 'CPTOrderPosts', 99, 2);

    }

    function theme_slug_render_title() {
        ?>
        <title><?php wp_title('|', true, 'right'); ?></title>
        <?php
    }

    function save_page_section_order() {

        $post_id = $_POST['page_id'];

        $nonce = $_POST['security'];
        if (!wp_verify_nonce($nonce, 'page_section_' . $post_id))
            die('-1');

        $order = $_POST['order'];

        $page_sections = "";
        if (!empty($order)) {
            $order = wp_parse_args($order);
            $order = $order['section'];
            $page_sections = implode(',', array_values($order));
        }

        /* Update even if empty to indicate that no page sections were selected to empty the page section bin */
        update_post_meta($post_id, '_page_section_order_field', $page_sections);

    }

    /* Output css as per user customization from the options panel */

    function mo_init_custom_css() {

        $output = '';

        $custom_css = mo_custom_css();

        if ($custom_css <> '') {
            $output .= $custom_css . "\n";
        }

        // Output styles
        if ($output <> '') {
            wp_add_inline_style('mo-style-custom', $custom_css); // after custom.css file
        }

    }

    /**
     * Enable Theme Features.
     *
     */
    function enable_theme_features() {

        remove_theme_support('custom-background');
        remove_theme_support('custom-header');

        add_theme_support('header-social-links');
        add_theme_support('composite-page');

        add_theme_support('title-tag');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        add_theme_support('campaigns');

        add_theme_support('events');

        add_theme_support('woocommerce');

        /* Add support for excerpts and entry-views to the 'page' post type. */
        add_post_type_support('page', array('excerpt'));

    }

    /**
     * Registers new widgets for the theme.
     *
     */
    function register_widgets() {

        register_widget('MO_Popular_Posts_Widget');
        register_widget('MO_Recent_Posts_Widget');
        register_widget('MO_Author_Widget');
        register_widget('MO_Featured_Posts_Widget');
        register_widget('MO_Contact_Info_Widget');

        // YARPP is far more experienced and is recommended to use the same with the YARPP template provided
        //register_widget('MO_Related_Posts_Widget');

        register_widget('MO_Social_Networks_Widget');
    }

    /**
     * Registers new thumbnails for the theme.
     *
     */
    function register_thumbs() {

        $image_sizes = $this->get_image_sizes();

        foreach (array_keys($image_sizes) as $key) {
            add_image_size($key, $image_sizes[$key][0], $image_sizes[$key][1], true);
        }

    }

    /**
     * Registers new nav menus for the theme. By default, the framework registers the 'primary' menu only.
     *
     */
    function register_menus() {
        register_nav_menus(
            array(
                'primary' => esc_html__('Primary Menu', 'peak'),
                'side' => esc_html__('Side Menu', 'peak'),
                'footer' => esc_html__('Footer Menu', 'peak')
            )
        );
    }

    /* Overcome problems caused by late loading plugin scripts overriding the theme ones and destroying functionality */
    function enqueue_additional_scripts() {
        if (!is_admin()) {
            wp_enqueue_script('mo-jquery-waypoints-sticky', MO_SCRIPTS_LIB_URL . '/waypoints.sticky.min.js', array('jquery'), '2.0.2', true);
        }
    }

    /**
     * Load all the damned Javascript entries for the theme
     *
     */
    function enqueue_scripts() {

        if (!is_admin()) {

            $layoutManager = mo_get_layout_manager();

            wp_enqueue_script('mo-jquery-easing', MO_SCRIPTS_LIB_URL . '/jquery.easing.1.3.js', array('jquery'));
            wp_enqueue_script('mo-jquery-tools', MO_SCRIPTS_LIB_URL . '/jquery.tools.min.js', array('jquery'), '1.2.7', true);
            wp_enqueue_script('mo-drop-downs', MO_SCRIPTS_LIB_URL . '/drop-downs.js', array('jquery'), '1.4.8', true);
            wp_enqueue_script('mo-jquery-waypoint', MO_SCRIPTS_LIB_URL . '/waypoints.js', array('jquery'), '2.0.2', true);
            wp_enqueue_script('mo-jquery-plugins-lib', MO_SCRIPTS_LIB_URL . '/jquery.plugins.lib.js', array('mo-jquery-easing'), '1.0', true);
            wp_enqueue_script('mo-jquery-skrollr', MO_SCRIPTS_LIB_URL . '/skrollr.min.js', array('jquery'), '1.0', true);
            wp_enqueue_script('mo-jquery-modernizr', MO_SCRIPTS_LIB_URL . '/modernizr.js', array('jquery'), '2.7.1', true);
            /* Slider packs */
            wp_enqueue_script('mo-jquery-flexslider', MO_SCRIPTS_LIB_URL . '/jquery.flexslider.js', array('mo-jquery-easing'), '1.2', true);
            wp_enqueue_script('mo-jquery-owl-carousel', MO_SCRIPTS_LIB_URL . '/owl.carousel.min.js', array('mo-jquery-easing'), '4.1', true);


            $slider_type = get_post_meta(get_the_ID(), 'mo_slider_choice', true);
            if (!empty($slider_type) && $slider_type == 'Nivo')
                wp_enqueue_script('mo-nivo-slider', MO_SCRIPTS_LIB_URL . '/jquery.nivo.slider.pack.js', array('jquery'), '3.2', false);


            wp_enqueue_script('mo-jquery-validate', MO_SCRIPTS_LIB_URL . '/jquery.validate.min.js', array('jquery'), '1.9.0', true);
            wp_enqueue_script('mo-jquery-ytpplayer', MO_SCRIPTS_LIB_URL . '/jquery.mb.YTPlayer.js', array('jquery'), '1.0', true);
            wp_enqueue_script('mo-jquery-magnific-popup', MO_SCRIPTS_LIB_URL . '/jquery.magnific-popup.min.js', array('jquery'), '1.0.0', true);


            wp_enqueue_script('mo-jquery-isotope', MO_SCRIPTS_LIB_URL . '/isotope.js', array('jquery'), '1.5.19', true);

            $ajax_portfolio = mo_get_theme_option('mo_ajax_portfolio');
            $ajax_gallery = mo_get_theme_option('mo_ajax_gallery');
            if (($layoutManager->is_portfolio_template() && $ajax_portfolio) || ($layoutManager->is_gallery_template() && $ajax_gallery))
                wp_enqueue_script('mo-jquery-infinitescroll', MO_SCRIPTS_LIB_URL . '/jquery.infinitescroll.min.js', array('jquery'), '2.0', true);

            if (is_singular())
                wp_enqueue_script("comment-reply");

            wp_enqueue_script('mo-slider-js', MO_SCRIPTS_URL . '/slider.js', array('jquery'), '1.0', true);
            wp_enqueue_script('mo-theme-js', MO_SCRIPTS_URL . '/main.js', array('jquery'), '1.0', true);

            $localized_array = array(
                'name_required' => esc_html__('Please provide your name', 'peak'),
                'name_format' => esc_html__('Your name must consist of at least 5 characters', 'peak'),
                'email_required' => esc_html__('Please provide a valid email address', 'peak'),
                'url_required' => esc_html__('Please provide a valid URL', 'peak'),
                'phone_required' => esc_html__('Minimum 5 characters required', 'peak'),
                'message_required' => esc_html__('Please input the message', 'peak'),
                'message_format' => esc_html__('Your message must be at least 15 characters long', 'peak'),
                'success_message' => esc_html__('Your message has been sent. Thanks!', 'peak')
            );

            $localized_array['blog_url'] = esc_url(home_url('/'));

            $localized_array['loading_portfolio'] = esc_html__('Loading the next set of posts...', 'peak');
            $localized_array['finished_loading'] = esc_html__('No more items to load...', 'peak');

            $localized_array['close_form'] = esc_html__('Close Form', 'peak');
            $localized_array['donate_now'] = esc_html__('Donate Now', 'peak');

            /* localized script attached to theme */
            wp_localize_script('mo-theme-js', 'peak', $localized_array);

        }
    }

    function admin_enqueue_scripts($hook) {

        if (($hook == 'post.php') || ($hook == 'post-new.php') || ($hook == 'page.php') || ($hook == 'page-new.php')) {
            wp_enqueue_script('mo-admin-js', MO_SCRIPTS_URL . '/admin.js', array(
                'jquery-ui-sortable',
                'jquery-ui-draggable',
                'jquery-ui-droppable'
            ), '1.0', true);
        }

        if ($hook == 'appearance_page_ot-theme-options') {
            wp_enqueue_script('mo-itoggle-js', MO_SCRIPTS_URL . '/libs/jquery.simplecheckbox.js');
        }
    }

    function admin_enqueue_styles() {
        /* Register Style */
        wp_register_style('mo-admin-css', MO_THEME_URL . '/css/admin.css');
        wp_register_style('ot-custom-style', MO_THEME_URL . '/css/ot-custom-style.css', array('ot-admin-css'));

        /* Enqueue Style */
        wp_enqueue_style('ot-custom-style');
        wp_enqueue_style('mo-admin-css');

        add_editor_style('css/custom-editor-style.css');
    }

    function enqueue_styles() {

        wp_register_style('mo-animate', MO_THEME_URL . '/css/animate.css', array(), false, 'screen');
        wp_register_style('mo-icon-fonts', MO_THEME_URL . '/css/icon-fonts.css', array(), false, 'screen');

        wp_register_style('mo-style-theme', get_stylesheet_uri(), array(
            'mo-icon-fonts'
        ), false, 'all');

        wp_register_style('mo-style-ie8', MO_THEME_URL . '/css/ie8.css', array('mo-style-theme'), false, 'screen');
        $GLOBALS['wp_styles']->add_data('mo-style-ie8', 'conditional', 'IE 8');
        wp_enqueue_style('mo-style-ie8');

        wp_register_style('mo-style-ie9', MO_THEME_URL . '/css/ie9.css', array('mo-style-theme'), false, 'screen');
        $GLOBALS['wp_styles']->add_data('mo-style-ie9', 'conditional', 'IE 9');
        wp_enqueue_style('mo-style-ie9');

        wp_register_style('mo-style-html5', MO_THEME_URL . '/js/libs/html5.js', array('mo-style-elements'), false, 'screen');
        $GLOBALS['wp_styles']->add_data('mo-style-html5', 'conditional', 'IE 8');
        wp_enqueue_style('mo-style-html5');

        /* Enqueue all registered styles */
        wp_enqueue_style('mo-animate');
        wp_enqueue_style('mo-style-theme');

    }


    function enqueue_plugin_styles() {
        wp_register_style('mo-style-plugins', MO_THEME_URL . '/css/plugins.css', array('mo-style-theme'), false, 'all');

        wp_enqueue_style('mo-style-plugins'); // load the plugins css in the footer
    }

    function enqueue_custom_styles() {
        /* The theme Custom CSS file for overriding css in a safe way - comes after skin CSS has loaded */
        wp_register_style('mo-style-custom', MO_THEME_URL . '/custom/custom.css', array('mo-style-plugins'), false, 'all');

        wp_enqueue_style('mo-style-custom');
    }

    function sort_page_section_selection_list($query_params, $field_id) {
        if ($field_id === 'mo_page_section_select_for_one_page') {
            $query_params['orderby'] = 'menu_order';
        }
        return $query_params;
    }

    function display_campaign_for_event() {

        $campaign_id = get_post_meta(get_the_ID(), '_lm_campaign_event', true);

        if (!empty($campaign_id)):

            echo '<div class="campaign-link">';

            echo esc_html__('This event is part of campaign - ', 'peak') . '<a href="' . get_permalink($campaign_id) . '" title="' . get_the_title($campaign_id) . '">' . get_the_title($campaign_id) . '</a>';

            echo '</div>';

        endif;
    }

    function display_campaign_details($payment) {

        $archive_url = mo_get_post_type_archive_url('campaign');

        if (!empty($archive_url)):

            echo '<div class="campaigns-link">';

            echo do_shortcode('[read_more text="' . esc_html__('Back to All Campaigns', 'peak') . '" title="' . esc_html__('All Campaigns', 'peak') . '" href="' . esc_url($archive_url) . '"]');

            echo '</div>';

        endif;

    }

}