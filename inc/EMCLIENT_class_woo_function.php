<?php
declare(strict_types=1);
namespace inc\EMCLIENT_class_woo_function;
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package em-client
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */

if (!class_exists('EMCLIENT_theme_woo_function_Class')) {

    class EMCLIENT_theme_woo_function_Class
    {

        /** Declaring constructor
         */
        public function __construct()
        {

			add_action( 'after_setup_theme',  [$this, 'emclient_woocommerce_setup' ]  );
			add_filter( 'body_class',  [$this, 'emclient_woocommerce_active_body_class' ]  );
			add_filter( 'woocommerce_output_related_products_args',  [$this, 'emclient_woocommerce_related_products_args' ]  );
			add_action( 'woocommerce_before_main_content',  [$this, 'emclient_woocommerce_wrapper_before' ]  );
			add_action( 'woocommerce_after_main_content', [$this, 'emclient_woocommerce_wrapper_after' ]  );
			add_filter( 'woocommerce_add_to_cart_fragments', [$this, 'emclient_woocommerce_cart_link_fragment' ]   );
			/**
			 * Remove default WooCommerce wrapper.
			 */
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

        }
		public static function emclient_woocommerce_setup() {
			add_theme_support(
				'woocommerce',
				array(
					'thumbnail_image_width' => 150,
					'single_image_width'    => 300,
					'product_grid'          => array(
						'default_rows'    => 3,
						'min_rows'        => 1,
						'default_columns' => 4,
						'min_columns'     => 1,
						'max_columns'     => 6,
					),
				)
			);
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
		
		
		
		/**
		 * Add 'woocommerce-active' class to the body tag.
		 *
		 * @param  array $classes CSS classes applied to the body tag.
		 * @return array $classes modified to include 'woocommerce-active' class.
		 */
		public static function emclient_woocommerce_active_body_class( $classes ) {
			$classes[] = 'woocommerce-active';
		
			return $classes;
		}

		
		/**
		 * Related Products Args.
		 *
		 * @param array $args related products args.
		 * @return array $args related products args.
		 */
		public static function emclient_woocommerce_related_products_args( $args ) {
			$defaults = array(
				'posts_per_page' => 3,
				'columns'        => 3,
			);
		
			$args = wp_parse_args( $defaults, $args );
		
			return $args;
		}

		/**
		 * Before Content.
		 *
		 * Wraps all WooCommerce content in wrappers which match the theme markup.
		 *
		 * @return void
		 */
		public static function emclient_woocommerce_wrapper_before() {
			?>
				<main id="primary" class="site-main">
			<?php
		}

		/**
		 * After Content.
		 *
		 * Closes the wrapping divs.
		 *
		 * @return void
		 */
		public static function emclient_woocommerce_wrapper_after() {
			?>
				</main><!-- #main -->
			<?php
		}
	
		/**
		 * Cart Fragments.
		 *
		 * Ensure cart contents update when products are added to the cart via AJAX.
		 *
		 * @param array $fragments Fragments to refresh via AJAX.
		 * @return array Fragments to refresh via AJAX.
		 */
		public static function emclient_woocommerce_cart_link_fragment( $fragments ) {
			ob_start();
			emclient_woocommerce_cart_link();
			$fragments['a.cart-contents'] = ob_get_clean();
	
			return $fragments;
		}
		
		/**
		 * Cart Link.
		 *
		 * Displayed a link to the cart including the number of items present and the cart total.
		 *
		 * @return void
		 */
		public static function emclient_woocommerce_cart_link() {
			?>
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'em-client' ); ?>">
				<?php
				$item_count_text = sprintf(
					/* translators: number of items in the mini cart. */
					_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'em-client' ),
					WC()->cart->get_cart_contents_count()
				);
				?>
				<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
			</a>
			<?php
		}
		
		/**
		 * Display Header Cart.
		 *
		 * @return void
		 */
		public static function emclient_woocommerce_header_cart() {
			if ( is_cart() ) {
				$class = 'current-menu-item';
			} else {
				$class = '';
			}
			?>
			<ul id="site-header-cart" class="site-header-cart">
				<li class="<?php echo esc_attr( $class ); ?>">
					<?php  $this->emclient_woocommerce_cart_link(); ?>
				</li>
				<li>
					<?php
					$instance = array(
						'title' => '',
					);
	
					the_widget( 'WC_Widget_Cart', $instance );
					?>
				</li>
			</ul>
			<?php
		}

		

	} // Closing bracket for classes

}

use inc\EMCLIENT_class_woo_function;
new EMCLIENT_theme_woo_function_Class;
