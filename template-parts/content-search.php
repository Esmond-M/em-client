<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package em-client
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if (get_the_post_thumbnail_url()) { ?>
				<div class="featured-img" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"> 
				</div>
				<?php
				 } 
				else 
				{ ?>	
				<div class="featured-img" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/blog-placholder.jpg"; ?>');"></div>
			<?php 
		     }
		     ?>
				<header class="entry-header">
					<?php
     if (is_singular()):
         the_title('<h1 class="entry-title">', "</h1>");
     else:
         the_title(
             '<h2 class="entry-title"><a href="' .
                 esc_url(get_permalink()) .
                 '" rel="bookmark">',
             "</a></h2>"
         );
     endif;

     if ("post" === get_post_type()): ?>
						<div class="entry-meta">
							<?php
       emclient_posted_on();
       emclient_posted_by();
       ?>
						</div><!-- .entry-meta -->
					<?php endif;
     ?>
				</header><!-- .entry-header -->
				<div class="entry-content">
					<?php
     the_excerpt(
         sprintf(
             wp_kses(
                 /* translators: %s: Name of current post. Only visible to screen readers */
                 __(
                     'Continue reading<span class="screen-reader-text"> "%s"</span>',
                     "em-client"
                 ),
                 [
                     "span" => [
                         "class" => [],
                     ],
                 ]
             ),
             wp_kses_post(get_the_title())
         )
     );

     wp_link_pages([
         "before" =>
             '<div class="page-links">' . esc_html__("Pages:", "em-client"),
         "after" => "</div>",
     ]);
     ?>
				</div><!-- .entry-content -->

				<footer class="entry-footer">
					<?php emclient_entry_footer(); ?>
				</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
