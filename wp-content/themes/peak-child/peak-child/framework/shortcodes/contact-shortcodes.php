<?php

/* Contact Form Shortcode -

Usage: Pls refer to http://portfoliotheme.org/peak/contact-form-shortcode/

[contact_form mail_to="receipient@mydomain.com" phone=true web_url=true subject=true button_color="default"]

Parameters -

class - Custom CSS class name to be set for the div element created (optional)
mail_to - A string field specifying the recipient email where all form submissions will be received.
web_url - Can be true or false. A boolean indicating that the user should be requested for Web URL via an input field.
phone - Can be true or false. Request for phone number of the user. A phone number field is displayed.
subject - Can be true or false. A mail subject field is displayed if the value is set to true.
button_color - Color of the submit button. Available colors are black, blue, cyan, green, orange, pink, red, teal, theme and trans.

*/

if (!function_exists('mo_contact_form_shortcode')) {

    function mo_contact_form_shortcode($atts, $content = null, $code) {
        extract(shortcode_atts(array(
            'class' => '',
            'mail_to' => '',
            'web_url' => false,
            'phone' => true,
            'email' => true,
            'subject' => false,
            'button_color' => 'default',
            'button_text' => 'Send the message'
        ), $atts));

        if (empty($mail_to))
            $mail_to = get_bloginfo('admin_email');
        $mail_script_url = MO_THEME_URL . '/framework/scripts/sendmail.php';

        $output = '<div class="feedback"></div>';

        $output .= '<form class="contact-form ' . esc_attr($class) . '" action="' . $mail_script_url . '" method="post">';

        $output .= '<fieldset>';

        $output .= '<p><label>' . esc_html__('Name *', 'peak') . '</label><input type="text" name="contact_name" placeholder="' . esc_html__("Name:", 'peak') . '" class="text-input" required></p>';

        if (mo_to_boolean($email))
            $output .= '<p><label>' . esc_html__('Email *', 'peak') . '</label><input type="email" name="contact_email" placeholder="' . esc_html__("Email:", 'peak') . '" class="text-input" required></p>';

        if (mo_to_boolean($phone))
            $output .= '<p><label>' . esc_html__('Phone Number', 'peak') . '</label><input type="tel" name="contact_phone" placeholder="' . esc_html__("Phone:", 'peak') . '"  class="text-input"></p>';

        if (mo_to_boolean($web_url))
            $output .= '<p><label>' . esc_html__('Web URL', 'peak') . '</label><input type="url" name="contact_url" placeholder="' . esc_html__("URL:", 'peak') . '" class="text-input"></p>';

        if (mo_to_boolean($subject))
            $output .= '<p class="subject"><label>' . esc_html__('Subject', 'peak') . '</label><input type="text" name="subject" placeholder="' . esc_html__("Subject:", 'peak') . '" class="text-input"></p>';

        $output .= '<p class="text-area"><label>' . esc_html__('Message *', 'peak') . '</label><textarea name="message" placeholder="' . esc_html__("Message:", 'peak') . '"  rows="7" cols="40"></textarea></p>';

        $output .= '<div class="clear"></div>';

        $output .= '<p class="trap-field"><label>' . esc_html__('Leave Empty', 'peak') . '</label><input type="text" name="website" placeholder="' . esc_html__("Leave Blank:", 'peak') . '" class="text-input"></p>';

        $output .= '<button type="submit" class="button large ' . esc_attr($button_color) . '">' . esc_html($button_text) . '</button>';

        if (empty($mail_to)) {
            $mail_to = sanitize_email(mo_get_theme_option('mo_contact_form_email'));
        }

        update_option('mo_cf_email_recipient' , $mail_to);

        $output .= '</fieldset>';

        $output .= '</form>';

        return $output;
    }
}

add_shortcode('contact_form', 'mo_contact_form_shortcode');