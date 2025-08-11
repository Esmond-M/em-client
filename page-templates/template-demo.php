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

   get_header(); 
   
   ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("em-page-content"); ?>>
	
<section>
	<div class="entry-content">
<button class="btn" data-modal-open="#exampleModal">Open Modal</button>

<!-- Modal -->
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

<!--Modal end -->

<?php
// Example: query latest 12 posts; swap 'post' for 'project' if needed
$q = new WP_Query([
  'post_type'      => 'post',
  'posts_per_page' => 12,
  'ignore_sticky_posts' => true,
]);
?>

<?php if ($q->have_posts()) : ?>
  <section class="container">
    <h2 class="section-title">Recent Work</h2>

    <div class="masonry">
      <?php while ($q->have_posts()) : $q->the_post(); ?>
        <article <?php post_class('masonry__item'); ?>>
          <?php if (has_post_thumbnail()) : ?>
            <a href="<?php the_permalink(); ?>">
              <?php the_post_thumbnail(); ?>
            </a>
          <?php else : ?>
            <a href="<?php the_permalink(); ?>">
              <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/blog-placeholder.jpg'; ?>" alt="No image available" class="featured-img" />
            </a>
          <?php endif; ?>

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
<?php endif; ?>
	</div><!-- .entry-content -->
</section>

	
</article>
<?php get_footer(); ?>