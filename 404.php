<?php
   get_header(); 
   
   ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("em-404"); ?> >
   <div class="entry-content">
      <img src="<?php echo get_stylesheet_directory_uri() . "/assets/img/svg/404.svg"?>">
      <p>Page not found</p>
      <a href="<?php echo get_home_url();?>"><button>Go to Home</button></a>  
   </div>   
</article>
<?php get_footer(); ?>