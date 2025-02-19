<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package em-client
 */

get_header();

	$url = $_SERVER['REQUEST_URI'];	
	$home_or_blog = str_contains( $url,"blog"); 
	if ( $home_or_blog ) {
	get_template_part( 'template-parts/content-blog');

	}
	else{
		get_template_part( 'template-parts/content-front');
	}
get_sidebar();
get_footer();
