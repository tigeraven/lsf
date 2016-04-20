<?php
/**
 * Search Form Template
 *
 * The search form template displays the search form.
 *
 * @package Peak
 * @subpackage Template
 */
?>
<div class="search">

    <form method="get" id="search-form" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
        <input type="text" class="search-text" name="s" id="s" placeholder="<?php esc_attr_e('Search', 'peak'); ?>" />
        <input type="submit" class="submit" name="submit" id="searchsubmit" value="" />
    </form>

</div>