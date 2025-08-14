
<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 * @package em-client
 */

class EmClient_Jetpack {
	/**
	 * Setup Jetpack theme supports
	 */
	public static function setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support(
			'infinite-scroll',
			array(
				'container' => 'main',
				'render'    => [ __CLASS__, 'infinite_scroll_render' ],
				'footer'    => 'page',
			)
		);

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Content Options.
		add_theme_support(
			'jetpack-content-options',
			array(
				'post-details' => array(
					'stylesheet' => 'emclientstyle',
					'date'       => '.posted-on',
					'categories' => '.cat-links',
					'tags'       => '.tags-links',
					'author'     => '.byline',
					'comment'    => '.comments-link',
				),
				'featured-images' => array(
					'archive' => true,
					'post'    => true,
					'page'    => true,
				),
			)
		);
	}

	/**
	 * Custom render function for Infinite Scroll
	 */
	public static function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'template-parts/content', 'search' );
			else :
				get_template_part( 'template-parts/content', get_post_type() );
			endif;
		}
	}
}

add_action( 'after_setup_theme', [ 'EmClient_Jetpack', 'setup' ] );
