<?php
/**
 * 404 Template
 *
 * The 404 template is used when a reader visits an invalid URL on your site. By default, the template will 
 * display a generic message.
 *
 * @package Peak
 * @subpackage Template
 */
@header('HTTP/1.1 404 Not found', true, 404);

get_header();
?>

<div id="content" class="<?php echo mo_get_content_class();?>">

    <div class="hfeed">

        <div id="post-0" <?php post_class(); ?>>

            <div class="entry-content clearfix">

                <p>
                    <?php printf(wp_kses_post(__('The page you requested %1$s, does not exist. <p>You may try searching for what you\'re looking for below.</p>', 'peak')), '<code>' . site_url(esc_url($_SERVER['REQUEST_URI'])) . '</code>'); ?>
                </p>

                <?php get_search_form(); // Loads the searchform.php template. ?>

            </div><!-- .entry-content -->

        </div><!-- .hentry -->

    </div><!-- .hfeed -->

</div><!-- #content -->

<?php get_sidebar(); ?>

<?php
get_footer();  ?>