<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package em-client
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
<div class="emclient-fixedheader-placeholder"></div>
	<header id="masthead" class="site-header">
		<?php 
			wp_nav_menu(
				array(
					'menu'            =>16,
					'container'            => '',
					'container_class'      => '',
					'container_id'         => '',
					'container_aria_label' => '',
					'menu_class'           => 'menu',
					'menu_id'              => 'primary-menu',
					'echo'                 => true,
					'fallback_cb'          => 'wp_page_menu',
					'before'               => '',
					'after'                => '',
					'link_before'          => '',
					'link_after'           => '',
					'items_wrap'           => '<ul id="%1$s" class="%2$s">%3$s</ul>',
					'item_spacing'         => 'preserve',
					'depth'                => 0,
					'walker'               => '',
					'theme_location' => 'primary',
				)
			);
			?>
	</header><!-- #masthead -->
