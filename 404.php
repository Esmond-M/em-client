
<?php get_header(); ?>

<main id="main" class="site-main em-404-wrapper" style="display:flex;align-items:center;justify-content:center;min-height:70vh;background:#f8f9fa;">
   <section class="em-404-content" style="text-align:center;max-width:500px;padding:2rem;box-shadow:0 2px 16px rgba(0,0,0,0.07);border-radius:12px;background:#fff;">
      <img src="<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/svg/404.svg'); ?>" alt="404 - Page Not Found" style="width:120px;margin-bottom:1.5rem;">
      <h1 style="font-size:2.5rem;margin-bottom:1rem;color:#d9534f;">404</h1>
      <p style="font-size:1.2rem;margin-bottom:1.5rem;color:#333;">Sorry, the page you are looking for does not exist or has been moved.</p>
      <a href="<?php echo esc_url(get_home_url()); ?>" class="em-404-home-btn" style="display:inline-block;padding:0.75rem 2rem;background:#007bff;color:#fff;border:none;border-radius:6px;text-decoration:none;font-size:1rem;transition:background 0.2s;">Go to Home</a>
   </section>
</main>

<?php get_footer(); ?>