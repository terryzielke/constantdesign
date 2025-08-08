<?php
    // Exit if accessed directly.
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }

    // add project post type
    add_action( 'init', 'constantdesign_register_project_post_type' );
    function constantdesign_register_project_post_type() {
        $labels = array(
            'name'               => _x( 'Projects', 'post type general name', 'constantdesign' ),
            'singular_name'      => _x( 'Project', 'post type singular name', 'constantdesign' ),
            'menu_name'          => _x( 'Projects', 'admin menu', 'constantdesign' ),
            'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'constantdesign' ),
            'add_new'            => _x( 'Add New', 'project', 'constantdesign' ),
            'add_new_item'       => __( 'Add New Project', 'constantdesign' ),
            'new_item'           => __( 'New Project', 'constantdesign' ),
            'edit_item'          => __( 'Edit Project', 'constantdesign' ),
            'view_item'          => __( 'View Project', 'constantdesign' ),
            'all_items'          => __( 'All Projects', 'constantdesign' ),
            'search_items'       => __( 'Search Projects', 'constantdesign' ),
            'parent_item_colon'  => __( 'Parent Projects:', 'constantdesign' ),
            'not_found'          => __( 'No Projects found.', 'constantdesign' ),
            'not_found_in_trash' => __( 'No Projects found in Trash.', 'constantdesign' )
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'project' ),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-cover-image',
            'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
            'show_in_rest'       => true,
            'rest_base'          => 'projects',
        ); 
        register_post_type( 'project', $args );
    }


    // add custom meta boxes for project post type
    add_action( 'add_meta_boxes', 'constantdesign_add_project_meta_boxes' );
    function constantdesign_add_project_meta_boxes() {
        // project details
        add_meta_box(
            'project_details',
            __( 'Project Details', 'constantdesign' ),
            'constantdesign_project_details_callback',
            'project',
            'normal',
            'high'
        );
        // project gallery
        add_meta_box(
            'project_gallery',
            __( 'Project Gallery', 'constantdesign' ),
            'constantdesign_project_gallery_callback',
            'project',
            'normal',
            'high'
        );
        // project banner
        add_meta_box(
            'project_banner_image',
            __( 'Project Banner', 'constantdesign' ),
            'constantdesign_project_banner_callback',
            'project',
            'side',
            'high'
        );
    }

    // callback function for project details meta box including file from views folder
    function constantdesign_project_details_callback( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'constantdesign_project_details_nonce', 'constantdesign_project_details_nonce' );
        // Include the project details form
        include_once( get_template_directory() . '/admin/project/views/project-details.php' );
    }
    // callback function for project gallery meta box including file from views folder
    function constantdesign_project_gallery_callback( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'constantdesign_project_gallery_nonce', 'constantdesign_project_gallery_nonce' );
        // Include the project gallery form
        include_once( get_template_directory() . '/admin/project/views/project-gallery.php' );
    }
    // callback function for project banner meta box including file from views folder
    function constantdesign_project_banner_callback( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'constantdesign_project_banner_nonce', 'constantdesign_project_banner_nonce' );
        // Include the project banner form
        include_once( get_template_directory() . '/admin/project/views/project-banner.php' );
    }

    // Save project details and gallery
    add_action( 'save_post', 'constantdesign_save_project_details' );
    function constantdesign_save_project_details( $post_id ) {
        // Check if our nonce is set.
        if ( ! isset( $_POST['constantdesign_project_details_nonce'] ) || ! wp_verify_nonce( $_POST['constantdesign_project_details_nonce'], 'constantdesign_project_details_nonce' ) ) {
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
        // Save project details
        if ( isset( $_POST['project_client'] ) ) {
            update_post_meta( $post_id, 'project_client', sanitize_text_field( $_POST['project_client'] ) );
        }
        if ( isset( $_POST['project_date'] ) ) {
            update_post_meta( $post_id, 'project_date', sanitize_text_field( $_POST['project_date'] ) );
        }
        if ( isset( $_POST['project_url'] ) ) {
            update_post_meta( $post_id, 'project_url', esc_url_raw( $_POST['project_url'] ) );
        }
        if ( isset( $_POST['project_banner'] ) ) {
            update_post_meta( $post_id, 'project_banner', esc_url_raw( $_POST['project_banner'] ) );
        }

        // Save project gallery
        if ( isset( $_POST['project_gallery'] ) && is_array( $_POST['project_gallery'] ) ) {
            $gallery = array();
            foreach ( $_POST['project_gallery'] as $image_id ) {
                $image_id = intval( $image_id );
                if ( $image_id > 0 ) {
                    $gallery[] = $image_id;
                }
            }
            update_post_meta( $post_id, 'project_gallery', $gallery );
        } else {
            // If no gallery images are set, delete the meta
            delete_post_meta( $post_id, 'project_gallery' );
        }
    }

    // Add category support for project post type
    add_action( 'init', 'constantdesign_add_project_taxonomies' );
    function constantdesign_add_project_taxonomies() {
        register_taxonomy_for_object_type( 'category', 'project' );
    }

    // single project template
    add_filter( 'single_template', 'constantdesign_project_single_template' );
    function constantdesign_project_single_template( $single ) {
        global $post;
        if ( $post->post_type == 'project' ) {
            $single = get_template_directory() . '/admin/project/templates/single-project.php';
        }
        return $single;
    }
    
?>