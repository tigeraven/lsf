<?php
/**
 * Template Name: Archives
 *
 * A custom page template for displaying blog archives.
 *
 * @package Peak
 * @subpackage Template
 */
get_header();
?>

<div id="archives-template" class="layout-1c">

<div id="content" class="<?php echo mo_get_content_class();?>">

        <?php mo_display_breadcrumbs(); ?>

        <?php if (have_posts()) : ?>

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <div class="entry-content clearfix">

                    <?php the_content(); ?>

                    <div class="fourcol">

                        <h2><?php esc_html_e('Recent 20 Posts', 'peak'); ?></h2>

                        <ul class="recent-posts list1">
                            <?php
                            $args = array('numberposts' => '20');
                            $recent_posts = wp_get_recent_posts($args);
                            foreach ($recent_posts as $recent) {
                                echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look ' . esc_attr($recent["post_title"]) . '" >' . esc_html($recent["post_title"]) . '</a> </li> ';
                            }
                            ?>
                        </ul>

                    </div>

                    <div class="fourcol">

                        <h2><?php esc_html_e('Archives by category', 'peak'); ?></h2>

                        <ul class="category-archives list1">

                            <?php wp_list_categories(array('show_count' => false, 'use_desc_for_title' => false, 'title_li' => false)); ?>

                        </ul>
                        <!-- .category-archives -->

                    </div>

                    <div class="fourcol last">

                        <h2><?php esc_html_e('Archives by month', 'peak'); ?></h2>

                        <ul class="monthly-archives list1">

                            <?php wp_get_archives(array('show_post_count' => true, 'type' => 'monthly')); ?>

                        </ul>
                        <!-- .monthly-archives -->

                        <div class="divider-line"></div>

                        <h2 id="authors"> <?php esc_html_e('Author Archives', 'peak'); ?></h2>

                        <ul class="list1">

                            <?php wp_list_authors(array('exclude_admin' => false, 'optioncount' => true)); ?>

                        </ul>

                    </div>

                    <?php wp_link_pages(array('before' => '<p class="page-links">' . esc_html__('Pages:', 'peak'), 'after' => '</p>')); ?>

                </div>
                <!-- .entry-content -->

            </article><!-- .hentry -->

            <?php endwhile; ?>

        <?php endif; ?>

    </div><!-- #content -->

</div>

<?php get_footer(); ?>