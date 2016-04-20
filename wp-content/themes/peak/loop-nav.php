<?php
/**
 * Loop Nav Template
 *
 * This template is used to show your your next/previous post links on singular pages and
 * the next/previous posts links on the home/posts page and archive pages.
 *
 * @package Peak
 * @subpackage Template
 */
?>
<?php if (is_attachment()) : ?>

    <div class="loop-nav">
        <?php previous_post_link('<div class="previous">' . esc_html__('Return to ', 'peak') . '%link</div>'); ?>
    </div><!-- .loop-nav -->


<?php elseif (is_singular('portfolio')) : ?>

    <div class="loop-nav">
        <?php previous_post_link('<div class="previous">' . '%link' . '</div>', '<i class="icon-keyboard-arrow-left"></i><span>' . esc_html__('Previous', 'peak') . '</span>'); ?>
        <?php
        $page_id = mo_get_theme_option('mo_default_portfolio_page');
        if (!empty($page_id))
            $page_link = get_permalink($page_id);
        else
            $page_link = get_post_type_archive_link('portfolio');
        echo '<div class="post-index"><a title="' . esc_html__('All Portfolio Items', 'peak') . '" href="' . esc_url($page_link) . '"><i class="icon-apps"></i></a></div>'; ?>
        <?php next_post_link('<div class="next">' . '%link' . '</div>', '<span>' . esc_html__('Next', 'peak') . '</span><i class="icon-keyboard-arrow-right"></i>'); ?>
    </div><!-- .loop-nav -->

<?php elseif (is_singular('campaign')) : ?>

    <div class="loop-nav">
        <?php previous_post_link('<div class="previous"><i class="icon-keyboard-arrow-left"></i>' . wp_kses_post(__('%link', 'peak')) . '</div>', '%title'); ?>
        <?php
        $page_id = mo_get_theme_option('mo_default_campaign_page');
        if (!empty($page_id))
            $page_link = get_permalink($page_id);
        else
            $page_link = get_post_type_archive_link('campaign');
        echo '<div class="post-index"><a title="' . esc_html__('All Campaigns', 'peak') . '" href="' . esc_url($page_link) . '"><i class="icon-apps"></i></a></div>'; ?>
        <?php next_post_link('<div class="next">' . wp_kses_post(__('%link', 'peak')) . '<i class="icon-keyboard-arrow-right"></i></div>', '%title'); ?>
    </div><!-- .loop-nav -->

<?php
elseif (is_singular('post')) : ?>

    <div class="loop-nav">
        <?php previous_post_link('<div class="previous"><i class="icon-keyboard-arrow-left"></i>' . wp_kses_post(__('%link', 'peak')) . '</div>', '%title'); ?>
        <?php $page_link = mo_get_post_type_archive_url('post');
        echo '<div class="post-index"><a title="' . esc_html__('Blog Posts', 'peak') . '" href="' . esc_url($page_link) . '"><i class="icon-apps"></i></a></div>'; ?>
        <?php next_post_link('<div class="next">' . wp_kses_post(__('%link', 'peak')) . '<i class="icon-keyboard-arrow-right"></i></div>', '%title'); ?>
    </div><!-- .loop-nav -->

<?php
elseif (mo_is_context('portfolio') || mo_is_context('gallery_item') || mo_is_context('custom') || mo_is_context('campaign')) :
    // Use custom loop for portfolio or gallery or blog
    mo_loop_pagination(array(
        'prev_text' => '<i class="icon-arrow-left"></i>' . '',
        'next_text' => '' . '<i class="icon-arrow-right"></i>'
    ), $loop); ?>

<?php
elseif (!is_singular()) :
    mo_loop_pagination(array(
        'prev_text' => '<i class="icon-arrow-left"></i>' . '',
        'next_text' => '' . '<i class="icon-arrow-right"></i>'
    )); ?>

<?php
elseif (!is_singular() && $nav = get_posts_nav_link(array(
        'sep' => '',
        'prelabel' => '<div class="previous">' . esc_html__('Previous Page', 'peak') . '</div>',
        'nxtlabel' => '<div class="next">' . esc_html__('Next Page', 'peak') . '</div>'
    ))
) : ?>

    <div class="loop-nav">
        <?php echo wp_kses_post($nav); ?>
    </div><!-- .loop-nav -->

<?php endif; ?>