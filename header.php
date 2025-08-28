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
                        'menu'                 => 17,
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
                        'items_wrap'           => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                        'item_spacing'         => 'preserve',
                        'depth'                => 3, // Enable submenu depth
                        'walker'               => new EMClient_Desktop_Nav_Walker(),
                        'theme_location'       => 'primary_menu',
                    )
                );
            ?>
        </nav>
    </header><!-- #masthead -->

    <nav id="mobile-site-navigation" class="mobile-navigation" role="navigation" aria-label="Mobile Menu">
        <button class="close-nav-btn" aria-label="Close menu">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="white" xmlns="http://www.w3.org/2000/svg">
                <line x1="8" y1="8" x2="24" y2="24" stroke="white" stroke-width="3" stroke-linecap="round"/>
                <line x1="24" y1="8" x2="8" y2="24" stroke="white" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </button>
        <?php 
            wp_nav_menu(
                array(
                    'menu'                 => '',
                    'container'            => 'ul',
                    'container_class'      => '',
                    'container_id'         => '',
                    'container_aria_label' => '',
                    'menu_class'           => 'menu',
                    'menu_id'              => 'demo-menu',
                    'echo'                 => true,
                    'fallback_cb'          => 'wp_page_menu',
                    'before'               => '',
                    'after'                => '',
                    'link_before'          => '',
                    'link_after'           => '',
                    'items_wrap'           => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                    'item_spacing'         => 'preserve',
                    'depth'                => 3, // Enable submenu depth
                    'walker'               => new EMClient_Mobile_Nav_Walker(),
                    'theme_location'       => 'primary_menu',
                )
            );
        ?>
    </nav>
    <div class="nav-overlay"></div>
