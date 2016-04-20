<?php

/* Tab Group Shortcode -

Creates a list of tabs by converting a group of shortcodes indicating tab title and tab content.

Usage:

[tabgroup]
[tab title="Tab 1"]Tab 1 content goes here.[/tab]
[tab title="Tab 2"]Tab 2 content goes here.[/tab]
[tab title="Tab 3"]Tab 3 content goes here.[/tab]
[/tabgroup]

Parameters -

None

*/

$tab_count = 0;
$tabs = array();

function mo_tabgroup_shortcode($atts, $content)
{

    global $tab_count, $tabs;

    $tab_count = 0; //count reset

    do_shortcode($content); // Explode [tab] shortcode
    $output = '';
    if (is_array($tabs)) {
        foreach ($tabs as $tab) {
            $tab_elements[] = '<li class="tab-title"><a href="#">' . htmlspecialchars_decode(esc_html($tab['title'])) . '</a></li>';
            $panes[] = '<div class="tab-pane">' . htmlspecialchars_decode(esc_html($tab['content'])) . '</div>';
        }
        $output .= "\n" . '<ul class="tab-titles">' . implode("\n", $tab_elements) . '</ul>' . "\n";
        $output .= "\n" . '<div class="tab-panes">' . implode("\n", $panes) . '</div>' . "\n";

    }
    return $output;
}

add_shortcode('tabgroup', 'mo_tabgroup_shortcode');

/* Tabs Shortcode -

Displays a tab with a title and content.

Usage:

[tabgroup]
[tab title="Tab 1"]Tab 1 content goes here.[/tab]
[tab title="Tab 2"]Tab 2 content goes here.[/tab]
[tab title="Tab 3"]Tab 3 content goes here.[/tab]
[/tabgroup]

Parameters -

title - The title of the tab. The content of the tab is derived from content wrapped by the shortcode.

*/
function mo_tab_shortcode($atts, $content)
{
    global $tab_count, $tabs;

    extract(shortcode_atts(array(
        'title' => 'Tab %d'
    ), $atts));

    $tabs[$tab_count] = array('title' => $title, 'content' => do_shortcode($content));

    $tab_count++;
}

add_shortcode('tab', 'mo_tab_shortcode');


/* Toggle Shortcode -

Displays a toggle box with content hidden. The content is shown when the toggle is clicked.

Usage:

[toggle class="first" title="Toggle 1"]Toggle 1 content goes here.[/toggle]
[toggle title="Toggle 2"]Toggle 2 content goes here.[/toggle]
[toggle title="Toggle 3"]Toggle 3 content goes here.[/toggle]

Parameters -

class - CSS class name to be assigned to the toggle DIV element created.
title - The title of the toggle.

*/

function mo_toggle_shortcode($atts, $content = null, $code)
{
    extract(shortcode_atts(array(
        'title' => '',
        'class' => ''
    ), $atts));
    $output = '<div class="toggle' . (empty($class) ? '' : ' ' . esc_attr($class)) . '">';
    $output .= '<div class="toggle-label">' . esc_attr($title) . '</div>';
    $output .= '<div class="toggle-content">' . do_shortcode($content) . '</div>';
    $output .= '</div>';

    return $output;
}

add_shortcode('toggle', 'mo_toggle_shortcode');