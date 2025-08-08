<div class="z-template-page-builder-settings-wrapper zielke">
<h1>Template Page Builder Settings</h1>

<form method="post" action="options.php">
<?php
// select settings group
settings_fields( 'z_sections_settings' );
do_settings_sections( 'z_sections_settings' );

// get current settings
$z_sections_css = esc_attr( get_option('z_sections_css'));
$z_sections_js = esc_attr( get_option('z_sections_js'));
?>
	
<div class="break clear"></div>

<div>
    <!-- checkbox for enabling plugin CSS -->
    <label for="z_sections_css">
        <input type="checkbox" id="z_sections_css" name="z_sections_css" value="1" <?php checked( $z_sections_css, '1' ); ?> />
        Disable Plugin CSS
    </label>
    <br>
    <!-- checkbox for enabling plugin JS -->
    <label for="z_sections_js">
        <input type="checkbox" id="z_sections_js" name="z_sections_js" value="1" <?php checked( $z_sections_js, '1' ); ?> />
        Disable Plugin JS
    </label>
</div>


	
<div class="break clear"></div>

<?php submit_button('Save','primary','z_sections_save_button'); ?>

</form>
</div>