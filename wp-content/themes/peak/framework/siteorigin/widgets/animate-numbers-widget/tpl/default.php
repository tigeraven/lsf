<?php
/**
 * @var $animate_numbers
 */


$shortcode = '[animate-numbers]';

foreach ($animate_numbers as $number):

    $shortcode .= '[animate-number title="' . $number['stats_title'] . '" start_value="' . $number['start_value'] . '" icon="' . $number['icon'] . '" prefix="' . $number['prefix'] . '"  suffix="' . $number['suffix'] . '"]';

    $shortcode .= $number['stop_value'];

    $shortcode .= '[/animate-number]';

endforeach;

$shortcode .= '[/animate-numbers]';

echo do_shortcode($shortcode);