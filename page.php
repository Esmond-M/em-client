<?php
  
   get_header(); 
   
   ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("em-page-content"); ?> >
	
<section>
	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'em-client' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->
</section>

	
</article>
<?php get_footer(); ?>