<?php
$wp_include = "../wp-load.php";
$i = 0;
while (!file_exists($wp_include) && $i++ < 10) {
    $wp_include = "../$wp_include";
}
//TODO - Get rid of these for speed. Use GET request to pass data to this file
require_once($wp_include);

function cs_validate_email($email) {
    /*
       (Name) Letters, Numbers, Dots, Hyphens and Underscores
       (@ sign)
       (Domain) (with possible subdomain(s) ).
       Contains only letters, numbers, dots and hyphens (up to 255 characters)
       (. sign)
       (Extension) Letters only (up to 10 (can be increased in the future) characters)
       */

    $regex = '/([a-z0-9_.-]+)' . # name

        '@' . # at

        '([a-z0-9.-]+){2,255}' . # domain & possibly subdomains

        '.' . # period

        '([a-z]+){2,10}/i'; # domain extension

    if ($email == '') {
        return false;
    }
    else {
        $eregi = preg_replace($regex, '', $email);
    }

    return empty($eregi) ? true : false;
}


$post = (!empty($_POST)) ? true : false;

if ($post) {

    //Check for bots which fill out website fields hidden to humans

    $website = trim($_POST['website']);

    if (!empty($website)) {
        echo esc_html__('It appears you are a bot and hence exiting!', 'peak');

        return;
    }

    $name = esc_html(stripslashes($_POST['contact_name']));
    $contact_url = esc_url(trim($_POST['contact_url']));
    $subject = $name;
    if (empty($contact_url))
        $subject .= esc_html__(' tried to reach you', 'peak');
    else
        $subject .= esc_html__(' tried to reach you from ', 'peak') . esc_url($contact_url);
    $email = sanitize_email(trim($_POST['contact_email']));

    $to = esc_html(trim(get_option('mo_cf_email_recipient')));

    $message = '';


    if (!empty($name))
        $message .= "\n" . esc_html__('Name: ', 'peak') . esc_html($name);
    $phone_number = esc_html(trim($_POST['contact_phone']));
    if (!empty($phone_number))
        $message .= "\n\n" . esc_html__('Contact Number: ', 'peak') . esc_html($phone_number);
    if (!empty ($email))
        $message .= "\n\n" . esc_html__('Contact Email: ', 'peak') . esc_html($email);
    if (!empty($contact_url))
        $message .= "\n\n" . esc_html__('URL: ', 'peak') . esc_url($contact_url);
    $contact_reason = trim($_POST['subject']);
    if (!empty($contact_reason))
        $message .= "\n\n" . esc_html__('Subject: ', 'peak') . esc_html($contact_reason);

    $message .= "\n\n" . esc_html__('Contact Message: ', 'peak') . stripslashes($_POST['message']);

    $error = '';

    // Check name

    if (!$name) {
        $error .= esc_html__('Please enter your name.', 'peak') . '<br />';
    }

    // Check email

    if (!$email) {
        $error .= esc_html__('Please enter an e-mail address.', 'peak') . '<br />';
    }

    if ($email && !is_email($email)) {
        $error .= esc_html__('Please enter a valid e-mail address.', 'peak') . '<br />';
    }

    // Check message (length)

    if (!$message || strlen($message) < 15) {
        $error .= esc_html__('Please enter your message. It should have at least 15 characters.<br />', 'peak');
    }

    if (!$error) // send email
    {
        $headers = 'From: ' . esc_html($name) . ' <' . esc_html($email) . '>' . "\n" . 'Reply-To: ' . esc_html($name) . ' <' . esc_html($email) . '>';
        $mail_sent = wp_mail($to, esc_html__('Hello', 'peak'), $message, $headers);

    }
}

?>