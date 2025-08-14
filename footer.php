
<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package em-client
 */
?>

	</div><!-- #content (assumed open in main template) -->
	<footer id="colophon" class="site-footer emclientfooter" role="contentinfo" aria-label="Site Footer">
		<div class="footer-inner" style="max-width:1200px;margin:auto;padding:2rem 1rem;">
			<?php
			if ( is_active_sidebar( 'footer-one' ) || is_active_sidebar( 'footer-two' ) || is_active_sidebar( 'footer-three' ) ) : ?>
				<aside class="footer-widgets" aria-label="Footer Widgets" style="display:flex;gap:2rem;flex-wrap:wrap;justify-content:center;">
					<?php if ( is_active_sidebar( 'footer-one' ) ) : ?>
						<section class="footer-widget-area" aria-label="Footer Widget One">
							<?php dynamic_sidebar( 'footer-one' ); ?>
						</section>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-two' ) ) : ?>
						<section class="footer-widget-area" aria-label="Footer Widget Two">
							<?php dynamic_sidebar( 'footer-two' ); ?>
						</section>
					<?php endif; ?>
					<?php if ( is_active_sidebar( 'footer-three' ) ) : ?>
						<section class="footer-widget-area" aria-label="Footer Widget Three">
							<?php dynamic_sidebar( 'footer-three' ); ?>
						</section>
					<?php endif; ?>
				</aside>
			<?php endif; ?>

			<div class="site-info" style="margin-top:2rem;text-align:center;color:#666;font-size:0.95rem;">
				<small class="copy-right">© <?php echo esc_html(date("Y")); ?> Esmond. All Rights Reserved.</small>
			</div>
		</div>
	</footer><!-- #colophon -->
	<?php wp_footer(); ?>
</body>
</html>
