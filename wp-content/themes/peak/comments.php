<?php
/**
 * Comments Template
 *
 * Lists comments and calls the comment form.  Individual comments have their own templates.  The
 * hierarchy for these templates is $comment_type.php, comment.php.
 *
 * @package Peak
 * @subpackage Template
 */
/* Kill the page if trying to access this template directly. */

if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die(esc_html__('This page is not supposed to be loaded directly. Thanks!', 'peak'));

/* If a post password is required or no comments are given and comments/pings are closed, return. */
if (post_password_required() || (!have_comments() && !comments_open() && !pings_open()))
    return;
?>

    <div id="comments-template">

        <div class="comments-wrap">

            <?php if (have_comments()) : ?>

                <div id="comments">

                    <h3 id="comments-number"
                        class="comments-header"><?php comments_number(esc_html__('No&nbsp;Comments', 'peak'), '<span class="number">1</span>&nbsp;' . esc_html__('Comment', 'peak'), '<span class="number">%</span>&nbsp;' . esc_html__('Comments', 'peak')); ?></h3>

                    <ol class="comment-list">
                        <?php wp_list_comments(mo_list_comments_args()); ?>
                    </ol>
                    <!-- .comment-list -->

                    <?php if (get_option('page_comments')) : ?>
                        <div class="comment-navigation comment-pagination">
                            <?php paginate_comments_links(); ?>
                        </div><!-- .comment-navigation -->
                    <?php endif; ?>

                </div><!-- #comments -->

            <?php else : ?>

                <?php if (pings_open() && !comments_open()) : ?>

                    <p class="comments-closed pings-open">
                        <?php printf(wp_kses_post(__('Comments are closed, but <a href="%1$s" title="Trackback URL for this post">trackbacks</a> and pingbacks are open.', 'peak')), get_trackback_url()); ?>
                    </p><!-- .comments-closed .pings-open -->

                <?php elseif (!comments_open()) : ?>

                    <p class="comments-closed">
                        <?php esc_html_e('Comments are closed.', 'peak'); ?>
                    </p><!-- .comments-closed -->

                <?php endif; ?>

            <?php endif; ?>

            <?php comment_form(array(
                'title_reply' => esc_html__('Leave a Comment', 'peak'),
                'title_reply_to' => esc_html__('Leave a Comment to %s', 'peak'),
                'cancel_reply_link' => esc_html__('Cancel comment', 'peak')
            )); // Loads the comment form.  ?>

        </div>
        <!-- .comments-wrap -->

    </div><!-- #comments-template -->

<?php 

