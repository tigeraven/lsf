<?php
/**
 * Loop Error Template
 *
 * Displays an error message when no posts are found.
 *
 * @package Peak
 * @subpackage Template
 */
?>
<div id="post-0" <?php post_class(); ?>>

	<div class="entry-content clearfix">

		<p><?php esc_html_e( 'No posts were found with the criteria specified. Try searching again.', 'peak' ); ?></p>

						<?php get_search_form(); // Loads the searchform.php template. ?>

	</div><!-- .entry-content -->

</div><!-- .hentry .error -->