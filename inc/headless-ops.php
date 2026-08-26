<?php
/**
 * Headless Operations CPTs, Taxonomies, and REST API Enhancements
 *
 * Support for headlesswp-ops-dashboard React app.
 *
 * @package emclientWP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once dirname( __FILE__ ) . '/headless-ops-seeder.php';

/**
 * Register Portfolio Item Custom Post Type & Taxonomies
 */
function emclient_register_headless_ops_cpt() {

    // 1. Project Type Taxonomy (Client, Internal, Plugin, etc.)
    $type_labels = array(
        'name'              => _x( 'Project Types', 'taxonomy general name', 'em-client' ),
        'singular_name'     => _x( 'Project Type', 'taxonomy singular name', 'em-client' ),
        'search_items'      => __( 'Search Project Types', 'em-client' ),
        'all_items'         => __( 'All Project Types', 'em-client' ),
        'parent_item'       => __( 'Parent Project Type', 'em-client' ),
        'parent_item_colon' => __( 'Parent Project Type:', 'em-client' ),
        'edit_item'         => __( 'Edit Project Type', 'em-client' ),
        'update_item'       => __( 'Update Project Type', 'em-client' ),
        'add_new_item'      => __( 'Add New Project Type', 'em-client' ),
        'new_item_name'     => __( 'New Project Type Name', 'em-client' ),
        'menu_name'         => __( 'Project Types', 'em-client' ),
    );

    register_taxonomy( 'project_type', array( 'project_item' ), array(
        'hierarchical'      => true,
        'labels'            => $type_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'project-type' ),
        'show_in_rest'      => true,
        'rest_base'         => 'project_type',
    ) );

    // 2. Project Stack Taxonomy (React, WordPress, PHP, TypeScript, etc.)
    $stack_labels = array(
        'name'              => _x( 'Project Stacks', 'taxonomy general name', 'em-client' ),
        'singular_name'     => _x( 'Project Stack', 'taxonomy singular name', 'em-client' ),
        'search_items'      => __( 'Search Project Stacks', 'em-client' ),
        'all_items'         => __( 'All Project Stacks', 'em-client' ),
        'edit_item'         => __( 'Edit Project Stack', 'em-client' ),
        'update_item'       => __( 'Update Project Stack', 'em-client' ),
        'add_new_item'      => __( 'Add New Project Stack', 'em-client' ),
        'new_item_name'     => __( 'New Project Stack Name', 'em-client' ),
        'menu_name'         => __( 'Project Stacks', 'em-client' ),
    );

    register_taxonomy( 'project_stack', array( 'project_item' ), array(
        'hierarchical'      => false,
        'labels'            => $stack_labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'project-stack' ),
        'show_in_rest'      => true,
        'rest_base'         => 'project_stack',
    ) );

    // 3. Project Item Custom Post Type
    $cpt_labels = array(
        'name'                  => _x( 'Portfolio Items', 'Post Type General Name', 'em-client' ),
        'singular_name'         => _x( 'Portfolio Item', 'Post Type Singular Name', 'em-client' ),
        'menu_name'             => __( 'Portfolio Items', 'em-client' ),
        'name_admin_bar'        => __( 'Portfolio Item', 'em-client' ),
        'archives'              => __( 'Portfolio Archives', 'em-client' ),
        'all_items'             => __( 'All Portfolio Items', 'em-client' ),
        'add_new_item'          => __( 'Add New Portfolio Item', 'em-client' ),
        'add_new'               => __( 'Add New', 'em-client' ),
        'new_item'              => __( 'New Portfolio Item', 'em-client' ),
        'edit_item'             => __( 'Edit Portfolio Item', 'em-client' ),
        'update_item'           => __( 'Update Portfolio Item', 'em-client' ),
        'view_item'             => __( 'View Portfolio Item', 'em-client' ),
        'search_items'          => __( 'Search Portfolio Item', 'em-client' ),
    );

    $cpt_args = array(
        'label'                 => __( 'Portfolio Item', 'em-client' ),
        'description'           => __( 'Portfolio items for Headless Dashboard & client showcase', 'em-client' ),
        'labels'                => $cpt_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'author', 'revisions' ),
        'taxonomies'            => array( 'project_type', 'project_stack' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rest_base'             => 'project_item',
    );

    register_post_type( 'project_item', $cpt_args );

}
add_action( 'init', 'emclient_register_headless_ops_cpt', 0 );

/**
 * Use the Classic Editor for portfolio items only.
 */
function emclient_use_classic_editor_for_project_items( $use_block_editor, $post ) {
    if ( $post instanceof WP_Post && 'project_item' === $post->post_type ) {
        return false;
    }

    return $use_block_editor;
}
add_filter( 'use_block_editor_for_post', 'emclient_use_classic_editor_for_project_items', 10, 2 );

/**
 * Add CORS headers to REST API requests to support local headless development
 */
function emclient_send_cors_headers() {
    add_filter( 'rest_pre_serve_request', function( $value ) {
        header( 'Access-Control-Allow-Origin: *' );
        header( 'Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE' );
        header( 'Access-Control-Allow-Credentials: true' );
        header( 'Access-Control-Expose-Headers: X-WP-Total, X-WP-TotalPages, Link' );
        return $value;
    } );
}
add_action( 'rest_api_init', 'emclient_send_cors_headers' );
