<?php
/**
 * A generic page content template part
 *
 * A reusable page template part for displaying contents of a page
 *
 * @package Peak
 * @subpackage Template
 */
?>

<div id="content" class="<?php echo mo_get_content_class();?>">

    <?php mo_display_breadcrumbs(); ?>

    <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="entry-content">

                    <?php
                    $thumbnail_args = mo_get_thumbnail_args_for_singular();
                    mo_thumbnail($thumbnail_args);
                    ?>

                    <?php the_content(); ?>

                    <?php wp_link_pages(array('before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'), 'after' => '</p>')); ?>

                </div><!-- .entry-content -->

            </article><!-- .hentry -->

            <?php mo_display_sidebar('after-singular-page'); ?>

            <?php comments_template('/comments.php', true); // Loads the comments.php template.  ?>

        <?php endwhile; ?>

    <?php endif; ?>

</div><!-- #content -->