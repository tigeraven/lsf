<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Peak
 * @subpackage Template
 */

get_header(); ?>

    <div id="content">

        <?php mo_display_breadcrumbs(); ?>

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="entry-content">

                        <?php the_content(); /* No thumbnail support for this. Everything user has to input - videos, audio, slider etc. */ ?>

                        <?php wp_link_pages(array(
                            'before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'),
                            'after' => '</p>'
                        )); ?>

                    </div>
                    <!-- .entry-content -->

                    <div id="portfolio-footer">
                        <div class="social-share">
                            <?php
                            echo '<span>';
                            echo esc_html__('Share:', 'peak');
                            echo '</span>';
                            mo_display_rrssb_social_media_buttons();
                            ?>
                        </div>
                        <div class="portfolio-link">
                            <?php
                            $project_url = get_post_meta($post->ID, '_portfolio_link_field', true);
                            if (!empty($project_url)) {
                                echo '<a href = "' . esc_url($project_url) . '" class="button">' . esc_html__('Visit Site', 'peak') . '</a>';
                            }
                            ?>
                        </div>
                    </div>

                </article><!-- .hentry -->

                <?php if (mo_get_theme_option('mo_enable_portfolio_comments')) {
                    comments_template('/comments.php', true); // Loads the comments.php template.
                } ?>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php
        $args = array(
            'taxonomy' => 'portfolio_category',
            'header_text' => esc_html__('Related Portfolio', 'peak'),
            'post_count' => 5,
            'number_of_columns' => 3
        );

        mo_display_related_posts($args); ?>


        <nav class="portfolio-nav">

                <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

        </nav>


    </div><!-- #content -->

<?php get_footer(); ?>