<?php
    // Exit if accessed directly.
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // add faq post type
    add_action( 'init', 'constantdesign_register_faq_post_type' );
    function constantdesign_register_faq_post_type() {
        $labels = array(
            'name'               => _x( 'FAQs', 'post type general name', 'constantdesign' ),
            'singular_name'      => _x( 'FAQ', 'post type singular name', 'constantdesign' ),
            'menu_name'          => _x( 'FAQs', 'admin menu', 'constantdesign' ),
            'name_admin_bar'     => _x( 'FAQ', 'add new on admin bar', 'constantdesign' ),
            'add_new'            => _x( 'Add New', 'FAQ', 'constantdesign' ),
            'add_new_item'       => __( 'Add New FAQ', 'constantdesign' ),
            'new_item'           => __( 'New FAQ', 'constantdesign' ),
            'edit_item'          => __( 'Edit FAQ', 'constantdesign' ),
            'view_item'          => __( 'View FAQ', 'constantdesign' ),
            'all_items'          => __( 'All FAQs', 'constantdesign' ),
            'search_items'       => __( 'Search FAQs', 'constantdesign' ),
            'parent_item_colon'  => __( 'Parent FAQs:', 'constantdesign' ),
            'not_found'          => __( 'No FAQs found.', 'constantdesign' ),
            'not_found_in_trash' => __( 'No FAQs found in Trash.', 'constantdesign' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'faq' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-format-chat',
            'supports'           => array( 'title', 'editor' ),
            'show_in_rest'       => true,
            'rest_base'          => 'faqs',
        ); 
        register_post_type( 'faq', $args );
    }
?>