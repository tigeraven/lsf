<?php
/**
 * Template Name: Composite Page
 *
 * Custom Page template for creating single page site utilizing page sections custom post type instances
 *
 * @package Peak
 * @subpackage Template
 */

get_header(); // displays slider content if so chosen by user
?>

<div id="content" class="<?php echo mo_get_content_class(); ?>">

    <div class="hfeed">

        <?php

        /* Check if Livemesh Tools plugin is active before proceeding */
        if (class_exists('LM_Framework')) :

            $page_sections_ids = mo_get_chosen_page_section_ids(get_the_ID());
            if (!empty($page_sections_ids))
                $posts_per_page = -1;
            else
                $posts_per_page = 20; // limit the number of page sections shown if none selected

            $loop = new WP_Query(array(
                'post_type' => 'page_section',
                'posts_per_page' => $posts_per_page,
                'post__in' => $page_sections_ids,
                'orderby' => 'post__in',
                'post_status' => 'publish'
            ));

            if ($loop->have_posts()) {

                while ($loop->have_posts()) : $loop->the_post();

                    $post_id = get_the_ID(); ?>

                    <article class="<?php echo(join(' ', get_post_class()) . ' first'); ?>">

                        <?php the_content(); ?>

                        <?php
                        if (current_user_can('edit_post', $post_id) && $link = esc_url(get_edit_post_link($post_id)))
                            echo '<a title="' . get_the_title($post_id) . '" class="button edit-button" href="' . esc_url($link) . '" target="_blank">' . esc_html__('Edit', 'peak') . '</a>';
                        ?>

                    </article>
                    <!-- .hentry -->

                <?php

                endwhile;
            }
            else {
                get_template_part('loop-error'); // Loads the loop-error.php template.
            }

        else :
            mo_display_plugin_error();

        endif;

        ?>

    </div>
    <!-- .hfeed -->

</div><!-- #content -->

<?php wp_reset_postdata(); /* Right placement to help not lose context information */ ?>

<?php get_footer(); ?>
