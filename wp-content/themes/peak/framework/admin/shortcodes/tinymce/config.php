<?php


$livemesh_shortcodes['columns'] = array(
    'params' => array(),
    'shortcode' => '{{child_shortcode}}',
    // as there is no wrapper shortcode
    'popup_title' => esc_html__('Insert Columns Shortcode', 'peak'),
    'no_preview' => true,

    // child shortcode is clonable & sortable
    'child_shortcode' => array(
        'params' => array(
            'column' => array(
                'type' => 'select',
                'label' => esc_html__('Column Type', 'peak'),
                'desc' => esc_html__('Select the type, i.e., width of the column.', 'peak'),
                'options' => array(
                    'one_third' => esc_html__('One Third', 'peak'),
                    'one_third_last' => esc_html__('One Third Last', 'peak'),
                    'two_third' => esc_html__('Two Thirds', 'peak'),
                    'two_third_last' => esc_html__('Two Thirds Last', 'peak'),
                    'one_half' => esc_html__('One Half', 'peak'),
                    'one_half_last' => esc_html__('One Half Last', 'peak'),
                    'one_fourth' => esc_html__('One Fourth', 'peak'),
                    'one_fourth_last' => esc_html__('One Fourth Last', 'peak'),
                    'three_fourth' => esc_html__('Three Fourth', 'peak'),
                    'three_fourth_last' => esc_html__('Three Fourth Last', 'peak'),
                    'one_sixth' => esc_html__('One Sixth', 'peak'),
                    'one_sixth_last' => esc_html__('One Sixth Last', 'peak'),
                    'one_col' => esc_html__('One Column', 'peak'),
                    'one_col_last' => esc_html__('One Column Last', 'peak'),
                    'two_col' => esc_html__('Two Columns', 'peak'),
                    'two_col_last' => esc_html__('Two Columns Last', 'peak'),
                    'three_col' => esc_html__('Three Columns', 'peak'),
                    'three_col_last' => esc_html__('Three Columns Last', 'peak'),
                    'four_col' => esc_html__('Four Columns', 'peak'),
                    'four_col_last' => esc_html__('Four Columns Last', 'peak'),
                    'five_col' => esc_html__('Five Columns', 'peak'),
                    'five_col_last' => esc_html__('five Columns Last', 'peak'),
                    'six_col' => esc_html__('Six Columns', 'peak'),
                    'six_col_last' => esc_html__('Six Columns Last', 'peak'),
                    'seven_col' => esc_html__('Seven Columns', 'peak'),
                    'seven_col_last' => esc_html__('Seven Columns Last', 'peak'),
                    'eight_col' => esc_html__('Eight Columns', 'peak'),
                    'eight_col_last' => esc_html__('Eight Columns Last', 'peak'),
                    'nine_col' => esc_html__('Nine Columns', 'peak'),
                    'nine_col_last' => esc_html__('Nine Columns Last', 'peak'),
                    'ten_col' => esc_html__('Ten Columns', 'peak'),
                    'ten_col_last' => esc_html__('Ten Columns Last', 'peak'),
                    'eleven_col' => esc_html__('Eleven Columns', 'peak'),
                    'eleven_col_last' => esc_html__('Eleven Columns Last', 'peak')
                )
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => esc_html__('Column Content', 'peak'),
                'desc' => esc_html__('Add the column content.', 'peak'),
            )
        ),
        'shortcode' => '[{{column}}]{{content}}[/{{column}}] ',
        'clone_button' => esc_html__('Add Column', 'peak')
    )
);


/*veena edited*/


$livemesh_shortcodes['contact_form'] = array(
    'no_preview' => true,
    'params' => array(
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Style', 'peak'),
            'desc' => esc_html__('Custom CSS class name to be set for the DIV element created (optional)', 'peak')
        ),
        'mail_to' => array(
            'std' => 'recipient@mydomain.com',
            'type' => 'text',
            'label' => esc_html__('Recipient Email', 'peak'),
            'desc' => esc_html__(' A string field specifying the recipient email where all form submissions will be received.', 'peak')
        ),
        'web_url' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Web URL', 'peak'),
            'desc' => esc_html__('Specify if the user should be requested for Web URL via an input field.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'phone' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Phone Field', 'peak'),
            'desc' => esc_html__('Specify if the users should be requested for their phone number. A phone field is displayed if the value is set to true.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'subject' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Subject Field', 'peak'),
            'desc' => esc_html__('A form subject field is displayed if the value is set to true.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'button_color' => array(
            'std' => 'default',
            'type' => 'select',
            'label' => esc_html__('Button Color', 'peak'),
            'desc' => esc_html__('Color of the submit button.', 'peak'),
            'options' => array(
                'black' => esc_html__('Black', 'peak'),
                'blue' => esc_html__('Blue', 'peak'),
                'cyan' => esc_html__('Cyan', 'peak'),
                'green' => esc_html__('Green', 'peak'),
                'orange' => esc_html__('Orange', 'peak'),
                'pink' => esc_html__('Pink', 'peak'),
                'red' => esc_html__('Red', 'peak'),
                'teal' => esc_html__('Teal', 'peak'),
                'theme' => esc_html__('Theme', 'peak'),
                'trans' => esc_html__('Trans', 'peak')
            )
        ),
    ),

    'shortcode' => '[contact_form class="{{class}}" mail_to="{{mail_to}}" phone="{{phone}}" web_url="{{web_url}}" subject="{{subject}}" button_color="{{button_color}}"]',
    'popup_title' => esc_html__('Insert contact_form  Shortcode', 'peak')
);

$livemesh_shortcodes['pullquote'] = array(
    'no_preview' => true,
    'params' => array(
        'align' => array(
            'type' => 'select',
            'label' => esc_html__('Alignment', 'peak'),
            'desc' => esc_html__('Choose Pullquote Alignment (optional)', 'peak'),
            'std' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'peak'),
                'left' => esc_html__('Left', 'peak'),
                'center' => esc_html__('Center', 'peak'),
                'right' => esc_html__('Right', 'peak')
            )
        ),
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => esc_html__('Pullquote Content', 'peak'),
            'desc' => esc_html__('The actual quotation text for the pullquote element.', 'peak'),

        )

    ),
    'shortcode' => '[pullquote align="{{align}}"]{{content}}[/pullquote]',
    'popup_title' => esc_html__('Insert Pullquote Shortcode', 'peak')
);


$livemesh_shortcodes['blockquote'] = array(
    'no_preview' => true,
    'params' => array(
        'id' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Element Id', 'peak'),
            'desc' => esc_html__('The element id to be set for the blockquote element created', 'peak')
        ),
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Blockquote Class', 'peak'),
            'desc' => esc_html__('Custom CSS class name to be set for the blockquote element created ', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Blockquote Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the blockquote element created ', 'peak')
        ),
        'align' => array(
            'type' => 'select',
            'label' => esc_html__('Alignment', 'peak'),
            'desc' => esc_html__('Choose blockquote Alignment', 'peak'),
            'std' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'peak'),
                'left' => esc_html__('Left', 'peak'),
                'center' => esc_html__('Center', 'peak'),
                'right' => esc_html__('Right', 'peak')
            )
        ),
        'author' => array(
            'type' => 'text',
            'label' => esc_html__('Author', 'peak'),
            'desc' => esc_html__('Author Information.', 'peak'),
            'std' => ''
        ),
        'affiliation' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Affiliation', 'peak'),
            'desc' => esc_html__('The entity/organization to which the author of the quote belongs to.', 'peak'),

        ),
        'affiliation_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Affiliation URL', 'peak'),
            'desc' => esc_html__('The URL of the entity/organization to which this quote is attributed to', 'peak'),

        ),
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => esc_html__('Blockquote Content', 'peak'),
            'desc' => esc_html__('The actual quotation text for the blockquote element.', 'peak'),

        )
    ),
    'shortcode' => '[blockquote id="{{id}}" class="{{class}}" style="{{style}}" align="{{align}}" author="{{author}}" affiliation="{{affiliation}}" affiliation_url="{{affiliation_url}}"]{{content}}[/blockquote]',
    'popup_title' => esc_html__('Insert Blockquote Shortcode', 'peak')
);


$livemesh_shortcodes['segment'] = array(
    'no_preview' => true,
    'params' => array(
        'id' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Segment Id', 'peak'),
            'desc' => esc_html__('The id of the wrapper HTML element created by the segment shortcode (optional).', 'peak')
        ),
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Segment Class', 'peak'),
            'desc' => esc_html__('The CSS class of the HTML element wrapping the content(optional).', 'peak')
        ),

        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Segment Style', 'peak'),
            'desc' => esc_html__('Any optional inline styling you would like to apply to the segment.eg.padding:50px 0; ', 'peak')
        ),
        'background_image' => array(
            'std' => '',
            'type' => 'image',
            'label' => esc_html__('URL', 'peak'),
            'desc' => esc_html__('Provide the URL of the background image.eg.http://example.com/background3.jpg (optional)', 'peak')
        ),
        'parallax_background' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Parallax Background ', 'peak'),
            'desc' => esc_html__('Specify if this needs to be a parallax background image.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'background_speed' => array(
            'type' => 'text',
            'label' => esc_html__('Background Speed', 'peak'),
            'desc' => esc_html__('Speed of parallax animation - the speed at which the parallax background moves with user scrolling the page. Specify a value between 0 and 1. ', 'peak'),
            'std' => '0.6'
        ),
        'background_pattern' => array(
            'std' => '',
            'type' => 'image',
            'label' => esc_html__('Background Pattern', 'peak'),
            'desc' => esc_html__('As an alternative to Background Image option above, you can provide the URL of the background image which acts like a pattern background.', 'peak')

        ),
        'background_color' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Background Color', 'peak'),
            'desc' => esc_html__('The background color to be applied to the segment that spans the entire browser width.', 'peak')
        ),
        'video_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('YouTube Video URL', 'peak'),
            'desc' => esc_html__('Enter the YouTube URL of the YouTube video background (ex: http://www.youtube.com/watch?v=PzjwAAskt4o).', 'peak'),
        ),
        'video_quality' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Video Quality', 'peak'),
            'desc' => esc_html__('Quality of YouTube Background Video', 'peak'),
            'options' => array(
                'small' => esc_html__('Small', 'peak'),
                'medium' => esc_html__('Medium', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'hd720' => esc_html__('hd720', 'peak'),
                'hd1080' => esc_html__('hd1080', 'peak'),
                'highres' => esc_html__('highres', 'peak'),
            )
        ),
        'video_opacity' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Video Opacity', 'peak'),
            'desc' => esc_html__('Define the opacity of the YouTube Background Video. Specify a decimal value between 0 and 1.', 'peak'),
        ),
        'aspect_ratio' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Video Aspect Ratio', 'peak'),
            'desc' => esc_html__('Set the aspect ratio of the YouTube Background Video', 'peak'),
            'options' => array(
                '4/3' => esc_html__('4/3', 'peak'),
                '16/9' => esc_html__('16/9', 'peak'),
            )
        ),
        'overlay_color' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Video Overlay Color', 'peak'),
            'desc' => esc_html__('The color of the overlay to be applied on the YouTube Background Video.', 'peak'),
        ),
        'overlay_opacity' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Video Overlay Opacity', 'peak'),
            'desc' => esc_html__('The opacity of the overlay color for YouTube video background. Specify a value between 0 and 1.', 'peak'),
        ),
        'overlay_pattern' => array(
            'std' => '',
            'type' => 'image',
            'label' => esc_html__('Video Overlay Pattern', 'peak'),
            'desc' => esc_html__('The URL of the image which can act as a pattern displayed on top of the YouTube Background Video.', 'peak'),
        )
    ),
    'shortcode' => '[segment id="{{id}}" class="{{class}}" background_color="{{background_color}}" style="{{style}}" background_image="{{background_image}}" parallax_background="{{parallax_background}}" background_speed="{{background_speed}}" background_pattern="{{background_pattern}}" youtube_bg_url="{{video_url}}" youtube_bg_quality="{{video_quality}}" youtube_bg_opacity="{{video_opacity}}" youtube_bg_aspect_ratio="{{aspect_ratio}}" overlay_color="{{overlay_color}}" overlay_opacity="{{overlay_opacity}}"]REPLACE ME[/segment]',
    'popup_title' => esc_html__('Insert Segment Shortcode', 'peak')
);


$livemesh_shortcodes['code'] = array(
    'no_preview' => true,
    'params' => array(
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => esc_html__('Code Content', 'peak'),
            'desc' => esc_html__('Add the code content.', 'peak'),
        )
    ),
    'shortcode' => '[code]{{content}}[/code]',
    'popup_title' => esc_html__('Insert Code Shortcode', 'peak')
);


$livemesh_shortcodes['wrap'] = array(
    'params' => array(
        'id' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Parent Wrap Id', 'peak'),
            'desc' => esc_html__('The element id to be set for the parent DIV element created (optional).', 'peak')
        ),
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Parent Wrap Class', 'peak'),
            'desc' => esc_html__(' Custom CSS class name to be set for the parent DIV element created (optional)', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Parent Wrap Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the parent DIV element created (optional) ', 'peak')
        ),
    ),
    'shortcode' => '[parent_wrap id="{{id}}" class="{{class}}" style="{{style}}"]{{child_shortcode}}[/parent_wrap]',
    'popup_title' => esc_html__('Insert wrap Shortcode', 'peak'),
    'no_preview' => true,

    // child shortcode is clonable & sortable
    'child_shortcode' => array(
        'params' => array(
            'id' => array(
                'std' => '',
                'type' => 'text',
                'label' => esc_html__('Wrap Id', 'peak'),
                'desc' => esc_html__('The element id to be set for the child DIV element created (optional).', 'peak')
            ),
            'class' => array(
                'std' => '',
                'type' => 'text',
                'label' => esc_html__('Wrap Class', 'peak'),
                'desc' => esc_html__(' Custom CSS class name to be set for the child DIV element created (optional)', 'peak')
            ),
            'style' => array(
                'std' => '',
                'type' => 'text',
                'label' => esc_html__('Wrap Style', 'peak'),
                'desc' => esc_html__('Inline CSS styling applied for the child DIV element created (optional) ', 'peak')
            ),
            'content' => array(
                'std' => '',
                'type' => 'textarea',
                'label' => esc_html__('Wrap Content', 'peak'),
                'desc' => esc_html__('Add the code content for the child DIV element.', 'peak'),
            )
        ),
        'shortcode' => '[wrap id="{{id}}" class="{{class}}" style="{{style}}"]{{content}}[/wrap] ',
        'clone_button' => esc_html__('Add new Wrap', 'peak')
    )
);

$livemesh_shortcodes['highlight1'] = array(
    'no_preview' => true,
    'params' => array(
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => esc_html__('Highlighted Content', 'peak'),
            'desc' => esc_html__('Specify the content to be highlighted', 'peak'),
        )
    ),
    'shortcode' => '[highlight1]{{content}}[/highlight1]',
    'popup_title' => esc_html__('Insert Highlight1 Shortcode', 'peak')
);

$livemesh_shortcodes['highlight2'] = array(
    'no_preview' => true,
    'params' => array(
        'content' => array(
            'std' => '',
            'type' => 'textarea',
            'label' => esc_html__('Highlighted Content', 'peak'),
            'desc' => esc_html__('Specify the content to be highlighted.', 'peak'),
        )
    ),
    'shortcode' => '[highlight2]{{content}}[/highlight2]',
    'popup_title' => esc_html__('Insert Highlight2 Shortcode', 'peak')
);

$livemesh_shortcodes['list'] = array(
    'no_preview' => true,
    'params' => array(
        'style' => array(
            'type' => 'text',
            'label' => esc_html__('List Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the UL element created (optional).', 'peak'),
            'std' => ''
        ),
        'type' => array(
            'type' => 'select',
            'label' => esc_html__('Type', 'peak'),
            'desc' => esc_html__('Custom CSS class name to be set for the UL element created (optional).', 'peak'),
            'std' => 'list1',
            'options' => array(
                'list1' => esc_html__('list1', 'peak'),
                'list2' => esc_html__('list2', 'peak'),
                'list3' => esc_html__('list3', 'peak'),
                'list4' => esc_html__('list4', 'peak'),
                'list5' => esc_html__('list5', 'peak'),
                'list6' => esc_html__('list6', 'peak'),
                'list7' => esc_html__('list7', 'peak'),
                'list8' => esc_html__('list8', 'peak'),
                'list9' => esc_html__('list9', 'peak'),
                'list10' => esc_html__('list10', 'peak')
            )
        )

    ),
    'shortcode' => '[list type="{{type}}" style="{{style}}"]REPLACE ME WITH A LIST[/list]',
    'popup_title' => esc_html__('Insert List Shortcode', 'peak')
);

$livemesh_shortcodes['heading'] = array(
    'no_preview' => true,
    'params' => array(
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Heading Class', 'peak'),
            'desc' => esc_html__(' Custom CSS class name to be set for the heading div element created (optional)', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Heading Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the div element created (optional)', 'peak')
        ),
        'title' => array(
            'type' => 'text',
            'label' => esc_html__('Title', 'peak'),
            'desc' => esc_html__('A string value indicating the title of the heading.', 'peak'),
            'std' => ''
        ),
        'pitch_text' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Text', 'peak'),
            'desc' => esc_html__('The text displayed below the heading title.', 'peak'),
        )
    ),
    'shortcode' => '[heading class="{{class}}" style="{{style}}" title="{{title}}" pitch_text="{{pitch_text}}"]',
    'popup_title' => esc_html__('Insert Heading Shortcode', 'peak')
);


$livemesh_shortcodes['heading2'] = array(
    'no_preview' => true,
    'params' => array(
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Heading Class', 'peak'),
            'desc' => esc_html__(' Custom CSS class name to be set for the heading div element created (optional)', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Heading Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the div element created (optional)', 'peak')
        ),
        'title' => array(
            'type' => 'text',
            'label' => esc_html__('Title', 'peak'),
            'desc' => esc_html__('A string value indicating the title of the heading.', 'peak'),
            'std' => ''
        ),
        'sub_title' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Subtitle', 'peak'),
            'desc' => esc_html__('The string value displayed above the heading title.', 'peak'),
        )
    ),
    'shortcode' => '[heading2 class="{{class}}" style="{{style}}" title="{{title}}" sub_title="{{sub_title}}"]',
    'popup_title' => esc_html__('Insert Heading 2 Shortcode', 'peak')
);


$livemesh_shortcodes['icon'] = array(
    'no_preview' => true,
    'params' => array(

        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Icon Class', 'peak'),
            'desc' => esc_html__('Custom CSS class name to be set for the icon element created. The class names are listed at http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Icon Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the icon element created (optional). Useful if you want to specify font-size, color etc. for the icon inline.', 'peak')
        )
    ),
    'shortcode' => '[icon class="{{class}}" style="{{style}}"]',
    'popup_title' => esc_html__('Insert Icon Shortcode', 'peak')
);


$livemesh_shortcodes['action_call'] = array(
    'no_preview' => true,
    'params' => array(
        'text' => array(
            'std' => 'Call us now for a project quote.',
            'type' => 'text',
            'label' => esc_html__('Text', 'peak'),
            'desc' => esc_html__('Text to be displayed urging for an action call.', 'peak')
        ),
        'button_text' => array(
            'std' => 'Contact Us',
            'type' => 'text',
            'label' => esc_html__('Button Text', 'peak'),
            'desc' => esc_html__('The title to be displayed for the button.', 'peak')
        ),
        'button_color' => array(
            'std' => 'theme',
            'type' => 'select',
            'label' => esc_html__('Button Color Options', 'peak'),
            'desc' => esc_html__('The color of the button.', 'peak'),
            'options' => array(
                'black' => esc_html__('Black', 'peak'),
                'blue' => esc_html__('Blue', 'peak'),
                'cyan' => esc_html__('Cyan', 'peak'),
                'green' => esc_html__('Green', 'peak'),
                'orange' => esc_html__('Orange', 'peak'),
                'pink' => esc_html__('Pink', 'peak'),
                'red' => esc_html__('Red', 'peak'),
                'teal' => esc_html__('Teal', 'peak'),
                'theme' => esc_html__('Theme', 'peak'),
                'trans' => esc_html__('Trans', 'peak')
            )
        ),
        'button_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Button URL', 'peak'),
            'desc' => esc_html__('The URL to which the button links to.', 'peak'),
        )
    ),
    'shortcode' => '[action_call text="{{text}}" button_url="{{button_url}}" button_text="{{button_text}}" button_color="{{button_color}}"]',
    'popup_title' => esc_html__('Insert Action Call Shortcode', 'peak')
);


$livemesh_shortcodes['button'] = array(
    'no_preview' => true,
    'params' => array(

        'id' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Element Id', 'peak'),
            'desc' => esc_html__('The element id to be set for the button element created (optional)', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Button Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the button element created eg.padding: 10px 20px; (optional)', 'peak')
        ),
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Button Class', 'peak'),
            'desc' => esc_html__('Custom CSS class name to be set for the button element created (optional)', 'peak')
        ),
        'color' => array(
            'std' => 'theme',
            'type' => 'select',
            'label' => esc_html__('Color', 'peak'),
            'desc' => esc_html__('The color of the button.', 'peak'),
            'options' => array(
                'theme' => esc_html__('Theme', 'peak'),
                'black' => esc_html__('Black', 'peak'),
                'blue' => esc_html__('Blue', 'peak'),
                'cyan' => esc_html__('Cyan', 'peak'),
                'green' => esc_html__('Green', 'peak'),
                'orange' => esc_html__('Orange', 'peak'),
                'pink' => esc_html__('Pink', 'peak'),
                'red' => esc_html__('Red', 'peak'),
                'teal' => esc_html__('Teal', 'peak'),
                'trans' => esc_html__('Trans', 'peak')
            )

        ),
        'align' => array(
            'type' => 'select',
            'label' => esc_html__('Alignment', 'peak'),
            'desc' => esc_html__(' Alignment of the button and text alignment of the button title displayed.', 'peak'),
            'std' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'peak'),
                'left' => esc_html__('Left', 'peak'),
                'center' => esc_html__('Center', 'peak'),
                'right' => esc_html__('Right', 'peak')
            )
        ),
        'type' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Type', 'peak'),
            'desc' => esc_html__('Can be large, small or rounded.', 'peak'),
            'options' => array(
                'large' => esc_html__('Large', 'peak'),
                'small' => esc_html__('Small', 'peak'),
                'rounded' => esc_html__('Rounded', 'peak'),
            )

        ),
        'href' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('URL', 'peak'),
            'desc' => esc_html__('The URL to which button should point to. The user is taken to this destination when the button is clicked.eg.http://targeturl.com', 'peak'),

        ),
        'target' => array(
            'type' => 'select',
            'label' => esc_html__('Button Target', 'peak'),
            'desc' => esc_html__('_self = open in same window. _blank = open in new window', 'peak'),
            'std' => '_self',
            'options' => array(
                '_self' => esc_html__('_self', 'peak'),
                '_blank' => esc_html__('_blank', 'peak')
            )
        ),
        'content' => array(
            'std' => 'Contact Us',
            'type' => 'text',
            'label' => esc_html__('Button Title', 'peak'),
            'desc' => esc_html__('Specify the title of the button.', 'peak'),
        )

    ),
    'shortcode' => '[button id="{{id}}" style="{{style}}" color="{{color}}" type="{{type}}" href="http://targeturl.com" align="{{align}}" target="{{target}}"]{{content}}[/button]',
    'popup_title' => esc_html__('Insert Button Shortcode', 'peak')
);


$livemesh_shortcodes['image'] = array(
    'no_preview' => true,
    'params' => array(
        'link' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Link URL', 'peak'),
            'desc' => esc_html__('Specify a URL to which the link should point to if image should be a link (optional).', 'peak'),
        ),
        'title' => array(
            'type' => 'text',
            'label' => esc_html__('Image Title', 'peak'),
            'desc' => esc_html__('The title of the link to which image points to.', 'peak'),
            'std' => ''
        ),
        'class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Image Class', 'peak'),
            'desc' => esc_html__('Custom CSS class name to be set for the IMG element created (optional).', 'peak')
        ),
        'src' => array(
            'std' => '',
            'type' => 'image',
            'label' => esc_html__('Image URL', 'peak'),
            'desc' => esc_html__('Choose your image. An IMG element will be created for this image and the image will be cropped and styled as per the parameters provided', 'peak')
        ),
        'alt' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Alt Text', 'peak'),
            'desc' => esc_html__('The alt attribute value for the IMG element.', 'peak')
        ),
        'align' => array(
            'type' => 'select',
            'label' => esc_html__('Alignment', 'peak'),
            'desc' => esc_html__('Choose Image Alignment', 'peak'),
            'std' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'peak'),
                'left' => esc_html__('Left', 'peak'),
                'center' => esc_html__('Center', 'peak'),
                'right' => esc_html__('Right', 'peak')
            )
        ),
        'image_frame' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Image Frame', 'peak'),
            'desc' => esc_html__('A boolean value specifying if the image should be wrapped in a border frame and another type of frame as styled by the theme', 'peak'),
            'options' => array(
                'false' => esc_html__('False', 'peak'),
                'true' => esc_html__('True', 'peak'),
            )
        ),
        'wrapper' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Wrapper', 'peak'),
            'desc' => esc_html__('A boolean value indicating if the a wrapper DIV element needs to be created for the image.', 'peak'),
            'options' => array(
                'false' => esc_html__('False', 'peak'),
                'true' => esc_html__('True', 'peak'),
            )
        ),
        'wrapper_class' => array(
            'type' => 'text',
            'label' => esc_html__('Wrapper Class', 'peak'),
            'desc' => esc_html__('The CSS class for any wrapper DIV element created for the image. (optional)', 'peak'),
            'std' => ''
        ),
        'wrapper_style' => array(
            'type' => 'text',
            'label' => esc_html__('Wrapper Style', 'peak'),
            'desc' => esc_html__('The inline CSS styling for any wrapper DIV element created for the image. (optional)', 'peak'),
            'std' => ''
        ),
        'width' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Width', 'peak'),
            'desc' => esc_html__('Any custom width (in pixel units) specified for the element (optional). The original image (pointed to by the src parameter) will be cropped to this width.(optional)', 'peak')
        ),
        'height' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Height', 'peak'),
            'desc' => esc_html__('Any custom height (in pixel units) specified for the element (optional). The original image (pointed to by the Image URL parameter) will be cropped to this height.(optional)', 'peak')
        )

    ),
    'shortcode' => '[image link="{{link}}" class="{{class}}" title="{{title}}" src="{{src}}" alt="{{alt}}" align="{{align}}" image_frame="{{image_frame}}" wrapper="{{wrapper}}" wrapper_class="{{wrapper_class}}" wrapper_style="{{wrapper_style}}" width="{{width}}" height="{{height}}"]',
    'popup_title' => esc_html__('Insert Image Shortcode', 'peak')
);

$livemesh_shortcodes['audio'] = array(
    'no_preview' => true,
    'params' => array(
        'ogg_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('OGG URL', 'peak'),
            'desc' => esc_html__('The URL of the audio clip uploaded in OGG format.eg.http://mydomain.com/song.ogg', 'peak'),
        ),
        'mp3_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('MP4 URL', 'peak'),
            'desc' => esc_html__('The URL of the audio uploaded in MP3 format.eg.http://mydomain.com/song.mp3', 'peak'),
        )
    ),
    'shortcode' => '[html5_audio ogg_url="{{ogg_url}}" mp3_url="{{mp3_url}}" ]',
    'popup_title' => esc_html__('Insert HTML5 Audio Shortcode', 'peak')
);


$livemesh_shortcodes['vimeo_video'] = array(
    'no_preview' => true,
    'params' => array(
        'vimeo_video_id' => array(
            'std' => '20370519',
            'type' => 'text',
            'label' => esc_html__('Vimeo Video ID', 'peak'),
            'desc' => esc_html__('The id of the video uploaded on Vimeo. The id is usually at the end of the Vimeo video URL.', 'peak'),
        ),
        'placeholder_url' => array(
            'std' => '',
            'type' => 'image',
            'label' => esc_html__('Placeholder Image', 'peak'),
            'desc' => esc_html__('Choose the placeholder image for the Vimeo video', 'peak')
        ),
        'placeholder_alt' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Placeholder Image ALT text', 'peak'),
            'desc' => esc_html__('The alt attribute for the placeholder image specified.', 'peak'),
        )
    ),
    'shortcode' => '[vimeo_video vimeo_video_id="{{vimeo_video_id}}" placeholder_url="{{placeholder_url}}" placeholder_alt="{{placeholder_alt}}"]',
    'popup_title' => esc_html__('Insert Vimeo Video Shortcode', 'peak')
);

/*porfolio shortcodes*/

$livemesh_shortcodes['show_post_snippets'] = array(
    'no_preview' => true,
    'params' => array(
        'post_type' => array(
            'std' => 'portfolio',
            'type' => 'select',
            'label' => esc_html__('Post Type', 'peak'),
            'desc' => esc_html__('The custom post type whose posts need to be displayed. Examples include post, portfolio, team etc.', 'peak'),
            'options' => array(
                'post' => esc_html__('Post', 'peak'),
                'portfolio' => esc_html__('Portfolio', 'peak'),
                'gallery_item' => esc_html__('Gallery', 'peak')
            )
        ),
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Title', 'peak'),
            'desc' => esc_html__('Display a header title for the post snippets.', 'peak')
        ),
        'layout_class' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Layout Class', 'peak'),
            'desc' => esc_html__('The CSS class to be set for the list element (UL) displaying the post snippets (optional). Useful if you need to do some custom styling of our own (rounded, hexagon images etc.) for the displayed items.', 'peak')
        ),

        'number_of_columns' => array(
            'std' => '3',
            'type' => 'text',
            'label' => esc_html__('Number of Columns', 'peak'),
            'desc' => esc_html__('The number of columns to display per row of the post snippets', 'peak')
        ),
        'post_count' => array(
            'std' => '6',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__('Number of posts to display', 'peak')
        ),
        'image_size' => array(
            'std' => 'medium-thumb',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        ),
        'display_title' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Title', 'peak'),
            'desc' => esc_html__('Specify if the title of the post or custom post type needs to be displayed below the featured image', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'display_summary' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Summary', 'peak'),
            'desc' => esc_html__('Specify if the excerpt or summary content of the post/custom post type needs to be displayed below the featured image thumbnail.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_excerpt' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Show Excerpt', 'peak'),
            'desc' => esc_html__(' Display excerpt for the post/custom post type. Has no effect if Display Summary is set to false.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'excerpt_count' => array(
            'std' => '50',
            'type' => 'text',
            'label' => esc_html__('Excerpt Count', 'peak'),
            'desc' => esc_html__(' The excerpt displayed is truncated to the number of characters specified with this parameter.', 'peak')
        ),
        'hide_thumbnail' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Hide Thumbnail', 'peak'),
            'desc' => esc_html__('Specify if the thumbnail needs to be hidden', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_meta' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Meta', 'peak'),
            'desc' => esc_html__(' Display meta information like the author, date of publishing and number of comments', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'taxonomy' => array(
            'std' => 'portfolio_category',
            'type' => 'select',
            'label' => esc_html__('Taxonomy', 'peak'),
            'desc' => esc_html__('Custom taxonomy to be used for filtering the posts/custom post types displayed like category, department etc.', 'peak'),
            'options' => array(
                'category' => esc_html__('Category', 'peak'),
                'post_tag' => esc_html__('Tag', 'peak'),
                'portfolio_category' => esc_html__('Portfolio Category', 'peak'),
                'gallery_category' => esc_html__('Gallery Category', 'peak')
            )
        ),
        'terms' => array(
            'std' => 'inspiration,technology',
            'type' => 'text',
            'label' => esc_html__('Taxonomy Terms', 'peak'),
            'desc' => esc_html__(' A comma separated list of terms of taxonomy specified for which the items needs to be displayed. Helps filter the results by category/taxonomy, if the these terms are defined for the taxonomy chosen.', 'peak')
        ),
        'no_margin' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('No Margin - Packed Layout', 'peak'),
            'desc' => esc_html__(' If set to true, no margins are maintained between the columns. Helps to achieve the popular packed layout.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
    ),
    'shortcode' => '[show_post_snippets layout_class="{{layout_class}}" post_type="{{post_type}}" taxonomy="{{taxonomy}}" terms="{{terms}}" number_of_columns="{{number_of_columns}}" post_count="{{post_count}}" display_title="{{display_title}}" display_summary="{{display_summary}}" show_excerpt="{{show_excerpt}}" excerpt_count="{{excerpt_count}}" show_meta="{{show_meta}}" image_size="{{image_size}}" hide_thumbnail="{{hide_thumbnail}}" title="{{title}}" no_margin="{{no_margin}}"]',
    'popup_title' => esc_html__('Insert Portfolio  Shortcode', 'peak')
);

$livemesh_shortcodes['show_portfolio'] = array(
    'no_preview' => true,
    'params' => array(
        'number_of_columns' => array(
            'std' => '3',
            'type' => 'text',
            'label' => esc_html__('Number of Columns', 'peak'),
            'desc' => esc_html__('The number of columns to display per row of the post snippets', 'peak')
        ),
        'post_count' => array(
            'std' => '9',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__(' Total number of portfolio items to display.', 'peak')
        ),
        'image_size' => array(
            'std' => 'medium-thumb',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full..', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        ),
        'filterable' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Filterable', 'peak'),
            'desc' => esc_html__('The portfolio items will be filterable based on portfolio categories if set to true.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'no_margin' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Margin', 'peak'),
            'desc' => esc_html__(' If set to true, no margins are maintained between the columns. Helps to achieve the popular packed layout.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'layout_mode' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Layout Mode', 'peak'),
            'desc' => esc_html__(' Can be either Masonry or FitRows depending on the layout desired.', 'peak'),
            'options' => array(
                'fitRows' => esc_html__('FitRows', 'peak'),
                'masonry' => esc_html__('Masonry', 'peak')
            )
        ),
    ),
    'shortcode' => '[show_portfolio number_of_columns="{{number_of_columns}}" post_count="{{post_count}}" image_size="{{image_size}}" filterable="{{filterable}}" no_margin="{{no_margin}} layout_mode="{{layout_mode}}"]',
    'popup_title' => esc_html__('Insert Portfolio  Shortcode', 'peak')
);

$livemesh_shortcodes['show_gallery'] = array(
    'no_preview' => true,
    'params' => array(
        'number_of_columns' => array(
            'std' => '3',
            'type' => 'text',
            'label' => esc_html__('Number of Columns', 'peak'),
            'desc' => esc_html__('The number of columns to display per row of the post snippets', 'peak')
        ),
        'post_count' => array(
            'std' => '9',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__(' Total number of Gallery items to display', 'peak')
        ),
        'image_size' => array(
            'std' => 'medium-thumb',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        ),
        'filterable' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Filterable', 'peak'),
            'desc' => esc_html__('The Gallery items will be filterable based on portfolio categories if set to true.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
        'no_margin' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Margin', 'peak'),
            'desc' => esc_html__(' If set to true, no margins are maintained between the columns.', 'peak'),
            'options' => array(
                'true' => esc_html__('True', 'peak'),
                'false' => esc_html__('False', 'peak')
            )
        ),
    ),
    'shortcode' => '[show_gallery number_of_columns="{{number_of_columns}}" post_count="{{post_count}}" image_size="{{image_size}}" filterable="{{filterable}}" no_margin="{{no_margin}}"]',
    'popup_title' => esc_html__('Insert Gallery  Shortcode', 'peak')
);

/*blog posts shortcode*/
$livemesh_shortcodes['recent_posts'] = array(
    'no_preview' => true,
    'params' => array(
        'post_count' => array(
            'std' => '5',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__('Number of posts to display', 'peak')
        ),
        'hide_thumbnail' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Hide Thumbnail', 'peak'),
            'desc' => esc_html__('Display thumbnail image or hide the same', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_meta' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Meta Information', 'peak'),
            'desc' => esc_html__(' Display meta information like the author, date of publishing and number of comments', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'excerpt_count' => array(
            'std' => '50',
            'type' => 'text',
            'label' => esc_html__('Excerpt Count', 'peak'),
            'desc' => esc_html__(' The excerpt displayed is truncated to the number of characters specified with this parameter.', 'peak')
        ),
        'image_size' => array(
            'std' => 'small',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        )

    ),
    'shortcode' => '[recent_posts post_count="{{post_count}}" hide_thumbnail="{{hide_thumbnail}}" show_meta="{{show_meta}}" excerpt_count="{{excerpt_count}}" image_size="{{image_size}}"]',
    'popup_title' => esc_html__('Insert Blog Post Shortcode', 'peak')
);

$livemesh_shortcodes['popular_posts'] = array(
    'no_preview' => true,
    'params' => array(
        'post_count' => array(
            'std' => '5',
            'type' => 'text',
            'label' => esc_html__('Number Of Posts', 'peak'),
            'desc' => esc_html__('Number of posts to display', 'peak')
        ),
        'hide_thumbnail' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Hide Thumbnail', 'peak'),
            'desc' => esc_html__('Display thumbnail image or hide the same', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_meta' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Meta Information', 'peak'),
            'desc' => esc_html__(' Display meta information like the author, date of publishing and number of comments', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'excerpt_count' => array(
            'std' => '50',
            'type' => 'text',
            'label' => esc_html__('Excerpt Count', 'peak'),
            'desc' => esc_html__(' The excerpt displayed is truncated to the number of characters specified with this parameter.', 'peak')
        ),
        'image_size' => array(
            'std' => 'small',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        )

    ),
    'shortcode' => '[popular_posts post_count="{{post_count}}" hide_thumbnail="{{hide_thumbnail}}" show_meta="{{show_meta}}" excerpt_count="{{excerpt_count}}" image_size="{{image_size}}"]',
    'popup_title' => esc_html__('Insert Popular Posts Shortcode', 'peak')
);

$livemesh_shortcodes['category_posts'] = array(
    'no_preview' => true,
    'params' => array(
        'category_slugs' => array(
            'std' => 'inspiration,technology',
            'type' => 'text',
            'label' => esc_html__('Category Slugs', 'peak'),
            'desc' => esc_html__('The comma separated list of posts category slugs.', 'peak')
        ),
        'post_count' => array(
            'std' => '5',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__('Number of posts to display', 'peak')
        ),
        'hide_thumbnail' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Hide Thumbnail', 'peak'),
            'desc' => esc_html__('Display thumbnail image or hide the same', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_meta' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Meta Information', 'peak'),
            'desc' => esc_html__(' Display meta information like the author, date of publishing and number of comments', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'excerpt_count' => array(
            'std' => '50',
            'type' => 'text',
            'label' => esc_html__('Excerpt Count', 'peak'),
            'desc' => esc_html__(' The excerpt displayed is truncated to the number of characters specified with this parameter.', 'peak')
        ),
        'image_size' => array(
            'std' => 'small',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        )

    ),
    'shortcode' => '[category_posts category_slugs="{{category_slugs}}" post_count="{{post_count}}" hide_thumbnail="{{hide_thumbnail}}" show_meta="{{show_meta}}" excerpt_count="{{excerpt_count}}" image_size="{{image_size}}"]',
    'popup_title' => esc_html__('Insert Posts for one or more Categories', 'peak')
);

$livemesh_shortcodes['tag_posts'] = array(
    'no_preview' => true,
    'params' => array(
        'tag_slugs' => array(
            'std' => 'inspiration,technology',
            'type' => 'text',
            'label' => esc_html__('Tag Slugs', 'peak'),
            'desc' => esc_html__('The comma separated list of posts tag slugs.', 'peak')
        ),
        'post_count' => array(
            'std' => '5',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__('Number of posts to display', 'peak')
        ),
        'hide_thumbnail' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Hide Thumbnail', 'peak'),
            'desc' => esc_html__('Display thumbnail image or hide the same', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_meta' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Meta Information', 'peak'),
            'desc' => esc_html__(' Display meta information like the author, date of publishing and number of comments', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'excerpt_count' => array(
            'std' => '50',
            'type' => 'text',
            'label' => esc_html__('Excerpt Count', 'peak'),
            'desc' => esc_html__(' The excerpt displayed is truncated to the number of characters specified with this parameter.', 'peak')
        ),
        'image_size' => array(
            'std' => 'small',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        )
    ),
    'shortcode' => '[tag_posts tag_slugs="{{tag_slugs}}" post_count="{{post_count}}" hide_thumbnail="{{hide_thumbnail}}" show_meta="{{show_meta}}" excerpt_count="{{excerpt_count}}" image_size="{{image_size}}"]',
    'popup_title' => esc_html__('Insert Posts of one or more Tags', 'peak')
);

$livemesh_shortcodes['show_custom_post_types'] = array(
    'no_preview' => true,
    'params' => array(
        'post_types' => array(
            'std' => 'post',
            'type' => 'select',
            'label' => esc_html__('Post Types', 'peak'),
            'desc' => esc_html__('The comma separated list of post types whose posts need to be displayed.', 'peak'),
            'options' => array(
                'post' => esc_html__('Post', 'peak'),
                'portfolio' => esc_html__('Portfolio', 'peak'),
                'gallery_item' => esc_html__('Gallery', 'peak'),
                'team' => esc_html__('Team', 'peak')
            )
        ),
        'post_count' => array(
            'std' => '5',
            'type' => 'text',
            'label' => esc_html__('Number of Posts', 'peak'),
            'desc' => esc_html__('Number of posts to display', 'peak')
        ),
        'hide_thumbnail' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Hide Thumbnail', 'peak'),
            'desc' => esc_html__('Display thumbnail image or hide the same', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'show_meta' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Display Meta Information', 'peak'),
            'desc' => esc_html__(' Display meta information like the author, date of publishing and number of comments', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'excerpt_count' => array(
            'std' => '50',
            'type' => 'text',
            'label' => esc_html__('Excerpt Count', 'peak'),
            'desc' => esc_html__(' The excerpt displayed is truncated to the number of characters specified with this parameter.', 'peak')
        ),
        'image_size' => array(
            'std' => 'small',
            'type' => 'select',
            'label' => esc_html__('Image Size', 'peak'),
            'desc' => esc_html__(' Can be thumbnail, medium, medium-thumb, square-thumb, large or full.', 'peak'),
            'options' => array(
                'medium' => esc_html__('Medium', 'peak'),
                'thumbnail' => esc_html__('Thumbnail', 'peak'),
                'medium-thumb' => esc_html__('Medium Thumb', 'peak'),
                'square-thumb' => esc_html__('Square', 'peak'),
                'large' => esc_html__('Large', 'peak'),
                'full' => esc_html__('Full', 'peak')
            )
        )
    ),
    'shortcode' => '[show_custom_post_types post_types="{{post_types}}" post_count="{{post_count}}" hide_thumbnail="{{hide_thumbnail}}" show_meta="{{show_meta}}" excerpt_count="{{excerpt_count}}" image_size="{{image_size}}"]',
    'popup_title' => esc_html__('Insert Custom Post Types', 'peak')
);

/*custom Post Types*/

$livemesh_shortcodes['pricing_plans'] = array(
    'no_preview' => true,
    'params' => array(
        'post_count' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Number of Pricing Columns', 'peak'),
            'desc' => esc_html__('The number of pricing columns to be displayed. By default displays all of the custom posts entered as pricing in the Pricing Plan tab of WordPress admin (optional).', 'peak')
        ),
        'pricing_ids' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Pricing IDs', 'peak'),
            'desc' => esc_html__('A comma separated post ids of the pricing custom post types created in the Pricing Plan tab of WordPress admin (optional). Useful for filtering the items displayed. ', 'peak')
        )
    ),
    'shortcode' => '[pricing_plans post_count="{{post_count}}" pricing_ids="{{pricing_ids}}"]',
    'popup_title' => esc_html__('Insert Pricing Plans Shortcode', 'peak')
);

$livemesh_shortcodes['testimonials'] = array(
    'no_preview' => true,
    'params' => array(
        'post_count' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Number of Testimonials', 'peak'),
            'desc' => esc_html__('The number of testimonials to be displayed.', 'peak')
        ),
        'testimonial_ids' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Testimonials IDs', 'peak'),
            'desc' => esc_html__('A comma separated post ids of the Testimonial custom post types created in the Testimonials tab of the WordPress Admin. Helps to filter the testimonials for display (optional).', 'peak')
        )
    ),
    'shortcode' => '[testimonials post_count="{{post_count}}" testimonial_ids="{{testimonial_ids}}"]',
    'popup_title' => esc_html__('Insert Testimonials Shortcode', 'peak')
);

$livemesh_shortcodes['testimonials2'] = array(
    'no_preview' => true,
    'params' => array(
        'post_count' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Number of Testimonials2', 'peak'),
            'desc' => esc_html__('The number of testimonials to be displayed.', 'peak')
        ),
        'testimonial_ids' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Testimonials IDs', 'peak'),
            'desc' => esc_html__('A comma separated post ids of the Testimonial custom post types created in the Testimonials tab of the WordPress Admin. Helps to filter the testimonials for display (optional).', 'peak')
        )
    ),
    'shortcode' => '[testimonials2 post_count="{{post_count}}" testimonial_ids="{{testimonial_ids}}"]',
    'popup_title' => esc_html__('Insert Testimonials 2 Shortcode', 'peak')
);

$livemesh_shortcodes['team'] = array(
    'no_preview' => true,
    'params' => array(
        'post_count' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Number of Team Members', 'peak'),
            'desc' => esc_html__('The number of team members to be displayed.', 'peak')
        ),
        'column_count' => array(
            'std' => '3',
            'type' => 'text',
            'label' => esc_html__('Number of Columns', 'peak'),
            'desc' => esc_html__('The number of columns to display per row of the team members displayed', 'peak')
        ),
        'member_ids' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Team Member Post IDs', 'peak'),
            'desc' => esc_html__('A comma separated post ids of the Team Member custom post types created in the Team Profiles tab of the WordPress Admin. Helps to filter the team members for display (optional).', 'peak')
        )
    ),
    'shortcode' => '[team post_count="{{post_count}}" column_count="{{column_count}}" member_ids="{{member_ids}}"]',
    'popup_title' => esc_html__('Insert Team Shortcode', 'peak')
);

/*slider shortcodes*/

$livemesh_shortcodes['responsive_slider'] = array(
    'no_preview' => true,
    'params' => array(
        'type' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Type', 'peak'),
            'desc' => esc_html__('Constructs and sets a unique CSS class for the slider. (optional).', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Style', 'peak'),
            'desc' => esc_html__('The inline CSS applied to the slider container DIV element.(optional)', 'peak'),
        ),
        'slideshow_speed' => array(
            'std' => '5000',
            'type' => 'text',
            'label' => esc_html__('Slideshow Speed', 'peak'),
            'desc' => esc_html__('Set the speed of the slideshow cycling, in milliseconds', 'peak')
        ),
        'animation_speed' => array(
            'std' => '600',
            'type' => 'text',
            'label' => esc_html__('Animation Speed', 'peak'),
            'desc' => esc_html__('Set the speed of animations, in milliseconds.', 'peak')
        ),

        'animation' => array(
            'std' => 'fade',
            'type' => 'select',
            'label' => esc_html__('Animation', 'peak'),
            'desc' => esc_html__('Select your animation type, "fade" or "slide".', 'peak'),
            'options' => array(
                'fade' => esc_html__('fade', 'peak'),
                'slide' => esc_html__('slide', 'peak')
            )
        ),
        'pause_on_action' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Pause on Action', 'peak'),
            'desc' => esc_html__('Pause the slideshow when interacting with control elements, highly recommended.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'pause_on_hover' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Pause on Hover', 'peak'),
            'desc' => esc_html__('Pause the slideshow when hovering over slider, then resume when no longer hovering. ' , 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'direction_nav' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Direction Navigation', 'peak'),
            'desc' => esc_html__(' Create navigation for previous/next navigation.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'control_nav' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Control Navigation', 'peak'),
            'desc' => esc_html__('Create navigation for paging control of each slide? Note: Leave true for manual_controls usage.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'easing' => array(
            'std' => 'swing',
            'type' => 'text',
            'label' => esc_html__('Easing', 'peak'),
            'desc' => esc_html__(' Determines the easing method used in jQuery transitions. jQuery easing plugin is supported!', 'peak')
        ),
        'loop' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Loop', 'peak'),
            'desc' => esc_html__('Should the animation loop?', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'slideshow' => array(
            'std' => 'true',
            'type' => 'select',
            'label' => esc_html__('Slideshow', 'peak'),
            'desc' => esc_html__('Animate slider automatically without user intervention.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'controls_container' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Controls Container', 'peak'),
            'desc' => esc_html__('Advanced Use only - Selector: USE CLASS SELECTOR. Declare which container the navigation elements should be appended too. Default container is the FlexSlider element. Example use would be ".flexslider-container". Property is ignored if given element is not found.', 'peak')
        ),
        'manual_controls' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Manual Controls', 'peak'),
            'desc' => esc_html__('Advanced Use only - Selector: Declare custom control navigation. Examples would be ".flex-control-nav li" or "#tabs-nav li img", etc. The number of elements in your controlNav should match the number of slides/tabs.', 'peak')
        )
    ),
    'shortcode' => '[responsive_slider type="{{type}}" slideshow_speed="{{slideshow_speed}}" animation_speed="{{animation_speed}}" animation="{{animation}}" control_nav="{{control_nav}}" direction_nav="{{direction_nav}}" pause_on_hover="{{pause_on_hover}}" pause_on_action="{{pause_on_action}}" easing="{{easing}}" loop="{{loop}}" slideshow="{{slideshow}}" controls_container="{{controls_container}}" manualControls="{{manual_controls}}" style="{{style}}"]REPLACE WITH A LIST (ul > li tag) OF IMAGES OR HTML CONTENT[/responsive_slider]',
    'popup_title' => esc_html__('Insert Slider  Shortcode', 'peak')

);

/*tabs shortcode*/

$livemesh_shortcodes['tabgroup'] = array(
    'params' => array(),
    'no_preview' => true,
    'shortcode' => '[tabgroup]{{child_shortcode}}[/tabgroup]',
    'popup_title' => esc_html__('Insert Tab Shortcode', 'peak'),
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Title',
                'type' => 'text',
                'label' => esc_html__('Tab Title', 'peak'),
                'desc' => esc_html__('Title of the tab', 'peak'),
            ),
            'content' => array(
                'std' => 'Tab Content',
                'type' => 'textarea',
                'label' => esc_html__('Tab Content', 'peak'),
                'desc' => esc_html__('Add the tabs content', 'peak')
            )
        ),
        'shortcode' => '[tab title="{{title}}"]{{content}}[/tab]',
        'clone_button' => esc_html__('Add Tab', 'peak')
    )

);

$livemesh_shortcodes['toggle'] = array(
    'no_preview' => true,
    'params' => array(
        'class' => array(
            'type' => 'text',
            'label' => esc_html__('Class', 'peak'),
            'desc' => esc_html__('CSS class name to be assigned to the toggle DIV element created.', 'peak'),
            'std' => ''
        ),
        'title' => array(
            'type' => 'text',
            'label' => esc_html__('Toggle Content Title', 'peak'),
            'desc' => esc_html__('The title of the toggle.', 'peak'),
            'std' => 'Title'
        ),
        'content' => array(
            'std' => 'Content',
            'type' => 'textarea',
            'label' => esc_html__('Toggle Content', 'peak'),
            'desc' => esc_html__('Add the toggle content. Will accept HTML', 'peak'),
        )
    ),
    'shortcode' => '[toggle class="{{class}}" title="{{title}}"]{{content}}[/toggle]',
    'popup_title' => esc_html__('Insert Toggle Shortcode', 'peak')
);
/* stats shortcode */
$livemesh_shortcodes['stats'] = array(
    'params' => array(),
    'shortcode' => '[stats]{{child_shortcode}}[/stats]',
    'popup_title' => esc_html__('Insert Stats Shortcode', 'peak'),
    'no_preview' => true,

    // child shortcode is clonable & sortable
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Campaigns Completed',
                'type' => 'text',
                'label' => esc_html__('Stats Title', 'peak'),
                'desc' => esc_html__('The title indicating the stats bar title', 'peak'),
            ),
            'value' => array(
                'std' => '45',
                'type' => 'text',
                'label' => esc_html__('Percentage Value', 'peak'),
                'desc' => esc_html__('The percentage value for the percentage stats to be displayed', ''),
            )
        ),
        'shortcode' => '[stats_bar title="{{title}}" value="{{value}}"][/stats_bar] ',
        'clone_button' => esc_html__('Add Stats', 'peak')
    )
);

$livemesh_shortcodes['animate_numbers'] = array(
    'params' => array(),
    'shortcode' => '[animate-numbers]{{child_shortcode}}[/animate-numbers]',
    'popup_title' => esc_html__('Insert Animate Numbers Shortcode', 'peak'),
    'no_preview' => true,

    // child shortcode is clonable & sortable
    'child_shortcode' => array(
        'params' => array(
            'title' => array(
                'std' => 'Volunteer Hours',
                'type' => 'text',
                'label' => esc_html__('Stats Title', 'peak'),
                'desc' => esc_html__('The title indicating the stats title.', 'peak'),
            ),
            'start_value' => array(
                'std' => '25',
                'type' => 'text',
                'label' => esc_html__('Start Value', 'peak'),
                'desc' => esc_html__('The starting value for the animation which displays a counter that animates to the end value specified as the content of the [animate-number] shortcode.', 'peak'),
            ),
            'end_value' => array(
                'std' => '23670',
                'type' => 'text',
                'label' => esc_html__('End Value', 'peak'),
                'desc' => esc_html__('The ending value for the animation which displays a counter that animates from the start value above to the end value specified here as the content of the [animate-number] shortcode.', 'peak'),
            ),
            'icon' => array(
                'std' => 'icon-lab4',
                'type' => 'text',
                'label' => esc_html__('Icon', 'peak'),
                'desc' => esc_html__('The font icon to be displayed for the statistic being displayed. The class names are listed at http://portfoliotheme.org/support/faqs/how-to-use-1500-icons-bundled-with-the-agile-theme/', 'peak'),
            )
        ),
        'shortcode' => '[animate-number icon="{{icon}}" title="{{title}}" start_value="{{start_value}}"]{{end_value}}[/animate-number] ',
        'clone_button' => esc_html__('Add Animated Number', 'peak')
    )
);
$livemesh_shortcodes['piechart'] = array(
    'no_preview' => true,
    'params' => array(
        'title' => array(
            'type' => 'text',
            'label' => esc_html__('Piechart Title', 'peak'),
            'desc' => esc_html__('The title of the Piechart.', 'peak'),
            'std' => 'Repeat Customers'
        ),
        'value' => array(
            'std' => '83',
            'type' => 'text',
            'label' => esc_html__('Percentage Value', 'peak'),
            'desc' => esc_html__('The percentage value for the percentage stats.', 'peak'),
        ),
        'color' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Color of the Bar', 'peak'),
            'desc' => esc_html__('Enter any custom color for the piechart bar that depicts the percentage.', 'peak')
        )
    ),
    'shortcode' => '[piechart title="{{title}}" percent="{{value}}" bar_color="{{color}}"][/piechart]',
    'popup_title' => esc_html__('Insert Piechart Shortcode', 'peak')
);

/*miscellenous shortcodes*/
$livemesh_shortcodes['message'] = array(
    'no_preview' => true,
    'params' => array(
        'message_type' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Message Type', 'peak'),
            'desc' => esc_html__('Message Type', 'peak'),
            'options' => array(
                'success' => esc_html__('Success', 'peak'),
                'info' => esc_html__('Info', 'peak'),
                'warning' => esc_html__('Warning', 'peak'),
                'tip' => esc_html__('Tip', 'peak'),
                'note' => esc_html__('Note', 'peak'),
                'errors' => esc_html__('Error', 'peak'),
                'attention' => esc_html__('Attention', 'peak')
            )
        ),
        'title' => array(
            'type' => 'text',
            'label' => esc_html__('Title', 'peak'),
            'desc' => esc_html__('Title displayed above the text in bold.', 'peak'),
            'std' => ''
        ),
        'message_text' => array(
            'type' => 'text',
            'label' => esc_html__('Message Text', 'peak'),
            'desc' => esc_html__('The message text to be displayed.', 'peak'),
            'std' => ''
        )
    ),
    'shortcode' => '[{{message_type}} title="{{title}}"]{{message_text}}[/{{message_type}}]',
    'popup_title' => esc_html__('Insert Message Shortcode', 'peak')
);

$livemesh_shortcodes['divider'] = array(
    'no_preview' => true,
    'params' => array(
        'divider_type' => array(
            'std' => 'divider',
            'type' => 'select',
            'label' => esc_html__('Divider Type', 'peak'),
            'desc' => esc_html__('Type of Divider', 'peak'),
            'options' => array(
                'divider' => esc_html__('Divider', 'peak'),
                'divider_line' => esc_html__('Divider Line', 'peak'),
                'divider_space' => esc_html__('Divider Space', 'peak'),
                'divider_fancy' => esc_html__('Divider Fancy', 'peak'),
                'divider_top' => esc_html__('Divider with Top Link', 'peak'),
                'clear' => esc_html__('Clear', 'peak'),
            )
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the DIV element created (optional)', 'peak')
        )
    ),
    'shortcode' => '[{{divider_type}} style="{{style}}"]',
    'popup_title' => esc_html__('Insert Divider Shortcode', 'peak')
);


$livemesh_shortcodes['box_frame'] = array(
    'no_preview' => true,
    'params' => array(
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Title', 'peak'),
            'desc' => esc_html__('Title for the box.', 'peak')
        ),
        'align' => array(
            'type' => 'select',
            'label' => esc_html__('Alignment', 'peak'),
            'desc' => esc_html__('Choose Alignment', 'peak'),
            'std' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'peak'),
                'left' => esc_html__('Left', 'peak'),
                'center' => esc_html__('Center', 'peak'),
                'right' => esc_html__('Right', 'peak')
            )
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the div element created (optional)', 'peak')
        ),
        'class' => array(
            'type' => 'text',
            'label' => esc_html__('Class', 'peak'),
            'desc' => esc_html__(' Custom CSS class name to be set for the div element created (optional)', 'peak'),
            'std' => ''
        ),
        'width' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Width', 'peak'),
            'desc' => esc_html__('Custom width of the box. Do include px suffix or another appropriate suffix for width.', 'peak')
        ),
        'inner_style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Inner Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling for the inner box (optional)', 'peak')
        )
    ),
    'shortcode' => '[box_frame style="{{style}}" width="{{width}}" class="{{class}}" align="{{align}}" title="{{title}}" inner_style="{{inner_style}}"]REPLACE WITH CONTENT[/box_frame]',
    'popup_title' => esc_html__('Insert Box Frame Shortcode', 'peak')
);


$livemesh_shortcodes['clear'] = array(
    'no_preview' => true,
    'params' => array(),
    'shortcode' => '[clear]',
    'popup_title' => esc_html__('Insert Clear Shortcode', 'peak')
);

$livemesh_shortcodes['header_fancy'] = array(
    'no_preview' => true,
    'params' => array(
        'text' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Text', 'peak'),
            'desc' => esc_html__('The text to be displayed in the center of the header.', 'peak')
        ),
        'style' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Style', 'peak'),
            'desc' => esc_html__('Inline CSS styling applied for the DIV element created (optional);', 'peak')
        ),
        'class' => array(
            'type' => 'text',
            'label' => esc_html__('Class', 'peak'),
            'desc' => esc_html__(' Custom CSS class name to be set for the div element created (optional)', 'peak'),
            'std' => ''
        )
    ),
    'shortcode' => '[header_fancy class="{{class}}" style="{{style}}" text="{{text}}"]',
    'popup_title' => esc_html__('Insert Header Fancy Shortcode', 'peak')
);

/*Social Shortcodes*/

$livemesh_shortcodes['social_list'] = array(
    'no_preview' => true,
    'params' => array(
        'email' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Email', 'peak'),
            'desc' => esc_html__('The email address to be used.', 'peak')
        ),
        'align' => array(
            'type' => 'select',
            'label' => esc_html__('Alignment', 'peak'),
            'desc' => esc_html__('Choose Alignment', 'peak'),
            'std' => 'none',
            'options' => array(
                'none' => esc_html__('None', 'peak'),
                'left' => esc_html__('Left', 'peak'),
                'center' => esc_html__('Center', 'peak'),
                'right' => esc_html__('Right', 'peak')
            )
        ),
        'facebook_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Facebook URL', 'peak'),
            'desc' => esc_html__('The URL of the Facebook page.', 'peak')
        ),
        'twitter_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Twitter URL', 'peak'),
            'desc' => esc_html__('The URL of the Twitter page.', 'peak')
        ),
        'flickr_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Flickr URL', 'peak'),
            'desc' => esc_html__('The URL of the Flickr page.', 'peak')
        ),
        'youtube_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('YouTube URL', 'peak'),
            'desc' => esc_html__('The URL of the Youtube page.', 'peak')
        ),
        'youtube_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('YouTube URL', 'peak'),
            'desc' => esc_html__('The URL of the Youtube page.', 'peak')
        ),
        'linkedin_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Linkedin URL', 'peak'),
            'desc' => esc_html__('The URL of the Linkedin page.', 'peak')
        ),
        'googleplus_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Googleplus URL', 'peak'),
            'desc' => esc_html__('The URL of the Googleplus page.', 'peak')
        ),
        'vimeo_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Vimeo URL', 'peak'),
            'desc' => esc_html__('The URL of the Vimeo page.', 'peak')
        ),
        'instagram_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Instagram URL', 'peak'),
            'desc' => esc_html__('The URL of the Instagram page.', 'peak')
        ),
        'behance_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Behance URL', 'peak'),
            'desc' => esc_html__('The URL of the Behance page.', 'peak')
        ),
        'pinterest_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Pinterest URL', 'peak'),
            'desc' => esc_html__('The URL of the Pinterest page.', 'peak')
        ),
        'skype_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Skype URL', 'peak'),
            'desc' => esc_html__('The URL of the Skype page.', 'peak')
        ),
        'dribbble_url' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Dribbble URL', 'peak'),
            'desc' => esc_html__('The URL of the Dribbble page.', 'peak')
        ),
        'include_rss' => array(
            'std' => 'false',
            'type' => 'select',
            'label' => esc_html__('Include RSS', 'peak'),
            'desc' => esc_html__('A boolean value(true/false string) indicating that the link to the RSS feed be included. Default is false.', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        )
    ),
    'shortcode' => '[social_list googleplus_url="{{googleplus_url}}" facebook_url="{{facebook_url}}" twitter_url="{{twitter_url}}" youtube_url="{{youtube_url}}" linkedin_url="{{linkedin_url}}" vimeo_url="{{vimeo_url}}" instagram_url="{{instagram_url}}" behance_url="{{behance_url}}" pinterest_url="{{pinterest_url}}" skype_url="{{skype_url}}" dribbble_url="{{dribbble_url}}" include_rss="{{include_rss}}"]',
    'popup_title' => esc_html__('Insert Social List Shortcode', 'peak')
);


$livemesh_shortcodes['donate'] = array(
    'no_preview' => true,
    'params' => array(
        'title' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Title', 'peak'),
            'desc' => esc_html__('The title of the link that displays the Paypal donate button.', 'peak')
        ),
        'account' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Account', 'peak'),
            'desc' => esc_html__('The Paypal account for which the donate button is being created.', 'peak')
        ),
        'display_card_logos' => array(
            'std' => '',
            'type' => 'select',
            'label' => esc_html__('Display Card Logos', 'peak'),
            'desc' => esc_html__(' Specify if you need to display the logo images of the credit cards accepted for Paypal donations', 'peak'),
            'options' => array(
                'false' => esc_html__('false', 'peak'),
                'true' => esc_html__('true', 'peak')
            )
        ),
        'cause' => array(
            'std' => '',
            'type' => 'text',
            'label' => esc_html__('Cause', 'peak'),
            'desc' => esc_html__('The text indicating the purpose for which the donation is being collected.', 'peak')
        )
    ),
    'shortcode' => '[donate title="{{title}}" account="{{account}}" display_card_logos="{{display_card_logos}}" cause="{{cause}}"]',
    'popup_title' => esc_html__('Insert Donate Shortcode', 'peak')
);

$livemesh_shortcodes['subscribe_rss'] = array(
    'no_preview' => true,
    'params' => array(),
    'shortcode' => '[subscribe_rss]',
    'popup_title' => esc_html__('Insert Subscribe RSS Shortcode', 'peak')
);












