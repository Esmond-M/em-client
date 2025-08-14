
<?php
// Front page main content template part
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('em-front-page-content'); ?> role="main" aria-label="Front Page Content">
    <!-- Intro Section -->
    <section class="intro" aria-labelledby="front-intro-title">
        <h1 id="front-intro-title">Boilerplate WordPress Theme</h1>
        <p>Theme setup with a basic structure to be improved upon per client.</p>
        <figure class="bg-img" style="background-image: url('<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/front-page-placeholder.jpg'); ?>');" aria-label="Theme Preview Image">
            <!-- Decorative background image for intro section -->
        </figure>
    </section>

    <!-- Features Section -->
    <section class="features" aria-labelledby="front-features-title">
        <h2 id="front-features-title">Features</h2>
        <div class="em-container" style="display:flex;flex-wrap:wrap;gap:2rem;">
            <!-- Feature: Customization -->
            <article class="feature-item" aria-label="Customization">
                <h3 class="title"><?php _e('Customization', 'em-client'); ?></h3>
                <p class="description"><?php _e('Straightforward template structure. Convenient NPM commands for automated processes.', 'em-client'); ?></p>
            </article>
            <!-- Feature: WooCommerce Compatibility -->
            <article class="feature-item" aria-label="WooCommerce Compatibility">
                <h3 class="title"><?php _e('WooCommerce Compatibility', 'em-client'); ?></h3>
                <p class="description"><?php _e('WooCommerce compatibility. Includes pre-built features with easily updated template files.', 'em-client'); ?></p>
            </article>
            <!-- Feature: Sass Files -->
            <article class="feature-item" aria-label="Sass Files">
                <h3 class="title"><?php _e('Sass Files', 'em-client'); ?></h3>
                <p class="description"><?php _e('All the conveniences of using Sass. Variables that can be easily updated, etc.', 'em-client'); ?></p>
            </article>
        </div>
    </section>
</article>
