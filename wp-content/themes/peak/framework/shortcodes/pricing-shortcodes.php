<?php

/**
 * Display Pricing Table
 *
 * @param    int $post_per_page The number of pricing_plans you want to display
 * @param    string $orderby The order by setting  https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters
 * @param    array $pricing_id The ID or IDs of the pricing(s), comma separated
 *
 * @return    string  Formatted HTML
 */

if (!function_exists('mo_get_pricing')) {

    function mo_get_pricing($post_count = -1, $pricing_ids = null) {
        $query_args = array(
            'posts_per_page' => (int)$post_count,
            'post_type' => 'pricing',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'no_found_rows' => true,
        );
        if (!empty($pricing_ids))
            $query_args['post__in'] = explode(',', esc_attr($pricing_ids));

        $query = new WP_Query($query_args);

        $plans = '';

        if ($query->have_posts()) {
            $column_count = $query->post_count;
            $style_class = mo_get_column_style($column_count);
            $post_count = 0;

            // Gather output
            ob_start();

            ?>

            <div class="pricing-table">

                <?php
                while ($query->have_posts()) : $query->the_post();
                    $post_id = get_the_ID();

                    $tagline = esc_html(get_post_meta($post_id, '_lm_pricing_tagline', true));
                    $price_tag = htmlspecialchars_decode(esc_html(get_post_meta($post_id, '_lm_price_tag', true)));
                    $pricing_img_url = esc_url(get_post_meta($post_id, '_lm_pricing_img', true));
                    $pricing_url = esc_url(get_post_meta($post_id, '_lm_pricing_url', true));
                    $pricing_button_text = esc_html(get_post_meta($post_id, '_lm_pricing_button_text', true));
                    $highlight = esc_html(get_post_meta($post_id, '_lm_highlight_pricing', true));
                    $last_column = (++$post_count % $column_count == 0) ? true : false;


                    $price_tag = (empty($price_tag)) ? '' : $price_tag;
                    $pricing_url = (empty($pricing_url)) ? '#' : esc_url($pricing_url);

                    ?>

                    <div
                        class="pricing-plan <?php echo esc_attr($style_class) . ($last_column ? ' last' : '') . (!empty($highlight) ? ' highlight' : ''); ?>">
                        <div class="top-header">
                            <?php if (!empty($tagline))
                                echo '<p class="tagline center">' . $tagline . '</p>'; ?>
                            <h3 class="center"><?php the_title() ?></h3>
                            <?php if (!empty($pricing_img_url))
                                echo '<img alt="' . get_the_title() . '" src="' . $pricing_img_url . '" /><br>'; ?>
                        </div>
                        <h4 class="plan-price plan-header center"><span class="text"><?php echo wp_kses_post($price_tag); ?></span></h4>

                        <div class="plan-details">
                            <?php the_content(); ?>
                        </div>
                        <!-- .plan-details -->
                        <div class="purchase">
                            <a class="button default" href="<?php echo esc_url($pricing_url); ?>"
                               target="_self"><?php echo esc_html($pricing_button_text); ?></a>
                        </div>

                    </div><!-- .pricing-plan -->

                <?php
                endwhile;
                ?>
            </div>
            <div class="clear"></div>

            <?php

            // Save output
            $plans = ob_get_contents();
            ob_end_clean();

            wp_reset_postdata();
        }

        return $plans;
    }
}

/**
 * Shortcode to display pricing_plans
 *
 * This functions is attached to the 'pricing' action hook.
 *
 * [pricing post_count="1" orderby="none" pricing_id=""]
 */

/* Pricing Table Shortcode -

Displays the pricing table with the columns drawn from the pricing information provided by creating a custom post type named pricing.

Usage:

[pricing_plans post_count=4 pricing_ids="234,235,236"]

Parameters -

post_count - The number of pricing columns to be displayed. By default displays all of the custom posts entered as pricing in the Pricing Plan tab of WordPress admin (optional).
pricing_ids - A comma separated post ids of the pricing custom post types created in the Pricing Plan tab of WordPress admin. Helps to filter the pricing plans for display (optional).

*/


if (!function_exists('mo_pricing_shortcode')) {
    function mo_pricing_shortcode($atts) {

        /* Do not continue if the Livemesh Tools plugin is not loaded */
        if (!class_exists('LM_Framework')) {
            return mo_display_plugin_error();
        }

        extract(shortcode_atts(array(
            'post_count' => '-1',
            'pricing_ids' => '',
        ), $atts));

        return mo_get_pricing(intval($post_count), esc_attr($pricing_ids));
    }
}

add_shortcode('pricing_plans', 'mo_pricing_shortcode');

/* Pricing Line Item Shortcode -

Displays a line item part of a pricing plan.

Usage:

[pricing_item title="Storage Space" value="50GB" icon="icon-cloud"]

Parameters -

title - The title for the pricing plan line item.
value - The value of the pricing plan item.
icon - The font icon to be displayed for the item, chosen from the list of icons listed at http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/
*/
function mo_pricing_item_shortcode($atts) {
    extract(shortcode_atts(array(
            'style' => '',
            'class' => '',
            'title' => '',
            'value' => false,
            'icon' => 'icon-checkmark8'
        ),
        $atts));

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';
    if (!empty($class))
        $class = ' ' . esc_attr($class);
    $output = '<div class="pricing_item' . $class . '"' . $style . '>';

    if (!empty ($title))
        $output .= '<div class="title">' . htmlspecialchars_decode(esc_html($title)) . '</div>';
    $output .= '<div class="value-wrap">';
    if (!empty ($icon))
        $output .= '<i class="'. esc_attr($icon) .'"></i>';
    if (!empty ($value))
        $output .= '<div class="value">' . htmlspecialchars_decode(esc_html($value)) . '</div>';

    $output .= '</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('pricing_item', 'mo_pricing_item_shortcode');
