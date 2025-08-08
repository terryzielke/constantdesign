<?php
    // Exit if accessed directly.
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // add service post type
    add_action( 'init', 'constantdesign_register_service_post_type' );
    function constantdesign_register_service_post_type() {
        $labels = array(
            'name'               => _x( 'Services', 'post type general name', 'constantdesign' ),
            'singular_name'      => _x( 'Service', 'post type singular name', 'constantdesign' ),
            'menu_name'          => _x( 'Services', 'admin menu', 'constantdesign' ),
            'name_admin_bar'     => _x( 'Service', 'add new on admin bar', 'constantdesign' ),
            'add_new'            => _x( 'Add New', 'service', 'constantdesign' ),
            'add_new_item'       => __( 'Add New Service', 'constantdesign' ),
            'new_item'           => __( 'New Service', 'constantdesign' ),
            'edit_item'          => __( 'Edit Service', 'constantdesign' ),
            'view_item'          => __( 'View Service', 'constantdesign' ),
            'all_items'          => __( 'All Services', 'constantdesign' ),
            'search_items'       => __( 'Search Services', 'constantdesign' ),
            'parent_item_colon'  => __( 'Parent Services:', 'constantdesign' ),
            'not_found'          => __( 'No services found.', 'constantdesign' ),
            'not_found_in_trash' => __( 'No services found in Trash.', 'constantdesign' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'service' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-admin-tools',
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
            'show_in_rest'       => true, // Enable Gutenberg editor
            'rest_base'          => 'services', // REST API base
        ); 
        register_post_type( 'service', $args );
    }


    // add custom meta boxes for service post type
    add_action( 'add_meta_boxes', 'constantdesign_add_service_meta_boxes' );
    function constantdesign_add_service_meta_boxes() {
        // service includes
        add_meta_box(
            'service_includes',
            __( 'Services Included', 'constantdesign' ),
            'constantdesign_service_includes_callback',
            'service',
            'normal',
            'high'
        );
        // service tagline
        add_meta_box(
            'service_tagline',
            __( 'Service Tagline', 'constantdesign' ),
            'constantdesign_service_tagline_callback',
            'service',
            'normal',
            'high'
        );
        // svg icon code
        add_meta_box(
            'service_icon_svg',
            __( 'Service Icon', 'constantdesign' ),
            'constantdesign_service_icon_callback',
            'service',
            'side'
        );
    }


    // callback function for service includes meta box including file from views folder
    function constantdesign_service_includes_callback( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'constantdesign_service_nonce', 'constantdesign_service_nonce' );
        // Include the service includes form
        include_once( get_template_directory() . '/admin/service/views/service-includes.php' );
    }
    // callback function for service tagline meta box including file from views folder
    function constantdesign_service_tagline_callback( $post ) {
        // Include the service tagline form
        include_once( get_template_directory() . '/admin/service/views/service-tagline.php' );
    }
    // callback function for service icon meta box including file from views folder
    function constantdesign_service_icon_callback( $post ) {
        // Include the service icon form
        include_once( get_template_directory() . '/admin/service/views/service-icon.php' );
    }


    // Save service includes and tagline
    add_action( 'save_post', 'constantdesign_save_service_includes' );
    function constantdesign_save_service_includes( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['constantdesign_service_nonce'] ) || ! wp_verify_nonce( $_POST['constantdesign_service_nonce'], 'constantdesign_service_nonce' ) ) {
            return;
        }
        // Check if this is an autosave.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }
        // Check the user's permissions.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        // Service includes
        if ( isset( $_POST['service_tagline'] ) ) {
            update_post_meta( $post_id, 'service_tagline', sanitize_text_field( $_POST['service_tagline'] ) );
        }
        // Service icon
        if ( isset( $_POST['service_icon'] ) ) {
            // do not sanitize because it is SVG code
            update_post_meta( $post_id, 'service_icon',  $_POST['service_icon'] );
        }
        // save service inc repeatable field groups
        if ( isset( $_POST['service_include'] ) && is_array( $_POST['service_include'] ) ) {
            $include = array();
            foreach ( $_POST['service_include'] as $social ) {
                if ( isset( $social['desc'] ) ) {
                    $include[] = array(
                        'desc' => sanitize_text_field( $social['desc'] )
                    );
                }
            }
            update_post_meta( $post_id, 'service_include', $include );
        } else {
            // If no inc are set, delete the meta
            delete_post_meta( $post_id, 'service_include' );
        }
    }

    // single service template
    add_filter( 'single_template', 'constantdesign_service_single_template' );
    function constantdesign_service_single_template( $single ) {
        global $post;
        if ( $post->post_type == 'service' ) {
            $single = get_template_directory() . '/admin/service/templates/single-service.php';
        }
        return $single;
    }

?>