<?php

// SETUP
add_action('after_setup_theme', function(){
	add_theme_support('title-tag');
	add_theme_support('post-thumbnails');
	add_theme_support('html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	]);
	
	register_nav_menus(['header' => 'Header']);
	register_nav_menus(['footer' => 'Footer']);
});


// INCLUDED PLUGINS
require_once('admin/company/company-index.php');
require_once('admin/service/service-index.php');
require_once('admin/project/project-index.php');
require_once('admin/faq/faq-index.php');


// ENQUEUE STYLES & SCRIPTS
add_action('wp_enqueue_scripts', function(){
	wp_dequeue_style('wp-block-library');
	// CSS
	$theme_css = get_template_directory() . '/css/theme.min.css';
	$theme_css_uri = get_template_directory_uri() . '/css/theme.min.css';
	wp_enqueue_style('theme', $theme_css_uri, array(), file_exists($theme_css) ? filemtime($theme_css) : false);
	// JS
	wp_enqueue_script('jquery');
	wp_enqueue_script('scripts', get_template_directory_uri().'/js/scripts.js', ['jquery'], '', true);
	wp_enqueue_script('navigation', get_template_directory_uri().'/js/navigation.js', ['jquery'], '', true);
	// INC
	wp_enqueue_script('visible', get_template_directory_uri().'/inc/visible/jquery.visible.min.js', ['jquery'], '', true);
	wp_enqueue_style( 'slick-css', get_template_directory_uri() . '/inc/slick/slick.css');
	wp_enqueue_script( 'slick-js', get_template_directory_uri() . '/inc/slick/slick.min.js', array(), '', true );
	wp_enqueue_script( 'fake-3d', get_template_directory_uri() . '/inc/fake3d/js/app.js', array(), '', true );
});


// ADMIN STYLES & SCRIPTS
add_action('admin_enqueue_scripts', function(){
    // worpdpress media
    wp_enqueue_media();
	// css
	wp_enqueue_style( 'admin_styles', get_template_directory_uri() . '/css/admin.css' );
});


// CUSTOM LOGIN PAGE
add_action( 'login_enqueue_scripts', function(){
	wp_enqueue_style( 'login_page_styles', get_template_directory_uri() . '/css/login.css' );
});


// PAGE TEMPLATES
add_filter('theme_page_templates', function($templates) {
    $templates['php/templates/pages/contact-template.php'] = 'Contact';
    $templates['php/templates/pages/services-template.php'] = 'Services';
    $templates['php/templates/pages/projects-template.php'] = 'Projects';
    $templates['php/templates/pages/faq-template.php'] = 'FAQ';
    $templates['php/templates/pages/support-template.php'] = 'Support';
    $templates['php/templates/pages/payments-template.php'] = 'Payments';
    return $templates;
});
add_filter('template_include', function($template) {
    if (is_page()) {
        $page_template = get_page_template_slug();
        if ($page_template && locate_template($page_template)) {
            return locate_template($page_template);
        }
    }
    return $template;
});


// REMOVE ADMIN BAR
show_admin_bar( false );


// REDIRECT FROM LOGOUT SCREEN TO HOME
add_action('wp_logout',function(){
	wp_safe_redirect( home_url() );
	exit;
});


// ALLOW SVGS
add_filter('upload_mimes', function($mimes){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
});


// INCREASE MAX IMAGE SIZE
update_option('large_size_w', 9999);
update_option('large_size_h', 9999);
add_filter( 'big_image_size_threshold', '__return_false' );


// FORCE CLASSIC EDITOR
function force_classic_editor() {
    add_filter('use_block_editor_for_post', '__return_false', 10);
    remove_action('admin_enqueue_scripts', 'wp_enqueue_editor_block_directory_assets');
}
add_action('after_setup_theme', 'force_classic_editor');


// CUSTOMIZE FRONTEND TINYMCE EDITOR
add_filter('mce_css', function($mce_css) {

	$custom_css = get_template_directory_uri() . '/css/editor-style.css';
	if ($mce_css) {
		$mce_css .= ',' . $custom_css;
	} else {
		$mce_css = $custom_css;
	}
	// if not admin page check
	if (!is_admin()) {
		return $mce_css;
	}
});


// remmove everything from admin dashboard except dashboard, pages, media, plugins, users, tools, settings
add_action('admin_menu', function() {
	remove_menu_page('edit.php'); // Posts
	remove_menu_page('edit-comments.php'); // Comments
	//remove_menu_page('themes.php'); // Appearance
	//remove_menu_page('tools.php'); // Tools
	//remove_menu_page('options-general.php'); // Settings
	//remove_menu_page('upload.php'); // Media
	//remove_menu_page('edit.php?post_type=page'); // Pages
});

// remove everything from admin bar except site, new, logout
add_action('wp_before_admin_bar_render', function() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('themes');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('wp-logo');
	//$wp_admin_bar->remove_menu('site-name');
	//$wp_admin_bar->remove_menu('my-account');
	$wp_admin_bar->remove_menu('search');
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('support-forums');
	$wp_admin_bar->remove_menu('feedback');
	$wp_admin_bar->remove_menu('view-site');
	//$wp_admin_bar->remove_menu('edit');
	$wp_admin_bar->remove_menu('site-health');
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('comments');
	//$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('widgets');
	$wp_admin_bar->remove_menu('menus');
	$wp_admin_bar->remove_menu('customize-support');
	$wp_admin_bar->remove_menu('customize-widgets');
	$wp_admin_bar->remove_menu('customize-menus');
	$wp_admin_bar->remove_menu('customize-header');
	$wp_admin_bar->remove_menu('customize-background');
	$wp_admin_bar->remove_menu('customize-site-identity');
	$wp_admin_bar->remove_menu('customize-homepage-settings');
	$wp_admin_bar->remove_menu('customize-plugins');
	$wp_admin_bar->remove_menu('customize-themes');
	$wp_admin_bar->remove_menu('customize-appearance');
	$wp_admin_bar->remove_menu('customize-plugins');
});