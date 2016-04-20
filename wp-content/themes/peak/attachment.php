<?php

/**
 * Attachment Template
 *
 * This template is loaded when browsing a Wordpress attachment.
 *
 * @package Peak
 * @subpackage Template
 */

get_header();
?>
    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <div class="hfeed">

            <?php if (have_posts()) : ?>

                <?php while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php echo mo_get_entry_title(); ?>

                        <?php
                        // Do not display meta for attachments - not much use
                        echo '<div class="entry-meta">' . mo_entry_published("M d, Y") . mo_entry_author() . mo_entry_comments_link() . '</div>';
                        ?>

                        <div class="entry-content clearfix">

                            <?php the_attachment_link(get_the_ID(), true) ?>

                            <?php the_content(); ?>

                            <?php wp_link_pages(array('link_before' => '<span class="page-number">', 'link_after' => '</span>', 'before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'), 'after' => '</p>')); ?>

                        </div>
                        <!-- .entry-content -->

                    </article><!-- .hentry -->

                    <?php comments_template('/comments.php', true); // Loads the comments.php template.   ?>

                <?php endwhile; ?>

            <?php endif; ?>

        </div>
        <!-- .hfeed -->

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

<?php get_footer(); ?>