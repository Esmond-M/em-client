<?php
   get_header('404'); 
   
   ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("em-page-content"); ?> >
   <section>
      <div class="entry-content">
      </div>
      <!-- .entry-content -->
   </section>
</article>
<?php get_footer(); ?>