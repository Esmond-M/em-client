
<?php
/* Template Name: Demo */
/*
 * Demo Page Template
 *
 * This template displays a demo page with various content blocks.
 * Features:
 * - Hero section with background image and call-to-action button
 * - Three-column layout for showcasing features or services
 * - Testimonials section with client quotes and ratings
 * - Contact form section for user inquiries
 */

get_header('');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("em-page-content"); ?>>
  <!-- =========================
       Hero Section
  ========================= -->
  <section
    class="hero"
    style="background-image: url('<?php echo esc_url(get_stylesheet_directory_uri() . '/assets/img/hero-bg.jpg'); ?>');"
  >
    <div class="hero__overlay"></div>
    <div class="hero__content container">
      <h1 class="hero__title">Build Your Future with WordPress</h1>
      <p class="hero__subtitle">
        Custom, fast, and secure websites tailored to your business.
      </p>
      <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn--primary btn--lg">
        Get Started
      </a>
    </div>
  </section>

  <!-- =========================
       Main Content Section
  ========================= -->
  <section>
    <div class="entry-content">
      <!-- Modal Trigger Button -->
      <button class="btn" data-modal-open="#exampleModal">Open Modal</button>

      <!-- =========================
           Modal Component
      ========================= -->
      <div id="exampleModal" class="modal" aria-hidden="true">
        <div class="modal__overlay" data-modal-close></div>
        <div
          class="modal__dialog"
          role="dialog"
          aria-modal="true"
          aria-labelledby="modal-title"
          aria-describedby="modal-desc"
        >
          <header class="modal__header">
            <h2 id="modal-title" class="modal__title">Subscribe</h2>
            <button class="modal__close" aria-label="Close dialog" data-modal-close>&times;</button>
          </header>
          <div id="modal-desc" class="modal__body">
            <p>Join our newsletter for WordPress tips.</p>
            <form>
              <label class="field">
                <span>Email</span>
                <input type="email" required />
              </label>
              <button class="btn btn--primary">Subscribe</button>
            </form>
          </div>
        </div>
      </div>
      <!-- End Modal Component -->

      <?php
      // Query latest 12 posts; swap 'post' for 'project' if needed
      $masonryQuery = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => 12,
        'ignore_sticky_posts' => true,
      ]);
      ?>

      <?php if ($masonryQuery->have_posts()) : ?>
        <!-- =========================
             Masonry Grid of Recent Posts
        ========================= -->
        <section class="container">
          <h2 class="section-title">Recent Work</h2>
          <div class="masonry">
            <?php while ($masonryQuery->have_posts()) : $masonryQuery->the_post(); ?>
              <article <?php post_class('masonry__item'); ?>>
                <!-- Featured Image or Placeholder -->
                <?php if (has_post_thumbnail()) : ?>
                  <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail(); ?>
                  </a>
                <?php else : ?>
                  <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/blog-placeholder.jpg'; ?>" alt="No image available" class="featured-img" />
                  </a>
                <?php endif; ?>

                <!-- Post Content -->
                <div class="masonry__content">
                  <h3 class="masonry__title">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h3>
                  <div class="masonry__meta"><?php echo get_the_date(); ?></div>
                  <p><?php echo wp_trim_words(get_the_excerpt(), 22, '…'); ?></p>
                  <a class="btn btn--primary" href="<?php the_permalink(); ?>">Read more</a>
                </div>
              </article>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        </section>
        <!-- End Masonry Grid -->
      <?php endif; ?>
    </div><!-- .entry-content -->
  </section>


<!-- =========================
     Demo Slick Slider (Posts)
========================= -->
<div class="demo-slider">
  <?php
  $sliderQuery = new WP_Query([
    'post_type'      => 'post',
    'posts_per_page' => 6,
    'ignore_sticky_posts' => true,
    'orderby'        => 'date',
    'order'          => 'DESC',
  ]);
  if ($sliderQuery->have_posts()) :
    while ($sliderQuery->have_posts()) : $sliderQuery->the_post();
      $image_url = has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'large') : get_stylesheet_directory_uri() . '/assets/img/blog-placeholder.jpg';
  ?>
    <div class="slider-item">
      <a href="<?php the_permalink(); ?>">
        <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>" />
      </a>
      <div class="slider-caption">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo wp_trim_words(get_the_excerpt(), 18, '…'); ?></p>
      </div>
    </div>
  <?php
    endwhile;
    wp_reset_postdata();
  endif;
  ?>
</div>

</article>
<?php get_footer(); ?>