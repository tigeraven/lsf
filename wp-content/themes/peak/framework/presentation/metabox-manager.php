<?php
/**
 * Custom Meta Boxes using Option Tree framework
 * @package Livemesh_Framework
 */

/**
 * Initialize the meta boxes.
 */
add_action('admin_init', 'mo_custom_meta_boxes');

if (!function_exists('mo_custom_meta_boxes')) {


    function mo_custom_meta_boxes() {

        mo_build_advanced_page_meta_boxes();

        mo_build_layout_option_meta_Boxes();

        mo_build_entry_header_metaboxes();

        mo_build_blog_meta_boxes();

        if (post_type_exists('portfolio'))
            mo_build_masonry_portfolio_meta_boxes();

    }
}

if (!function_exists('mo_build_layout_option_meta_Boxes')) {

    function mo_build_layout_option_meta_Boxes() {

        $post_layouts = mo_get_entry_layout_options();

        $layout_meta_box = array(
            'id' => 'mo_post_layout',
            'title' => 'Post Layout',
            'desc' => '',
            'pages' => array('post'),
            'context' => 'side',
            'priority' => 'default',
            'fields' => array(
                array(
                    'id' => 'mo_current_post_layout',
                    'label' => esc_html__('Current Post Layout', 'peak'),
                    'desc' => 'Choose the layout for the current post.',
                    'std' => '',
                    'type' => 'select',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => $post_layouts
                )
            )
        );

        ot_register_meta_box($layout_meta_box);

        $my_sidebars = mo_get_user_defined_sidebars();

        $sidebar_meta_box = array(
            'id' => 'mo_sidebar_options',
            'title' => 'Choose Custom Sidebar',
            'desc' => '',
            'pages' => array('post', 'page'),
            'context' => 'side',
            'priority' => 'default',
            'fields' => array(
                array(
                    'id' => 'mo_primary_sidebar_choice',
                    'label' => esc_html__('Custom Sidebar Choice', 'peak'),
                    'desc' => 'Custom sidebar for the post/page. <i>Useful if the post/page is not designated as full width.</i>',
                    'std' => '',
                    'type' => 'select',
                    'rows' => '',
                    'post_type' => '',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => $my_sidebars
                )
            )
        );

        ot_register_meta_box($sidebar_meta_box);
    }
}

if (!function_exists('mo_build_advanced_page_meta_boxes')) {

    function mo_build_advanced_page_meta_boxes() {

        $menu_array = array(array('value' => 'default',
            'label' => esc_html__('Default', 'peak'),
            'src' => ''
        ));

        $menu_items = get_terms('nav_menu', array('hide_empty' => true));
        foreach ($menu_items as $wp_menu) {
            $menu_array[] = array('value' => $wp_menu->slug,
                'label' => $wp_menu->name,
                'src' => ''
            );
        };

        $advanced_page_meta_box = array(
            'id' => 'mo_advanced_entry_options',
            'title' => 'Advanced Entry Options',
            'desc' => '',
            'pages' => array('post', 'page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_slider_choice',
                    'label' => esc_html__('Display Slider and Remove Title Header', 'peak'),
                    'desc' => 'Select your choice of Slider type to be shown in the top section of the page, replacing the default page/post title header for this page. This option is often used with full width page templates like Home Page or Composite Page, although one can choose to display sliders in any page.',
                    'std' => '',
                    'type' => 'select',
                    'section' => 'general_default',
                    'rows' => '',
                    'post_type' => 'page,post,portfolio',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => array(
                        array(
                            'value' => 'None',
                            'label' => 'None',
                            'src' => ''
                        ),
                        array(
                            'value' => 'Revolution',
                            'label' => 'Revolution Slider',
                            'src' => ''
                        ),
                        array(
                            'value' => 'FlexSlider',
                            'label' => 'FlexSlider',
                            'src' => ''
                        ),
                        array(
                            'value' => 'Nivo',
                            'label' => 'Nivo',
                            'src' => ''
                        )
                    ),
                ),
                array(
                    'id' => 'mo_revolution_slider_choice',
                    'label' => esc_html__('Revolution Slider Choice', 'peak'),
                    'desc' => 'If Revolution Slider type is chosen above, choose the instance of Revolution Slider to be displayed in the page/post/portfolio. <strong><i>The Revolution Slider plugin bundled with the theme must be installed and activated before you can choose the slider for display.</i></strong>',
                    'std' => '',
                    'type' => 'select',
                    'section' => 'general_default',
                    'rows' => '',
                    'post_type' => 'page,post,portfolio',
                    'taxonomy' => '',
                    'class' => '',
                    'choices' => mo_get_revolution_slider_options(),
                ),
                array(
                    'id' => 'mo_remove_title_header',
                    'label' => esc_html__('Remove Title Header', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'checkbox',
                    'post_type' => 'page',
                    'desc' => 'Do not display normal title headers for this entry (disables both custom or default headers specified in heading options below). Useful if normal headers with page/post title and description (or custom HTML) need to be replaced with custom content for a entry as is often the case for pages that use Composite Page template or Home Page template.',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => esc_html__('Yes', 'peak'),
                            'src' => ''
                        )
                    )
                ),
                array(
                    'id' => 'mo_custom_primary_navigation_menu',
                    'label' => esc_html__('Choose Custom Primary Navigation Menu', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'select',
                    'desc' => 'Choose the page specific header navigation menu created using tools in ' . mo_get_menu_admin_url() . '. Useful for one page/single page templates with multiple internal navigation links. Users can choose to any of the custom menu designed in that screen for this page. <br/>Leave "Default" selected to display any global WordPress Menu set by you in ' . mo_get_menu_admin_url() . '.',
                    'choices' => $menu_array
                )

            )
        );

        ot_register_meta_box($advanced_page_meta_box);
    }
}

if (!function_exists('mo_build_blog_meta_boxes')) {

    function mo_build_blog_meta_boxes() {
        $post_meta_box = array(
            'id' => 'mo_post_thumbnail_detail',
            'title' => esc_html__('Post Thumbnail Options', 'peak'),
            'desc' => '',
            'pages' => array('post'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(

                array(
                    'label' => esc_html__('Use Slider as Thumbnail', 'peak'),
                    'id' => 'mo_use_slider_thumbnail',
                    'type' => 'checkbox',
                    'desc' => 'Specify if slider will be used as a thumbnail instead of a featured image or a video.',
                    'choices' => array(
                        array(
                            'label' => esc_html__('Yes', 'peak'),
                            'value' => 'Yes'
                        )
                    ),
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),

                array(
                    'label' => esc_html__('Images for thumbnail slider', 'peak'),
                    'id' => 'post_slider',
                    'desc' => 'Specify the images to be used a slider thumbnails for the post',
                    'type' => 'list-item',
                    'class' => '',
                    'settings' => array(
                        array(
                            'id' => 'slider_image',
                            'label' => esc_html__('Image', 'peak'),
                            'desc' => '',
                            'std' => '',
                            'type' => 'upload',
                            'class' => '',
                            'choices' => array()
                        )
                    )
                )

            )
        );

        ot_register_meta_box($post_meta_box);
    }
}

if (!function_exists('mo_build_masonry_portfolio_meta_boxes')) {

    function mo_build_masonry_portfolio_meta_boxes() {
        $portfolio_meta_box = array(
            'id' => 'mo_masonry_portfolio_detail',
            'title' => esc_html__('Masonry Portfolio Options', 'peak'),
            'desc' => '',
            'pages' => array('portfolio'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'label' => esc_html__('Project Thumbnail Size', 'peak'),
                    'id' => 'mo_portfolio_thumbnail_column_size',
                    'type' => 'select',
                    'desc' => 'The number of columns the project thumbnail should occupy in the portfolio showcase with masonry layout.',
                    'choices' => array(
                        array(
                            'value' => 'default',
                            'label' => 'Default',
                            'src' => ''
                        ),
                        array(
                            'value' => '1',
                            'label' => '1 column',
                            'src' => ''
                        ),
                        array(
                            'value' => '2',
                            'label' => '2 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '3',
                            'label' => '3 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '4',
                            'label' => '4 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '5',
                            'label' => '5 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '6',
                            'label' => '6 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '7',
                            'label' => '7 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '8',
                            'label' => '8 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '9',
                            'label' => '9 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '10',
                            'label' => '10 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '11',
                            'label' => '11 Columns',
                            'src' => ''
                        ),
                        array(
                            'value' => '12',
                            'label' => '12 Columns',
                            'src' => ''
                        )
                    ),
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),

                array(
                    'id' => 'mo_portfolio_thumbnail',
                    'label' => esc_html__('Portfolio Thumbnail', 'peak'),
                    'std' => '',
                    'type' => 'upload',
                    'desc' => esc_html__('Specify the image to be used the thumbnail for the portfolio archive pages. The featured image is used for portfolio archives if this image is omitted. Useful when a custom sized image needs to be used for masonry layout.', 'peak')
                )

            )
        );

        ot_register_meta_box($portfolio_meta_box);
    }
}


if (!function_exists('mo_build_entry_header_metaboxes')) {

    function mo_build_entry_header_metaboxes() {
        $header_meta_box = array(
            'id' => 'mo_entry_header_options',
            'title' => esc_html__('Header Options', 'peak'),
            'desc' => '',
            'pages' => array('page', 'campaign'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_description',
                    'label' => esc_html__('Description', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'textarea',
                    'desc' => 'Enter the description of the page/post. Shown under the entry title.',
                    'rows' => '2'
                ),
                array(
                    'id' => 'mo_entry_title_background',
                    'label' => esc_html__('Entry Title Background', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'upload',
                    'desc' => 'Specify a background for your page/post title and description.'
                ),
                array(
                    'id' => 'mo_entry_title_height',
                    'label' => esc_html__('Page/Post Title Height', 'peak'),
                    'desc' => 'Specify the approximate height in pixel units that the entry title area for a page/post occupies along with the background. <br><br> Does not apply when custom heading content is specified. ',
                    'type' => 'text',
                    'std' => '',
                    'rows' => '',
                    'class' => ''
                ),
                array(
                    'id' => 'mo_disable_breadcrumbs_for_entry',
                    'label' => esc_html__('Disable Breadcrumbs on this Post/Page', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'checkbox',
                    'desc' => 'Disable Breadcrumbs on this Post/Page. Breadcrumbs can be a hindrance in many pages that showcase marketing content. Home pages and wide layout pages will have no breadcrumbs displayed.',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => esc_html__('Yes', 'peak'),
                            'src' => ''
                        )
                    )
                )
            )
        );

        ot_register_meta_box($header_meta_box);

        $custom_header_meta_box = array(
            'id' => 'mo_custom_entry_header_options',
            'title' => esc_html__('Custom Header Options', 'peak'),
            'desc' => '',
            'pages' => array('page'),
            'context' => 'normal',
            'priority' => 'high',
            'fields' => array(
                array(
                    'id' => 'mo_custom_heading_background',
                    'label' => esc_html__('Custom Heading Background', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'background',
                    'desc' => 'Specify a background for custom heading content that replaces the regular page/post title area. Spans maximum available width.'
                ),
                array(
                    'id' => 'mo_custom_heading_content',
                    'label' => esc_html__('Custom Heading Content', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'textarea',
                    'desc' => 'Enter custom heading content HTML markup that replaces the regular page/post title area. This can be any of these - image, a slider, a slogan, purchase/request quote button, an invitation to signup or any plain marketing material.<br><br>Shown under the logo area. Be aware of SEO implications and <strong>use heading tags appropriately</strong>.',
                    'rows' => '8'
                ),
                array(
                    'id' => 'mo_wide_heading_layout',
                    'label' => esc_html__('Custom Heading Content spans entire available width', 'peak'),
                    'desc' => '',
                    'std' => '',
                    'type' => 'checkbox',
                    'desc' => 'Make the heading content span the available width. While the background graphics or color spans entire available width for custom heading content, the HTML markup consisting of heading text and content is restricted to the 1140px grid in the center of the window. <br>Choosing this option will make the content span the max available width.<br><strong>Choose this option when when you want to go for a custom heading with maps or a wide slider like the revolution slider in the custom heading area</strong>.',
                    'choices' => array(
                        array(
                            'value' => 'Yes',
                            'label' => esc_html__('Yes', 'peak'),
                            'src' => ''
                        )
                    )
                )
            )
        );

        ot_register_meta_box($custom_header_meta_box);
    }
}


if (!function_exists('mo_get_user_defined_sidebars')) {
    function mo_get_user_defined_sidebars() {
        $my_sidebars = array(
            array(
                'label' => esc_html__('Default', 'peak'),
                'value' => 'default'
            )
        );

        $sidebar_list = mo_get_theme_option('mo_sidebar_list');

        if (!empty($sidebar_list)) {
            foreach ($sidebar_list as $sidebar_item) {
                $sidebar = array('label' => $sidebar_item['title'], 'value' => $sidebar_item['id']);
                $my_sidebars [] = $sidebar;
            }
        }

        return $my_sidebars;
    }
}

if (!function_exists('mo_get_menu_admin_url')) {
    function mo_get_menu_admin_url() {
        $menu_admin_url = home_url('/') . 'wp-admin/nav-menus.php';

        $menu_admin_url = '<a href="' . esc_url($menu_admin_url) . '" title="' . esc_html__('Appearances Menu Screen',
                'peak') . '">' . esc_html__('Appearances Menu Screen', 'peak') . '</a>';

        return $menu_admin_url;
    }
}