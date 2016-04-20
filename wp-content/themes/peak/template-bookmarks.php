<?php
/**
 * Template Name: Bookmarks
 *
 * A custom page template for displaying the site's bookmarks/links.
 *
 * @package Peak
 * @subpackage Template
 */
get_header();

?>

    <div id="content" class="<?php echo mo_get_content_class(); ?>">

        <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <div class="entry-content clearfix">
                        <?php the_content(); ?>

                        <?php
                        $args = array(
                            'title_li' => false,
                            'title_before' => '<h2>',
                            'title_after' => '</h2>',
                            'category_before' => false,
                            'category_after' => false,
                            'categorize' => true,
                            'show_description' => true,
                            'between' => '<br />',
                            'show_images' => false,
                            'show_rating' => false,
                        );
                        ?>
                        <?php wp_list_bookmarks($args); ?>

                        <?php wp_link_pages(array('before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'), 'after' => '</p>')); ?>
                    </div>
                    <!-- .entry-content -->

                </article><!-- .hentry -->

                <?php comments_template('/comments.php', true); // Loads the comments.php template. ?>

            <?php endwhile; ?>

        <?php endif; ?>

    </div><!-- #content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>