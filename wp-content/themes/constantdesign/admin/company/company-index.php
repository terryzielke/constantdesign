<?php

// Register settings and create the menu under the "Settings" menu in WordPress admin
add_action('admin_init', 'register_company_info_settings');
add_action('admin_menu', function() {
    add_options_page(
        'Company Information',
        'Company Info',
        'manage_options',
        'company-info',
        'company_info_form'
    );
});

// Register settings for company information
add_action('admin_init', 'register_company_info_settings');
function register_company_info_settings() {
    $fields = [
        'company_name', 'phone_number', 'email_address',
        'street_address', 'city', 'province', 'postal_code',
        'facebook', 'twitter', 'linkedin', 'instagram'
    ];
    foreach ($fields as $field) {
        register_setting('company_info_group', $field);
    }
}


function company_info_form() {
    // Show update message if settings were saved
    if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
        echo '<div id="message" class="updated notice is-dismissible"><p>Company information saved successfully.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Company Information</h1>
        <form method="post" action="options.php">
            <?php
                settings_fields('company_info_group');
                do_settings_sections('company-info');
            ?>
            <table class="form-table">
                <tr><th>Company Name</th><td><input type="text" name="company_name" value="<?php echo esc_attr(get_option('company_name')); ?>" class="regular-text"></td></tr>
                <tr><th>Phone Number</th><td><input type="text" name="phone_number" value="<?php echo esc_attr(get_option('phone_number')); ?>" class="regular-text"></td></tr>
                <tr><th>Email Address</th><td><input type="email" name="email_address" value="<?php echo esc_attr(get_option('email_address')); ?>" class="regular-text"></td></tr>
                <tr><th>Street Address</th><td><input type="text" name="street_address" value="<?php echo esc_attr(get_option('street_address')); ?>" class="regular-text"></td></tr>
                <tr><th>City</th><td><input type="text" name="city" value="<?php echo esc_attr(get_option('city')); ?>" class="regular-text"></td></tr>
                <tr><th>Province</th><td><input type="text" name="province" value="<?php echo esc_attr(get_option('province')); ?>" class="regular-text"></td></tr>
                <tr><th>Postal Code</th><td><input type="text" name="postal_code" value="<?php echo esc_attr(get_option('postal_code')); ?>" class="regular-text"></td></tr>
                <tr><th>Facebook</th><td><input type="url" name="facebook" value="<?php echo esc_attr(get_option('facebook')); ?>" class="regular-text"></td></tr>
                <tr><th>Twitter</th><td><input type="url" name="twitter" value="<?php echo esc_attr(get_option('twitter')); ?>" class="regular-text"></td></tr>
                <tr><th>LinkedIn</th><td><input type="url" name="linkedin" value="<?php echo esc_attr(get_option('linkedin')); ?>" class="regular-text"></td></tr>
                <tr><th>Instagram</th><td><input type="url" name="instagram" value="<?php echo esc_attr(get_option('instagram')); ?>" class="regular-text"></td></tr>
            </table>
            <?php submit_button('Save Company Info'); ?>
        </form>
    </div>
    <?php
}
