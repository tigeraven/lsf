<?php
/*
 * Various utility functions required by theme defined here
 * 
 * @package Livemesh_Framework
 *
 */

if (!function_exists('mo_get_entry_title')) {
    function mo_get_entry_title() {
        global $post;

        if (is_front_page() && !is_home())
            $title = the_title('<h2 class="' . esc_attr($post->post_type) . '-title entry-title"><a href="' . get_permalink() . '"
                                                                                        title="' . get_the_title() . '"
                                                                                        rel="bookmark">', '</a></h2>',
                false);
        elseif (mo_is_context('portfolio') || mo_is_context('gallery_item') || mo_is_context('campaign') || mo_is_context('custom'))
            $title = the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h2>', false);
        elseif (is_singular())
            $title = the_title('<h1 class="' . esc_attr($post->post_type) . '-title entry-title">', '</h1>', false);
        else
            $title = the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h2>', false);

        /* If there's no post title, return a default title */
        if (empty($title)) {
            if (!is_singular()) {
                $title = '<h2 class="entry-title no-entry-title"><a href="' . get_permalink() . '" rel="bookmark">' . esc_html__('(Untitled)',
                        'peak') . '</a></h2>';
            }
            else {
                $title = '<h1 class="entry-title no-entry-title">' . esc_html__('(Untitled)', 'peak') . '</h1>';
            }
        }

        return $title;
    }
}

if (!function_exists('mo_entry_author')) {

    function mo_entry_author() {
        $author = '<span class="author vcard">' . esc_html__('By ', 'peak'). '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author_meta('display_name')) . '">' . esc_html(get_the_author_meta('display_name')) . '</a></span>';
        return $author;
    }
}

if (!function_exists('mo_entry_published')) {

    function mo_entry_published($format = "M d, Y") {


        global $post;

        $post_id = $post->ID;

        $prefix = esc_html__('On ', 'peak');

        $link = '<span class="published">' . '<a href="' . get_day_link(get_the_time(esc_html__('Y', 'peak')), get_the_time(esc_html__('m', 'peak')), get_the_time(esc_html__('d', 'peak'))) . '" title="' . sprintf(get_the_time(esc_html__('l, F, Y, g:i a', 'peak'))) . '">' . '<span class="updated">' . get_the_time($format) . '</span>' . '</a></span>';

        return $link;

        $published = '<span class="published">' . esc_html($prefix) . ' <abbr title="' . sprintf(get_the_time(esc_html__('l, F, Y, g:i a', 'peak'))) . '">' . sprintf(get_the_time($format)) . '</abbr></span>';

        return $published;
    }
}

if (!function_exists('mo_custom_entry_published')) {

    function mo_custom_entry_published() {

        $published = '<span class="published"><abbr title="' . sprintf(get_the_time(esc_html__('l, F, Y, g:i a', 'peak'))) . '"><span class="month">' . sprintf(get_the_time('M')) . '</span><span class="date">' . sprintf(get_the_time('d')) . '</span></abbr></span>';
        return $published;
    }
}

if (!function_exists('mo_entry_terms_list')) {

    function mo_entry_terms_list($taxonomy = 'category', $separator = '', $before = '', $after = '') {
        global $post;

        $output = '<span class="' . esc_attr($taxonomy) . '">';
        $output .= get_the_term_list($post->ID, $taxonomy, $before, $separator, $after);
        $output .= '</span>';

        return $output;
    }
}

if (!function_exists('mo_entry_terms_text')) {

    function mo_entry_terms_text($taxonomy = 'category', $separator = ' , ') {
        global $post;

        $output = '';

        $terms = get_the_terms($post, $taxonomy);
        if (!empty($terms)) {
            foreach ($terms as $term)
                $term_names[] = $term->name;

            $output = implode($separator, $term_names);
        }

        return $output;
    }
}


if (!function_exists('mo_display_related_posts')) {
    function mo_display_related_posts($args) {

        global $post;

        /** Default config options */
        $defaults = array(
            'header_text' => esc_html__("Related Posts", 'peak'),
            'taxonomy' => 'category',
            'show_meta' => false,
            'post_count' => 4,
            'number_of_columns' => 4,
            'image_size' => 'medium-thumb',
            'excerpt_count' => 80,
            'display_summary' => false
        );

        /** Parse default options with config options from $this->bulk_upgrade and extract them */
        $args = wp_parse_args($args, $defaults);
        extract($args);

        $style_class = mo_get_column_style($number_of_columns);

        $posts = mo_related_posts_by_taxonomy(get_the_ID(), $taxonomy, array('posts_per_page' => $post_count));

        if (!empty($posts)):

            $post_count = 0;

            $first_row = true;
            $last_column = false;

            echo '<div class="related-posts post-snippets">';

            echo '<h4 class="subheading">' . esc_html($header_text) . '</h4>';

            foreach ($posts as $post) {

                setup_postdata($post);

                $post_id = $post->ID;

                if ($last_column) {
                    echo '<div class="clear"></div>';
                    $first_row = false;
                }

                if (++$post_count % $number_of_columns == 0)
                    $last_column = true;
                else
                    $last_column = false;

                echo '<div class="' . esc_attr($style_class) . ' clearfix' . ($last_column ? ' last' : '') . '">';

                echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';

                $thumbnail_exists = mo_thumbnail(array(
                    'post_id' => $post_id,
                    'image_size' => $image_size,
                    'wrapper' => true,
                    'show_image_info' => true,
                    'image_alt' => get_the_title($post_id),
                    'size' => 'full'
                ));

                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                $before_title = '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">';
                $after_title = '</a></h3>';

                the_title($before_title, $after_title);

                if ($show_meta)
                    echo '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';

                if ($excerpt_count != 0) {
                    echo '<div class="entry-summary">';
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    echo '</div><!-- .entry-summary -->';
                }

                echo '</div><!-- entry-text-wrap -->';

                echo '</article><!-- .hentry -->';

                echo '</div> <!-- .column-class -->';

            }

            echo '</div> <!-- .related-posts -->';

            echo '<div class="clear"></div>';

            wp_reset_postdata();

        endif;

    }
}



if (!function_exists('mo_related_posts_by_taxonomy')) {

    function mo_related_posts_by_taxonomy($post_id, $taxonomy, $args = array()) {
        $terms = wp_get_object_terms($post_id, $taxonomy);

        //Pluck out the IDs to get an array of IDS
        $term_ids = wp_list_pluck($terms, 'term_id');

        //Query posts with tax_query. Choose in 'IN' if want to query posts with any of the terms
        //Choose 'AND' if you want to query for posts with all terms
        $args = wp_parse_args($args, array(
            'post_type' => get_post_type($post_id),
            'tax_query' => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field' => 'id',
                    'terms' => $term_ids,
                    'operator' => 'IN'
                    //Or 'AND' or 'NOT IN'
                )
            ),
            'ignore_sticky_posts' => 1,
            'orderby' => 'rand',
            'post__not_in' => array($post_id)
        ));

        $posts = get_posts($args);

        // Return our results in query form
        return $posts;
    }

}

if (!function_exists('mo_get_post_snippets')) {

// Display grid style posts layout for portfolio or regular posts
    function mo_get_post_snippets($args) {
        global $mo_theme;

        $mo_theme->set_context('loop', 'portfolio'); // tells the thumbnail functions to prepare lightbox constructs for the image

        $output = mo_get_post_snippets_layout($args);

        $mo_theme->set_context('loop', null); //reset it

        return $output;

    }
}

if (!function_exists('mo_get_post_snippets_list')) {

    // Display posts snippets list for flexslider carousel
    function mo_get_post_snippets_list($args) {

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if ($post_type == 'portfolio')
            $taxonomy = 'portfolio_category';
        elseif ($post_type == 'gallery_item')
            $taxonomy = 'gallery_category';

        if (empty($post_type))
            $loop = new WP_Query(array(
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $post_count
            ));
        elseif (empty($taxonomy) || empty($terms))
            $loop = new WP_Query(array(
                'post_type' => $post_type,
                'posts_per_page' => $post_count
            ));
        else
            $loop = new WP_Query(array(
                'post_type' => $post_type,
                'posts_per_page' => $post_count,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => explode(',', $terms)
                    )
                )
            ));

        $output = '';

        if ($loop->have_posts()) :

            $hide_thumbnail = mo_to_boolean($hide_thumbnail);

            $display_title = mo_to_boolean($display_title);

            $show_meta = mo_to_boolean($show_meta);

            $display_summary = mo_to_boolean($display_summary);

            $output .= '<ul>';

            while ($loop->have_posts()) : $loop->the_post();

                $thumbnail_exists = false;

                $output .= "\n" . '<li>';

                $output .= '<article class="' . join(' ', get_post_class()) . '">';

                if (!$hide_thumbnail) {
                    $thumbnail_url = mo_get_thumbnail(array(
                        'show_image_info' => true,
                        'image_size' => $image_size
                    ));
                    if (!empty($thumbnail_url)) {
                        $thumbnail_exists = true;
                        $output .= $thumbnail_url;
                    }
                }

                if ($display_title || $display_summary || $show_meta) {

                    $output .= "\n" . '<div class="entry-text-wrap ' . ($thumbnail_exists ? '' : 'nothumbnail') . '">';

                    if ($display_title)
                        $output .= "\n" . the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h3>', false);

                    if ($show_meta) {
                        $output .= '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';
                    }


                    if ($display_summary) {

                        $output .= '<div class="entry-summary">';

                        if ($show_excerpt) {
                            $output .= mo_truncate_string(get_the_excerpt(), $excerpt_count);
                        }
                        else {
                            global $more;
                            $more = 0;
                            $output .= get_the_content(esc_html__('Read More <span class="meta-nav">&rarr;</span>', 'peak'));
                        }
                        $output .= '</div><!-- .entry-summary -->';
                    }

                    $output .= '</div><!-- .entry-text-wrap -->';
                }

                $output .= '</article><!-- .hentry -->';

                $output .= '</li>';


            endwhile;

            $output .= '</ul>';

        endif;

        wp_reset_postdata();

        return $output;
    }
}

if (!function_exists('mo_display_post_nuggets_grid_style')) {

    function mo_display_post_nuggets_grid_style($args) {

        /* Set the default arguments. */
        $defaults = array(
            'loop' => null,
            'number_of_columns' => 2,
            'image_size' => 'medium-thumb',
            'excerpt_count' => 120,
            'show_meta' => false,
            'style' => null
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        $style_class = mo_get_column_style($number_of_columns);

        if ($loop->have_posts()) :
            $post_count = 0;

            $first_row = true;
            $last_column = false;

            $style = ($style ? ' ' . $style : '');

            echo '<div class="post-list' . esc_attr($style) . '">';

            while ($loop->have_posts()) : $loop->the_post();

                if ($last_column) {
                    echo '<div class="start-row"></div>';
                    $first_row = false;
                }

                if (++$post_count % $number_of_columns == 0)
                    $last_column = true;
                else
                    $last_column = false;

                echo '<div class="' . esc_attr($style_class) . ' clearfix' . ($last_column ? ' last' : '') . '">';

                echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';

                $thumbnail_exists = mo_thumbnail(array(
                    'image_size' => $image_size,
                    'wrapper' => true,
                    'size' => 'full'
                ));

                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                $before_title = '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">';
                $after_title = '</a></h3>';

                the_title($before_title, $after_title);

                if ($show_meta)
                    echo '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';

                if ($excerpt_count != 0) {
                    echo '<div class="entry-summary">';
                    echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    echo '</div><!-- .entry-summary -->';
                }

                echo '</div><!-- entry-text-wrap -->';

                echo '</article><!-- .hentry -->';

                echo '</div> <!-- .column-class -->';

            endwhile;

            echo '</div> <!-- post-list -->';

            echo '<div class="clear"></div>';

        endif;

        wp_reset_postdata(); // Right placement to help not lose context information
    }
}

if (!function_exists('mo_get_thumbnail_post_list')) {
    function mo_get_thumbnail_post_list($args) {

        /* Set the default arguments. */
        $defaults = array(
            'loop' => null,
            'image_size' => 'thumbnail',
            'style' => null,
            'show_meta' => false,
            'excerpt_count' => 120,
            'hide_thumbnail' => false
        );

        $output = '';

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if (!$loop)
            $loop = new WP_Query($query_args);

        if ($loop->have_posts()):

            $css_class = $image_size . '-size';

            $style = ($style ? ' ' . $style : '');

            $output = '<ul class="post-list' . esc_attr($style) . ' ' . esc_attr($css_class) . '">';

            $hide_thumbnail = mo_to_boolean($hide_thumbnail);

            $show_meta = mo_to_boolean($show_meta);

            while ($loop->have_posts()) : $loop->the_post();

                $output .= '<li>';

                $thumbnail_exists = false;

                $output .= "\n" . '<article class="' . join(' ', get_post_class()) . '">' . "\n"; // Removed id="post-'.get_the_ID() to help avoid duplicate IDs validation error in the page

                if (!$hide_thumbnail) {
                    $thumbnail_url = mo_get_thumbnail(array('image_size' => $image_size));
                    if (!empty($thumbnail_url)) {
                        $thumbnail_exists = true;
                        $output .= $thumbnail_url;
                    }
                }

                $output .= "\n" . '<div class="entry-text-wrap ' . ($thumbnail_exists ? '' : 'nothumbnail') . '">';

                $output .= "\n" . the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h3>', false);

                if ($show_meta) {
                    $output .= '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';
                }

                if ($excerpt_count != 0) {

                    $output .= "\n" . '<div class="entry-summary">';

                    $excerpt_text = mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    $output .= $excerpt_text;

                    $output .= "\n" . '</div><!-- entry-summary -->';
                }

                $output .= "\n" . '</div><!-- entry-text-wrap -->';

                $output .= "\n" . '</article><!-- .hentry -->';

                $output .= '</li>';

            endwhile;

            $output .= '</ul>';

        endif;

        wp_reset_postdata();

        return $output;
    }
}

if (!function_exists('mo_get_post_snippets_layout')) {

    function mo_get_post_snippets_layout($args) {

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if (!empty ($query_args)) {
            $loop = new WP_Query($query_args);
        }
        else {

            if ($post_type == 'portfolio' || $post_type == 'gallery_item') {
                /* Do not continue if the Livemesh Tools plugin is not loaded */
                if (!class_exists('LM_Framework')) {
                    return mo_display_plugin_error();
                }
            }

            if ($post_type == 'portfolio')
                $taxonomy = 'portfolio_category';
            elseif ($post_type == 'gallery_item')
                $taxonomy = 'gallery_category';

            if (empty($post_type))
                $loop = new WP_Query(array(
                    'ignore_sticky_posts' => 1,
                    'posts_per_page' => $post_count
                ));
            elseif (empty($taxonomy) || empty($terms))
                $loop = new WP_Query(array(
                    'post_type' => $post_type,
                    'posts_per_page' => $post_count
                ));
            else
                $loop = new WP_Query(array(
                    'post_type' => $post_type,
                    'posts_per_page' => $post_count,
                    'tax_query' => array(
                        array(
                            'taxonomy' => $taxonomy,
                            'field' => 'slug',
                            'terms' => explode(',', $terms)
                        )
                    )
                ));
        }

        $output = '';

        if ($loop->have_posts()) :

            $style_class = mo_get_column_style($number_of_columns, $no_margin);

            if ($post_type == 'portfolio' || $post_type == 'gallery_item')
                $style_class .= ' showcase-item';

            $hide_thumbnail = mo_to_boolean($hide_thumbnail);

            $display_title = mo_to_boolean($display_title);

            $show_meta = mo_to_boolean($show_meta);

            $display_summary = mo_to_boolean($display_summary);

            $show_excerpt = mo_to_boolean($show_excerpt);

            if (!empty($title))
                $output .= '<h3 class="post-snippets-title">' . esc_html($title) . '</h3>';

            if ($layout_mode == 'masonry')
                $image_size = 'large';

            $output .= '<ul class="image-grid post-snippets ' . esc_attr($layout_class) . ' ' . esc_attr($layout_mode) . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".entry-item", "layoutMode": "' . esc_attr($layout_mode) . '" }\'>';

            while ($loop->have_posts()) : $loop->the_post();

                $thumbnail_exists = false;

                $output .= '<li data-id="' . get_the_ID() . '" class="' . esc_attr($style_class) . ' entry-item">';

                $output .= "\n" . '<article class="' . join(' ', get_post_class()) . '">';

                if (!$hide_thumbnail) {
                    $thumbnail_output = mo_get_thumbnail(array(
                            'image_size' => $image_size,
                            'taxonomy' => $taxonomy
                        ));
                    if (!empty($thumbnail_output)) {
                        $thumbnail_exists = true;
                        $output .= $thumbnail_output;
                    }
                }

                if ($display_title || $display_summary || $show_meta) {
                    $output .= "\n" . '<div class="entry-text-wrap ' . ($thumbnail_exists ? '' : 'nothumbnail') . '">';

                    if ($display_title)
                        $output .= "\n" . the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h3>', false);

                    if ($show_meta) {
                        $output .= '<div class="byline">' . mo_entry_published() . mo_entry_comments_number() . '</div>';
                    }

                    if ($display_summary) {

                        $output .= '<div class="entry-summary">';

                        if ($show_excerpt) {
                            $output .= mo_truncate_string(get_the_excerpt(), $excerpt_count);
                        }
                        else {
                            global $more;
                            $more = 0;
                            $output .= get_the_content(esc_html__('Read More <span class="meta-nav">&rarr;</span>', 'peak'));
                        }
                        $output .= '</div><!-- .entry-summary -->';
                    }

                    $output .= '</div><!-- .entry-text-wrap -->';
                }

                $output .= '</article><!-- .hentry -->';

                $output .= '</li><!-- .isotope element -->';

            endwhile;

            $output .= '</ul> <!-- post-snippets -->';

        endif;

        wp_reset_postdata();

        return $output;
    }
}


if (!function_exists('mo_get_post_listing')) {

    // Display posts snippets list for flexslider carousel
    function mo_get_post_listing($args) {

        /* Extract the array to allow easy use of variables. */
        extract($args);

        if (empty($terms))
            $loop = new WP_Query(array(
                'ignore_sticky_posts' => 1,
                'posts_per_page' => $post_count
            ));
        else
            $loop = new WP_Query(array(
                'post_type' => 'post',
                'posts_per_page' => $post_count,
                'tax_query' => array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => explode(',', $terms)
                    )
                )
            ));

        $output = '';

        if ($loop->have_posts()) :

            $output .= '<ul class="post-listing">';

            while ($loop->have_posts()) : $loop->the_post();

                $output .= "\n" . '<li>';

                $output .= '<article class="' . join(' ', get_post_class()) . '">';

                $output .= "\n" . '<div class="post-info">' . mo_entry_terms_list() . mo_entry_published() . '</div>';

                $output .= "\n" . the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark">', '</a></h3>', false);

                $output .= "\n" . '<div class="byline">' . esc_html__('Posted by ', 'peak') . mo_entry_author() . '</div>';

                $output .= '</article><!-- .hentry -->';

                $output .= "\n" . '</li>';

            endwhile;

            $output .= '</ul>';

        endif;

        wp_reset_postdata();

        return $output;
    }
}

if (!function_exists('mo_get_post_type_archive_url')) {

    function mo_get_post_type_archive_url($post_type) {

        $archive_url = get_post_type_archive_link($post_type);

        if (empty($archive_url)) {
            $page_id = mo_get_post_type_archive_page_id($post_type);
            if (!empty($page_id))
                $archive_url = get_permalink($page_id);
        }
        return $archive_url;
    }

}

if (!function_exists('mo_get_post_type_archive_page_id')) {

    function mo_get_post_type_archive_page_id($post_type) {

        $page_id = null;

        $archive_template_map = mo_get_archive_template_map();

        $pages = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => $archive_template_map[$post_type]
        ));
        foreach ($pages as $page) {
            $page_id = $page->ID;
        }

        return $page_id;
    }

}

if (!function_exists('mo_get_archive_template_map')) {
    function mo_get_archive_template_map() {
        $archive_template_map = array(
            'gallery' => 'template-gallery.php',
            'portfolio' => 'template-portfolio.php',
            'post' => 'template-blog.php',
            'campaign' => 'template-campaigns.php'
        );
        return $archive_template_map;
    }
}

if (!function_exists('mo_display_post_thumbnail')) {
    function mo_display_post_thumbnail() {

        $post_id = get_the_ID();
        $args = mo_get_thumbnail_args_for_singular();
        $image_size = $args['image_size'];
        $thumbnail_exists = mo_display_slider_thumbnail($post_id, $image_size);
        if (!$thumbnail_exists) {

            $thumbnail_exists = mo_thumbnail($args);
        }
        return $thumbnail_exists;

    }
}

if (!function_exists('mo_is_context')) {
    function mo_is_context($context) {

        global $mo_theme;

        $current = $mo_theme->get_context('loop');

        if ($current == $context)
            return true;

        return false;
    }
}

