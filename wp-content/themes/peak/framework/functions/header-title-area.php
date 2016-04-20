<?php

add_filter('mo_header_class', 'mo_header_class');

if (!function_exists('mo_site_logo')) {
    function mo_site_logo() {
        $heading_tag = (is_home() || is_front_page()) ? 'h1' : 'div';

        $blog_name = esc_attr(get_bloginfo('name'));

        $output = '<' . $heading_tag . ' id="site-logo"><a href="' . esc_url(home_url('/')) . '" title="' . $blog_name . '" rel="home">';

        $use_text_logo = mo_get_theme_option('mo_use_text_logo') ? true : false;
        $logo_url = mo_get_theme_option('mo_site_logo');
        $light_logo_url = mo_get_theme_option('mo_light_site_logo');

        // If no logo image is specified, use text logo
        if ($use_text_logo || (empty ($logo_url) && empty($light_logo_url))) {
            $output .= '<span>' . $blog_name . '</span>';
        }
        else {
            if ($logo_url)
                $output .= '<img class="standard-logo" src="' . esc_url($logo_url) . '" alt="' . $blog_name . '"/>';
            if ($light_logo_url)
                $output .= '<img class="light-logo" src="' . esc_url($light_logo_url) . '" alt="' . $blog_name . '"/>';
        }

        $output .= '</a></' . $heading_tag . '>';

        echo wp_kses_post($output);

    }
}

if (!function_exists('mo_site_description')) {

    /* TODO: Support for site description */
    function mo_site_description() {
        $display_desc = mo_get_theme_option('mo_display_site_desc') ? true : false;
        $display_desc = false; // no support for description now
        if ($display_desc) {
            echo '<div id="site-description"><span>' . esc_html(bloginfo('description')) . '</span></div>';
        }
    }
}

if (!function_exists('mo_populate_top_area')) {

    function mo_populate_top_area($post_id = NULL) {

        $slider_type = get_post_meta(get_the_ID(), 'mo_slider_choice', true);
        if (!empty($slider_type) && $slider_type != 'None') {
            $slider_manager = mo_get_slider_manager();
            $slider_manager->display_slider_area();
            return;
        }

        $remove_title_header = get_post_meta(get_the_ID(), 'mo_remove_title_header', true);
        if (!empty($remove_title_header))
            return;

        if (is_home() && mo_get_theme_option('mo_remove_homepage_tagline'))
            return;

        if (is_singular('portfolio')) {

            echo '<header id="title-area" class="clearfix">';

            mo_display_post_thumbnail();

            echo '<div class="inner">';

            echo '<div class="portfolio-header">';

            $portfolio_categories = get_the_terms(get_the_ID(), 'portfolio_category');

            if (!empty($portfolio_categories)) {
                echo '<span class="category-links">';
                $first = true;
                foreach ($portfolio_categories as $term) {
                    $category_url = get_term_link($term);
                    if (is_wp_error($category_url))
                        continue;
                    echo ($first ? '' : ',') . '<a href="' . esc_url($category_url) . '" class="term-' . intval($term->term_id) . '" title="' . esc_html__('View all items filed under ', 'peak') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a>';
                    $first = false;
                }
                echo '</span>';
                echo '<span class="separator"> ' . esc_html__('for', 'peak') . ' </span>';
                $project_client = get_post_meta(get_the_ID(), '_portfolio_client_field', true);
                if (!empty($project_client)) {
                    echo '<span class="portfolio-client">' . esc_html($project_client) . '</span>';
                }

            }

            echo mo_get_entry_title(); // populate entry title for page and custom post types like portfolio type

            echo '</div>';

            echo '</div>';

            echo '</header> <!-- title-area -->';

            return;
        }
        elseif (is_singular(array(
            'page', 'post'
        ))) {
            $custom_heading = mo_get_custom_heading();
            if (!empty($custom_heading)) {
                echo '<header id="custom-title-area">';
                $wide_heading_layout = get_post_meta(get_queried_object_id(), 'mo_wide_heading_layout', true);
                if (empty($wide_heading_layout))
                    echo '<div class="inner">';
                else
                    echo '<div class="wide">';
                echo do_shortcode($custom_heading);
                echo '</div>';
                echo '</header> <!-- custom-title-area -->';
                return;
            }
        }

        echo '<header id="title-area" class="clearfix">';
        echo '<div class="inner">';
        mo_populate_tagline();
        echo '</div>';
        echo '</header> <!-- title-area -->';
    }


}

if (!function_exists('mo_display_sidenav')) {
    function mo_display_sidenav() {

        if (!has_nav_menu('side')) {
            return;
        }

        echo '<div class="side-nav-toggle"><a href="#"><span class="icon"></span></a></div>';

        ?>

        <aside id="sidenav" class="sec-nav closed">

            <?php get_template_part('menu', 'side'); ?>

            <?php mo_sidenav_bottom_section(); ?>

        </aside> <!-- #sidenav -->

    <?php

    }
}

if (!function_exists('mo_populate_tagline')) {
    function mo_populate_tagline() {

        // Allow others to display - only if not shown, proceed to next step
        $done = apply_filters('mo_show_page_title', null);
        if ($done)
            return;

        /* Default tagline for blog */
        $tagline = mo_get_theme_option('mo_blog_tagline', esc_html__('Blog', 'peak'));

        if (is_attachment()) {
            echo '<h1>' . esc_html__('Media', 'peak') . '</h1>';
        }
        elseif (is_home()) {
            /* If a separate front page has been set along with this posts page, use Blog as default title, else use Site Title as default */
            if (get_option('page_on_front'))
                $default_homepage_title = esc_html__('Blog', 'peak');
            else
                $default_homepage_title = get_bloginfo('name');

            $blog_page_tagline = mo_get_theme_option('mo_posts_page_tagline', $default_homepage_title);

            echo '<h2 class="tagline">' . esc_html($blog_page_tagline) . '</h2>';
        }
        elseif (class_exists('Tribe__Events__Main') && (tribe_is_event_query())) {
            $tagline = mo_get_theme_option('mo_events_tagline', esc_html__('Events', 'peak'));
            echo '<h2 class="tagline">' . esc_html($tagline) . '</h2>';
        }
        elseif (is_singular('post')) {
            echo '<h2 class="tagline">' . esc_html($tagline) . '</h2>';
        }
        elseif (is_archive() || is_search()) {
            get_template_part('loop-meta'); // Loads the loop-meta.php template.
        }
        elseif (is_404()) {
            echo '<h1>' . esc_html__('404 Not Found', 'peak') . '<h1>';
        }
        else {
            echo mo_get_entry_title(); // populate entry title for page and custom post types like portfolio type
        }
        $description = get_post_meta(get_queried_object_id(), 'mo_description', true);
        if (!empty ($description)) {
            echo '<div class="post-description">';
            echo '<p>' . esc_html($description) . '</p>';
            echo '</div>';
        }
    }
}

if (!function_exists('mo_get_custom_heading')) {
    function mo_get_custom_heading() {
        $output = '';
        $custom_heading = get_post_meta(get_queried_object_id(), 'mo_custom_heading_content', true);
        if (!empty ($custom_heading)) {
            $output .= htmlspecialchars_decode(esc_html($custom_heading));
        }
        return $output;
    }
}

if (!function_exists('mo_header_class')) {
    function mo_header_class($header_classes) {

        return $header_classes;
    }
}

if (!function_exists('mo_display_header_info')) {

    function mo_display_header_info() {
        $featured_campaign = mo_get_theme_option('mo_featured_campaign');

        if (!empty ($featured_campaign)) :

            $donation_form = get_post_meta($featured_campaign, '_lm_campaign_form', true); ?>

            <div id="header-info">

                <div class="inner">

                    <div id="header-campaign" class="featured-campaign dropdown-content">

                        <div class="sixcol">

                            <?php

                            $campaign_title = get_the_title($featured_campaign);

                            echo '<h3 class="entry-title">' . esc_html($campaign_title) . '</h3>';

                            echo do_shortcode('[read_more text="' . esc_html__('Support this Campaign', 'peak') . '" title="' . esc_attr($campaign_title) . '" href="' . get_permalink($featured_campaign) . '"]');

                            ?>

                        </div>

                        <div class="sixcol last">

                            <div class="campaign-stats">

                                <?php echo mo_display_campaign_collections($donation_form); ?>

                                <div class="countdown-label"><?php echo esc_html__('Ends:', 'peak'); ?></div>

                                <div id="featured-campaign-timer" class="campaign-timer"></div>

                            </div>

                        </div>

                    </div>

                    <div id="campaign-header">

                        <i class="icon-keyboard-arrow-down" data-id="header-campaign"></i>

                    </div>

                </div>

            </div>

        <?php endif; ?>
    <?php

    }
}

?>