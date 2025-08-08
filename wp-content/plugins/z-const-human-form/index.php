<?php
/*
Plugin Name: Constant Human Form
Plugin URI: http://zielke.design/
Description: Adds a human check slider to forms inside a .const-human-form class.
Version: 1.0.0
Author: Terry Zielke
Author URI: https://zielke.design
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: zielke
*/

// Abort if this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) { die; }

// Enqueue frontend scripts and styles.
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'z-const-human-form-css', plugin_dir_url( __FILE__ ) . 'css/styles.css', [], '1.0.0' );
    wp_enqueue_script( 'z-const-human-form-js', plugin_dir_url( __FILE__ ) . 'js/scripts.js', [ 'jquery' ], '1.0.0', true );
} );