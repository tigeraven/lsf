<?php


/* Team Shortcode -

Displays a list of team members entered by creating Team custom post types in the Team Profiles tab of the WordPress Admin.
Usage:

[team post_count=6 column_count=3 member_ids="123,234,456,876,654,321"]

Parameters -

post_count - Number of team members to display if the query returns more than the specified number
column_count - Number of columns per row of team members displayed
member_ids - The custom post ids of the member profiles to be displayed.
*/

if (!function_exists('mo_team_shortcode')) {

    function mo_team_shortcode($atts, $content = null, $shortcode_name = "") {

        extract(shortcode_atts(array(
            'post_count' => '-1',
            'column_count' => '',
            'member_ids' => '',
        ), $atts));

        $query_args = array(
            'post_type' => 'team',
            'posts_per_page' => $post_count,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        if (!empty($member_ids))
            $query_args['post__in'] = explode(',', $member_ids);

        $output = mo_get_team_content($query_args, $column_count);

        // Output the HTML if it exists
        return ($output) ? $output : '';
    }
}

/**
 * @param $query_args
 * @return String
 */

if (!function_exists('mo_get_team_content')) {
    function mo_get_team_content($query_args, $column_count) {

        global $post;

        // Get 'team' posts
        $team_posts = get_posts($query_args);

        $output = null;
        if ($team_posts):

            if (empty($column_count))
                $column_count = count($team_posts);
            $style_class = mo_get_column_style($column_count);
            $counter = 0;

            // Gather output
            ob_start();
            ?>
            <div class="team clearfix">
                <?php
                foreach ($team_posts as $post):
                    setup_postdata($post);
                    $post_id = $post->ID;
                    $member_name = get_the_title();
                    $position = htmlspecialchars_decode(get_post_meta($post_id, '_lm_position', true));
                    $email = get_post_meta($post_id, '_lm_email', true);
                    $phone = get_post_meta($post_id, '_lm_phone', true);
                    $twitter = get_post_meta($post_id, '_lm_twitter', true);
                    $linkedin = get_post_meta($post_id, '_lm_linkedin', true);
                    $googleplus = get_post_meta($post_id, '_lm_googleplus', true);
                    $facebook = get_post_meta($post_id, '_lm_facebook', true);
                    $dribbble = get_post_meta($post_id, '_lm_dribbble', true);

                    $last_column = (++$counter % $column_count == 0) ? true : false;

                    ?>

                    <div class="<?php echo esc_attr($style_class) . ($last_column ? ' last' : ''); ?>">

                        <div class="center">

                            <div class="team-member">

                                <div class="img-wrap">

                                    <?php
                                    $image_alt = $member_name;
                                    mo_thumbnail(array('image_size' => 'square', 'image_class' => 'img-circle', 'wrapper' => true, 'image_alt' => $image_alt, 'size' => 'full'));
                                    ?>

                                </div>

                                <?php echo '<h3>' . esc_html($member_name) . '</h3>'; ?>

                                <?php echo '<div class="employee-title">' . wp_kses_post($position) . '</div>'; ?>

                                <div class="social-wrap">
                                    <?php

                                    $shortcode_text = '[social_list';
                                    $shortcode_text .= $twitter ? ' twitter_url="' . $twitter . '"' : '';
                                    $shortcode_text .= $googleplus ? ' googleplus_url="' . $googleplus . '"' : '';
                                    $shortcode_text .= $linkedin ? ' linkedin_url="' . $linkedin . '"' : '';
                                    $shortcode_text .= $facebook ? ' facebook_url="' . $facebook . '"' : '';
                                    $shortcode_text .= ' align="right"]';

                                    echo do_shortcode($shortcode_text); ?>
                                </div>

                                <div class="bio"><?php the_content(); ?></div>

                            </div>

                        </div>

                    </div>

                    <?php if ($last_column)
                    echo '<div class="clear"></div>';?>

                    <?php wp_reset_postdata(); ?>

                <?php endforeach; ?>

            </div><!-- .team -->

            <?php
            // Save output
            $output = ob_get_contents();
            ob_end_clean();

        endif;

        return $output; // end if $team_posts
    }
}

add_shortcode('team', 'mo_team_shortcode');