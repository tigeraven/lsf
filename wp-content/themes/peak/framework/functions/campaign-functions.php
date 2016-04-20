<?php

if (!function_exists('mo_display_campaign_content')) {


    function mo_display_campaign_content($args) {

        /* Do not continue if the Livemesh Tools plugin is not loaded */
        if (!class_exists('LM_Framework')) {
            return mo_display_plugin_error();
        }

        global $mo_theme;

        $mo_theme->set_context('loop', 'campaign'); // tells the thumbnail functions to prepare lightbox constructs for the image

        if (is_front_page()) {
            $paged = (get_query_var('page')) ? get_query_var('page') : 1;
        }
        else {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        $query_args = array(
            'post_type' => 'campaign',
            'posts_per_page' => $args['posts_per_page'],
            'filterable' => $args['filterable'],
            'paged' => $paged,
            'orderby' => 'menu_order',
            'order' => 'ASC'
        );

        $term = get_term_by('slug', get_query_var('term'), 'campaign_category');

        if ($term)
            $query_args['campaign_category'] = $term->slug;

        $args['query_args'] = $query_args;

        mo_display_campaign_content_grid_style($args);

        $mo_theme->set_context('loop', null); //reset it
    }
}

if (!function_exists('mo_display_campaign_content_grid_style')) {
    function mo_display_campaign_content_grid_style($args) {

        /* Set the default arguments. */
        $defaults = array(
            'number_of_columns' => 4,
            'image_size' => 'medium-thumb',
            'query_args' => null,
            'excerpt_count' => 160,
            'layout_mode' => 'fitRows'
        );

        /* Merge the input arguments and the defaults. */
        $args = wp_parse_args($args, $defaults);

        /* Extract the array to allow easy use of variables. */
        extract($args);

        $style_class = mo_get_column_style($number_of_columns);
        ?>

        <div id="content" class="<?php echo mo_get_content_class(); ?>">

            <?php mo_display_breadcrumbs(); ?>

            <div class="hfeed">

                <?php
                mo_show_page_content();

                $loop = new WP_Query($query_args);

                if ($loop->have_posts()) :

                    if ($filterable)
                        echo mo_get_taxonomy_terms_filter('campaign_category');
                    else
                        echo mo_get_taxonomy_terms_links('campaign', 'campaign_category');

                    echo '<ul id="showcase-items" class="image-grid post-snippets ' . esc_attr($layout_mode) . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".showcase-item", "layoutMode": "' . esc_attr($layout_mode) . '" }\'>';

                    while ($loop->have_posts()) : $loop->the_post();

                        $style = $style_class . ' showcase-item clearfix';
                        $terms = get_the_terms(get_the_ID(), 'campaign_category');
                        if (!empty($terms)) {
                            foreach ($terms as $term) {
                                $style .= ' term-' . $term->term_id;
                            }
                        }
                        ?>
                        <li data-id="id-<?php the_ID(); ?>" class="<?php echo esc_attr($style); ?>">

                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                <?php $thumbnail_exists = mo_thumbnail(array(
                                    'image_size' => $image_size,
                                    'wrapper' => true,
                                    'size' => 'full',
                                    'taxonomy' => 'campaign_category'
                                ));

                                $display_summary = mo_get_theme_option('mo_show_details_in_campaign') ? true : false;

                                echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

                                echo mo_get_entry_title();

                                $donation_form = get_post_meta(get_the_ID(), '_lm_campaign_form', true);

                                echo mo_display_campaign_collections($donation_form);

                                if ($display_summary) {

                                    echo '<div class="entry-summary">';

                                    $show_excerpt = mo_get_theme_option('mo_show_content_summary_in_campaign') ? false : true;

                                    if ($show_excerpt) {
                                        echo mo_truncate_string(get_the_excerpt(), $excerpt_count);
                                    }
                                    else {
                                        global $more;
                                        $more = 0;
                                        the_content(esc_html__('Read More <span class="meta-nav">&rarr;</span>', 'peak'));
                                    }

                                    echo '</div> <!-- .entry-summary -->';

                                }

                                echo '</div> <!-- .entry-text-wrap -->';

                                ?>

                            </article>
                            <!-- .hentry -->

                        </li> <!--Isotope element -->


                    <?php endwhile; ?>

                    </ul> <!-- Isotope items -->

                <?php else : ?>

                    <?php get_template_part('loop-error'); // Loads the loop-error.php template.                  ?>

                <?php endif; ?>

            </div>
            <!-- .hfeed -->

            <?php
            /* No need to load the loop-nav.php template if filterable is true since all posts get displayed. */
            if (!$filterable) {
                include(locate_template('loop-nav.php'));
            }
            ?>

        </div><!-- #content -->

        <?php wp_reset_postdata(); /* Right placement to help not lose context information */ ?>

    <?php
    }
}

if (!function_exists('mo_get_filterable_campaign_content')) {
    function mo_get_filterable_campaign_content($args) {
        global $mo_theme;

        $output = '';

        $mo_theme->set_context('loop', 'campaign'); // tells the thumbnail functions to prepare lightbox constructs for the image

        /* Extract the array to allow easy use of variables. */
        extract($args);

        $style_class = mo_get_column_style($number_of_columns, $no_margin);

        $loop = new WP_Query(array(
            'post_type' => 'campaign',
            'posts_per_page' => $posts_per_page
        ));

        if ($loop->have_posts()) :

            $filterable = mo_to_boolean($filterable);
            if ($filterable)
                $output .= mo_get_taxonomy_terms_filter('campaign_category');

            $output .= '<ul id="showcase-items" class="image-grid post-snippets ' . esc_attr($layout_mode) . ' js-isotope" data-isotope-options=\'{ "itemSelector": ".showcase-item", "layoutMode": "' . esc_attr($layout_mode) . '" }\'>';

            $output .= '<div class="hfeed">';

            while ($loop->have_posts()) : $loop->the_post();

                if ($layout_mode == 'masonry')
                    $image_size = 'large';

                $style = $style_class . ' showcase-item clearfix'; // no margin or spacing between campaign items
                $terms = get_the_terms(get_the_ID(), 'campaign_category');
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $style .= ' term-' . $term->term_id;
                    }
                }

                $output .= '<li data-id="id-' . get_the_ID() . '" class="' . esc_attr($style) . '">';

                $output .= '<article id="post-' . get_the_ID() . '" class="' . join(' ', get_post_class()) . '">';

                $output .= mo_get_thumbnail(array(
                    'image_size' => $image_size,
                    'wrapper' => true,
                    'size' => 'full',
                    'taxonomy' => 'campaign_category'
                ));

                $display_summary = mo_get_theme_option('mo_show_details_in_campaign') ? true : false;

                $output .= '<div class="entry-text-wrap">';

                $output .= mo_get_entry_title();

                $donation_form = get_post_meta(get_the_ID(), '_lm_campaign_form', true);

                $output .= mo_display_campaign_collections($donation_form);

                if ($display_summary) {

                    $output .= '<div class="entry-summary">';

                    $show_excerpt = mo_get_theme_option('mo_show_content_summary_in_campaign') ? false : true;

                    if ($show_excerpt) {
                        $output .= mo_truncate_string(get_the_excerpt(), $excerpt_count);
                    }
                    else {
                        global $more;
                        $more = 0;
                        the_content(esc_html__('Read More <span class="meta-nav">&rarr;</span>', 'peak'));
                    }

                    $output .= '</div> <!-- .entry-summary -->';

                }

                $output .= '</div> <!-- .entry-text-wrap -->';

                $output .= '</article><!-- .hentry -->';

                $output .= '</li> <!--isotope element -->';

            endwhile;

            $output .= '</ul> <!-- Isotope items -->';

            $output .= '</div> <!-- .hfeed -->';

        else :
            get_template_part('loop-error'); // Loads the loop-error.php template.
        endif;

        wp_reset_postdata();

        $mo_theme->set_context('loop', null); //reset it

        return $output;
    }
}

if (!function_exists('mo_display_campaign_entry_text')) {
    function mo_display_campaign_entry_text($thumbnail_exists, $excerpt_count) {

        $display_title = mo_get_theme_option('mo_show_title_in_campaign') ? true : false;

        $display_summary = mo_get_theme_option('mo_show_details_in_campaign') ? true : false;

        if ($display_summary || $display_title) {

            echo '<div class="entry-text-wrap' . ($thumbnail_exists ? '' : ' nothumbnail') . '">';

            echo mo_get_entry_title();

            if ($display_summary) {

                echo '<div class="entry-summary">';

                echo mo_truncate_string(get_the_excerpt(), $excerpt_count);

                echo '</div> <!-- .entry-summary -->';

            }

            echo '</div> <!-- .entry-text-wrap -->';
        }


    }
}

if (!function_exists('mo_is_campaign_page')) {
    /**
     * Check if this is a campaign page
     */
    function mo_is_campaign_page() {

        if (is_page_template('template-campaigns.php')
            || is_page_template('template-campaigns-filterable.php')
        )
            return true;

        return false;
    }

}

if (!function_exists('mo_is_campaign_context')) {
    /**
     * Check if this is a campaign context
     *
     */
    function mo_is_campaign_context() {

        global $mo_theme;

        $context = $mo_theme->get_context('loop');

        if ($context == 'campaign')
            return true;

        return false;
    }
}

if (!function_exists('mo_display_campaign_collections')) {
    function mo_display_campaign_collections($form_id) {

        if (!post_type_exists('give_forms') || empty($form_id))
            return;

        $goal_option = get_post_meta($form_id, '_give_goal_option', true);
        $form = new Give_Donate_Form($form_id);
        $target_amount = $form->goal;
        $raised_amount = $form->get_earnings();
        $bar_color = get_post_meta($form_id, '_give_goal_color', true);

        if (!empty($bar_color))
            $style = 'style="background:' . $bar_color . ';"';
        else
            $style = "";

        if (empty($form->ID) || $goal_option !== 'yes' || $target_amount == 0) {
            return;
        }

        $percentage_raised = round(($raised_amount / $target_amount) * 100, 2);

        if ($raised_amount > $target_amount) {
            $percentage_raised = 100;
        }

        ob_start();

        ?>

        <div class="stats-bars">

            <div class="stats-bar">

                <div class="stats-title">

                    <div class="raised-amount"><?php echo give_currency_filter(give_format_amount($raised_amount)); ?>
                        <span
                            class="label"><?php echo esc_html__('Raised', 'peak'); ?></span></div>

                    <div class="target-amount"><?php echo give_currency_filter(give_format_amount($target_amount)); ?>
                        <span
                            class="label"><?php echo esc_html__('Target', 'peak'); ?></span></div>

                </div>

                <div class="stats-bar-wrap">

                    <div class="stats-bar-content" <?php echo esc_attr($style); ?>
                         data-perc="<?php echo intval($percentage_raised); ?>"></div>

                    <div class="stats-bar-bg"></div>

                </div>

            </div>

        </div>

        <?php

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}

if (!function_exists('mo_display_related_events')) {
    function mo_display_related_events($campaign_id) {

        // If Events Calendar is not activated, do not continue
        if ( !class_exists( 'Tribe__Events__Main' ) )
            return;

        global $post;

        $number_of_columns = 2;

        $style_class = mo_get_column_style($number_of_columns);

        $query_params = array(
            'post_type' => 'tribe_events',
            'posts_per_page' => -1,
            'meta_key' => '_lm_campaign_event',
            'meta_value' => $campaign_id,
            'meta_compare' => 'LIKE'
        );

        $posts = get_posts($query_params);

        if (!empty($posts)):

            $post_count = 1;

            $first_row = true;
            $last_column = false;
            ?>

            <div class="related-events">

                <h3><?php echo esc_html__('Related Events', 'peak'); ?></h3>

                <div class="post-snippets tribe-events-list">

                    <?php
                    foreach ($posts as $post) {

                        setup_postdata($post);

                        $post_id = $post->ID;

                        if ($last_column) {
                            echo '<div class="clear"></div>';
                            $first_row = false;
                        }

                        if ($post_count++ % $number_of_columns == 0)
                            $last_column = true;
                        else
                            $last_column = false;


                        echo '<div class="post-wrap ' . esc_attr($style_class) . ($last_column ? ' last' : '') . '">';

                        echo '<article class="' . join(' ', get_post_class()) . ($first_row ? ' first' : '') . '">';


                        ?>

                        <!-- Event Title -->
                        <h4 class="tribe-events-list-event-title entry-title summary">
                            <a class="url" href="<?php echo esc_url(tribe_get_event_link()); ?>"
                               title="<?php the_title_attribute() ?>" rel="bookmark">
                                <?php the_title() ?>
                            </a>
                        </h4>

                        <!-- Event Meta -->
                        <?php $has_venue_address = tribe_address_exists($post_id); ?>
                        <div class="tribe-events-event-meta vcard">
                            <div class="author <?php echo esc_attr($has_venue_address); ?>">

                                <!-- Schedule & Recurrence Details -->
                                <div class="updated published time-details">
                                    <?php echo tribe_events_event_schedule_details() ?>
                                </div>

                            </div>
                        </div>

                        <!-- Event Image -->
                        <?php echo tribe_event_featured_image($post_id, 'medium') ?>

                        <!-- Event Content -->
                        <div class="tribe-events-list-event-description tribe-events-content description entry-summary">
                            <?php the_excerpt() ?>
                            <a href="<?php echo esc_url(tribe_get_event_link()); ?>" class="tribe-events-read-more"
                               rel="bookmark"><?php esc_html_e('Find out more', 'peak') ?> &raquo;</a>
                        </div>
                        <!-- .tribe-events-list-event-description -->

                        <?php

                        echo '</article><!-- .hentry -->';

                        echo '</div><!-- .post-wrap -->';


                    } ?>

                </div>
                <!-- .post-snippets -->

            </div> <!-- .related-events -->

            <div class="clear"></div>

            <?php

            wp_reset_postdata();

        endif;

    }
}

if (!function_exists('mo_donate_form_filter')) {
    function mo_donate_form_filter($output = null, $args = null) {

        $doc = new DOMDocument();
        if (version_compare(PHP_VERSION, '5.4') >= 0) {
            $doc->loadHTML($output, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        }
        else {
            $doc->loadHTML($output);
        }

        $xpathsearch = new DOMXPath($doc);
        $nodes = $xpathsearch->query('//h2[contains(attribute::class, "give-form-title")]');

        foreach ($nodes as $node) {
            $node->parentNode->removeChild($node);
        }

        $nodes = $xpathsearch->query('//div[contains(attribute::class, "goal-progress")]');

        foreach ($nodes as $node) {
            $node->parentNode->removeChild($node);
        }

        return $doc->saveHTML($doc->documentElement);
    }
}



?>