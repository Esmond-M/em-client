
<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package em-client
 */
?>

<!-- Search Result Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('search-result'); ?> role="article" aria-label="Search Result">
    <!-- Featured Image (decorative) -->
    <?php if ( get_the_post_thumbnail_url() ) : ?>
        <figure class="featured-img" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url()); ?>');" aria-label="Featured Image"></figure>
    <?php else : ?>
        <figure class="featured-img" style="background-image: url('<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/blog-placeholder.jpg'); ?>');" aria-label="Placeholder Image"></figure>
    <?php endif; ?>

    <!-- Entry Header -->
    <header class="entry-header">
        <?php
        // Output the post title with semantic heading
        if ( is_singular() ) :
            the_title( '<h1 class="entry-title">', '</h1>' );
        else :
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        endif;

        // Output meta info for posts only
        if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php emclient_posted_on(); emclient_posted_by(); ?>
            </div>
        <?php endif; ?>
    </header>

    <!-- Entry Content -->
    <div class="entry-content">
        <?php
        // Output excerpt with accessible continue reading link
        the_excerpt(
            sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'em-client' ),
                    array( 'span' => array( 'class' => array(), ) )
                ),
                wp_kses_post( get_the_title() )
            )
        );

        // Output pagination for multi-page posts
        wp_link_pages(array(
            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'em-client' ),
            'after'  => '</div>',
        ));
        ?>
    </div>

    <!-- Entry Footer -->
    <footer class="entry-footer">
        <?php emclient_entry_footer(); ?>
    </footer>
</article>
