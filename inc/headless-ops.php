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
 * Register Case Study Custom Post Type & Taxonomies.
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
        'name'                  => _x( 'Case Studies', 'Post Type General Name', 'em-client' ),
        'singular_name'         => _x( 'Case Study', 'Post Type Singular Name', 'em-client' ),
        'menu_name'             => __( 'Case Studies', 'em-client' ),
        'name_admin_bar'        => __( 'Case Study', 'em-client' ),
        'archives'              => __( 'Case Study Archives', 'em-client' ),
        'all_items'             => __( 'All Case Studies', 'em-client' ),
        'add_new_item'          => __( 'Add New Case Study', 'em-client' ),
        'add_new'               => __( 'Add New', 'em-client' ),
        'new_item'              => __( 'New Case Study', 'em-client' ),
        'edit_item'             => __( 'Edit Case Study', 'em-client' ),
        'update_item'           => __( 'Update Case Study', 'em-client' ),
        'view_item'             => __( 'View Case Study', 'em-client' ),
        'search_items'          => __( 'Search Case Studies', 'em-client' ),
    );

    $cpt_args = array(
        'label'                 => __( 'Case Study', 'em-client' ),
        'description'           => __( 'Structured case studies for the HeadlessWP Operations Dashboard', 'em-client' ),
        'labels'                => $cpt_labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
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
 * Register case study metadata for REST responses and the native admin form.
 */
function emclient_register_case_study_meta() {
    $meta_fields = array(
        'emclient_client_name'     => 'sanitize_text_field',
        'emclient_role'            => 'sanitize_text_field',
        'emclient_project_url'     => 'esc_url_raw',
        'emclient_repository_url'  => 'esc_url_raw',
        'emclient_challenge'       => 'sanitize_textarea_field',
        'emclient_solution'        => 'sanitize_textarea_field',
        'emclient_outcome'         => 'sanitize_textarea_field',
    );

    foreach ( $meta_fields as $meta_key => $sanitize_callback ) {
        register_post_meta(
            'project_item',
            $meta_key,
            array(
                'type'         => 'string',
                'single'       => true,
                'show_in_rest' => true,
                'sanitize_callback' => $sanitize_callback,
            )
        );
    }

    register_post_meta(
        'project_item',
        'emclient_completion_year',
        array(
            'type'         => 'integer',
            'single'       => true,
            'show_in_rest' => true,
            'sanitize_callback' => 'absint',
        )
    );
}
add_action( 'init', 'emclient_register_case_study_meta', 10 );

/**
 * Add the case study details metabox to the Classic Editor screen.
 */
function emclient_add_case_study_details_metabox() {
    add_meta_box(
        'emclient_case_study_details',
        __( 'Case Study Details', 'em-client' ),
        'emclient_render_case_study_details_metabox',
        'project_item',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes_project_item', 'emclient_add_case_study_details_metabox' );

/**
 * Render fields used by the React dashboard and case study audit.
 */
function emclient_render_case_study_details_metabox( $post ) {
    wp_nonce_field( 'emclient_save_case_study_details', 'emclient_case_study_nonce' );

    $fields = array(
        'emclient_client_name'       => __( 'Client / Organization', 'em-client' ),
        'emclient_role'              => __( 'Role', 'em-client' ),
        'emclient_project_url'       => __( 'Project URL', 'em-client' ),
        'emclient_repository_url'    => __( 'Repository URL', 'em-client' ),
        'emclient_completion_year'   => __( 'Completion Year', 'em-client' ),
        'emclient_challenge'         => __( 'Challenge', 'em-client' ),
        'emclient_solution'          => __( 'Solution', 'em-client' ),
        'emclient_outcome'           => __( 'Outcome', 'em-client' ),
    );

    foreach ( $fields as $meta_key => $label ) {
        $value = get_post_meta( $post->ID, $meta_key, true );
        $is_textarea = in_array( $meta_key, array( 'emclient_challenge', 'emclient_solution', 'emclient_outcome' ), true );
        $type = 'text';

        if ( 'emclient_completion_year' === $meta_key ) {
            $type = 'number';
        } elseif ( false !== strpos( $meta_key, '_url' ) ) {
            $type = 'url';
        }
        ?>
        <p>
            <label for="<?php echo esc_attr( $meta_key ); ?>"><strong><?php echo esc_html( $label ); ?></strong></label><br />
            <?php if ( $is_textarea ) : ?>
                <textarea class="widefat" rows="3" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
            <?php else : ?>
                <input class="widefat" type="<?php echo esc_attr( $type ); ?>" id="<?php echo esc_attr( $meta_key ); ?>" name="<?php echo esc_attr( $meta_key ); ?>" value="<?php echo esc_attr( $value ); ?>" />
            <?php endif; ?>
        </p>
        <?php
    }
}

/**
 * Save case study details from the Classic Editor metabox.
 */
function emclient_save_case_study_details( $post_id ) {
    if ( ! isset( $_POST['emclient_case_study_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['emclient_case_study_nonce'] ) ), 'emclient_save_case_study_details' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    $text_fields = array(
        'emclient_client_name'    => 'sanitize_text_field',
        'emclient_role'           => 'sanitize_text_field',
        'emclient_project_url'    => 'esc_url_raw',
        'emclient_repository_url' => 'esc_url_raw',
        'emclient_challenge'      => 'sanitize_textarea_field',
        'emclient_solution'       => 'sanitize_textarea_field',
        'emclient_outcome'        => 'sanitize_textarea_field',
    );

    foreach ( $text_fields as $meta_key => $sanitize_callback ) {
        $value = isset( $_POST[ $meta_key ] ) ? call_user_func( $sanitize_callback, wp_unslash( $_POST[ $meta_key ] ) ) : '';
        update_post_meta( $post_id, $meta_key, $value );
    }

    $year = isset( $_POST['emclient_completion_year'] ) ? absint( $_POST['emclient_completion_year'] ) : 0;
    update_post_meta( $post_id, 'emclient_completion_year', $year );
}
add_action( 'save_post_project_item', 'emclient_save_case_study_details' );

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
