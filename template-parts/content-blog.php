<main id="primary" class="site-main em-client-blog">

    <header>
        <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
    </header>
    <?php

    /* Start the Loop */
    while ( have_posts() ) :
        the_post();
    ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class("post-item"); ?>>
        <?php 
        if( get_the_post_thumbnail_url() ){

        ?>
        <div class="featured-img" style="background-image: url('<?php echo get_the_post_thumbnail_url();?>');"> </div>
        <?php
        }

        else{
        ?>	
        <div class="featured-img" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/blog-placholder.jpg"?>');"></div>
        <?php
        }

        ?>
        <header class="entry-header">
            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
                ?>
                <div class="entry-meta">
                    <?php
                    emclient_posted_on();
                    emclient_posted_by();
                    ?>
                </div><!-- .entry-meta -->
        </header><!-- .entry-header -->
        <div class="entry-content">
            <?php
            the_excerpt(
                sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'em-client' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    wp_kses_post( get_the_title() )
                )
            );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'em-client' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <footer class="entry-footer">
            <?php emclient_entry_footer(); ?>
        </footer><!-- .entry-footer -->
    </article><!-- #post-<?php the_ID(); ?> -->
    <?php
    endwhile;

    the_posts_navigation();?>
</main><!-- #main -->