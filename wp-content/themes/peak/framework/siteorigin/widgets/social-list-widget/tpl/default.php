<?php
/**
 * @var $email
 * @var $googleplus_url
 * @var $facebook_url
 * @var $twitter_url
 * @var $youtube_url
 * @var $linkedin_url
 * @var $vimeo_url
 * @var $instagram_url
 * @var $dribbble_url
 * @var $flickr_url
 * @var $skype_url
 * @var $pinterest_url
 * @var $behance_url
 * @var $include_rss
 */


echo do_shortcode('[social_list email="' . $email . '" googleplus_url="' . $googleplus_url . '" facebook_url="' . $facebook_url . '" twitter_url="' . $twitter_url . '" youtube_url="' . $youtube_url . '" linkedin_url="' . $linkedin_url . '" vimeo_url="' . $vimeo_url . '" instagram_url="' . $instagram_url . '" dribbble_url="' . $dribbble_url . '" flickr_url="' . $flickr_url . '" skype_url="' . $skype_url . '" pinterest_url="' . $pinterest_url . '" behance_url="' . $behance_url . '" include_rss="' . ($include_rss ? 'true' : 'false') . '" ]');
