<?php
/**
 * Home Template
 *
 * This template is loaded as the home page. Can be overridden by user by specifying a static
 * page as home page in the Wordpress admin panel, under 'Reading' admin page. 
 * 
 * @package Peak
 * @subpackage Template
 */

get_header();

mo_display_archive_content();

get_sidebar();

get_footer(); 

?>