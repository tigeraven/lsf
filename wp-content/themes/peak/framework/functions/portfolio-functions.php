<?php

if (!function_exists('mo_display_portfolio_content')) {


    function mo_display_portfolio_content($args) {

        /* Do not continue if the Livemesh Tools plugin is not loaded */
        if (!class_exists('LM_Framework')) {
            return mo_display_plugin_error();
        }

        global $mo_theme;

        $mo_theme->set_context('loop', 'portfolio'); // tells the thumbnail functions to prepare lightbox constructs for the image

        if(is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        $query_args = array(
            'post_type' => 'portfolio',
            'posts_per_page' => $args['posts_per_page'],
            'paged' => $paged,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $term = get_term_by('slug', get_query_var('term'), 'portfolio_category');

        if ($term)
            $query_args['portfolio_category'] = $term->slug;

        $args['query_args'] = $query_args;

        mo_display_portfolio_content_grid_style($args);

        $mo_theme->set_context('loop', null); //reset it
    }
}

if (!function_exists('mo_display_portfolio_content_grid_style')) {
    function mo_display_portfolio_content_grid_style($args) {

        /* Set the default arguments. */
        $defaults = array(
            'number_of_columns' => 4,
            'image_size' => 'medium-thumb',
            'query_args' => null,
            'excerpt_count' => 160,
            'layout_mode' => 'fitRows'
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if ($layout_mode == "fitRows")
            $style_class = mo_get_column_style($number_of_columns);
        ?>

        <div id="content" class="<?php echo mo_get_content_class(); ?>">

            <?php mo_display_breadcrumbs(); ?>

            <div class="hfeed">

                <?php
                mo_show_page_content();

                $loop = new WP_Query($query_args);

                if ($loop->have_posts()) :

                    if ($filterable)
                        echo mo_get_taxonomy_terms_filter('portfolio_category');
                    else
                        echo mo_get_taxonomy_terms_links('portfolio', 'portfolio_category');

                    echo '<ul id="showcase-items" class="image-grid ' . esc_attr($layout_mode) . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".showcase-item", "masonry": { "columnWidth": ".grid-sizer" }, "layoutMode": "' . esc_attr($layout_mode) . '" }\'>';

                    if ($layout_mode == "masonry") {
                        echo '<li class="grid-sizer onecol zero-margin"></li>'; //for masonry layout grid sizing
                    }
                    while ($loop->have_posts()) : $loop->the_post();

                        if ($layout_mode == "masonry") {
                            $portfolio_column_size = get_post_meta(get_the_ID(), 'mo_portfolio_thumbnail_column_size', true);
                            if (empty($portfolio_column_size) || $portfolio_column_size == 'default')
                                $portfolio_column_size = $number_of_columns; // derived from theme option "Number of Portfolio Columns" in Portfolio Page tab.
                            $style_class = mo_get_column_class($portfolio_column_size, true);
                            $image_size = null; // do not crop the original image
                        }

                        $style = $style_class . ' showcase-item clearfix';
                        $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $style .= ' term-' . intval($term->term_id);
                            }
                        }
                        ?>
                        <li data-id="id-<?php the_ID(); ?>" class="<?php echo esc_attr($style); ?>">

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                <?php $thumbnail_exists = mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'wrapper' => true,
                                    'size' => 'full',
                                    'taxonomy' => 'portfolio_category'
                                ));

                                mo_display_portfolio_entry_text($thumbnail_exists, $excerpt_count);
                                ?>

                            </article>
                            <!-- .hentry -->

                        </li> <!--Isotope element -->


                    <?php endwhile; ?>

                    </ul> <!-- Isotope items -->

                <?php else : ?>

                    <?php get_template_part('loop-error'); // Loads the loop-error.php template.                  ?>

                <?php endif; ?>

            </div>
            <!-- .hfeed -->


            <?php
            /* No need to paginate if filterable is true since all posts get displayed. */
            if (!$filterable) {
                include(locate_template('loop-nav.php'));
            }
            ?>

        </div><!-- #content -->

        <?php wp_reset_postdata(); /* Right placement to help not lose context information */ ?>

    <?php
    }
}

if (!function_exists('mo_get_filterable_portfolio_content')) {
    function mo_get_filterable_portfolio_content($args) {
        global $mo_theme;

        $output = '';

        $mo_theme->set_context('loop', 'portfolio'); // tells the thumbnail functions to prepare lightbox constructs for the image

        /* Extract the array to allow easy use of variables. */
        extract($args);

        $no_margin = mo_to_boolean($no_margin);

        if ($layout_mode == "fitRows") {
            $style_class = mo_get_column_style($number_of_columns, $no_margin);
        }

        $output .= '<div class="hfeed">';

        $loop = new WP_Query(array(
            'post_type' => 'portfolio',
            'posts_per_page' => $posts_per_page,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));

        if ($loop->have_posts()) :

            $post_count = 0;

            if (mo_to_boolean($filterable))
                $output .= mo_get_taxonomy_terms_filter('portfolio_category');

            $output .= '<ul id="showcase-items" class="image-grid ' . esc_attr($layout_mode) . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".showcase-item", "masonry": { "columnWidth": ".grid-sizer" }, "layoutMode": "' . esc_attr($layout_mode) . '" }\'>';

            if ($layout_mode == "masonry") {
                $output .= '<li class="grid-sizer onecol zero-margin"></li>'; //for masonry layout grid sizing
                $image_size = 'large'; // retain original aspect ratio for masonry layout
            }

            while ($loop->have_posts()) : $loop->the_post();

                if ($layout_mode == "masonry") {
                    $portfolio_column_size = get_post_meta(get_the_ID(), 'mo_portfolio_thumbnail_column_size', true);
                    if (empty($portfolio_column_size) || $portfolio_column_size == 'default')
                        $portfolio_column_size = $number_of_columns; // derived from theme option "Number of Portfolio Columns" in Portfolio Page tab.
                    $style_class = mo_get_column_class($portfolio_column_size, true); // masonry layout is supported with zero margins for now
                    $image_size = null; // do not crop the original image
                }

                $post_count++;

                $style = $style_class . ' showcase-item'; // no margin or spacing between portfolio items

                $terms = get_the_terms(get_the_ID(), 'portfolio_category');
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $style .= ' term-' . intval($term->term_id);
                    }
                }

                if ($post_count == 1 && !empty($portfolio_link)) {

                    $output .= '<li data-id="id-' . get_the_ID() . '" class="' . esc_attr($style) . ' portfolio-link-item">';

                    $output .= '<article id="post-' . get_the_ID() . '" class="' . join(' ', get_post_class()) . '">';

                    $output .= mo_get_thumbnail(array(
                        'image_size' => $image_size,
                        'wrapper' => false,
                        'size' => 'full',
                        'taxonomy' => 'portfolio_category'
                    ));

                    $output .= '<h3 class="portfolio-link-wrap">';
                    $output .= '<a class="portfolio-link" href="' . esc_url($portfolio_link) . '" title="' . esc_html__('Our Work', 'peak') . '">' . esc_html($link_text) . '</a>';
                    $output .= '</h3>';
                }
                else {
                    $output .= '<li data-id="id-' . get_the_ID() . '" class="' . esc_attr($style) . '">';

                    $output .= '<article id="post-' . get_the_ID() . '" class="' . join(' ', get_post_class()) . '">';

                    $output .= mo_get_thumbnail(array(
                        'image_size' => $image_size,
                        'wrapper' => true,
                        'size' => 'full',
                        'taxonomy' => 'portfolio_category'
                    ));
                }

                $output .= '</article><!-- .hentry -->';

                $output .= '</li> <!--isotope element -->';

            endwhile;

            $output .= '</ul> <!-- Isotope items -->';

        else :
            get_template_part('loop-error'); // Loads the loop-error.php template.
        endif;

        $output .= '</div> <!-- .hfeed -->';

        wp_reset_postdata();

        $mo_theme->set_context('loop', null); //reset it

        return $output;
    }
}

if (!function_exists('mo_display_portfolio_entry_text')) {
    function mo_display_portfolio_entry_text($thumbnail_exists, $excerpt_count) {

        $display_title = mo_get_theme_option('mo_show_title_in_portfolio') ? true : false;

        $display_summary = mo_get_theme_option('mo_show_details_in_portfolio') ? true : false;

        if ($display_summary || $display_title) {

            echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

            echo mo_get_entry_title();

            if ($display_summary) {

                echo '<div class="entry-summary">';

                $show_excerpt = mo_get_theme_option('mo_show_content_summary_in_portfolio') ? false : true;

                if ($show_excerpt) {
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                }
                else {
                    global $more;
                    $more = 0;
                    the_content(wp_kses_post(__('Read More <span class="meta-nav">&rarr;</span>', 'peak')));
                }
                echo '</div> <!-- .entry-summary -->';

            }

            echo '</div> <!-- .entry-text-wrap -->';
        }


    }
}

if (!function_exists('mo_get_taxonomy_terms_filter')) {
    /** Isotope filtering support for Portfolio pages * */
    function mo_get_taxonomy_terms_filter($taxonomy) {

        $output = '';

        $terms = get_terms($taxonomy);

        if (!empty($terms)) {

            $output .= '<ul id="showcase-filter">';

            $output .= '<li class="segment-0"><a class="showcase-filter" data-value="*" href="#">' . esc_html__('All', 'peak') . '</a></li>';

            $segment_count = 1;
            foreach ($terms as $term) {

                $output .= '<li class="segment-' . intval($segment_count) . '"><a class="" href="#" data-value=".term-' . intval($term->term_id) . '" title="' . esc_html__('View all items filed under ', 'peak') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a></li>';

                $segment_count++;
            }

            $output .= '</ul>';

        }

        return $output;
    }
}

if (!function_exists('mo_get_taxonomy_terms_links')) {

    function mo_get_taxonomy_terms_links($post_type, $taxonomy) {

        $output = '';

        $portfolio_categories = get_terms($taxonomy);

        if (!empty($portfolio_categories)) {

            $output .= '<ul id="showcase-links">';

            $archive_url = mo_get_post_type_archive_url($post_type);

            $archive_page = is_post_type_archive($post_type);

            $output .= '<li class="portfolio-archive"><a class="showcase-filter" href="' . esc_url($archive_url) . '">' . esc_html__('All', 'peak') . '</a></li>';

            foreach ($portfolio_categories as $term) {

                $category_url = get_term_link($term);

                if (is_wp_error($category_url))
                    continue;

                $current = is_tax($taxonomy, $term->term_id);

                $output .= '<li class="category-archive"><a class="category-link' . ($current ? ' active' : '') . '" href="' . esc_url($category_url) . '" title="' . esc_html__('View all items filed under ', 'peak') . esc_attr($term->name) . '">' . esc_html($term->name) . '</a></li>';

            }

            $output .= '</ul>';

        }

        return $output;
    }
}

if (!function_exists('mo_is_portfolio_context')) {
    /**
     * Check if this is a portfolio page
     *
     */
    function mo_is_portfolio_context() {

        global $mo_theme;

        $context = $mo_theme->get_context('loop');

        if ($context == 'portfolio')
            return true;

        return false;
    }
}

if (!function_exists('mo_is_portfolio_page')) {
    /**
     * Check if this is a portfolio page
     */
    function mo_is_portfolio_page() {

        if (is_page_template('template-portfolio.php')
            || is_page_template('template-portfolio-filterable.php')
        )
            return true;

        return false;
    }

}

?>