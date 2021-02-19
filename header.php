<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package website-theme-name
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
<div class="ROOTEDin-fixedheader-placeholder"></div>
	<header id="masthead" class="site-header">
		<button class="ROOTEDin-openbtn"><i class="fas fa-bars"></i> Menu</button>
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="ROOTEDin-closebtn">Close <i class="fa fa-times" aria-hidden="true"></i></a>
			<?php 
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
</div><!-- #site-navigation -->
		<div class="site-branding">
		 <?php       

     $custom_logo_id = get_theme_mod( 'custom_logo' );
     $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
     if ( has_custom_logo() ) {
           $custom_logo_image = esc_url( $logo[0] );
     } else {
            $custom_logo_image = get_template_directory_uri() . '/inc/images/logo/site logo transparent.png';
     }
     ?>
     <a href="<?php echo home_url(); ?>"><img class="site-branding-img" src="<?php echo  $custom_logo_image; ?>" alt="Logo" class="logo-img"></a> 
			
		
		</div><!-- .site-branding -->

	</header><!-- #masthead -->
