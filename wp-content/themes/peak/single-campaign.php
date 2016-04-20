<?php

/**
 * Post Template
 *
 * This template is loaded when browsing a Wordpress campaign post type.
 *
 * @package Peak
 * @subpackage Template
 */

$donation_form = get_post_meta($post->ID, '_lm_campaign_form', true);

$image_size = "large";

get_header();
?>

    <div id="content" class="ninecol">

        <div class="hfeed">

            <?php if (have_posts()) :

                while (have_posts()) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="entry-content clearfix">

                            <div class="campaign-content">

                                <?php mo_display_breadcrumbs(); ?>

                                <?php
                                mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'before_html' => '<div class="featured-thumbnail">',
                                    'after_html' => '</div>',
                                    'wrapper' => false
                                ));

                                ?>

                                <?php if (post_type_exists('give_forms') && !empty($donation_form)) : ?>

                                    <div class="campaign-stats">

                                        <?php echo mo_display_campaign_collections($donation_form); ?>

                                        <a class="button donate-now large" href="#"
                                           target="_self"><?php echo esc_html__('Donate Now', 'peak'); ?></a>

                                    </div>

                                    <div class="donation-form">

                                        <?php

                                        //add_filter('give_donate_form', 'mo_donate_form_filter');

                                        echo do_shortcode('[give_form id="' . intval($donation_form) . '"]'); ?>

                                    </div>

                                <?php endif; ?>

                                <?php the_content(); ?>

                                <?php mo_display_related_events($post->ID); ?>


                            </div>

                            <div class="clear"></div>

                        </div>
                        <!-- .entry-content -->

                    </article><!-- .hentry -->

                    <?php

                    comments_template('/comments.php', true); // Loads the comments.php template.

                endwhile;

            endif; ?>

        </div>
        <!-- .hfeed -->

        <?php get_template_part('loop-nav'); // Loads the loop-nav.php template.   ?>

    </div><!-- #content -->

    <div class="campaign-sidebar sidebar-right-nav threecol last">

        <div class="campaign-details box-wrap">

            <div class="content-wrap">

                <?php $campaign_info = get_post_meta($post->ID, '_lm_campaign_info', true); ?>

                <?php if (!empty($campaign_info)) : ?>

                    <div class="campaign-information info-section first">

                        <h3 class="subheading"><?php echo esc_html__('Campaign Info', 'peak'); ?></h3>

                        <div class="info-content">

                            <?php echo wp_kses_post($campaign_info); ?>

                        </div>

                    </div>

                <?php endif; ?>

                <div class="socials info-section">

                    <h3 class="subheading"><?php echo esc_html__('Share', 'peak'); ?></h3>

                    <div class="info-content">

                        <?php

                        echo get_the_excerpt();

                        ?>

                    </div>

                    <div class="share">

                        <?php

                        mo_display_rrssb_social_media_buttons();

                        ?>

                    </div>

                </div>

            </div>

        </div>
        <!-- campaign-details -->

        <?php dynamic_sidebar('primary-campaign');; ?>

    </div>
    <!-- campaign-sidebar -->

<?php get_footer(); ?>