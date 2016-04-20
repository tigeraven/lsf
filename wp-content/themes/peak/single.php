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

                        <?php echo mo_get_entry_title(); ?>

                        <?php echo '<div class="entry-meta">' . mo_entry_published("M d, Y") . mo_entry_author() . mo_entry_comments_link() . mo_entry_terms_list('category') . '</div>'; ?>

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

                    <?php comments_template('/comments.php', true); // Loads the comments.php template.   ?>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        <!-- .hfeed -->

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>