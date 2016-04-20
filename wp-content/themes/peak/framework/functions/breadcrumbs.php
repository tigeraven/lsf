<?php

/* * *********************************************************************
 * @Author: Boutros AbiChedid
 * @Date:   February 14, 2011
 * @Copyright: Boutros AbiChedid (http://bacsoftwareconsulting.com/)
 * @Licence: Feel free to use it and modify it to your needs but keep the
 * Author's credit. This code is provided 'as is' without any warranties.
 * @Function Name:  mo_breadcrumb()
 * @Version:  1.0 -- Tested up to WordPress version 3.1.2
 * @Description: WordPress Breadcrumb navigation function. Adding a
 * breadcrumb trail to the theme without a plugin.
 * This code does not support multi-page split numbering, attachments,
 * custom post types and custom taxonomies.
 * ********************************************************************* */

if (!function_exists('mo_breadcrumb')) {
    function mo_breadcrumb() {
        //Variable (symbol >> encoded) and can be styled separately.
        //Use >> for different level categories (parent >> child >> grandchild)
        $delimiter = '<span class="sep"> / </span>';
        //Use bullets for same level categories ( parent . parent )
        $separator = '<span class="delimiter1"> - </span>';


        $main = esc_html__('Home', 'peak');

        /* is_front_page(): If the front of the site is displayed, whether it is posts or a Page. This is true
          when the main blog page is being displayed and the 'Settings > Reading ->Front page displays'
          is set to "Your latest posts", or when 'Settings > Reading ->Front page displays' is set to
          "A static page" and the "Front Page" value is the current Page being displayed. In this case
          no need to add breadcrumb navigation. is_home() is a subset of is_front_page() */

        //Check if NOT the front page (whether your latest posts or a static page) is displayed. Then add breadcrumb trail.
        if (!is_front_page()) {
            echo '<div id="breadcrumbs">';

            global $post, $cat;
            $homeLink = home_url('/');
            echo '<a href="' . esc_url($homeLink) . '">' . esc_html($main) . '</a>' . $delimiter;

            if (is_attachment()) {
                global $post;
                $my_query = get_post($post->post_parent);
                $categories = get_the_category($my_query->ID);
                mo_display_categories($categories, $separator, $delimiter);
                previous_post_link(' %link ' . $delimiter . ' ');
            }
            elseif (is_singular('portfolio')) {
                $page_id = mo_get_theme_option('mo_default_portfolio_page');
                if (!empty($page_id)) {
                    $page_title = get_the_title($page_id);
                    echo ' <a href="' . get_permalink($page_id) . '" title="' . esc_attr($page_title) . '">' . esc_html($page_title) . '</a>';
                    echo ' ' . $delimiter;
                }
                mo_display_breadcrumb_post_title();
            }
            elseif (is_single()) {
                $categories = get_the_category();
                mo_display_categories($categories, $separator, $delimiter);
                mo_display_breadcrumb_post_title();
            }
            elseif (is_category()) {
                echo '' . get_category_parents($cat, true, ' ' . $delimiter . ' ');
            }
            elseif (is_tag()) {
                echo '' . single_tag_title("", false);
            }
            elseif (is_date()) {
                mo_date_breadcrumb($delimiter);
            }
            elseif (is_search()) {
                echo esc_html__('Search Results for: ', 'peak') . get_search_query() . '';
            }
            elseif (is_page() && !$post->post_parent) { //Check if this is a top Level page being displayed.
                echo get_the_title();
            }
            //Display breadcrumb trail for multi-level subpages (multi-level submenus)
            elseif (is_page() && $post->post_parent) {
                $post_array = get_post_ancestors($post);

                //Sorts in descending order by key, since the array is from top category to bottom.
                krsort($post_array);

                foreach ($post_array as $key => $postid) {
                    //returns the object $post_ids
                    $post_ids = get_post($postid);
                    $title = $post_ids->post_title;
                    echo '<a href="' . get_permalink($post_ids) . '">' . esc_html($title) . '</a>' . $delimiter;
                }
                echo get_the_title();
            }
            elseif (is_author()) {
                global $author;
                $user_info = get_userdata($author);
                echo esc_html__('Posts by ', 'peak') . $user_info->display_name;
            }
            elseif (is_404()) { //checks if 404 error is being displayed
                echo esc_html__('Error 404 - Not Found.', 'peak');
            }
            elseif (is_tax()) {
                $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                echo esc_attr($term->name);
            }
            else {
                //All other cases that I missed. No Breadcrumb trail.
            }
            echo '</div> <!-- #breadcrumbs -->';
        }
    }
}

if (!function_exists('mo_display_breadcrumb_post_title')) {
    function mo_display_breadcrumb_post_title() {
        $post_title = get_the_title();
        $maxLength = 30; //Display only the first 30 characters of the post title.
        //Display partial post title, in order to save space.
        if (strlen($post_title) >= $maxLength) { //If the title is long, then don't display it all.
            echo ' ' . trim(substr(esc_html($post_title), 0, $maxLength)) . ' ...';
        }
        else { //the title is short, display all post title.
            echo ' ' . esc_html($post_title);
        }
    }
}

if (!function_exists('mo_date_breadcrumb')) {

    function mo_date_breadcrumb($delimiter) { //variable for archived year
        $arc_year = get_the_time('Y');
        $arc_month = get_the_time('F');

        $arc_day = get_the_time('d');
        $arc_day_full = get_the_time('l');

        $url_year = get_year_link($arc_year);
        $url_month = get_month_link($arc_year, $arc_month);


        if (is_day()) {
            echo '<a href="' . esc_url($url_year) . '">' . esc_html($arc_year) . '</a> ' . $delimiter . ' ';
            echo '<a href="' . esc_url($url_month ). '">' . esc_html($arc_month) . '</a> ' . $delimiter . $arc_day . ' (' . $arc_day_full . ')';
        }
        elseif (is_month()) {
            echo '<a href="' . esc_url($url_year) . '">' . esc_html($arc_year) . '</a> ' . $delimiter . $arc_month;
        }
        elseif (is_year()) {
            echo get_the_time('Y');
        }
    }
}

if (!function_exists('mo_display_categories')) {

    function mo_display_categories($categories, $separator, $delimiter) {
        if (empty($categories)) {
            return;
        }
        $count = 0;
        foreach ($categories as $cat) {
            if ($count > 0)
                echo wp_kses_post($separator) . ' ';
            echo get_category_parents($cat, true, ' ');
            $count++;
        }
        echo wp_kses_post($delimiter);
    }
}

function mo_display_breadcrumbs() {

    $show_breadcrumbs = mo_get_theme_option('mo_show_breadcrumbs') ? true : false;
    $disable_breadcrumbs_for_entry = get_post_meta(get_queried_object_id(), 'mo_disable_breadcrumbs_for_entry', true);

    if ($show_breadcrumbs && empty($disable_breadcrumbs_for_entry)) {
        mo_breadcrumb();
    }
}

?>