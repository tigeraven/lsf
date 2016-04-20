<?php
/**
 * Header Template
 *
 * This template is loaded for displaying header information for the website. Called from every page of the website.
 *
 * @package Peak
 * @subpackage Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>"/>

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="profile" href="http://gmpg.org/xfn/11"/>

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

    <?php mo_setup_theme_options_for_scripts(); ?>

    <?php wp_head(); // wp_head  ?>

</head>

<body <?php body_class(); ?>>

<?php

$disable_smooth_page_load = mo_get_theme_option('mo_disable_smooth_page_load');

if (empty($disable_smooth_page_load)) {
    echo '<div id="page-loading"></div>';
}

?>

<?php echo '<a id="mobile-menu-toggle" href="#"><i class="icon-menu"></i>&nbsp;</a>'; ?>

<?php get_template_part('menu', 'mobile'); // Loads the menu-mobile.php template.    ?>

<div id="container">

    <?php
    $header_classes = apply_filters('mo_header_class', array());
    if (!empty($header_classes))
        $header_classes = 'class="' . implode(' ', $header_classes) . '"';
    else
        $header_classes = '';
    ?>

    <header id="header" class="<?php echo esc_attr($header_classes); ?>">

        <div class="inner clearfix">

            <div class="wrap">

                <?php

                mo_site_logo();

                mo_site_description();

                ?>

                <div class="alignright">

                    <?php

                    mo_display_sidebar('header');

                    get_template_part('menu', 'primary'); // Loads the menu-primary.php template.

                    mo_display_sidenav(); // Displays the side navigation content.

                    do_action('mo_header');

                    ?>

                </div>

            </div>

        </div>

    </header>
    <!-- #header -->

    <?php echo '<div id="header-spacer"></div>'; ?>

    <?php mo_display_header_info(); ?>

    <?php mo_populate_top_area(); ?>

    <div id="main" class="clearfix">

        <div class="inner clearfix">