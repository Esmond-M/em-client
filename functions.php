<?php
/**
 * website-theme-name functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package website-theme-name
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'website_theme_name_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function website_theme_name_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on website-theme-name, use a find and replace
		 * to change 'website-theme-name' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'website-theme-name', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'website-theme-name' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'website_theme_name_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'website_theme_name_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function website_theme_name_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'website_theme_name_content_width', 640 );
}
add_action( 'after_setup_theme', 'website_theme_name_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function website_theme_name_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'website-theme-name' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'website-theme-name' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'website_theme_name_widgets_init' );

function wrookies_google_tag_manager() {
    echo '<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-143357052-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'UA-143357052-2\');
</script>';
 
}
add_action( 'wp_head', 'wrookies_google_tag_manager', 1 );

/**
 * Enqueue scripts and styles.
 */
function website_theme_name_scripts() {
    $ss_version = rand( 1, 99999999999 );
	$stable_version = '1.20';
	wp_enqueue_style( 'website-theme-name-style', get_stylesheet_uri(), array(), $ss_version );
	wp_style_add_data( 'website-theme-name-style', 'rtl', 'replace' );
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' , array(), $stable_version);
	wp_enqueue_style('font-awesome-official-css', 'https://use.fontawesome.com/releases/v5.14.0/css/all.css');
	wp_enqueue_style('font-awesome-official-v4shim-css', 'https://use.fontawesome.com/releases/v5.14.0/css/v4-shims.css');
    wp_enqueue_style( 'wrookies-slider-css', get_template_directory_uri() . '/css/wrookies-slider.css' , array(), $ss_version );
	wp_enqueue_script( 'wrookies-general-js', get_template_directory_uri() . '/js/general.min.js', array(), $stable_version, true );
	wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), $stable_version, true);

	if (is_page(128)) {
		wp_enqueue_style( 'test-css', get_template_directory_uri() . '/css/test-css.css' , array(), $ss_version );
	}
}
add_action( 'wp_enqueue_scripts', 'website_theme_name_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
