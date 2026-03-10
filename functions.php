<?php

/**
 * Theme functions and definitions — Full Site Editing (FSE) variant.
 *
 * Navigation and layout are managed via theme.json and block templates in
 * /templates/ and /parts/. Nav walkers and the mobile-menu JS from the base
 * theme are not loaded here; the Navigation block handles all of that.
 *
 * @package emclientWP WordPress theme
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * emclientWP theme class
 */
final class EMCLIENT_Theme_Class {

    /**
     * Main Theme Class Constructor
     *
     * @since   1.0.0
     */
    public function __construct() {
        // Load framework classes.
        add_action( 'after_setup_theme', array( 'EMCLIENT_Theme_Class', 'classes' ), 4 );
        // Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc.
        add_action( 'after_setup_theme', array( 'EMCLIENT_Theme_Class', 'theme_setup' ), 10 );
        // register sidebar widget areas.
        add_action( 'widgets_init', array( 'EMCLIENT_Theme_Class', 'register_sidebars' ) );

        /** Admin only actions */
        if ( is_admin() ) {
            /** Non Admin actions */
        } else {
            // Load theme js.
            add_action( 'wp_enqueue_scripts',  [$this, 'theme_js' ]  );
            // Load theme CSS.
            add_action( 'wp_enqueue_scripts',  [$this, 'theme_css' ] );
            // Add a pingback url auto-discovery header for singularly identifiable articles.
            add_action( 'wp_head',  [$this, 'pingback_header' ] , 1 );
            add_filter( 'emclient_enqueue_generated_files', '__return_false' );
        }
    }

    /**
     * Static replacements for theme constants
     */
    public static function theme_dir() {
        return get_template_directory();
    }
    public static function theme_uri() {
        return get_template_directory_uri();
    }
    public static function theme_version() {
        return '3.6.0';
    }
    public static function lib_dir() {
        return self::theme_dir() . '/lib/';
    }
    public static function js_dir_uri() {
        return self::theme_uri() . '/assets/js/';
    }
    public static function css_dir_uri() {
        return self::theme_uri() . '/assets/css/';
    }
    public static function inc_dir() {
        return self::theme_dir() . '/inc/';
    }

    /**
     * Load theme classes
     *
     * @since   1.0.0
     */
    public static function classes() {
        $dir_include = self::inc_dir();
        // Nav walkers and custom widgets are not needed in the FSE variant.
        // The Navigation block handles menus; block templates handle layout.
        if ( class_exists( 'WooCommerce' ) ) {
            require $dir_include . 'plugins/woocommerce/classes/woocommerce_function.php';
        }
    }

    /**
     * Theme Setup
     *
     * @since   1.0.0
     */
    public static function theme_setup() {
        $dir_include = self::inc_dir();
        // Load text domain.
        load_theme_textdomain( 'em-client', self::theme_dir() . '/languages' );

        // Get globals.
        global $content_width;

        // Set content width based on theme's default design.
        if ( ! isset( $content_width ) ) {
            $content_width = 1200;
        }

        // Register navigation menus — the Navigation block can reference these by slug.
        register_nav_menus(
            array(
                'primary_menu' => esc_html__( 'Primary', 'em-client' ),
                'footer_menu'  => esc_html__( 'Footer', 'em-client' ),
            )
        );

        // Enable support for Post Formats.
        add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );

        // Enable support for <title> tag.
        add_theme_support( 'title-tag' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails on posts and pages.
        add_theme_support( 'post-thumbnails' );

        /**
         * Enable support for site logo
         */
        add_theme_support(
            'custom-logo',
            apply_filters(
                'emclient_custom_logo_args',
                array(
                    'height'      => 45,
                    'width'       => 164,
                    'flex-height' => true,
                    'flex-width'  => true,
                )
            )
        );
        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'emclient_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );
        /*
         * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
                'widgets',
            )
        );

        // Block editor / FSE supports.
        add_theme_support( 'editor-styles' );
        add_editor_style( 'assets/css/style.min.css' );
        add_theme_support( 'align-wide' );
        add_theme_support( 'responsive-embeds' );

        // Declare WooCommerce support.
        add_theme_support( 'woocommerce' );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );

        // Declare support for selective refreshing of widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Custom template tags for this theme.
         */
        require $dir_include . 'template-tags.php';

        /**
         * Customizer additions.
         */
        require $dir_include . 'customizer.php';

        /**
         * Load Jetpack compatibility file.
         */
        if ( defined( 'JETPACK__VERSION' ) ) {
            require $dir_include . 'jetpack.php';
        }
    }

    /**
     * Adds the meta tag to the site header
     *
     * @since 1.1.0
     */
    public static function pingback_header() {

        if ( is_singular() && pings_open() ) {
            printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
        }

    }

    /**
     * Adds the meta tag to the site header
     *
     * @since 1.0.0
     */
    public static function meta_viewport() {

        // Meta viewport.
        $viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';

        // Apply filters for child theme tweaking.
        echo apply_filters( 'emclient_meta_viewport', $viewport ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

    }


    /**
     * Load front-end scripts
     *
     * @since   1.0.0
     */
    public static function theme_css() {

        $theme_version = self::theme_version();
        // Supplemental front-end styles. Global design tokens come from theme.json.
        wp_enqueue_style( 'emclient-style', get_stylesheet_directory_uri() . '/assets/css/style.min.css', array(), $theme_version );
        wp_style_add_data( 'emclient-style', 'rtl', 'replace' );
    }

    /**
     * Returns all js needed for the front-end
     *
     * @since 1.0.0
     */
    public static function theme_js() {

        // Get js directory uri.
        $dir = self::js_dir_uri();

        // Get current theme version.
        $theme_version = self::theme_version();

        // Comment reply.
        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }

        wp_enqueue_script( 'emclient-general', $dir . 'general.js', array(), $theme_version, true );
    }


    /**
     * Add headers for IE to override IE's Compatibility View Settings
     *
     * @param obj $headers   header settings.
     * @since 1.0.0
     */
    public static function x_ua_compatible_headers( $headers ) {
        $headers['X-UA-Compatible'] = 'IE=edge';
        return $headers;
    }

    /**
     * Registers sidebars
     *
     * @since   1.0.0
     */
    public static function register_sidebars() {

        $heading = get_theme_mod( 'emclient_sidebar_widget_heading_tag', 'h4' );
        $heading = apply_filters( 'emclient_sidebar_widget_heading_tag', $heading );

        // Default Sidebar — kept for widget/plugin compatibility.
        register_sidebar(
            array(
                'name'          => esc_html__( 'Default Sidebar', 'em-client' ),
                'id'            => 'sidebar',
                'description'   => esc_html__( 'Widgets in this area will be displayed in the sidebar.', 'em-client' ),
                'before_widget' => '<div id="%1$s" class="sidebar-box %2$s">',
                'after_widget'  => '</div>',
                'before_title'  => '<' . $heading . ' class="widget-title">',
                'after_title'   => '</' . $heading . '>',
            )
        );
    }

    /**
     * Wrap a string with a character (default: double quotes)
     */
    public static function em_client_str_wrap_global($string = '', $char = '"')
    {
        return str_pad($string, strlen($string) + 2, $char, STR_PAD_BOTH);
    }
}

/**
 * [em_copyright] shortcode — outputs a dynamic copyright line.
 * Use in the Site Editor by adding a Shortcode block containing [em_copyright].
 */
function emclient_copyright_shortcode() {
    return '&copy; ' . esc_html( date( 'Y' ) ) . ' ' . esc_html( get_bloginfo( 'name' ) ) . '. All rights reserved.';
}
add_shortcode( 'em_copyright', 'emclient_copyright_shortcode' );

new EMCLIENT_Theme_Class();