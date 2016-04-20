<?php
/*
 * Use Wordpress Post Thumbnail and Aqua Resizer to resize Get_The_Image thumbnails
 *
 * @package Livemesh_Framework
 *
*/

if (!function_exists('mo_get_image_element')) {
    function mo_get_image_element($src, $image_size, $css_class, $title = '') {
        //image_size can be an array with height and width key value pairs or a string
        if (!empty($image_size)) {

            $width = $image_size['width'];
            $height = $image_size['height'];


            $image_url = aq_resize($src, $width, $height, true, true, true); //resize & crop the image
        }
        else {
            $image_url = $src; // retain the original image if no size is specified
        }

        $output = '<img alt="' . esc_attr($title) . '" class="' . esc_attr($css_class) . '" src="' . esc_url($image_url) . '" />';

        return $output;
    }
}

if (!function_exists('mo_show_image_info')) {

    /* Return false to disable image info on hover */
    function mo_show_image_info($context) {

        if ($context == 'portfolio') {
            $enable_hover = mo_get_theme_option('mo_disable_portfolio_hover') ? false : true;
            return $enable_hover;
        }

        if ($context == 'gallery_item') {
            $enable_hover = mo_get_theme_option('mo_disable_gallery_hover') ? false : true;
            return $enable_hover;
        }

        if ($context == 'campaign') {
            $enable_hover = mo_get_theme_option('mo_disable_campaign_hover') ? false : true;
            return $enable_hover;
        }

        return ($context == 'archive' || $context == 'custom');

    }
}

if (!function_exists('mo_thumbnail')) {
    function mo_thumbnail($args) {

        $thumbnail_element = mo_get_thumbnail($args);

        if (!empty($thumbnail_element)) {
            echo balanceTags($thumbnail_element);
            return true;
        }

        return false;
    }
}

if (!function_exists('mo_get_thumbnail')) {

    function mo_get_thumbnail($args) {
        global $mo_theme;

        $context = $mo_theme->get_context('loop');

        $defaults = array(
            'wrapper' => true,
            'show_image_info' => false,
            'before_html' => '',
            'after_html' => '',
            'image_class' => 'thumbnail',
            'image_alt' => '',
            'image_title' => '',
            'image_size' => '',
            'taxonomy' => 'category',
            // WordPress handles image caching for you.
        );
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        $output = '';

        //image_size can be an array with height and width key value pairs or a string
        $thumbnail_urls = mo_get_thumbnail_urls($args);

        //create the thumbnail
        if (!empty($thumbnail_urls)) {

            $thumbnail_src = esc_url($thumbnail_urls[0]);
            $thumbnail_element = $thumbnail_urls[1];

            if (empty($post_id))
                $post_id = get_the_ID();

            $post_title = get_the_title($post_id);
            $post_link = get_permalink($post_id);
            $post_type = get_post_type($post_id);
            $rel_attribute = ' data-gal="' . esc_attr($context) . '" ';

            if ($post_type === 'gallery_item') {
                // Make the anchor to gallery thumbnail point to the image directly
                $before_html = '<a title="' . esc_attr($post_title) . '" href="' . esc_url($thumbnail_src) . ' ">';
                $after_html = '</a>' . $after_html;
                if ($wrapper) {
                    $wrapper_html = '<div class="image-area">';
                    $before_html = $wrapper_html . $before_html;
                    if (mo_show_image_info($context) || $show_image_info) {
                        $image_info = '<div class="image-info">';
                        $image_info .= '<span class="image-info-buttons">'; // Make this part of the link itself
                        $image_info .= '<a class="lightbox-link" ' . esc_attr($rel_attribute) . 'title="' . esc_attr($post_title) . '" href="' . esc_url($thumbnail_src) . ' "><i class="lightbox icon-maximize"></i></a>';
                        $image_info .= '</span>';
                        $image_info .= '<div class="entry-info">';
                        $image_info .= '<h3 class="post-title">' . esc_html($post_title) . '</h3>'; // do not link to post for gallery
                        $image_info .= mo_get_taxonomy_info($taxonomy);
                        $image_info .= '</div>';
                        $image_info .= '</div>';

                        $after_html .= $image_info;
                        $after_html .= '<div class="image-overlay"></div>';
                    }
                    $after_html .= '</div>'; // end of image-area
                }
            }
            else {
                if (empty($before_html)) {
                    $before_html = '<a title="' . esc_attr($post_title) . '" href="' . esc_url($post_link) . ' ">';
                    $after_html = '</a>' . $after_html;
                }

                if ($wrapper) {
                    $wrapper_html = '<div class="image-area">';
                    $before_html = $wrapper_html . $before_html;
                    if (mo_show_image_info($context) || $show_image_info) {
                        $image_info = '<div class="image-info">';
                        $image_info .= '<span class="image-info-buttons">';
                        // point me to the source of the image for lightbox preview
                        $image_info .= '<a class="lightbox-link" ' . esc_attr($rel_attribute) . 'title="' . esc_attr($post_title) . '" href="' . esc_url($thumbnail_src) . ' "><i class="lightbox icon-maximize"></i></a>';
                        $image_info .= '</span>';
                        $image_info .= '<div class="entry-info">';
                        $image_info .= '<h3 class="post-title"><a title="' . esc_attr($post_title) . '" href="' . esc_url($post_link) . ' ">' . esc_html($post_title) . '</a></h3>';
                        $image_info .= mo_get_taxonomy_info($taxonomy);
                        $image_info .= '</div>';
                        $image_info .= '</div>';

                        $after_html .= $image_info;
                        $after_html .= '<div class="image-overlay"></div>';
                    }
                    $after_html .= '</div>'; // end of image-area
                }
            }

            $output = $before_html;
            $output .= $thumbnail_element;
            $output .= $after_html;
        }
        return $output;
    }
}

if (!function_exists('mo_get_taxonomy_info')) {

    function mo_get_taxonomy_info($taxonomy) {
        $output = '';
        $terms = get_the_terms(get_the_ID(), $taxonomy);
        if ($terms) {
            $output .= '<div class="terms">';
            $term_count = 0;
            foreach ($terms as $term) {
                if ($term_count != 0)
                    $output .= ', ';
                $output .= '<a href="' . get_term_link($term->slug, $taxonomy) . '">' . $term->name . '</a>';
                $term_count = $term_count + 1;
            }
            $output .= '</div>';
        }
        return $output;
    }
}

if (!function_exists('mo_get_thumbnail_urls')) {

    function mo_get_thumbnail_urls($args) {
        extract($args);

        $thumbnail_urls = array();

        if (empty($post_id))
            $post_id = get_the_ID();

        // Get the custom sized image stored for portfolio archives/templates, if available.
        // For masonry layouts, no specific image size is specified.
        if (empty($image_size) && mo_is_portfolio_context()) {
            $image_src = get_post_meta($post_id, 'mo_portfolio_thumbnail', true);
            if (!empty($image_src)) {
                $image_element = mo_get_image_element($image_src, null, $image_class, $image_title);
                $thumbnail_urls[0] = esc_url($image_src);
                $thumbnail_urls[1] = $image_element;
                return $thumbnail_urls;
            }
        }

        if (empty($image_size))
            $image_size = 'full';

        // 1- First get me the link to featured image src
        $feature_image_id = get_post_thumbnail_id($post_id);
        $feature_image_src = wp_get_attachment_image_src($feature_image_id, 'full');

        if ($feature_image_src) {
            // 2- Now get me the complete img element
            $atts = array(
                'class' => $image_class,
                'alt' => $image_alt,
                'title' => $image_title
            );

            $thumbnail_element = get_the_post_thumbnail($post_id, $image_size, $atts);

            $thumbnail_urls[0] = $feature_image_src[0];
            $thumbnail_urls[1] = $thumbnail_element;
        }

        return $thumbnail_urls;
    }
}