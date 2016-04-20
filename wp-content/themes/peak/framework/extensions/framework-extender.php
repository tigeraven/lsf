<?php

/**
 * Framework Extender - Extends theme functions, handles customizations
 *
 *
 * @package Livemesh_Framework
 */

if (!class_exists('MO_Framework_Extender')) {

	class MO_Framework_Extender {

		protected static $instance;

		/**
		 * Construct method for the MO_Framework_Extender class.
		 */
		protected function __construct() {

		}

		/**
		 * Constructor method for the MO_Framework_Extender class.
		 *
		 */
		public static function getInstance() {
			if (!isset(self::$instance)) {
				// Check if this is at least PHP 5.3 version
				if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
					$class = get_called_class();
					self::$instance = new $class;
				}
				else {
					$c = __CLASS__;
					self::$instance = new $c;
				}
			}
			return self::$instance;
		}

		/**
		 * Prevent cloning of this singleton
		 */
		public function __clone() {
			trigger_error('Clone is not allowed.', E_USER_ERROR);
		}

		/**
		 * Init method for the MO_Framework_Extender class.
		 */
		function initialize() {

			/* Get action/filter hook prefix. */

			$this->handle_social_fields_for_users();

			add_action('tgmpa_register', array(&$this, 'register_required_plugins'));

			/* Embed width/height defaults. Sets dynamically the width and height for videos based on current column width */
			add_filter('embed_defaults', array(&$this, 'set_defaults_for_embeds'));

			add_filter('the_content_more_link', array(&$this, 'remove_more_link'));

			/* Remove auto-generated default styling for WP galleries */
			add_filter('use_default_gallery_style', '__return_false');

			add_action('pre_get_posts', array(&$this, 'change_posts_per_page'));

		}

		/**
		 * Register the required plugins for this theme.
		 *
		 * In this example, we register two plugins - one included with the TGMPA library
		 * and one from the .org repo.
		 *
		 * The variable passed to tgmpa_register_plugins() should be an array of plugin
		 * arrays.
		 *
		 * This function is hooked into tgmpa_init, which is fired within the
		 * TGM_Plugin_Activation class constructor.
		 */
		function register_required_plugins() {

			/**
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$plugins = array(

				// This is an example of how to include a plugin pre-packaged with a theme
				array(
					'name' => 'Livemesh Tools', // The plugin name
					'slug' => 'livemesh-tools', // The plugin slug (typically the folder name)
					'source' => get_template_directory() . '/framework/plugins/livemesh-tools.zip', // The plugin source
					'required' => true, // If false, the plugin is only 'recommended' instead of required
					'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation' => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url' => '', // If set, overrides default API URL and points to an external URL
				),
                array(
                    'name' => 'Revolution Slider', // The plugin name
                    'slug' => 'revslider', // The plugin slug (typically the folder name)
                    'source' => get_template_directory() . '/framework/plugins/revslider.zip', // The plugin source
                    'required' => true, // If false, the plugin is only 'recommended' instead of required
                    'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
                    'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
                    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
                    'external_url' => '', // If set, overrides default API URL and points to an external URL
                ),
                array(
                    'name' => 'Give Donation Plugin',
                    'slug' => 'give',
                    'required' => true,
                ),
				array(
					'name' => 'Page Builder by SiteOrigin',
					'slug' => 'siteorigin-panels',
					'required' => true,
				),
				array(
					'name' => 'SiteOrigin Widgets Bundle',
					'slug' => 'so-widgets-bundle',
					'required' => true,
				),
				array(
					'name' => 'Livemesh SiteOrigin Widgets',
					'slug' => 'livemesh-siteorigin-widgets',
					'required' => true,
				),
                array(
                    'name' => 'The Events Calendar',
                    'slug' => 'the-events-calendar',
                    'required' => false,
                ),
				array(
					'name' => 'Contact Form 7',
					'slug' => 'contact-form-7',
					'required' => false,
				),
                array(
                    'name' => 'WooCommerce',
                    'slug' => 'woocommerce',
                    'required' => false,
                ),
				array(
					'name' => 'Recent Tweets Widget',
					'slug' => 'recent-tweets-widget',
					'required' => false,
				),
                array(
                    'name' => 'WP Instagram Widget',
                    'slug' => 'wp-instagram-widget',
                    'required' => false,
                )

			);

			// Change this to your theme text domain, used for internationalising strings
			$theme_text_domain = 'peak';

			/**
			 * Array of configuration settings. Amend each line as needed.
			 * If you want the default strings to be available under your own theme domain,
			 * leave the strings uncommented.
			 * Some of the strings are added into a sprintf, so see the comments at the
			 * end of each line for what each argument will be.
			 */
			$config = array(
				'domain' => 'peak', // Text domain - likely want to be the same as your theme.
				'default_path' => '', // Default absolute path to pre-packaged plugins
				'parent_menu_slug' => 'themes.php', // Default parent menu slug
				'parent_url_slug' => 'themes.php', // Default parent URL slug
				'menu' => 'install-required-plugins', // Menu slug
				'has_notices' => true, // Show admin notices or not
				'is_automatic' => false, // Automatically activate plugins after installation or not
				'message' => '', // Message to output right before the plugins table
				'strings' => array(
                    'page_title' => esc_html__('Install Required Plugins', 'peak'),
                    'menu_title' => esc_html__('Install Plugins', 'peak'),
                    'installing' => esc_html__('Installing Plugin: %s', 'peak'), // %1$s = plugin name
                    'oops' => esc_html__('Something went wrong with the plugin API.', 'peak'),
                    'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'peak'), // %1$s = plugin name(s)
                    'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'peak'), // %1$s = plugin name(s)
                    'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'peak'), // %1$s = plugin name(s)
                    'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'peak'), // %1$s = plugin name(s)
                    'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'peak'), // %1$s = plugin name(s)
                    'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'peak'), // %1$s = plugin name(s)
                    'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'peak'), // %1$s = plugin name(s)
                    'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'peak'), // %1$s = plugin name(s)
                    'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins', 'peak'),
                    'activate_link' => _n_noop('Visit plugins page to activate installed plugin', 'Activate installed plugins', 'peak'),
                    'return' => esc_html__('Return to Required Plugins Installer', 'peak'),
                    'plugin_activated' => esc_html__('Plugin activated successfully.', 'peak'),
                    'complete' => esc_html__('All plugins installed and activated successfully. %s', 'peak'), // %1$s = dashboard link
                    'nag_type' => 'updated' // Determines admin notice type - can only be 'updated' or 'error'
				)
			);

			tgmpa($plugins, $config);
		}

		function mo_comment_form_fields($fields) {

			$commenter = wp_get_current_commenter();
			$req = get_option('require_name_email');
			$aria_req = ($req ? " aria-required='true'" : '');

			$fields = array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__('Name', 'peak') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input id="author" placeholder="' . esc_html__("Your name", 'peak') . '" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>'
			, 'email' => '<p class="comment-form-email"><label for="email">' . esc_html__('Email', 'peak') . ($req ? ' <span class="required">*</span>' : '') . '</label> ' .
					'<input id="email" placeholder="' . esc_html__("Your email", 'peak') . '" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>'
				/*  , 'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website' ) . '</label>' .
					'<input id="url" placeholder="'. esc_html__('Your website:' , 'peak'). ' name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>' */
			);
			return $fields;

		}

		function mo_comment_form_field_comment($field) {
			$comment_field = '<p class="comment-form-comment"><label for="comment">' . esc_html_x("Comment", "comment field", 'peak') . '</label><textarea id="comment" placeholder="' . esc_html__("Your comment", 'peak') . '" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>';
			return $comment_field;
		}

		function mo_add_lightbox_hook($content) {
			global $post;
			$pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
            $replacement = '<a$1href=$2$3.$4$5 data-gal="' . $post->ID . '"$6>$7</a>';
			$content = preg_replace($pattern, $replacement, $content);
			return $content;
		}

		function remove_more_jump_link($link) {
			$offset = strpos($link, '#more-');
			if ($offset) {
				$end = strpos($link, '"', $offset);
			}
			if ($end) {
				$link = substr_replace($link, '', $offset, $end - $offset);
			}
			return $link;
		}

		function remove_more_link() {
			$html = "&nbsp;[&middot;&middot;&middot;]";
			return $html;
		}

		/**
		 * Change Posts Per Page for Event Archive
		 *
		 * @author Bill Erickson
		 * @link http://www.billerickson.net/customize-the-wordpress-query/
		 * @param object $query data
		 *
		 */
		function change_posts_per_page($query) {

			if ($query->is_main_query() && !is_admin()) {

				if (is_post_type_archive('portfolio') || is_tax('portfolio_category')) {
					$post_count = intval(mo_get_theme_option('mo_portfolio_post_count', 6));
				}
				elseif (is_post_type_archive('gallery_item') || is_tax('gallery_category')) {
					$post_count = intval(mo_get_theme_option('mo_gallery_post_count', 6));
				}

				if (isset($post_count))
					$query->set('posts_per_page', $post_count);
			}

		}

		/**
		 * Extend the user profile page to handle social network information for individual authors
		 * Credit - http://wpsplash.com/how-to-create-a-wordpress-authors-page/
		 * @param
		 * @return
		 */
		function handle_social_fields_for_users() {
			add_action('show_user_profile', array(&$this, 'insert_extra_profile_fields'));
			add_action('edit_user_profile', array(&$this, 'insert_extra_profile_fields'));
			add_action('personal_options_update', array(&$this, 'save_extra_profile_fields'));
			add_action('edit_user_profile_update', array(&$this, 'save_extra_profile_fields'));
		}

		function save_extra_profile_fields($userID) {

			if (!current_user_can('edit_user', $userID)) {
				return false;
			}

			update_user_meta($userID, 'twitter', $_POST['twitter']);
			update_user_meta($userID, 'facebook', $_POST['facebook']);
			update_user_meta($userID, 'linkedin', $_POST['linkedin']);
			update_user_meta($userID, 'googleplus', $_POST['googleplus']);
			update_user_meta($userID, 'flickr', $_POST['flickr']);
		}

		function insert_extra_profile_fields($user) {
			?>
			<h3>Connect Information</h3>

			<table class='form-table'>
				<tr>
					<th><label for='twitter'>Twitter</label></th>
					<td>
						<input type='text' name='twitter' id='twitter'
							   value='<?php echo esc_attr(get_the_author_meta('twitter', $user->ID)); ?>'
							   class='input-social regular-text'/>
						<span class='description'>Please enter your Twitter username. http://www.twitter.com/<strong>username</strong></span>
					</td>
				</tr>
				<tr>
					<th><label for='facebook'>Facebook</label></th>
					<td>
						<input type='text' name='facebook' id='facebook'
							   value='<?php echo esc_attr(get_the_author_meta('facebook', $user->ID)); ?>'
							   class='input-social regular-text'/>
                    <span
						class='description'>Please enter your Facebook username/alias. http://www.facebook.com/<strong>username</strong></span>
					</td>
				</tr>
				<tr>
					<th><label for='linkedin'>LinkedIn</label></th>
					<td>
						<input type='text' name='linkedin' id='linkedin'
							   value='<?php echo esc_attr(get_the_author_meta('linkedin', $user->ID)); ?>'
							   class='input-social regular-text'/>
                        <span
							class='description'>Please enter your LinkedIn username. http://www.linkedin.com/in/<strong>username</strong></span>
					</td>
				</tr>
				<tr>
					<th><label for='googleplus'>Google Plus</label></th>
					<td>
						<input type='text' name='googleplus' id='googleplus'
							   value='<?php echo esc_attr(get_the_author_meta('googleplus', $user->ID)); ?>'
							   class='input-social regular-text'/>
                        <span
							class='description'>Please enter your Google Plus username. http://plus.google.com/<strong>username</strong></span>
					</td>
				</tr>
				<tr>
					<th><label for='flickr'>Flickr</label></th>
					<td>
						<input type='text' name='flickr' id='flickr'
							   value='<?php echo esc_attr(get_the_author_meta('flickr', $user->ID)); ?>'
							   class='input-social regular-text'/>
                        <span
							class='description'>Please enter your flickr username. http://www.flickr.com/photos/<strong>username</strong>/</span>
					</td>
				</tr>
			</table>

		<?php
		}


		/**
		 * Creates custom settings for the WordPress comment form.
		 */
		function set_comment_form_args($args) {
			$args['label_submit'] = esc_html__('Post Comment', 'peak');
			return $args;
		}

		/**
		 * Overwrites the default widths for embeds.This is especially useful for making sure videos properly
		 * expand the full width on video pages.This function overwrites what the $content_width variable handles
		 * with context-based widths.
		 *
		 */
		function set_defaults_for_embeds($args) {

			$layout_manager = mo_get_layout_manager();

			if ($layout_manager->is_full_width_layout())
				$args['width'] = 1140;
			else
				$args['width'] = 820;

			return $args;
		}

	}
}

/* Avoid defining global functions here - for child theme sake */