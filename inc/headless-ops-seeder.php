<?php
/**
 * Headless Ops Seed Data Generator
 *
 * Provides a WP Admin tool to auto-generate realistic sample case studies,
 * blog posts, and taxonomy terms to populate the Headless Operations Dashboard.
 *
 * @package emclientWP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Seed Generator Admin Menu under Case Studies
 */
function emclient_seed_generator_menu() {
    add_submenu_page(
        'edit.php?post_type=project_item',
        __( 'Seed Data Generator', 'em-client' ),
        __( 'Seed Generator', 'em-client' ),
        'manage_options',
        'headless-ops-seeder',
        'emclient_render_seed_generator_page'
    );
}
add_action( 'admin_menu', 'emclient_seed_generator_menu' );

/**
 * Render Seed Generator Admin Page
 */
function emclient_render_seed_generator_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        wp_die( esc_html__( 'Unauthorized user', 'em-client' ) );
    }

    $message = '';
    $message_type = 'updated';

    // Handle form submissions
    if ( isset( $_POST['emclient_seeder_action'] ) && check_admin_referer( 'emclient_seed_action_nonce', 'emclient_seed_nonce' ) ) {
        $action = sanitize_text_field( $_POST['emclient_seeder_action'] );

        if ( 'generate' === $action ) {
            $counts = emclient_generate_seed_data();
            $message = sprintf(
                __( 'Successfully generated %d Case Studies, %d Blog Posts, and taxonomy terms!', 'em-client' ),
                $counts['portfolio'],
                $counts['posts']
            );
        } elseif ( 'purge' === $action ) {
            $purged = emclient_purge_seed_data();
            $message = sprintf( __( 'Purged %d seeded posts and portfolio items.', 'em-client' ), $purged );
            $message_type = 'notice-warning';
        }
    }

    // Count current items
    $portfolio_count = wp_count_posts( 'project_item' );
    $seeded_portfolio = count( get_posts( array(
        'post_type'   => 'project_item',
        'numberposts' => -1,
        'meta_key'    => '_is_seeded_data',
        'post_status' => 'any',
    ) ) );

    $seeded_posts = count( get_posts( array(
        'post_type'   => 'post',
        'numberposts' => -1,
        'meta_key'    => '_is_seeded_data',
        'post_status' => 'any',
    ) ) );

    ?>
    <div class="wrap">
        <h1 style="display:flex; align-items:center; gap:10px;">
            <span class="dashicons dashicons-database-add" style="font-size:32px; width:32px; height:32px;"></span>
            <?php esc_html_e( 'Headless Dashboard Seed Generator', 'em-client' ); ?>
        </h1>
        <p><?php esc_html_e( 'Auto-generate realistic sample data (Case Studies, Blog Posts, Types, and Stacks) to test the Headless Operations React Dashboard.', 'em-client' ); ?></p>

        <?php if ( ! empty( $message ) ) : ?>
            <div class="notice <?php echo esc_attr( $message_type ); ?> is-dismissible">
                <p><?php echo esc_html( $message ); ?></p>
            </div>
        <?php endif; ?>

        <div style="background:#fff; border:1px solid #c3c4c7; padding:20px; border-radius:8px; max-width:700px; margin-top:20px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
            <h2><?php esc_html_e( 'Current Status', 'em-client' ); ?></h2>
            <ul>
                <li><strong><?php esc_html_e( 'Total Case Studies:', 'em-client' ); ?></strong> <?php echo esc_html( $portfolio_count->publish ?? 0 ); ?></li>
                <li><strong><?php esc_html_e( 'Seeded Case Studies:', 'em-client' ); ?></strong> <?php echo esc_html( $seeded_portfolio ); ?></li>
                <li><strong><?php esc_html_e( 'Seeded Blog Posts:', 'em-client' ); ?></strong> <?php echo esc_html( $seeded_posts ); ?></li>
            </ul>

            <hr style="margin:20px 0; border-color:#f0f0f1;" />

            <h3><?php esc_html_e( 'Actions', 'em-client' ); ?></h3>
            <p><?php esc_html_e( 'Generate case studies with complete and deliberately missing fields to test quality scoring and audit warnings in the dashboard.', 'em-client' ); ?></p>

            <div style="display:flex; gap:15px; margin-top:15px;">
                <form method="post" action="">
                    <?php wp_nonce_field( 'emclient_seed_action_nonce', 'emclient_seed_nonce' ); ?>
                    <input type="hidden" name="emclient_seeder_action" value="generate" />
                    <button type="submit" class="button button-primary button-large">
                        <span class="dashicons dashicons-plus-alt2" style="vertical-align:middle; margin-right:4px;"></span>
                        <?php esc_html_e( 'Generate Seed Data', 'em-client' ); ?>
                    </button>
                </form>

                <?php if ( $seeded_portfolio > 0 || $seeded_posts > 0 ) : ?>
                    <form method="post" action="" onsubmit="return confirm('Are you sure you want to delete all seeded sample items?');">
                        <?php wp_nonce_field( 'emclient_seed_action_nonce', 'emclient_seed_nonce' ); ?>
                        <input type="hidden" name="emclient_seeder_action" value="purge" />
                        <button type="submit" class="button button-secondary button-large" style="color:#d63638; border-color:#d63638;">
                            <span class="dashicons dashicons-trash" style="vertical-align:middle; margin-right:4px;"></span>
                            <?php esc_html_e( 'Purge Seeded Data', 'em-client' ); ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Generate Taxonomy Terms and Sample Posts/Portfolio Items
 */
function emclient_generate_seed_data() {
    // 1. Ensure Taxonomies exist
    $types = array(
        'Client Work'          => 'Client projects built for agency and enterprise clients',
        'Internal Product'     => 'Internal tools, dashboard apps, and business workflows',
        'Open Source Plugin'   => 'Custom WordPress plugins and block extensions',
        'Healthcare & Enterprise' => 'HIPAA / WCAG compliant enterprise applications',
    );

    $type_term_ids = array();
    foreach ( $types as $name => $desc ) {
        $term = get_term_by( 'name', $name, 'project_type' );
        if ( ! $term ) {
            $inserted = wp_insert_term( $name, 'project_type', array( 'description' => $desc ) );
            if ( ! is_wp_error( $inserted ) ) {
                $type_term_ids[$name] = $inserted['term_id'];
            }
        } else {
            $type_term_ids[$name] = $term->term_id;
        }
    }

    $stacks = array( 'React', 'TypeScript', 'WordPress', 'PHP', 'WooCommerce', 'Next.js', 'Node.js', 'Elementor', 'Tailwind CSS', 'REST API', 'Gutenberg' );
    $stack_term_ids = array();
    foreach ( $stacks as $name ) {
        $term = get_term_by( 'name', $name, 'project_stack' );
        if ( ! $term ) {
            $inserted = wp_insert_term( $name, 'project_stack' );
            if ( ! is_wp_error( $inserted ) ) {
                $stack_term_ids[$name] = $inserted['term_id'];
            }
        } else {
            $stack_term_ids[$name] = $term->term_id;
        }
    }

    // 2. Portfolio Items Seed Data Array
    $portfolio_seeds = array(
        array(
            'title'   => 'Madrigal Patient Support Portal',
            'excerpt' => 'Custom healthcare portal integration with accessibility compliance and secure patient onboarding workflow.',
            'type'    => 'Healthcare & Enterprise',
            'stacks'  => array( 'WordPress', 'PHP', 'Elementor', 'REST API' ),
            'days_ago'=> 12,
            'complete'=> true,
        ),
        array(
            'title'   => 'GEA Jewelers Custom Product Configurator',
            'excerpt' => 'Custom WooCommerce configurator replacing 2M+ variation system with high-performance custom DB price tables and AJAX.',
            'type'    => 'Client Work',
            'stacks'  => array( 'WooCommerce', 'WordPress', 'PHP', 'React' ),
            'days_ago'=> 25,
            'complete'=> true,
        ),
        array(
            'title'   => 'Nivero Next.js Dashboard UI',
            'excerpt' => 'Modern React/Next.js frontend interface refactor for enterprise SaaS analytics platform.',
            'type'    => 'Client Work',
            'stacks'  => array( 'React', 'Next.js', 'TypeScript', 'Tailwind CSS' ),
            'days_ago'=> 45,
            'complete'=> true,
        ),
        array(
            'title'   => 'Invoice Management App',
            'excerpt' => 'Laravel 12 time tracking and invoicing application with client portal and PDF reporting.',
            'type'    => 'Internal Product',
            'stacks'  => array( 'PHP', 'Tailwind CSS', 'Node.js' ),
            'days_ago'=> 60,
            'complete'=> true,
        ),
        array(
            'title'   => 'Headless Content Operations Dashboard',
            'excerpt' => 'React + TypeScript operations dashboard connecting to headless WordPress REST API with runtime Zod validation.',
            'type'    => 'Internal Product',
            'stacks'  => array( 'React', 'TypeScript', 'WordPress', 'REST API' ),
            'days_ago'=> 5,
            'complete'=> true,
        ),
        array(
            'title'   => 'Codofil WCAG 2.1 AA Accessibility Audit & Theme',
            'excerpt' => 'Accessible WordPress custom theme refactor ensuring Section 508 and WCAG 2.1 AA compliance across 18+ components.',
            'type'    => 'Healthcare & Enterprise',
            'stacks'  => array( 'WordPress', 'PHP', 'Elementor' ),
            'days_ago'=> 95, // Test staleness (>90 days)
            'complete'=> true,
        ),
        array(
            'title'   => 'Gutenberg EM Block Collection',
            'excerpt' => 'Custom Gutenberg block collection including FAQ accordion, post carousel, and custom block.json schema.',
            'type'    => 'Open Source Plugin',
            'stacks'  => array( 'Gutenberg', 'React', 'WordPress', 'PHP' ),
            'days_ago'=> 110, // Test staleness
            'complete'=> true,
        ),
        array(
            'title'   => 'Daily Posts Queue Plugin',
            'excerpt' => 'Automated WordPress post queue plugin with WP-Cron scheduling, custom user role, and front-end submission shortcode.',
            'type'    => 'Open Source Plugin',
            'stacks'  => array( 'WordPress', 'PHP' ),
            'days_ago'=> 30,
            'complete'=> false, // Intentionally missing structured fields for audit testing
        ),
        array(
            'title'   => 'Woo Team Manage Plugin',
            'excerpt' => 'WooCommerce extension for B2B team management, sub-account purchasing permissions, and seat management.',
            'type'    => 'Open Source Plugin',
            'stacks'  => array( 'WooCommerce', 'WordPress', 'PHP' ),
            'days_ago'=> 15,
            'complete'=> true,
        ),
        array(
            'title'   => 'Social Movement Technologies E-Learning',
            'excerpt' => 'Custom LearnDash LMS theme implementation, payment integration, and custom student progress dashboard.',
            'type'    => 'Client Work',
            'stacks'  => array( 'WordPress', 'PHP', 'Elementor' ),
            'days_ago'=> 120, // Test staleness
            'complete'=> true,
        ),
        array(
            'title'   => 'Mary Bird Perkins Healthcare Maintenance',
            'excerpt' => 'Ongoing WordPress theme updates, security hardening, performance optimization, and landing page engineering.',
            'type'    => 'Healthcare & Enterprise',
            'stacks'  => array( 'WordPress', 'PHP', 'Elementor' ),
            'days_ago'=> 8,
            'complete'=> true,
        ),
        array(
            'title'   => 'Project Manager App',
            'excerpt' => 'Full-stack React, Node.js, and SQLite project tracking application with Kanban board and milestone tracker.',
            'type'    => 'Internal Product',
            'stacks'  => array( 'React', 'Node.js', 'TypeScript' ),
            'days_ago'=> 75,
            'complete'=> true,
        ),
        array(
            'title'   => 'AWC Internal API Portal',
            'excerpt' => '', // Intentionally empty excerpt for audit rule
            'type'    => 'Client Work',
            'stacks'  => array( 'WordPress', 'PHP', 'REST API' ),
            'days_ago'=> 14,
            'complete'=> false,
        ),
        array(
            'title'   => 'Great Reads Custom Post Type Plugin',
            'excerpt' => 'Lightweight WP plugin registering curated book reviews CPT with REST API exposure.',
            'type'    => 'Open Source Plugin',
            'stacks'  => array( 'WordPress', 'PHP' ),
            'days_ago'=> 105,
            'complete'=> false,
        ),
        array(
            'title'   => 'Covalent Logic Partner Theme Suite',
            'excerpt' => 'Custom theme framework built for agency partner deployment across 18+ client websites.',
            'type'    => 'Client Work',
            'stacks'  => array( 'WordPress', 'PHP', 'Elementor' ),
            'days_ago'=> 50,
            'complete'=> true,
        ),
    );

    $portfolio_count = 0;
    foreach ( $portfolio_seeds as $seed ) {
        $post_date = date( 'Y-m-d H:i:s', strtotime( "-{$seed['days_ago']} days" ) );
        $is_complete = ! empty( $seed['complete'] );

        $post_id = wp_insert_post( array(
            'post_title'   => $seed['title'],
            'post_excerpt' => $seed['excerpt'],
            'post_content' => '<p>' . esc_html( $seed['excerpt'] ) . '</p><p>Built with modern architectural practices, emphasizing performance, clean code, and robust error handling.</p>',
            'post_status'  => 'publish',
            'post_type'    => 'project_item',
            'post_date'    => $post_date,
            'meta_input'   => array(
                '_is_seeded_data'          => 1,
                'emclient_client_name'     => $is_complete ? 'Sample Client Organization' : '',
                'emclient_role'            => $is_complete ? 'Lead WordPress Developer' : '',
                'emclient_project_url'     => '',
                'emclient_repository_url'  => '',
                'emclient_completion_year' => (int) gmdate( 'Y', strtotime( "-{$seed['days_ago']} days" ) ),
                'emclient_challenge'       => $is_complete ? 'The team needed a reliable digital workflow that was easier to maintain and measure.' : '',
                'emclient_solution'        => $is_complete ? 'Designed and implemented a maintainable solution with clear content and technical boundaries.' : '',
                'emclient_outcome'         => $is_complete ? 'Improved consistency, maintainability, and the team\'s ability to manage the work.' : '',
            ),
        ) );

        if ( ! is_wp_error( $post_id ) && $post_id > 0 ) {
            $portfolio_count++;

            // Set Project Type
            if ( isset( $type_term_ids[$seed['type']] ) ) {
                wp_set_object_terms( $post_id, array( $type_term_ids[$seed['type']] ), 'project_type' );
            }

            // Set Project Stack
            $stack_ids = array();
            foreach ( $seed['stacks'] as $stack_name ) {
                if ( isset( $stack_term_ids[$stack_name] ) ) {
                    $stack_ids[] = $stack_term_ids[$stack_name];
                }
            }
            if ( ! empty( $stack_ids ) ) {
                wp_set_object_terms( $post_id, $stack_ids, 'project_stack' );
            }
        }
    }

    // 3. Blog Posts Seed Data Array
    $post_seeds = array(
        array(
            'title'   => 'Building Scalable Headless WordPress Interfaces with React and TypeScript',
            'excerpt' => 'How to decouple WordPress using REST API, Zod schema validation, and React Query for rapid client-side rendering.',
            'days_ago'=> 3,
        ),
        array(
            'title'   => 'Optimizing WooCommerce Product Variations with Custom Database Price Tables',
            'excerpt' => 'Replacing millions of WooCommerce variation rows with custom SQL tables to speed up catalog queries by 10x.',
            'days_ago'=> 18,
        ),
        array(
            'title'   => 'WCAG 2.1 AA Accessibility Guidelines Every WordPress Developer Should Know',
            'excerpt' => 'A practical checklist for color contrast, keyboard navigation focus states, screen reader ARIA labels, and Section 508 compliance.',
            'days_ago'=> 40,
        ),
        array(
            'title'   => 'Why Zod Runtime Validation Prevents Production Breakages in Decoupled CMS Apps',
            'excerpt' => 'TypeScript types vanish at runtime. Here is how schema validation acts as a safety barrier for external REST API endpoints.',
            'days_ago'=> 65,
        ),
        array(
            'title'   => 'Creating Custom Gutenberg Blocks with Block.json and React Hooks',
            'excerpt' => 'Modern Gutenberg block development patterns using block.json schema, server-side render fallbacks, and React state.',
            'days_ago'=> 98, // Test staleness rule
        ),
        array(
            'title'   => 'Managing WP-Cron Jobs safely in High Traffic WordPress Environments',
            'excerpt' => 'Offloading native WP-Cron to system crontab routines to avoid performance bottleneck during peak user requests.',
            'days_ago'=> 102,
        ),
        array(
            'title'   => 'Short Post', // Test audit rule for short title
            'excerpt' => 'Quick tip on WP REST API custom headers.',
            'days_ago'=> 15,
        ),
        array(
            'title'   => 'Architecting Custom WordPress Plugins for Enterprise Clients',
            'excerpt' => '', // Empty excerpt for audit rule
            'days_ago'=> 28,
        ),
        array(
            'title'   => 'Comparing REST API vs GraphQL for WordPress Decoupled Architectures',
            'excerpt' => 'Tradeoffs between native WP REST API endpoints and WPGraphQL for frontend performance and caching strategies.',
            'days_ago'=> 55,
        ),
        array(
            'title'   => 'Clean Code Practices for Custom WordPress Theme Development',
            'excerpt' => 'Organizing theme includes, template parts, class structures, and PHPCS standard enforcement in agency workflows.',
            'days_ago'=> 80,
        ),
    );

    $posts_count = 0;
    foreach ( $post_seeds as $seed ) {
        $post_date = date( 'Y-m-d H:i:s', strtotime( "-{$seed['days_ago']} days" ) );

        $post_id = wp_insert_post( array(
            'post_title'   => $seed['title'],
            'post_excerpt' => $seed['excerpt'],
            'post_content' => '<p>' . esc_html( $seed['excerpt'] ) . '</p><p>Detailed technical breakdown of patterns, implementation steps, and production lessons learned.</p>',
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_date'    => $post_date,
            'meta_input'   => array(
                '_is_seeded_data' => 1,
            ),
        ) );

        if ( ! is_wp_error( $post_id ) && $post_id > 0 ) {
            $posts_count++;
        }
    }

    return array(
        'portfolio' => $portfolio_count,
        'posts'     => $posts_count,
    );
}

/**
 * Purge Seeded Data
 */
function emclient_purge_seed_data() {
    $seeded_items = get_posts( array(
        'post_type'   => array( 'project_item', 'post' ),
        'numberposts' => -1,
        'meta_key'    => '_is_seeded_data',
        'post_status' => 'any',
    ) );

    $count = 0;
    foreach ( $seeded_items as $item ) {
        if ( wp_delete_post( $item->ID, true ) ) {
            $count++;
        }
    }

    return $count;
}
