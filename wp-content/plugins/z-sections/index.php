<?php
/*
Plugin Name: Sections
Plugin URI: http://zielke.design/
Description: Adds a template option called Sections where the default page WYSIWYG editor is replcaced with a selection of templated sections that can be placed in whatever order you need.
Version: 1.0.0
Author: Terry Zielke
Author URI: https://zielke.design
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zielke
*/

// Abort if this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

// Add dashboard page inside the Settings dropdown
add_action( 'admin_menu', function() {
    add_submenu_page(
        'options-general.php',
        'Sections Settings',
        'Sections Settings',
        'edit_posts',
        'sections-settings',
        'display_z_sections_settings_admin_page'
    );
} );
function display_z_sections_settings_admin_page(){
    include('views/admin.php'); 
}


// Settings
add_action( 'admin_init', function() {
	register_setting( 'z_sections_settings', 'z_sections_css' );
	register_setting( 'z_sections_settings', 'z_sections_js' );
} );


// Enqueue frontend scripts and styles.
add_action( 'wp_enqueue_scripts', function() {
    // if z_sections_css is not set, enqueue the admin styles and scripts
    $z_sections_css = get_option( 'z_sections_css', '1' );
    $z_sections_js = get_option( 'z_sections_js', '1' );
    if ( $z_sections_css !== '1' ) {
        wp_enqueue_style( 'z-sections-css', plugin_dir_url( __FILE__ ) . 'css/styles.css', [], '1.0.0' );
    }
    if ( $z_sections_js !== '1' ) {
        wp_enqueue_script( 'z-sections-js', plugin_dir_url( __FILE__ ) . 'js/scripts.js', [ 'jquery' ], '1.0.0', true );
    }
} );

// Enqueue admin scripts and styles.
add_action( 'admin_enqueue_scripts', function() {
    // worpdpress media
    wp_enqueue_media();
    // wordpress tineymce
    wp_enqueue_editor();
    // css
    wp_enqueue_style( 'z-sections-admin-css', plugin_dir_url( __FILE__ ) . 'css/admin.css', [], '1.0.0' );
    // js
    wp_enqueue_script( 'z-sections-admin-js', plugin_dir_url( __FILE__ ) . 'js/admin.js', [ 'jquery' ], '1.0.0', true );
} );


// Add template
add_filter( 'theme_page_templates', function( $post_templates ) {
    $post_templates['z-sections-template'] = 'Sections';
    return $post_templates;
} );


// Add metabox to pages only if the template is set to Sections
add_action( 'add_meta_boxes', function() {
    global $post;
    if ( ! $post || $post->post_type !== 'page' ) {
        return;
    }
    // Check against the simple key 'z-sections-template'
    $template = get_page_template_slug( $post->ID );
    if ( $template === 'z-sections-template' ) { // Match the key used in theme_page_templates filter
        add_meta_box(
            'z_sections_metabox',
            'Page Editor',
            'z_sections_metabox_callback', // This is your callback function to render the postbox content
            'page',
            'normal',
            'high'
        );
    }
} );


// Remove the default editor for pages using the Sections template
add_action( 'edit_form_after_title', function( $post ) {
    $template = get_page_template_slug( $post->ID );
    if ( $template === 'z-sections-template' ) { // Match the key used in theme_page_templates filter
        remove_post_type_support( 'page', 'editor' );
    }
} );


// Implement the the_content filter to inject your sections.
add_filter( 'the_content', function( $content ) {
    global $post;

    // Only proceed if it's a page and our specific template is selected
    if ( is_page() && $post && get_page_template_slug( $post->ID ) === 'z-sections-template' ) {
        $z_sections_editor = get_post_meta( $post->ID, 'z_sections_editor', true );
        $z_sections_data = json_decode( $z_sections_editor, true );

        // If there are sections, generate their HTML and prepend/append to existing content.
        if ( ! empty( $z_sections_data ) && is_array( $z_sections_data ) ) {
            ob_start(); // Start output buffering
            // Include your frontend template file
            include plugin_dir_path( __FILE__ ) . 'templates/sections.php';

            $sections_html = ob_get_clean(); // Get the buffered output

            return $sections_html . $content;
        }
    }
    return $content;
}, 10 ); // Priority 10 is standard.


// If the Sections template is selected, remove the .et_pb_toggle_builder_wrapper element from the page editor
add_action( 'admin_head', function() {
    global $post;
    if ( ! $post || $post->post_type !== 'page' ) {
        return;
    }
    $template = get_page_template_slug( $post->ID );
    if ( $template === 'z-sections-template' ) { // Match the key used in theme_page_templates filter
        echo '<style>html body .et_pb_toggle_builder_wrapper { display: none !important; }</style>';
    }
} );


function z_sections_metabox_callback($post) {
    // Get the content of the post
    $content = $post->post_content;
    include(plugin_dir_path(__FILE__) . 'views/editor.php');
}


// Save the content from the metabox
add_action( 'save_post', function($post_id){
	// Check for varified nonce
	if ( ! isset( $_POST['z_sections_meta_nonce'] ) ||
		! wp_verify_nonce( $_POST['z_sections_meta_nonce'], 'z_sections_meta_nonce' ) ){
		return;
	}else{
		if ( isset( $_REQUEST['z_sections_editor'] ) ) {
			update_post_meta( $post_id, 'z_sections_editor', $_REQUEST['z_sections_editor']);
		}
	}
} );