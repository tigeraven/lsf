<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress post.
 *
 * @package Peak
 * @subpackage Template
 */

get_header();
?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php mo_display_breadcrumbs(); ?>

        <div class="hfeed">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php echo mo_entry_terms_list('category'); ?>

                        <?php echo mo_get_entry_title(); ?>

                        <?php echo '<div class="entry-meta">' . mo_entry_author() . mo_entry_published("F d, Y") . mo_entry_comments_link() . '</div>'; ?>

                        <div class="entry-content clearfix">

                            <?php
                            mo_display_post_thumbnail();
                            ?>

                            <?php the_content(); ?>

                            <?php wp_link_pages(array(
                                'link_before' => '<span class="page-number">',
                                'link_after' => '</span>',
                                'before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'),
                                'after' => '</p>'
                            )); ?>

                        </div>
                        <!-- .entry-content -->

                        <?php $post_tags = wp_get_post_tags($post->ID);

                        if (!empty($post_tags)) : ?>

                            <div class="entry-meta taglist">

                                <?php echo mo_entry_terms_list('post_tag', ''); ?>

                            </div>

                        <?php endif; ?>

                        <?php mo_display_rrssb_social_media_buttons(); ?>

                    </article><!-- .hentry -->

                    <?php mo_display_sidebar('after-singular-post'); ?>

                    <?php comments_template('/comments.php', true); // Loads the comments.php template.   ?>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        <!-- .hfeed -->

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

        <?php

        $column_count = 4;
        $post_count = 3;
        if (mo_get_layout_manager()->is_two_column_layout()) {
            $column_count = 3;
            $post_count = 2;
        }
        $args = array(
            'taxonomy' => 'category',
            'header_text' => esc_html__('Related Posts', 'peak'),
            'display_summary' => false,
            'post_count' => $post_count,
            'number_of_columns' => $column_count
        );

        mo_display_related_posts($args); ?>

    </div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>