<?php

/* Code Shortcode -

Usage: Wraps the content in HTML tag pre with required class name to enable custom theme styling for source code.

[code]

[one_half]Content[/one_half]

[one_half_last]Another content[/one_half_last]

[/code]

Parameters -

None


*/

/* Shortcode for source code formatting */
function mo_sourcecode_shortcode($atts, $content = null, $shortcode_name = "") {
    return '<pre class="code">' . do_shortcode(mo_remove_wpautop($content)) . '</pre>';
}

add_shortcode('code', 'mo_sourcecode_shortcode');

/* Shortcode for image nodes for additional styling */
function mo_image_node_shortcode($atts, $content = null, $shortcode_name = "") {
    return '<div class="image-node">' . do_shortcode(mo_remove_wpautop($content)) . '</div>';
}

add_shortcode('image-node', 'mo_image_node_shortcode');


/* Pullquote Shortcodes -

Usage:

[pullquote align="right"]Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet.[/pullquote]

Parameters -

align - Can be left, right, center or none. The default is none. (optional).
author - A string indicating author information. (optional)

*/

/* Shortcode for pull quotes with optional alignment = left or right or none */
function mo_pullquote_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(array(
        'align' => 'none',
        'author' => false,
    ), $atts));

    $pullquote_code = '<div class="quote-wrap align' . esc_attr($align) . '"><div class="' . $shortcode_name . '">' . do_shortcode($content) . '</div></div>';

    return $pullquote_code;

}

add_shortcode('pullquote', 'mo_pullquote_shortcode');

/* Blockquote Shortcode -

Usage:

[blockquote align="right" author="Tom Bodett"]They say a person needs just three things to be truly happy in this world: someone to love, something to do, and something to hope for.[/blockquote]

Parameters -

align - Can be left, right, center or none. The default is none. (optional).
id - The element id to be set for the blockquote element created (optional).
style - Inline CSS styling applied for the blockquote element created (optional)
class - Custom CSS class name to be set for the blockquote element created (optional)
subtitle - A companion div element which goes with the blockquote element created. Can be utilized to enhance the quote in parallax or video backgrounds. (optional)
author - A string value indicating the author of the quote.
affiliation - The entity to which the author of the quote belongs to.
affiliation_url - The URL of the entity to which this quote is attributed to.

*/

/* Shortcode for blockquotes with optional alignment = left or right and citation attributes*/
function mo_blockquote_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(
        array(
            'align' => 'none',
            'subtitle' => false,
            'author' => false,
            'affiliation' => false,
            'affiliation_url' => false,
            'id' => '',
            'class' => '',
            'style' => ''
        ), $atts));

    if (!empty($id))
        $id = ' id="' . esc_attr($id) . '"';
    if (!empty($class))
        $class = ' ' . esc_attr($class);
    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    $author_info = '';

    if ($author || $affiliation) {
        $author_info = '<p class="author">- ';
        $author_info .= $author ? esc_html($author) : '';
        $author_info .= $affiliation ? ', ' : '';
        if ($affiliation && $affiliation_url)
            $author_info .= '<a href="' . esc_url($affiliation_url) . '" title="' . esc_attr($affiliation) . '">' . esc_html($affiliation) . '</a>';
        elseif ($affiliation)
            $author_info .= esc_html($affiliation);

        $author_info .= '</p>';
    }

    if (!empty($subtitle)) {
        $subtitle = '<div class="subtitle">' . htmlspecialchars_decode(esc_html($subtitle)) . '</div>';
    }

    $output = '<div' . $id . ' class="quote-wrap align' . esc_attr($align) . esc_attr($class) . '">';

    $output .= '<blockquote' . $style . '>' . $subtitle . do_shortcode($content) . '</blockquote>';

    $output .= $author_info;

    $output .= '</div> <!-- .quote-wrap -->';

    return $output;

}

add_shortcode('blockquote', 'mo_blockquote_shortcode');

/* Highlight Shortcodes -

Highlights the text wrapped by the shortcode. Useful for highlighting text. Has two variations - highlight1 and highlight2.

Usage:

[highlight1]Lorem ipsum dolor sit amet, consetetur[/highlight1]

[highlight2]Lorem ipsum dolor sit amet, consetetur[/highlight2]

Parameters -

None


*/

/* Shortcode for highlighting text within the content */
function mo_highlight_shortcode($atts, $content = null, $shortcode_name = "") {

    $output = '<span class="' . $shortcode_name . '">' . do_shortcode($content) . '</span>';

    return $output;

}

add_shortcode('highlight1', 'mo_highlight_shortcode');
add_shortcode('highlight2', 'mo_highlight_shortcode');

/* List Shortcode -

A shortcode to create a styled unordered list element UL.

Usage:

[list]

<li>Item 1</li>
<li>Item 2</li>

[/list]

Parameters -

style - Inline CSS styling applied for the UL element created (optional)
type - Custom CSS class name to be set for the UL element created (optional). Possible values are from list1, list2, list3 to list10. Default is list1.


*/

function mo_list_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
        'style' => '',
        'type' => 'list1'
    ), $atts));

    $list_content = do_shortcode($content);

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';


    $styled_list = '<ul class="' . esc_attr($type) . '"' . $style . '>';

    $output = str_replace('<ul>', $styled_list, $list_content);

    return $output;
}

add_shortcode('list', 'mo_list_shortcode');

/* Heading Shortcodes -

Heading shortcodes are used across all pages in the theme as introductory texts/titles to the page sections.

Usage:

[heading
title="Connect with us on our <strong>blog</strong>"]
Parameters -

style - Inline CSS styling applied for the div element created (optional)
class - Custom CSS class name to be set for the div element created (optional)
title - A string value indicating the title of the heading.

*/

function mo_heading_shortcode($atts) {
    extract(shortcode_atts(array(
            'style' => '',
            'class' => '',
            'title' => '',
            'align' => 'center',
            'pitch_text' => ''
        ),
        $atts));

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';
    if (!empty($class))
        $class = ' ' . esc_attr($class);
    $output = '<div class="heading ' . $align . $class . '"' . $style . '>';

    if (!empty ($title))
        $output .= '<h3 class="title">' . htmlspecialchars_decode(esc_html($title)) . '</h3>';
    if (!empty ($pitch_text))
        $output .= '<p class="pitch">' . htmlspecialchars_decode(esc_html($pitch_text)) . '</p>';

    $output .= '</div>';

    return $output;
}

add_shortcode('heading', 'mo_heading_shortcode');

/* Heading 2 shortcode

Usage:

[heading2
title="Connect with us on our <strong>blog</strong>"
subtitle="From the Blog" button_text="Visit Blog"
button_url="#" 
pitch_text="Lorem ipsum dolor sit amet, consectetuer elit. Aenean leo ligula, porttitor eu, consequat vitae. Sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat"]
Parameters -

style - Inline CSS styling applied for the div element created (optional)
class - Custom CSS class name to be set for the div element created (optional)
title - A string value indicating the title of the heading.
subtitle - A string value specifying a short string or tagline shown beside the title.


*/

function mo_heading2_shortcode($atts) {
    extract(shortcode_atts(array(
            'style' => '',
            'class' => '',
            'title' => '',
            'sub_title' => ''
        ),
        $atts));

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';
    if (!empty($class))
        $class = ' ' . esc_attr($class);
    $output = '<div class="heading2' . $class . '"' . $style . '>';


    if (!empty ($sub_title))
        $output .= '<div class="sub-title">' . htmlspecialchars_decode(esc_html($sub_title)) . '</div>';
    if (!empty ($title))
        $output .= '<h3 class="title">' . htmlspecialchars_decode(esc_html($title)) . '</h3>';

    $output .= '</div>';

    return $output;
}

add_shortcode('heading2', 'mo_heading2_shortcode');

/* Segment Shortcode -

Usage:

[segment]

[one_half]Content[/one_half]

[one_half_last]Another content[/one_half_last]

[/segment]

Parameters -

id - The element id to be set for the div element created (optional).
style - Inline CSS styling applied for the div element created (optional)
class - Custom CSS class name to be set for the div element created (optional)
overlay_color - The color of the overlay to be applied on the video or background image.
overlay_opacity - 0.7 (number). 0 to 1 - The opacity of the overlay color.
overlay_pattern (link)- The URL of the image which can act as a pattern displayed on top of the video or background image.
*/
function mo_segment_shortcode($atts, $content = null) {
    extract(shortcode_atts(array(
            'id' => '',
            'class' => '',
            'style' => '',
            'background_pattern' => '',
            'background_color' => '',
            'background_image' => '',
            'parallax_background' => 'true',
            'youtube_bg_url' => '',
            'youtube_bg_quality' => 'highres',
            'youtube_bg_opacity' => 1,
            'youtube_bg_aspect_ratio' => '16/9',
            'overlay_color' => '',
            'overlay_opacity' => '0.7',
            'overlay_pattern' => '',
            'pointer_down_url' => false
        ),
        $atts));

    if ($id)
        $id = 'id="' . esc_attr($id) . '"';

    if (!empty($style) || !empty ($youtube_bg_url) || !empty ($background_image) || !empty($background_color) || !empty($background_pattern)) {

        $inline_style = ' style="';
        $youtube_classes = '';
        $banner_classes = '';
        $youtube_markup = '';
        $parallax_element = '';
        if (!empty($youtube_bg_url)) {
            $youtube_classes = ' ytp-bg';
            $youtube_markup = ' data-property="{mute:true,autoPlay:true,loop:true, ' . 'videoURL:\'' . esc_url($youtube_bg_url) . '\',' . 'quality:\'' . esc_attr($youtube_bg_quality) . '\',' . 'opacity:' . esc_attr($youtube_bg_opacity) . ',' . 'ratio:\'' . esc_attr($youtube_bg_aspect_ratio) . '\'}"';
        }
        if (!empty($background_image)) {

            if (empty($youtube_bg_url) && $parallax_background == 'true') {
                $parallax_element = '<div class="parallax-bg" style="background-image:url(' . esc_url($background_image) . ');"></div>';
                $banner_classes = ' parallax-banner';
            }
            else {
                $parallax_element = '<div class="image-bg" style="background-image:url(' . esc_url($background_image) . ');"></div>';
                $banner_classes = ' image-banner';
            }
        }
        elseif (!empty($background_pattern)) {
            $inline_style .= 'background:url(' . esc_url($background_pattern) . ') repeat scroll left top ' . esc_attr($background_color) . ';';
        }
        if (!empty($background_color)) {
            $inline_style .= 'background-color:' . esc_attr($background_color) . ';';
        }
        $inline_style .= $style . '"'; // let the style override what we specify above using background shorthand
        $output = '<div ' . $id . $youtube_markup . ' class="segment ' . esc_attr($class) . $banner_classes . $youtube_classes . '" ' . $inline_style . '>';

        $output .= $parallax_element;

        if (!empty($youtube_bg_url) || !empty($background_image)) {

            if (!empty($overlay_color) || !empty($overlay_pattern)) :

                $overlay_opacity = esc_attr($overlay_opacity);
                $hex = esc_attr($overlay_color);
                list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");

                $bg_color = empty($overlay_color) ? "" : "background-color: rgba(" . "$r, $g, $b, $overlay_opacity);";
                $bg_pattern = empty($overlay_pattern) ? "" : "background-image:url(" . esc_url($overlay_pattern) . ");";

                $output .= '<div class="overlay" style="' . $bg_color . $bg_pattern . '"></div>';

            endif;
        }

        if (!empty($pointer_down_url)) {
            $output .= '<a href="' . $pointer_down_url . '" class="icon-angle-down pointer-down"></a>';
        }

        $output .= '<div class="segment-content">' . do_shortcode(mo_remove_wpautop($content)) . '</div>';

        $output .= '</div><!-- .segment-->';
    }
    else {
        $output = '<div ' . $id . ' class="segment ' . esc_attr($class) . '"><div class="segment-content">' . do_shortcode(mo_remove_wpautop($content)) . '</div></div><!-- .segment-->';
    }

    return $output;
}

add_shortcode('segment', 'mo_segment_shortcode');

/* Wrap Shortcodes -

This shortcode is used to create a DIV wrapper elements for other shortcodes.

Helps to display these elements in the visual editor of WordPress. The regular DIV elements entered in the HTML tab are not visible in the visual editor which leads to mistakes and lost/malformed elements.

Usage:

[ancestor_wrap class="marketing-ancestor"]

[parent_wrap id="marketing-parent"]

[wrap class="marketing-section"]

[child_wrap class="child-section"]

[one_half]Content[/one_half]

[one_half_last]Another content[/one_half_last]

[/child_wrap]

[/wrap]

[/parent_wrap]

[/ancestor_wrap]

Each of the wrapper shortcodes accept the following parameters

Parameters -

id - The element id to be set for the DIV element created (optional).
style - Inline CSS styling applied for the DIV element created (optional)
class - Custom CSS class name to be set for the DIV element created (optional)


*/

/* Shortcode for wrapping markup as visible in the visual editor. */
function mo_wrap_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(array(
        'id' => false,
        'class' => false,
        'style' => ''
    ), $atts));


    $id = empty($id) ? '' : ' id="' . esc_attr($id) . '"';
    $class = empty($class) ? '' : ' class="' . esc_attr($class) . '"';
    $style = empty($style) ? '' : ' style="' . esc_attr($style) . '"';

    return '<div' . $id . $class . $style . '>' . do_shortcode(mo_remove_wpautop($content)) . '</div>';
}

add_shortcode('child_wrap', 'mo_wrap_shortcode');
add_shortcode('wrap', 'mo_wrap_shortcode');
add_shortcode('parent_wrap', 'mo_wrap_shortcode');
add_shortcode('ancestor_wrap', 'mo_wrap_shortcode');


/* Shortcode for image wrapper with caption/subcaption. */
function mo_image_caption_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(array(
        'subcaption' => false,
        'caption' => false,
        'image_url' => false,
        'image_alt' => false
    ), $atts));

    return '<div class="image-wrap"><img class="size-full" src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '"/><div class="caption"><div class="subcaption">' . esc_attr($subcaption) . '</div>' . htmlspecialchars_decode(esc_html($caption)) . '</div></div>';
}

add_shortcode('image_wrap', 'mo_image_caption_shortcode');

/* Icon Shortcode -

Shortcode to display one of the font icons, chosen from the list of icons listed at http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/

Usage:

[icon class="icon-cart" style="font-size:32px;"]

[icon class="icon-thumbnails style="font-size:48px;"]

Parameters -

style - Inline CSS styling applied for the icon element created (optional). Useful if you want to specify font-size, color etc. for the icon inline.
class - Custom CSS class name to be set for the icon element created (optional)


*/

/* Shortcode for wrapping markup as visible in the visual editor. */
function mo_icon_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(array(
        'wrapper' => false,
        'wrapper_class' => 'mo-icon',
        'class' => false,
        'style' => ''
    ), $atts));

    $class = empty($class) ? '' : ' class="' . esc_attr($class) . '"';
    $style = empty($style) ? '' : ' style="' . esc_attr($style) . '"';

    $output = '<i' . $class . $style . '></i>';

    if (!empty($wrapper)) {
        $output = '<div class="' . esc_attr($wrapper_class) . '">' . $output . '</div>';

    }

    return $output;

}

add_shortcode('icon', 'mo_icon_shortcode');


/* Wrap Shortcodes -

This shortcode is used to create a DIV wrapper elements for other shortcodes.

Helps to display these elements in the visual editor of WordPress. The regular DIV elements entered in the HTML tab are not visible in the visual editor which leads to mistakes and lost/malformed elements.

Usage:

Each of the wrapper shortcodes accept the following parameters

Parameters -

id - The element id to be set for the DIV element created (optional).
style - Inline CSS styling applied for the DIV element created (optional)
class - Custom CSS class name to be set for the DIV element created (optional)


*/

/* Shortcode for wrapping markup as visible for the dumb visual editor. */
function mo_dummy_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(shortcode_atts(array(
        'id' => false,
        'class' => false,
        'style' => ''
    ), $atts));


    $id = empty($id) ? '' : ' id="' . esc_attr($id) . '"';
    $class_name = str_replace('_', '-', $shortcode_name);
    $class = ' class="' . $class_name . ' ' . esc_attr($class) . '"';
    $style = empty($style) ? '' : ' style="' . esc_attr($style) . '"';

    return '<div' . $id . $class . $style . '>' . do_shortcode($content) . '</div>';
}

add_shortcode('pricing_table', 'mo_dummy_shortcode');

/* Action Call Shortcode -

Useful to create action call segments which typically display a text urging the user to take action and a button which leads to the action.

Usage:

[action_call text="Ready to get started <strong>on your project?</strong></h3>" button_url="http://themeforest.net/user/LiveMesh" button_text="Purchase Now"]

[/code]

Parameters -

text - Text to be displayed urging for an action call.
button_text - The title to be displayed for the button.
button_color - The color of the button. Available colors are black, blue, cyan, green, orange, pink, red, teal, theme and trans.
button_url - The URL to which the button links to. The user navigates to this URL when the button is clicked.

*/
/* Shortcode for wrapping markup as visible for the dumb visual editor. */
function mo_action_call_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(
        shortcode_atts(
            array(
                'text' => false,
                'button_text' => false,
                'button_url' => '',
                'button_class' => 'theme'
            ),
            $atts));

    $output = '<div class="action-call">';

    $output .= '<div class="text">';

    $output .= '<h3>' . htmlspecialchars_decode(esc_html($text)) . '</h3>';

    $output .= '</div>';

    $output .= '<div class="button-wrap">';

    $output .= '<a class="button ' . esc_attr($button_class) . '" href="' . esc_url($button_url) . '" target="_self">' . esc_html($button_text) . '</a>';

    $output .= '</div>';

    $output .= '</div>';

    return $output;
}

add_shortcode('action_call', 'mo_action_call_shortcode');


function mo_read_more_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(
        shortcode_atts(
            array(
                'text' => '',
                'href' => '#',
                'title' => 'Read More',
                'target' => '_self',
                'style' => '',
                'class' => ''
            ),
            $atts));

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    $output = '<a class="read-more ' . esc_attr($class) . '"' . $style . ' href="' . esc_url($href) . '" title="' . esc_attr($title) . '" target="' . esc_attr($target) . '">' . esc_html($text) . '<i class="icon-arrow_right"></i></a>';

    return $output;
}

add_shortcode('read_more', 'mo_read_more_shortcode');

function mo_text_shortcode($atts, $content = null, $shortcode_name = "") {

    extract(
        shortcode_atts(
            array(
                'class' => '',
                'style' => ''
            ),
            $atts));

    if (!empty($style))
        $style = ' style="' . esc_attr($style) . '"';

    if (!empty($class))
        $class = ' class="' . esc_attr($class) . '"';

    $output = '<p' . $class . $style . '>' . $content . '</p>';

    return $output;
}

add_shortcode('text', 'mo_text_shortcode');


