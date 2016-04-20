<?php

add_action('wp_loaded', 'child_create_objects', 11);

function child_create_objects() {

}

$shortcodes_path = get_stylesheet_directory() . '/framework/shortcodes/';

include_once($shortcodes_path . 'contact-shortcodes.php');


include_once(get_template_directory() . '/framework/framework.php');
class MO_Child_Framework extends MO_Framework {

    function i18n() {

        // Make theme available for translation
        // Translations can be filed in the /languages/ directory
        load_theme_textdomain('peak', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once($locale_file);

    }
    function name()
    {
        echo "My actual class is " , get_class($this) , "\n";
    }
}

$mo_theme = new MO_Child_Framework();


include_once(get_template_directory() . '/framework/presentation/sidebar-manager.php');
class MO_Custom_Sidebar_Manager extends MO_SidebarManager {

    function get_primary_sidebar_id() {

        $my_sidebar_id = get_post_meta(get_queried_object_id(), 'mo_primary_sidebar_choice', true);

        if (!empty($my_sidebar_id) && $my_sidebar_id !== 'default')
            return $my_sidebar_id;
        else
            return 'primary-' . $this->get_sidebar_id_suffix();
    }

}


include_once(get_template_directory() . '/framework/presentation/layout-manager.php');
class MO_Custom_Layout_Manager extends MO_LayoutManager {

    function is_full_width_page() {

        if (is_page_template('template-full-width.php')
            || $this->is_showcase_full_width_page()
            || is_page_template('template-home.php')
            || is_page_template('template-single-page-site.php')
            || is_page_template('template-archives.php')
            || is_page_template('template-sitemap.php')
            || is_page_template('template-1c.php')
        )
            return true;

        return false;
    }

}


include_once(get_template_directory() . '/framework/presentation/slider-manager.php');
class MO_Custom_Slider_Manager extends MO_Slider_Manager {

    function display_slider($slider_type) {

        switch ($slider_type) {
            case 'Nivo':
                $this->display_nivo_slider();
                break;
            case 'FlexSlider':
                $this->display_flex_slider();
                break;
            case 'Revolution':
                $this->display_revolution_slider();
                break;
            default:
                $this->display_nivo_slider(); // Go ahead and populate Nivo anyway
        }
    }

}


include_once(get_template_directory() . '/framework/extensions/framework-extender.php');
class MO_Custom_Framework_Extender extends MO_Framework_Extender {

    function mo_add_lightbox_hook($content) {

        global $post;
        $pattern = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
        $replacement = '<a$1href=$2$3.$4$5 rel="prettyPhoto[' . $post->ID . ']"$6>$7</a>';
        $content = preg_replace($pattern, $replacement, $content);
        return $content;
    }


}

if (!function_exists('mo_get_layout_manager')) {
    function mo_get_layout_manager() {

        $layout_manager = MO_Custom_Layout_Manager::getInstance();
        return $layout_manager;
    }
}

if (!function_exists('mo_get_sidebar_manager')) {
    function mo_get_sidebar_manager() {

        $sidebar_manager = MO_Custom_Sidebar_Manager::getInstance();
        return $sidebar_manager;
    }
}

if (!function_exists('mo_get_slider_manager')) {
    function mo_get_slider_manager() {

        $slider_manager = MO_Custom_Slider_Manager::getInstance();
        return $slider_manager;
    }
}

if (!function_exists('mo_get_framework_extender')) {
    function mo_get_framework_extender() {

        $framework_extender = MO_Custom_Framework_Extender::getInstance();
        return $framework_extender;
    }
}



?>