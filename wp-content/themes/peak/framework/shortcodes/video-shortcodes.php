<?php

/* HTML5 Audio Shortcode -

Displays a HTML5 audio clip with controls.

Usage:

[html5_audio ogg_url="http://mydomain.com/song.ogg" mp3_url="http://mydomain.com/song.mp3" ]

Parameters -

ogg_url - The URL of the audio clip uploaded in OGG format.
mp3_url - The URL of the audio clip uploaded in MP3 format.

*/

function mo_html5_audio_shortcode($atts, $content = null, $code = "") {

    extract(shortcode_atts(array(
        'mp3_url' => '',
        'ogg_url' => ''
    ), $atts));

    $ogg_url = esc_url($ogg_url);
    $mp3_url = esc_url($mp3_url);

    if (!empty($mp3_url) || !empty($ogg_url)) {
        return <<<HTML
<div class="video-box">
<audio controls="controls">
  <source src="{$ogg_url}" type="audio/ogg" />
  <source src="{$mp3_url}" type="audio/mp3" />
  Your browser does not support the HTML5 audio. Do upgrade. 
</audio>
</div>
HTML;
    }
}

add_shortcode('html5_audio', 'mo_html5_audio_shortcode');


/* Vimeo Video Placeholder -

Displays a vimeo image placeholder with a play button. The video is played on clicking the play button.

Usage:

[html5_audio ogg_url="http://mydomain.com/song.ogg" mp3_url="http://mydomain.com/song.mp3" ]

Parameters -

ogg_url - The URL of the audio clip uploaded in OGG format.
mp3_url - The URL of the audio clip uploaded in MP3 format.

*/

function mo_vimeo_video_shortcode($atts, $content = null, $code = "") {

    extract(shortcode_atts(array(
        'vimeo_video_id' => '',
        'placeholder_url' => '',
        'placeholder_id' => '',
        'placeholder_alt' => 'Video placeholder'
    ), $atts));

    $output = '';

    $placeholder_id = esc_attr($placeholder_id);
    $placeholder_url = esc_url($placeholder_url);
    $placeholder_alt = esc_attr($placeholder_alt);
    $vimeo_video_id = esc_attr($vimeo_video_id);

    if (!empty($placeholder_id)) {
        $image_elem = wp_get_attachment_image($placeholder_id, 'full', false, array('class' => 'full vimeoplayer'));
    }
    else {
        $image_elem = '<img class="vimeoplayer" src="' . $placeholder_url . '" alt="' . $placeholder_alt . '"/>';
    }

    if (!empty($vimeo_video_id)) {
        $output .= '<div class="vimeo-wrap video-wrap" data-vimeoid="' . $vimeo_video_id . '">';
        $output .= $image_elem;
        $output .= '<i class="icon-play2"></i>';
        $output .= '</div>';
    }
    return $output;

}

add_shortcode('vimeo_video', 'mo_vimeo_video_shortcode');

?>