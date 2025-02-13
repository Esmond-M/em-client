<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package em-client
 */

get_header();

?>

	<main id="primary" class="archive-esmond site-main em-page-content">

			<header class="page-header">
				<?php
				?>
			</header><!-- .page-header -->
			<?php 
        if ( have_posts() ) : 
            while ( have_posts() ) : the_post();
        	get_template_part( 'template-parts/content', get_post_type() );
            endwhile;
        else :
            _e( 'Sorry, no posts matched your criteria.', 'textdomain' );
        endif;
        ?>
	</main><!-- #main -->

<?php

get_footer();
