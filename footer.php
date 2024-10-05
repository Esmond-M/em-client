<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package website-theme-name
 */
?>
 <footer id="colophon" class="site-footer emThemefooter">
<?php
 if ( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ) : ?>
	<div class="footer-widgets">
		<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
			<div class="footer-widget-area">
				<?php dynamic_sidebar( 'footer-one' ); ?>
			</div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
			<div class="footer-widget-area">
				<?php dynamic_sidebar( 'footer-two' ); ?>
			</div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
			<div class="footer-widget-area">
				<?php dynamic_sidebar( 'footer-three' ); ?>
			</div>
		<?php endif; ?>
	</div><!-- .footer-widgets -->
<?php endif; ?>

<div class="copy-right">Copyright <?php echo date("Y"); ?></div>
</footer><!-- #colophon -->
<?php wp_footer(); ?>
</body>
</html>
