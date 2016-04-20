<?php

if (!function_exists('mo_display_archive_content')) {

    function mo_display_archive_content($query_args = null) {
        global $mo_theme;

        if (!empty($query_args))
            $mo_theme->set_context('loop', 'custom'); // tells the thumbnail functions to prepare lightbox constructs for the image
        else
            $mo_theme->set_context('loop', 'archive'); // tells the thumbnail functions to prepare lightbox constructs for the image

        mo_display_blog_content($query_args);

        $mo_theme->set_context('loop', null); //reset it
    }
}

if (!function_exists('mo_display_blog_content')) {

    function mo_display_blog_content($query_args = null, $layout_option = 'List') {
        $layout_manager = mo_get_layout_manager();
        if ($layout_manager->is_full_width_layout()) {
            $image_size = 'full';
        }
        else {
            // 3 Column and 2 Column layouts will share the
            // image and resizing will happen through css
            $image_size = 'large';
        }
        $class_name = 'default-list';

        $excerpt_count = mo_get_theme_option('mo_excerpt_count', 250);

        $args = array(
            'list_style' => $class_name,
            'image_size' => $image_size,
            'query_args' => $query_args,
            'excerpt_count' => $excerpt_count,
            'layout_option' => $layout_option
        );

        // If custom query is specified, use the same else just go ahead with the existing loop
        if (!empty($query_args)) {
            mo_display_custom_content_list_style($args);
        }
        else {
            mo_display_post_content_list_style($args);
        }
    }
}

if (!function_exists('mo_display_custom_content_list_style')) {
    function mo_display_custom_content_list_style($args) {

        /* Set the default arguments. */
        $defaults = array(
            'list_style' => 'default-list',
            'image_size' => 'large',
            'query_args' => null,
            'excerpt_count' => 160
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);
        ?>

        <div id="content" class="<?php echo esc_attr($list_style); ?> <?php echo esc_attr(mo_get_content_class()); ?>">

            <?php mo_display_breadcrumbs(); ?>

            <div class="hfeed">

                <?php
                $loop = new WP_Query($query_args);
                ?>

                <?php if ($loop->have_posts()) : ?>

                    <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                        <article id="post-<?php the_ID(); ?>"
                                 class="<?php echo(join(' ', get_post_class()) . (empty($thumbnail_element) ? ' nothumbnail' : '')); ?> clearfix">

                            <div class="entry-snippet">

                                <?php

                                $thumbnail_exists = mo_display_blog_thumbnail($image_size);

                                echo mo_entry_terms_list('category');

                                echo mo_get_entry_title();

                                echo '<div class="entry-meta">' . mo_entry_author() . mo_entry_published("F d, Y") . mo_entry_comments_link() . '</div>';

                                mo_display_blog_entry_text($thumbnail_exists, $excerpt_count);

                                $disable_read_more_button = mo_get_theme_option('mo_disable_read_more_button_in_archives');

                                if (!$disable_read_more_button)
                                    echo '<span class="read-more-link"><a class="button default" href="' . get_permalink() . '" title="' . get_the_title() . '">' . esc_html__('Read More', 'peak') . '</a></span>';

                                ?>

                            </div>
                            <!-- .entry-snippet -->

                        </article><!-- .hentry -->

                    <?php endwhile; ?>

                <?php else : ?>

                    <?php get_template_part('loop-error'); // Loads the loop-error.php template.
                    ?>

                <?php endif; ?>

            </div>
            <!-- .hfeed -->

            <?php
            include(locate_template('loop-nav.php'));
            ?>

        </div><!-- #content -->

        <?php wp_reset_postdata(); /* Right placement to help not lose context information */
        ?>


    <?php
    }
}

if (!function_exists('mo_display_post_content_list_style')) {
    function mo_display_post_content_list_style($args) {

        /* Set the default arguments. */
        $defaults = array(
            'list_style' => 'default-list',
            'image_size' => 'large',
            'excerpt_count' => 160
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);
        ?>

        <div id="content" class="<?php echo esc_attr($list_style); ?> <?php echo mo_get_content_class(); ?>">

            <?php mo_display_breadcrumbs(); ?>

            <div class="hfeed">

                <?php if (have_posts()) : ?>

                    <?php while (have_posts()) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>"
                                 class="<?php echo(join(' ', get_post_class()) . (empty($thumbnail_element) ? ' nothumbnail' : '')); ?> clearfix">

                            <div class="entry-snippet">

                                <?php

                                $thumbnail_exists = mo_display_blog_thumbnail($image_size);

                                echo mo_entry_terms_list('category');

                                echo mo_get_entry_title();

                                echo '<div class="entry-meta">' . mo_entry_author() . mo_entry_published("F d, Y") . mo_entry_comments_link() . '</div>';

                                mo_display_blog_entry_text($thumbnail_exists, $excerpt_count);

                                $disable_read_more_button = mo_get_theme_option('mo_disable_read_more_button_in_archives');

                                if (!$disable_read_more_button)
                                    echo '<span class="read-more-link"><a class="button default" href="' . get_permalink() . '" title="' . get_the_title() . '">' . esc_html__('Read More', 'peak') . '</a></span>';

                                ?>

                            </div>
                            <!-- .entry-snippet -->

                        </article><!-- .hentry -->

                    <?php endwhile; ?>

                <?php else : ?>

                    <?php get_template_part('loop-error'); // Loads the loop-error.php template.
                    ?>

                <?php endif; ?>

            </div>
            <!-- .hfeed -->

            <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.
            ?>

        </div><!-- #content -->

    <?php
    }
}

if (!function_exists('mo_display_blog_entry_text')) {
    function mo_display_blog_entry_text($thumbnail_exists, $excerpt_count) {

        echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

        echo '<div class="entry-summary">';

        $show_content = mo_get_theme_option('mo_show_content_in_archives');

        if ($show_content) {
            global $more;
            $more = 0;
            /*TODO: Remove the more link here since it will be shown later */
            the_content(esc_html__('Read More <span class="meta-nav">&rarr;</span>', 'peak'));
        }
        else {
            echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
        }

        wp_link_pages(array(
            'before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'),
            'after' => '</p>'
        ));

        echo '</div> <!-- .entry-summary -->';

        echo '</div>';

    }
}

if (!function_exists('mo_show_page_content')) {
    function mo_show_page_content() {

        if (is_archive() || is_search())
            return; // No content to be shown for archive pages. All content is derived.

        if (have_posts()) :
            ?>

            <?php while (have_posts()) : the_post(); ?>

            <?php if (get_the_content()): ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="entry-content clearfix">

                        <?php the_content(); ?>

                    </div>
                    <!-- .entry-content -->

                </article><!-- .hentry -->

            <?php endif; ?>

        <?php endwhile; ?>

        <?php
        endif;
    }
}

if (!function_exists('mo_display_slider_thumbnail')) {
    function mo_display_slider_thumbnail($post_id, $image_size) {

        $use_slider_thumbnail = get_post_meta($post_id, 'mo_use_slider_thumbnail', true);

        if ($use_slider_thumbnail) {

            $slides = get_post_meta($post_id, 'post_slider', true);

            if (!empty($slides)) {
                $output = '[responsive_slider slideshow_speed=3000 control_nav="false" direction_nav="false" type="thumbnail" ]';
                $output .= '<ul>';
                foreach ($slides as $slide) {
                    $output .= '<li>' . mo_get_image_element(esc_url($slide['slider_image']), null, 'thumbnail-slide', esc_attr($slide['title'])) . '</li>';
                }
                $output .= '</ul>';
                $output .= '[/responsive_slider]';

                echo do_shortcode($output);

                return true;
            }
        }
    }
}

if (!function_exists('mo_display_blog_thumbnail')) {
    function mo_display_blog_thumbnail($image_size, $taxonomy = "category") {

        global $post;

        $thumbnail_exists = mo_display_slider_thumbnail($post->ID, $image_size);

        if (!$thumbnail_exists)
            $thumbnail_exists = mo_thumbnail(array(
                'image_size' => $image_size,
                'wrapper' => true,
                'size' => 'large',
                'taxonomy' => $taxonomy
            ));
        return $thumbnail_exists;
    }
}
