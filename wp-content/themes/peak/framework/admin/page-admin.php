<?php

/**
 * Page Admin Manager - Handle the page admin for page section custom post types
 *
 *
 * @package Peak
 */
class MO_Page_Admin {

    private static $instance;

    /**
     * Constructor method for the MO_Portfolio_Admin class.
     *

     */
    private function __construct() {

    }

    /**
     * Constructor method for the MO_Portfolio_Admin class.
     *

     */
    public static function getInstance() {
        if (!isset(self::$instance)) {
            $c = __CLASS__;
            self::$instance = new $c;
        }
        return self::$instance;
    }

    /**
     * Prevent cloning of this singleton
     *

     */
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    /**
     * Init method for the MO_Portfolio_Admin class.
     * Called during theme setup.
     *

     */
    function initialize() {

        /* Do not continue with metabox creation if the Livemesh Tools plugin is not loaded */
        if (!class_exists('LM_Framework')) {
            return;
        }

        add_action('add_meta_boxes', array(
            $this,
            'add_page_meta_boxes'
        ));
        add_action('save_post', array(
            &$this,
            'save_page'
        ));

        // Provide data for the columns of page_section custom post type.
        add_action("manage_pages_custom_column", array(
            $this,
            "custom_pages_columns"
        ), 10, 2);

        //Manage column headers for columns displayed in the posts overview sceen. Different from above in the
        // sense that this applies to list instead of single custom post edit window.
        add_filter('manage_edit-page_columns', array(
            $this,
            'edit_page_columns'
        ));

    }

    function edit_page_columns($columns) {

        $new_columns = array(
            'cb' => '<input type="checkbox" />',
            'title' => esc_html__('Title', 'peak'),
            'page_section_order' => esc_html__('Page Sections', 'peak')
        );

        $columns = array_merge($new_columns, $columns);

        return $columns;
    }

// Change only the page_section link attributes, rest like date, title etc. will take the default values
    function custom_pages_columns($column, $post_id) {
        switch ($column) {
            case "page_section_order":
                $page_section_ids = mo_get_chosen_page_section_ids($post_id);
                $page_sections = "";
                $first = true;
                if (!empty($page_section_ids)) {
                    foreach ($page_section_ids as $section_id) {
                        if (!$first)
                            $page_sections .= ",&nbsp;&nbsp;";
                        $page_sections .= get_the_title($section_id);
                        $first = false;
                    }
                }
                echo esc_html($page_sections);
                break;
        }
    }

    function add_page_meta_boxes() {

        add_meta_box(
            'page_section_box', esc_html__('Page Section Information', 'peak'), array(
                $this,
                'render_page_section_metabox'
            ), 'page', 'normal', 'high'
        );
    }

    function render_page_section_metabox($post) {

        wp_nonce_field('page_section_' . $post->ID, 'mo_page_nonce'); ?>

        <p>Choose the page sections to display <strong>if 'Composite Page' template is chosen for this page</strong>,
            by dragging the desired page sections from the 'Available Page Sections' and dropping into the 'Chosen Page
            Sections' box below. A page
            built with 'Composite Page' page template will be composed of the below chosen page sections.</p>

        <input type="hidden" id="single_page_id" name="single_page_id" value="<?php echo intval($post->ID); ?>"/>

        <div id="order-post-type">
            <div id="available-page-sections">
                <h3><?php echo esc_html__('Available Page Sections', 'peak') ?></h3>

                <p class="box-description">To choose a page section for a single page, drag it and drop it into 'Chosen
                    Page Sections' box on the right.</p>
                <ul id="sortable1" class="blocks connected-sortable">
                    <?php
                    /* Make sure you remove already chosen elements */
                    $query = array(
                        'post_type' => 'page_section',
                        'posts_per_page' => -1,
                        'orderby' => 'menu_order',
                        'order' => 'ASC',
                        'post_status' => 'publish'
                    );
                    $this->list_page_sections($query);
                    ?>
                </ul>
            </div>
            <div id="chosen-page-sections">
                <h3><?php echo esc_html__('Chosen Page Sections', 'peak') ?> <span class="spinner"></span></h3>

                <p class="box-description">You may rearrange the order of the page sections for display via drag and
                    drop.</p>
                <ul id="sortable2" class="blocks connected-sortable">
                    <?php
                    $page_section_ids = mo_get_chosen_page_section_ids($post->ID);

                    if (!empty($page_section_ids)) {
                        $query = array(
                            'post_type' => 'page_section',
                            'posts_per_page' => -1,
                            'post__in' => $page_section_ids,
                            'orderby' => 'post__in',
                            'post_status' => 'publish'
                        );
                        $this->list_page_sections($query);
                    } ?>
                </ul>
            </div>
            <div class="clear"></div>
        </div>


    <?php
    }

    function save_page($post_id) {

        /* Verify the nonce before proceeding. */
        if (!isset($_POST['mo_page_nonce']) || !wp_verify_nonce($_POST['mo_page_nonce'], 'page_section_' . $post_id))
            return $post_id;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        if (!current_user_can('edit_post', $post_id))
            return $post_id;


        $post = get_post($post_id);
        if ($post->post_type == 'page') {
            //Save the value to a custom field for the post
        }
        return $post_id;
    }

    function list_page_sections($query) {

        $page_sections = get_posts($query);

        foreach ($page_sections as $post):

            $post_id = $post->ID;
            $description = esc_html(get_post_meta($post->ID, 'mo_page_section_desc', true));
            if (empty($description))
                $description = esc_html__('No description provided yet in the page section edit window.', 'peak');

            ?>

            <li class="block" rel="section_<?php echo intval($post_id); ?>">

                <dl class="block-bar">
                    <dt class="block-handle">
                    <div class="block-title">
                        <?php echo esc_attr($post->post_title); ?>
                    </div>
                        <span class="block-controls">
                            <a class="block-edit" id="edit-1" title="Edit Block"
                               href="#block-settings-1"><?php echo esc_html__('Edit Block', 'peak') ?></a>
                        </span>
                    </dt>
                </dl>

                <div class="block-settings clearfix">
                    <div class="description">
                        <?php echo wpautop($description); ?>
                    </div>


                    <div class="block-control-actions clearfix">

                        <?php
                        if (current_user_can('edit_post', $post_id) && $link = get_edit_post_link($post_id))
                            echo '<a class="edit" href="' . esc_url($link) . '" target="_blank">' . esc_html__('Edit', 'peak') . '</a> | ';
                        if (current_user_can('read', $post_id) && $link = get_post_permalink($post_id))
                            echo '<a class="view" href="' . esc_url($link) . '" target="_blank">' . esc_html__('View', 'peak') . '</a> | ';
                        echo '<span class="hideable"><a href="#" class="remove">' . esc_html__('Remove', 'peak') . '</a> | </span>';
                        echo '<a href="#" class="close">' . esc_html__('Close', 'peak') . '</a>';
                        ?>


                    </div>
                </div>

            </li>
        <?php

        endforeach;

    }

}