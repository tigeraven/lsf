<?php

if (!function_exists('lm_register_custom_post_types')) {
    function lm_register_custom_post_types() {

        lm_register_portfolio_type();

        lm_register_gallery_type();

        lm_register_page_section_type();

        lm_register_showcase_slide_type();

        lm_register_team_profile_post_type();

        lm_register_testimonials_post_type();

        lm_register_pricing_post_type();

        if (current_theme_supports('campaigns')) {
            lm_register_campaign_post_type();
        }

    }
}

if (!function_exists('lm_register_testimonials_post_type')) {
    function lm_register_testimonials_post_type() {
        $labels = array(
            'name' => esc_html_x('Testimonials', 'post type general name', 'lm-tools'),
            'singular_name' => esc_html_x('Testimonial', 'post type singular name', 'lm-tools'),
            'menu_name' => esc_html_x('Testimonials', 'post type menu name', 'lm-tools'),
            'add_new' => esc_html_x("Add New", "testimonial item", 'lm-tools'),
            'add_new_item' => __('Add New Testimonial', 'lm-tools'),
            'edit_item' => __('Edit Testimonial', 'lm-tools'),
            'new_item' => __('New Testimonial', 'lm-tools'),
            'view_item' => __('View Testimonial', 'lm-tools'),
            'search_items' => __('Search Testimonials', 'lm-tools'),
            'not_found' => __('No Testimonials found', 'lm-tools'),
            'not_found_in_trash' => __('No Testimonials in the trash', 'lm-tools'),
            'parent_item_colon' => '',
        );

        register_post_type('testimonials', array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => LM_URI . '/assets/images/admin/balloon-quotation.png',
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
        ));
    }
}

if (!function_exists('lm_register_pricing_post_type')) {
    function lm_register_pricing_post_type() {
        $labels = array(
            'name' => esc_html_x('Pricing Plans', 'post type general name', 'lm-tools'),
            'singular_name' => esc_html_x('Pricing Plan', 'post type singular name', 'lm-tools'),
            'menu_name' => esc_html_x('Pricing Plan', 'post type menu name', 'lm-tools'),
            'add_new' => esc_html_x('Add New', 'pricing plan item', 'lm-tools'),
            'add_new_item' => __('Add New Pricing Plan', 'lm-tools'),
            'edit_item' => __('Edit Pricing Plan', 'lm-tools'),
            'new_item' => __('New Pricing Plan', 'lm-tools'),
            'view_item' => __('View Pricing Plan', 'lm-tools'),
            'search_items' => __('Search Pricing Plans', 'lm-tools'),
            'not_found' => __('No Pricing Plans found', 'lm-tools'),
            'not_found_in_trash' => __('No Pricing Plans in the trash', 'lm-tools'),
            'parent_item_colon' => ''
        );

        register_post_type('pricing', array(
            'labels' => $labels,
            'public' => false,
            'publicly_queryable' => false,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => false,
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => LM_URI . '/assets/images/admin/price-tag.png',
            'supports' => array('title', 'editor', 'page-attributes')
        ));
    }
}

if (!function_exists('lm_register_team_profile_post_type')) {
    function lm_register_team_profile_post_type() {
        // Labels
        $labels = array(
            'name' => esc_html_x("Team", "post type general name", 'lm-tools'),
            'singular_name' => esc_html_x("Team", "post type singular name", 'lm-tools'),
            'menu_name' => esc_html_x('Team Profiles', 'post type menu name', 'lm-tools'),
            'add_new' => esc_html_x("Add New", "team item", 'lm-tools'),
            'add_new_item' => __("Add New Profile", 'lm-tools'),
            'edit_item' => __("Edit Profile", 'lm-tools'),
            'new_item' => __("New Profile", 'lm-tools'),
            'view_item' => __("View Profile", 'lm-tools'),
            'search_items' => __("Search Profiles", 'lm-tools'),
            'not_found' => __("No Profiles Found", 'lm-tools'),
            'not_found_in_trash' => __("No Profiles Found in Trash", 'lm-tools'),
            'parent_item_colon' => ''
        );

        // Register post type
        register_post_type('team', array(
            'labels' => $labels,
            'public' => false,
            'show_ui' => true,
            'hierarchical' => false,
            'publicly_queryable' => false,
            'query_var' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'menu_position' => 20,
            'has_archive' => false,
            'menu_icon' => LM_URI . '/assets/images/admin/users.png',
            'rewrite' => false,
            'supports' => array('title', 'editor', 'thumbnail', 'page-attributes')
        ));

        // Labels
        $labels = array(
            'name' => esc_html_x('Departments', "taxonomy general name", 'lm-tools'),
            'singular_name' => esc_html_x('Department', "taxonomy singular name", 'lm-tools'),
            'search_items' => __("Search Department", 'lm-tools'),
            'all_items' => __("All Departments", 'lm-tools'),
            'parent_item' => __("Parent Department", 'lm-tools'),
            'parent_item_colon' => __("Parent Department:", 'lm-tools'),
            'edit_item' => __("Edit Department", 'lm-tools'),
            'update_item' => __("Update Department", 'lm-tools'),
            'add_new_item' => __("Add New Department", 'lm-tools'),
            'new_item_name' => __("New Department Name", 'lm-tools'),
        );

        // Register and attach to 'team' post type
        register_taxonomy('department', 'team', array(
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'hierarchical' => true,
            'query_var' => true,
            'rewrite' => false,
            'labels' => $labels
        ));
    }

}

if (!function_exists('lm_register_portfolio_type')) {
    function lm_register_portfolio_type() {

        $labels = array(
            'name' => esc_html_x('Portfolio', 'portfolio name', 'lm-tools'),
            'singular_name' => esc_html_x('Portfolio Entry', 'portfolio type singular name', 'lm-tools'),
            'menu_name' => esc_html_x('Portfolio', 'portfolio type menu name', 'lm-tools'),
            'add_new' => esc_html_x('Add New', 'portfolio item', 'lm-tools'),
            'add_new_item' => __('Add New Portfolio Entry', 'lm-tools'),
            'edit_item' => __('Edit Portfolio Entry', 'lm-tools'),
            'new_item' => __('New Portfolio Entry', 'lm-tools'),
            'view_item' => __('View Portfolio Entry', 'lm-tools'),
            'search_items' => __('Search Portfolio Entries', 'lm-tools'),
            'not_found' => __('No Portfolio Entries Found', 'lm-tools'),
            'not_found_in_trash' => __('No Portfolio Entries Found in Trash', 'lm-tools'),
            'parent_item_colon' => ''
        );

        register_post_type('portfolio', array('labels' => $labels,

                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'portfolio'),
                'taxonomies' => array('portfolio_category'),
                'show_in_nav_menus' => true,
                'menu_position' => 20,
                'menu_icon' => LM_URI . '/assets/images/admin/portfolio.png',
                'supports' => array('title', 'editor', 'thumbnail', 'comments', 'excerpt', 'custom-fields')
            )
        );

        register_taxonomy('portfolio_category', array('portfolio'), array('hierarchical' => true,
            'label' => __('Portfolio Categories', 'lm-tools'),
            'singular_label' => __('Portfolio Category', 'lm-tools'),
            'rewrite' => true,
            'query_var' => true
        ));
    }
}

if (!function_exists('lm_register_gallery_type')) {
    function lm_register_gallery_type() {

        $labels = array(
            'name' => esc_html_x('Gallery', 'gallery name', 'lm-tools'),
            'singular_name' => esc_html_x('Gallery Entry', 'gallery type singular name', 'lm-tools'),
            'menu_name' => esc_html_x('Gallery', 'gallery type menu name', 'lm-tools'),
            'add_new' => esc_html_x('Add New', 'gallery', 'lm-tools'),
            'add_new_item' => __('Add New Gallery Entry', 'lm-tools'),
            'edit_item' => __('Edit Gallery Entry', 'lm-tools'),
            'new_item' => __('New Gallery Entry', 'lm-tools'),
            'view_item' => __('View Gallery Entry', 'lm-tools'),
            'search_items' => __('Search Gallery Entries', 'lm-tools'),
            'not_found' => __('No Gallery Entries Found', 'lm-tools'),
            'not_found_in_trash' => __('No Gallery Entries Found in Trash', 'lm-tools'),
            'parent_item_colon' => ''
        );

        register_post_type('gallery_item', array('labels' => $labels,

                'public' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => true,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'gallery'),
                'taxonomies' => array('gallery_category'),
                'show_in_nav_menus' => false,
                'menu_position' => 20,
                'menu_icon' => LM_URI . '/assets/images/admin/portfolio.png',
                'supports' => array('title', 'thumbnail', 'excerpt')
            )
        );

        register_taxonomy('gallery_category', array('gallery_item'), array('hierarchical' => true,
            'label' => __('Gallery Categories', 'lm-tools'),
            'singular_label' => __('Gallery Category', 'lm-tools'),
            'rewrite' => true,
            'query_var' => true
        ));
    }

}

if (!function_exists('lm_register_page_section_type')) {
    function lm_register_page_section_type() {

        $labels = array(
            'name' => esc_html_x('Page Section', 'page section general name', 'lm-tools'),
            'singular_name' => esc_html_x('Page Section', 'page section singular name', 'lm-tools'),
            'menu_name' => esc_html_x('Page Sections', 'post type menu name', 'lm-tools'),
            'add_new' => esc_html_x('Add New', 'page ', 'lm-tools'),
            'add_new_item' => __('Add New Page Section', 'lm-tools'),
            'edit_item' => __('Edit Page Section', 'lm-tools'),
            'new_item' => __('New Page Section', 'lm-tools'),
            'view_item' => __('View Page Section', 'lm-tools'),
            'search_items' => __('Search Page Sections', 'lm-tools'),
            'not_found' => __('No Page Sections Found', 'lm-tools'),
            'not_found_in_trash' => __('No Page Sections Found in Trash', 'lm-tools'),
            'parent_item_colon' => ''
        );

        register_post_type('page_section', array('labels' => $labels,
                'description' => __('A custom post type which represents a section like about, work, services, team etc. part of a typical single page site. Can be made up of one or more segments.', 'lm-tools'),
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'page',
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => true,
                'show_in_nav_menus' => false,
                'menu_position' => 15,
                'menu_icon' => LM_URI . '/assets/images/admin/blogs-stack.png',
                'rewrite' => array('slug' => 'page-section'),
                'supports' => array('title', 'editor', 'page-attributes', 'revisions')
            )
        );

    }
}

if (!function_exists('lm_register_showcase_slide_type')) {
    function lm_register_showcase_slide_type() {
        register_post_type('showcase_slide', array(
            'labels' => array(
                'name' => __('Showcase Slides', 'lm-tools'),
                'singular_name' => __('Showcase Slide', 'post type singular name', 'lm-tools'),
                'menu_name' => esc_html_x('Showcase Slides', 'post type menu name', 'lm-tools'),
                'add_new' => esc_html_x('Add New', 'showcase slide item', 'lm-tools'),
                'add_new_item' => __('Add New Slide', 'lm-tools'),
                'edit_item' => __('Edit Slide', 'lm-tools'),
                'new_item' => __('New Slide', 'lm-tools'),
                'view_item' => __('View Slide', 'lm-tools'),
                'search_items' => __('Search Slides', 'lm-tools'),
                'not_found' => __('No Slides Found', 'lm-tools'),
                'not_found_in_trash' => __('No Slides Found in Trash', 'lm-tools'),
                'parent_item_colon' => ''
            ),
            'description' => __('A custom post type which has the required information to display showcase slides in a slider', 'lm-tools'),
            'public' => false,
            'show_ui' => true,
            'publicly_queryable' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'exclude_from_search' => true,
            'menu_position' => 20,
            'menu_icon' => LM_URI . '/assets/images/admin/slides-stack.png',
            'supports' => array('title', 'thumbnail', 'page-attributes')
        ));
    }
}

if (!function_exists('lm_register_campaign_post_type')) {
    function lm_register_campaign_post_type() {

        $labels = array(
            'name' => esc_html_x('Campaign', 'campaign name', 'lm-tools'),
            'singular_name' => esc_html_x('Campaign Entry', 'campaign type singular name', 'lm-tools'),
            'menu_name' => esc_html_x('Campaigns', 'campaign type menu name', 'lm-tools'),
            'add_new' => esc_html_x('Add New', 'campaign item', 'lm-tools'),
            'add_new_item' => __('Add New Campaign Entry', 'lm-tools'),
            'edit_item' => __('Edit Campaign Entry', 'lm-tools'),
            'new_item' => __('New Campaign Entry', 'lm-tools'),
            'view_item' => __('View Campaign Entry', 'lm-tools'),
            'search_items' => __('Search Campaign Entries', 'lm-tools'),
            'not_found' => __('No Campaign Entries Found', 'lm-tools'),
            'not_found_in_trash' => __('No Campaign Entries Found in Trash', 'lm-tools'),
            'parent_item_colon' => ''
        );

        register_post_type('campaign', array('labels' => $labels,

                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'capability_type' => 'post',
                'has_archive' => false,
                'hierarchical' => false,
                'publicly_queryable' => true,
                'query_var' => true,
                'exclude_from_search' => false,
                'rewrite' => array('slug' => 'campaign'),
                'taxonomies' => array('campaign_category'),
                'show_in_nav_menus' => true,
                'supports' => array('title', 'editor', 'thumbnail', 'comments', 'excerpt', 'custom-fields')
            )
        );

        register_taxonomy('campaign_category', array('campaign'), array('hierarchical' => true,
            'label' => __('Campaign Categories', 'lm-tools'),
            'singular_label' => __('Campaign Category', 'lm-tools'),
            'rewrite' => true,
            'query_var' => true
        ));
    }
}
