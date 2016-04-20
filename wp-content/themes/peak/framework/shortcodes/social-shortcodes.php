<?php
/* Subscribe to RSS feed */

/* Subscribe RSS Shortcode -

Displays a box that lets users invite users to subscribe to the RSS feed for the blog.

Usage:

[subscribe_rss]

Parameters -

None

*/

function mo_subscribe_rss() {
    $feed_url = home_url('/') . 'feed';
    return '<div class="rss-block">Like what you see? <a href="' . esc_url($feed_url) . '">Subscribe to RSS feed</a> to receive updates!</div>';

}

add_shortcode('subscribe_rss', 'mo_subscribe_rss');

/* Social List Shortcode -

Displays a list of social icons with links to various social network pages.
Usage:

[social_list googleplus_url="http://plus.google.com" facebook_url="http://www.facebook.com" twitter_url="http://www.twitter.com" youtube_url="http://www.youtube.com/" linkedin_url="http://www.linkedin.com" include_rss="true"]

Parameters -

email - The email address to be used.
facebook_url - The URL of the Facebook page.
twitter_url - The URL of the Twitter account.
flickr_url - The URL of the Flickr page.
youtube_url - The URL for the YoutTube channel.
linkedin_url - The URL for the LinkedIn profile.
googleplus_url - The URL for the Google Plus page.
vimeo_url - The URL for the Vimeo channel.
instagram_url - The URL to your Instagram account.
behance_url - The URL of the Behance page.
pinterest_url - The URL for the Pinterest account.
skype_url - The URL for the Skype id.
dribbble_url - The URL of the Dribbble page.
include_rss - A boolean value(true/false string) indicating that the link to the RSS feed be included. Default is false.
align - Can be left, right, center or none. The default is left. (optional).

*/

function mo_social_list_shortcode($atts, $content = null, $code) {
    extract(shortcode_atts(array(
        'email' => false,
        'facebook_url' => false,
        'twitter_url' => false,
        'flickr_url' => false,
        'youtube_url' => false,
        'linkedin_url' => false,
        'googleplus_url' => false,
        'vimeo_url' => false,
        'instagram_url' => false,
        'behance_url' => false,
        'pinterest_url' => false,
        'skype_url' => false,
        'dribbble_url' => false,
        'include_rss' => false,
        'align' => 'left'
    ), $atts));


    $output = '<ul class="social-list clearfix';
    if ($align == 'center')
        $output .= ' center';
    $output .= '">';

    if ($email && is_email($email))
        $output .= '<li><a class="email" href="mailto:' . sanitize_email($email) . '" title="' . esc_html__("Contact Us", 'peak') . '"><i class="icon-envelope2"></i></a></li>';
    if ($facebook_url)
        $output .= '<li><a class="facebook" href="' . esc_url($facebook_url) . '" target="_blank" title="' . esc_html__("Follow on Facebook", 'peak') . '"><i class="icon-facebook5"></i></a></li>';
    if ($twitter_url)
        $output .= '<li><a class="twitter" href="' . esc_url($twitter_url) . '" target="_blank" title="' . esc_html__("Subscribe to Twitter Feed", 'peak') . '"><i class="icon-twitter5"></i></a></li>';
    if ($flickr_url)
        $output .= '<li><a class="flickr" href="' . esc_url($flickr_url) . '" target="_blank" title="' . esc_html__("View Flickr Portfolio", 'peak') . '"><i class="icon-flickr5"></i></a></li>';
    if ($youtube_url)
        $output .= '<li><a class="youtube" href="' . esc_url($youtube_url) . '" target="_blank" title="' . esc_html__("Subscribe to the YouTube channel", 'peak') . '"><i class="icon-youtube"></i></a></li>';
    if ($linkedin_url)
        $output .= '<li><a class="linkedin" href="' . esc_url($linkedin_url) . '" target="_blank" title="' . esc_html__("View LinkedIn Profile", 'peak') . '"><i class="icon-linkedin4"></i></a></li>';
    if ($googleplus_url)
        $output .= '<li><a class="googleplus" href="' . esc_url($googleplus_url) . '" target="_blank" title="' . esc_html__("Follow on Google Plus", 'peak') . '"><i class="icon-googleplus2"></i></a></li>';
    if ($vimeo_url)
        $output .= '<li><a class="vimeo" href="' . esc_url($vimeo_url) . '" target="_blank" title="' . esc_html__("Subscribe to the Vimeo Channel", 'peak') . '"><i class="icon-vimeo"></i></a></li>';
    if ($instagram_url)
        $output .= '<li><a class="instagram" href="' . esc_url($instagram_url) . '" target="_blank" title="' . esc_html__("View Instagram Feed", 'peak') . '"><i class="icon-instagram3"></i></a></li>';
    if ($behance_url)
        $output .= '<li><a class="behance" href="' . esc_url($behance_url) . '" target="_blank" title="' . esc_html__("View Behance Portfolio", 'peak') . '"><i class="icon-behance2"></i></a></li>';
    if ($pinterest_url)
        $output .= '<li><a class="pinterest" href="' . esc_url($pinterest_url) . '" target="_blank" title="' . esc_html__("Subscribe to Pinterest Feed", 'peak') . '"><i class="icon-pinterest3"></i></a></li>';
    if ($skype_url)
        $output .= '<li><a class="skype" href="' . esc_url($skype_url) . '" target="_blank" title="' . esc_html__("Connect to us on Skype", 'peak') . '"><i class="icon-skype2"></i></a></li>';
    if ($dribbble_url)
        $output .= '<li><a class="dribbble" href="' . esc_url($dribbble_url) . '" target="_blank" title="' . esc_html__("View Dribbble Portfolio", 'peak') . '"><i class="icon-dribbble5"></i></a></li>';

    if ($include_rss && mo_to_boolean($include_rss)) {
        $rss = get_bloginfo('rss2_url');
        $output .= '<li><a class="rss" href="' . esc_url($rss) . '" target="_blank" title="' . esc_html__("Subscribe to our RSS Feed", 'peak') . '"><i class="icon-rss4"></i></a></li>';
    }

    $output .= '</ul>';

    return $output;

}

add_shortcode('social_list', 'mo_social_list_shortcode');

/*------- Paypal Donate Button - http://blue-anvil.com/archives/8-fun-useful-shortcode-functions-for-wordpress/ ----*/

/* Paypal Donate Shortcode -

Lets you display a Paypal donate button wherever you need - inside a post or a page.

Usage:

[donate title="Please Donate to John Smith Foundation" account="email@example.com" display_card_logos="true" cause="Earthquake Relief"]

Parameters -

title - The title of the link that displays the Paypal donate button.
account - The Paypal account for which the donate button is being created.
display_card_logos - A boolean value to specify display of the logo images of the credit cards accepted for Paypal donations
cause - The text indicating the purpose for which the donation is being collected.

*/

function mo_paypal_donate_shortcode($atts) {
    extract(shortcode_atts(array(
        'title' => 'Make a donation',
        'account' => 'REPLACE ME',
        'cause' => '',
        'display_card_logos' => "Yes",
    ), $atts));

    $display_card_logos = mo_to_boolean($display_card_logos);

    global $post;

    if (!$cause)
        $cause = str_replace(" ", "+", $post->post_title);

    if ($display_card_logos)
        $class = 'donate-button-plus';
    else
        $class = 'donate-button';

    return '<a class="' . esc_attr($class) . '" href="https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=' . esc_attr($account) . '&item_name=Donation+for+' . urlencode($cause) . '" title="' . esc_attr($title) . '"></a>';

}

add_shortcode('donate', 'mo_paypal_donate_shortcode');
/*------ Credit - https://github.com/jeherve/jp-sd-shortcode. Enable JetPack sharing module to use this shortcode. ----*/

function tweakjp_sd_shortcode() {
    if (class_exists('Jetpack') && method_exists('Jetpack', 'get_active_modules') && in_array('sharedaddy', Jetpack::get_active_modules()))
        return sharing_display();
}

add_shortcode('jpshare', 'tweakjp_sd_shortcode');