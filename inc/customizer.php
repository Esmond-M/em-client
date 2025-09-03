<?php
/**
 * em-client Theme Customizer
 *
 * @package em-client
 */

class EmClient_Customizer {
	/**
	 * Register customizer settings and partials
	 */
	public static function register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'blogname',
				array(
					'selector'        => '.site-title a',
					'render_callback' => [ __CLASS__, 'partial_blogname' ],
				)
			);
			$wp_customize->selective_refresh->add_partial(
				'blogdescription',
				array(
					'selector'        => '.site-description',
					'render_callback' => [ __CLASS__, 'partial_blogdescription' ],
				)
			);
		}
	}

	/**
	 * Render the site title for the selective refresh partial.
	 */
	public static function partial_blogname() {
		bloginfo( 'name' );
	}

	/**
	 * Render the site tagline for the selective refresh partial.
	 */
	public static function partial_blogdescription() {
		bloginfo( 'description' );
	}

	/**
	 * Enqueue customizer preview JS
	 */
	public static function preview_js() {
		wp_enqueue_script( 'emclientcustomizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), defined('_S_VERSION') ? _S_VERSION : false, true );
	}
}

add_action( 'customize_register', [ 'EmClient_Customizer', 'register' ] );
add_action( 'customize_preview_init', [ 'EmClient_Customizer', 'preview_js' ] );
