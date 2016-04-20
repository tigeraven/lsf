<?php
/**
 * Plugin Name: Livemesh Framework Contact Info Widget
 * Plugin URI: http://portfoliotheme.org/
 * Description: A widget that displays the contact information.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */


class MO_Contact_Info_Widget extends MO_Widget {

    /**
     * Widget setup.
     */
    function MO_Contact_Info_Widget() {

        parent::init();

        /* Widget settings. */
        $widget_ops = array('classname' => 'contact-info-widget', 'description' => esc_html__('A widget that displays the contact information.', 'peak'));

        /* Widget control settings. */
        $control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'mo-contact-info-widget');

        /* Create the widget. */
        $this->WP_Widget('mo-contact-info-widget', esc_html__('Contact Info Widget', 'peak'), $widget_ops, $control_ops);
    }

    /**
     * How to display the widget on the screen.
     */
    function widget($args, $instance) {
        extract($args);

        /* Our variables from the widget settings. */
        $title = esc_html(apply_filters('widget_title', $instance['title']));

        $street1 = esc_html($instance['street1']);
        $street2 = esc_html($instance['street2']);
        $city = esc_html($instance['city']);
        $state = esc_html($instance['state']);
        $zip_code = esc_html($instance['zip_code']);
        $phone1 = esc_html($instance['phone1']);
        $phone2 = esc_html($instance['phone2']);
        $email = sanitize_email($instance['email']);


        /* Before widget (defined by themes). */
        echo wp_kses_post($before_widget);

        /* Display the widget title if one was input (before and after defined by themes). */
        if (trim($title) != '')
            echo wp_kses_post($before_title . $title . $after_title);

        echo '<div class="contact-info">';

        if (!empty($street1))
            echo '<p><span class="street1">'. $street1 . '</span>';
        if (!empty($street2))
            echo '<span class="street2">'. $street2 . '</span>';

        if (!empty($city) || !empty($state) || !empty($zip_code)) {
            echo '<span class="city-info">';

            if (!empty($city))
                echo esc_html($city);
            // assume city exists and proceed with next two steps
            if (!empty($state))
                echo ', ' . esc_html($state);
            if (!empty($zip_code))
                echo ', ' . esc_html($zip_code);

            echo '</span></p>';
        }

        if (!empty($email))
            echo '<p><span class="email"><a href="mailto:'. $email . '">'. $email . '</a></span></p>';

        if (!empty($phone1) || !empty($phone2))
            echo '<p><span class="phone">'. $phone1 . '<br>' . $phone2 . '</span></p>';

        echo '</div>';

        /* After widget (defined by themes). */
        echo wp_kses_post($after_widget);
    }

    /**
     * Update the widget settings.
     */
    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        /* Strip tags to remove HTML (important for text inputs). */
        $instance['title'] = sanitize_text_field($new_instance['title']);
        $instance['street1'] = sanitize_text_field($new_instance['street1']);
        $instance['street2'] = sanitize_text_field($new_instance['street2']);
        $instance['city'] = sanitize_text_field($new_instance['city']);
        $instance['state'] = sanitize_text_field($new_instance['state']);
        $instance['zip_code'] = sanitize_text_field($new_instance['zip_code']);
        $instance['phone1'] = sanitize_text_field($new_instance['phone1']);
        $instance['phone2'] = sanitize_text_field($new_instance['phone2']);
        $instance['email'] = sanitize_text_field($new_instance['email']);

        return $instance;
    }

    /**
     * Displays the widget settings controls on the widget panel.
     * Make use of the get_field_id() and get_field_name() function
     * when creating your form elements. This handles the confusing stuff.
     */
    function form($instance) {

        /* Set up some default widget settings. */
        $defaults = array('title' => esc_html__('Contact Info', 'peak'), 'title' => '', 'street1' => '', 'street2' => '', 'city' => '', 'state' => '', 'zip_code' => '', 'phone1' => '', 'phone2' => '', 'email' => '');
        $instance = wp_parse_args((array)$instance, $defaults); ?>

    <!-- Widget Title: Text Input -->
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr(esc_attr($instance['title'])); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('street1')); ?>"><?php esc_html_e('Street 1:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('street1')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('street1')); ?>" value="<?php echo esc_attr(esc_attr($instance['street1'])); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('street2')); ?>"><?php esc_html_e('Street 2:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('street2')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('street2')); ?>" value="<?php echo esc_attr($instance['street2']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('city')); ?>"><?php esc_html_e('City:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('city')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('city')); ?>" value="<?php echo esc_attr(esc_attr($instance['city'])); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('state')); ?>"><?php esc_html_e('State:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('state')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('state')); ?>" value="<?php echo esc_attr(esc_attr($instance['state'])); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('zip_code')); ?>"><?php esc_html_e('Zip Code:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('zip_code')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('zip_code')); ?>" value="<?php echo esc_attr($instance['zip_code']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone1')); ?>"><?php esc_html_e('Phone 1:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('phone1')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('phone1')); ?>" value="<?php echo esc_attr($instance['phone1']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('phone2')); ?>"><?php esc_html_e('Phone 2:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('phone2')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('phone2')); ?>" value="<?php echo esc_attr($instance['phone2']); ?>"/>
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_id('email')); ?>"><?php esc_html_e('Email:', 'peak'); ?></label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('email')); ?>"
                   name="<?php echo esc_attr($this->get_field_name('email')); ?>" value="<?php echo esc_attr($instance['email']); ?>"/>
        </p>



    <?php
    }
}

?>