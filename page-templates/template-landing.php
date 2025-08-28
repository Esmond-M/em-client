<?php
/*
Template Name: Landing Page
*/
get_header();
?>

<div id="primary" class="content-area em-landing-page">
    <main id="main" class="site-main">
        <?php
        while ( have_posts() ) : the_post();
            // Page title 
            echo '<h1 class="em-landing-title">' . get_the_title() . '</h1>';

            // Featured image 
            if ( has_post_thumbnail() ) {
                echo '<div class="em-landing-featured-image">';
                the_post_thumbnail('large');
                echo '</div>';
            }

            // Main content
            the_content();

            // Example: Call to Action section
            ?>
            <section class="em-landing-cta">
                <h2>Ready to get started?</h2>
                <a href="<?php echo esc_url( home_url('/contact') ); ?>" class="em-cta-btn">Contact Us</a>
            </section>
            <?php

            // Widget area 
            if ( is_active_sidebar( 'landing-page-widgets' ) ) {
                echo '<aside class="em-landing-widgets">';
                dynamic_sidebar( 'landing-page-widgets' );
                echo '</aside>';
            }
        endwhile;
        ?>
    </main>
</div>

<?php get_footer(); ?>