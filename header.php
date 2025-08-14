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
		<button class="ham-btn" aria-label="Open menu">
			<svg viewBox="0 0 100 80" width="40" height="40" fill="white">
				<rect width="100" height="10"></rect>
				<rect y="30" width="100" height="10"></rect>
				<rect y="60" width="100" height="10"></rect>
			</svg>
		</button>
		<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="Primary Menu">
			<?php 
				wp_nav_menu(
					array(
						'menu'                 =>17,
						'container'            => 'ul',
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
						'depth'                => 3, // Enable submenu depth
						'walker'               => new EMClient_Nav_Walker(),
						'theme_location' => 'primary_menu',
					)
				);
			?>
		</nav>
	</header><!-- #masthead -->
