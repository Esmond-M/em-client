<?php
/**
 * Headless Operations smoke tests for WP-CLI.
 *
 * @package emclientWP
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {
    /**
     * Run read-only checks for the HeadlessWP Operations integration.
     *
     * ## EXAMPLES
     *
     *     wp headless-ops test
     */
    class EMCLIENT_Headless_Ops_Command {

        /**
         * Run smoke tests.
         *
         * @return void
         */
        public function test() {
            $failures = array();

            $this->check( post_type_exists( 'project_item' ), 'project_item post type is registered.', $failures );
            $this->check( taxonomy_exists( 'project_type' ), 'project_type taxonomy is registered.', $failures );
            $this->check( taxonomy_exists( 'project_stack' ), 'project_stack taxonomy is registered.', $failures );

            $post_type = get_post_type_object( 'project_item' );
            $this->check( $post_type && $post_type->show_in_rest, 'project_item is exposed through REST.', $failures );
            $this->check( $post_type && in_array( 'thumbnail', $post_type->supports, true ), 'project_item supports featured images.', $failures );
            $this->check( $post_type && ! in_array( 'author', $post_type->supports, true ), 'project_item does not expose author support.', $failures );

            $meta_keys = array(
                'emclient_client_name',
                'emclient_role',
                'emclient_project_url',
                'emclient_repository_url',
                'emclient_completion_year',
                'emclient_challenge',
                'emclient_solution',
                'emclient_outcome',
            );

            foreach ( $meta_keys as $meta_key ) {
                $registered = get_registered_meta_keys( 'post', 'project_item' );
                $this->check( in_array( $meta_key, $registered, true ), sprintf( '%s is registered for project_item.', $meta_key ), $failures );
            }

            $seeded_items = get_posts(
                array(
                    'post_type'   => 'project_item',
                    'numberposts' => 1,
                    'post_status' => 'any',
                    'meta_key'    => '_is_seeded_data',
                )
            );

            if ( ! empty( $seeded_items ) ) {
                $seeded_id = $seeded_items[0]->ID;
                $this->check( ! empty( get_post_meta( $seeded_id, 'emclient_completion_year', true ) ), 'Seeded case study has completion year metadata.', $failures );
                $this->check( ! empty( wp_get_post_terms( $seeded_id, 'project_type' ) ), 'Seeded case study has a project type.', $failures );
                $this->check( ! empty( wp_get_post_terms( $seeded_id, 'project_stack' ) ), 'Seeded case study has a project stack.', $failures );
            } else {
                WP_CLI::warning( 'No seeded project_item found. Seed-data checks were skipped.' );
            }

            if ( empty( $failures ) ) {
                WP_CLI::success( 'All HeadlessWP Operations smoke tests passed.' );
                return;
            }

            foreach ( $failures as $failure ) {
                WP_CLI::warning( $failure );
            }

            WP_CLI::error( sprintf( '%d smoke test(s) failed.', count( $failures ) ) );
        }

        /**
         * Record or report a check result.
         *
         * @param bool  $condition Check condition.
         * @param string $message  Human-readable result.
         * @param array $failures  Failure accumulator.
         * @return void
         */
        private function check( $condition, $message, &$failures ) {
            if ( $condition ) {
                WP_CLI::log( 'PASS: ' . $message );
                return;
            }

            $failures[] = 'FAIL: ' . $message;
        }
    }

    WP_CLI::add_command( 'headless-ops', 'EMCLIENT_Headless_Ops_Command' );
}
