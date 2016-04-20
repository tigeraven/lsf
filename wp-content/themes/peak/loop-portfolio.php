<?php

get_header();
?>

<div id="showcase-template">

    <?php

    $column_count = intval(mo_get_theme_option('mo_portfolio_column_count', 3));
    $layout_mode = mo_get_theme_option('mo_portfolio_layout_mode', 'fitRows');
    if ($layout_mode == 'masonry')
        $image_size = null; // keep the original size for masonry and leave it to the user to upload an appropriate sized image
    else
        $image_size = 'medium-thumb';

    if (is_page_template('template-portfolio-filterable.php')) {
        $filterable = true;
        $post_count = 100;
    }
    else {
        $filterable = false;
        $post_count = intval(mo_get_theme_option('mo_portfolio_post_count', 8));
    }

    $args = array(
        'number_of_columns' => $column_count,
        'image_size' => $image_size,
        'posts_per_page' => $post_count,
        'filterable' => $filterable,
        'post_type' => 'portfolio',
        'layout_mode' => $layout_mode
    );

    mo_display_portfolio_content($args);
    ?>

</div> <!-- #showcase-template -->

<?php

get_sidebar();

get_footer(); // Loads the footer.php template.