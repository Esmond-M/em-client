
<article id="post-<?php the_ID(); ?>" <?php post_class("em-front-page-content"); ?> >
	
    <section class="intro">
    <h2>Boilerplate Wordpress Theme</h2>
    <p>Theme setup with a basic structure to be improved upon per client.</p>
    <div class="bg-img" style="background-image: url('<?php  echo get_stylesheet_directory_uri() . "/assets/img/front-page-placeholder.jpg";?>');">	
    <!-- .entry-content -->
    </section>

    <section class="features">
    <h2>Features</h2>
    <div class="em-container">
        <div class="feature-item">
            <img src="" />
            <p class="title"> <?php  _e( 'Customization', 'em-client' ); ?> </p>
            <p class="description"><?php  _e( 'Straight forward template structure. Convenient NPM commands for automated processes.', 'em-client' ); ?> </p>
        </div> 
        <div class="feature-item">
            <img src="" />
            <p class="title"> <?php  _e( 'Woocommerce Compatibility', 'em-client' ); ?>  </p>
            <p class="description"><?php  _e( 'WooCommerce compatibility. Includes pre-built features with easily updated template files.', 'em-client' ); ?>  </p>
        </div> 
        <div class="feature-item">
            <img src="" />
            <p class="title"> <?php  _e( 'Sass Files', 'em-client' ); ?>  </p>
            <p class="description"> <?php  _e( 'All the conveniences of using sass. Variables that can be easily updated etc.', 'em-client' ); ?> </p>
        </div> 
     </div>

    <!-- .entry-content -->
    </section>

	
</article>
