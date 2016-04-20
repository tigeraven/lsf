<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins.
 *
 * @package Peak
 * @subpackage Template
 */
?>

</div><!-- #main .inner -->

</div><!-- #main -->

<footer id="footer" class="sec-nav">

    <?php
    $sidebar_manager = mo_get_sidebar_manager();

    if ($sidebar_manager->is_nav_area_active('footer')):
        ?>

        <div id="footer-top">

            <div class="inner">

                <div id="sidebars-footer" class="sidebars clearfix">

                    <?php

                    $sidebar_manager->populate_nav_sidebars('footer');

                    echo '<a id="go-to-top" href="#" title="' . esc_html__('Back to top', 'peak') . '"><i class="icon-arrow-up"></i></a>';

                    ?>

                </div>
                <!-- #sidebars-footer -->

            </div>

        </div>

    <?php endif; ?>

    <div id="footer-bottom">

        <div class="inner">

            <?php get_template_part('menu', 'footer'); // Loads the menu-footer.php template.    ?>

            <?php mo_footer_content(); ?>

        </div>

    </div>
    <!-- #footer-bottom -->

</footer> <!-- #footer -->

</div><!-- #container -->

<?php wp_footer(); // wp_footer    ?>

</body>
</html>