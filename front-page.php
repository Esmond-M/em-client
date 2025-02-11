<?php
   get_header(); 
   
   ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("em-page-content"); ?> >
   <section>
      <div class="entry-content">
      </div>
      <!-- .entry-content -->
   </section>
   <section id="em-portfolio-home-slider-section">
      <div id="em-portfolio-inner-contain">
      </div>
   </section>
   <section id="about" class="em-portfolio-about-us-section">
      <div class="upwork-btn-area">
         <a target="_blank" href="https://www.upwork.com/o/profiles/users/_~01bc262783a150ad5c/">
         <button class="upwork-btn">upwork reviews</button>		</a>
      </div>
      <h1 class="em-name"><b>Esmond MCcain</b></h1>
      <h4 class="em-site-font-color">Full-stack Web Developer</h4>
      <ul class="em-social-icons">
         <li>
            <a rel="noopener noreferrer" target="_blank" href="https://www.linkedin.com/in/esmond-m-a17244129/"><i class="fab fa-linkedin"></i></a>
         </li>
         <li>
            <a rel="noopener noreferrer" target="_blank" href="https://www.upwork.com/o/profiles/users/_~01bc262783a150ad5c/"><img class="upwork-svg-icon" src="<?php echo get_stylesheet_directory_uri(); ?>\img\svg\upwork.svg" alt="Esmond Upwork Portfolio"></a>
         </li>
         <li>
            <a rel="noopener noreferrer" target="_blank" href="https://github.com/Esmond-M"><i class="fab fa-github"></i></a>
         </li>
      </ul>
   </section>
   <section class="em-portfolio-about-us-section-second">
      <div class="em-portfolio-about-sec wow zoomIn" data-wow-duration="1s" data-wow-delay="0.1s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.1s; animation-name: zoomIn;">
         <div class="em-portfolio-content">
            <h2 id="about" class="em-portfolio-section-title">About</h2>
            <p style="color: black; text-align: center;font-size:17px;"><strong>I work with different web agencies on a contract/full-time basis. I have quite a bit of experience collaborating with both different team members and clients to complete projects. I am currently working in the “LAMP/WordPress” stack but am branching out to learn more JavaScript frameworks like React for example. If you wish to contact me please message me through my email at esmondmccain@gmail.com or through <a class="gen-link" href="https://www.upwork.com/o/profiles/users/_~01bc262783a150ad5c/">upwork</a>.</strong></p>
         </div>
         <div class="em-portfolio-progress-bar-sec">
            <div class="em-portfolio-progress em-portfolio-progress-count1">
               <h6>WORDPRESS THEME DEVELOPMENT</h6>
               <div class="em-portfolio-progress-bar">
                  <div class="em-portfolio-progress-bar-length" data-width="100" style="width: 100%; visibility: visible;">
                     100%							
                  </div>
               </div>
            </div>
            <div class="em-portfolio-progress em-portfolio-progress-count2">
               <h6>WORDPRESS PLUGIN DEVELOPMENT</h6>
               <div class="em-portfolio-progress-bar">
                  <div class="em-portfolio-progress-bar-length" data-width="100" style="width: 100%; visibility: visible;">
                     100%							
                  </div>
               </div>
            </div>
            <div class="em-portfolio-progress em-portfolio-progress-count3">
               <h6>PHP &amp; BACKEND DEVELOPMENT</h6>
               <div class="em-portfolio-progress-bar">
                  <div class="em-portfolio-progress-bar-length" data-width="100" style="width: 100%; visibility: visible;">
                     100%							
                  </div>
               </div>
            </div>
            <div class="em-portfolio-progress em-portfolio-progress-count4">
               <h6>FRONTEND DEVELOPMENT</h6>
               <div class="em-portfolio-progress-bar">
                  <div class="em-portfolio-progress-bar-length" data-width="100" style="width: 100%; visibility: visible;">
                     100%							
                  </div>
               </div>
            </div>
            <div class="em-portfolio-progress em-portfolio-progress-count5">
               <h6>TEAM COLLABORATION</h6>
               <div class="em-portfolio-progress-bar">
                  <div class="em-portfolio-progress-bar-length" data-width="100" style="width: 100%; visibility: visible;">
                     100%							
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section id="em-portfolio-portfolio-section" >
      <h2 id="portfolio" class="em-portfolio-section-title wow fadeInUp" data-wow-duration="0.2s" style="visibility: visible; animation-duration: 0.2s; animation-name: fadeInUp;">Portfolio</h2>
	  <div class="controls">
				<button type="button" class="control mixitup-control-active" data-filter="all">All</button>
				<button type="button" class="control" data-filter=".react">React</button>
				<button type="button" class="control" data-filter=".wordpress">WordPress</button>
	</div>

	  <div class="em-modal-container"  >
     <?php
            $portfolio_post_args = array(
            	'post_type' => 'esmond-portfolio',
            	'post_status' => 'publish',
            	'posts_per_page' => 9,
            	'orderby'   => 'date',
                   'order' => 'ASC',
            
            );
            
            // Variable to call WP_Query.
            $portfolio_post_the_query = new WP_Query($portfolio_post_args);
            if ( $portfolio_post_the_query->have_posts() ) :
            	// Start the Loop
               $portfolio_query_count = 1;
            	while ( $portfolio_post_the_query->have_posts() ) : $portfolio_post_the_query->the_post();
            		// Start the Loop
            			$title = get_the_title();
            			$excerpt = get_the_excerpt();
            			$post_id = get_the_ID();
                     $portfolio_featuredimg = get_the_post_thumbnail_url();
                     $portfolio_category = get_the_category($post_id);
            			$portfolio_post_url_link_value = get_post_meta($post_id, 'portfolio_post_url_link_value', true);
                     $portfolio_post_popup_target_id_value = get_post_meta($post_id, 'portfolio_post_popup_target_id_value', true);
            			?>
 			<div class="em-modal modal-<?php echo $portfolio_query_count;?> mix <?php echo strtolower($portfolio_category[1]->name);?>">
				<div class="em-modal-inner">
					<img src="<?php echo $portfolio_featuredimg;?>"/>
					<div class="em-modal-caption">
						<h4><?php echo $title;?></h4>
						<div class="em-modal-btn-contain">
						<a class="em-portfolio-portfolio-link" href="<?php echo $portfolio_post_url_link_value;?>" target="_blank" rel="noopener noreferrer">
						<button type="button">Visit</button>
					    </a>
						<a id="<?php echo $portfolio_post_popup_target_id_value;?>" class="em-portfolio-portfolio-image" style="cursor: pointer;">
						<button class="port-detail-btn" type="button">Details</button>
					    </a>
						</div>

					</div>
				</div>	
			</div>
         <?php
            $portfolio_query_count++;
            endwhile;
            else:
            // If no posts match this query, output this text.
            	_e( 'Sorry, no posts matched your criteria.', 'em-client' );
            endif; 
            
            // If no posts match this query, output this text. 
            wp_reset_postdata();
            
            ?> 
	  </div>
   </section>
   <section id="em-portfolio-featured-post-section" >
      <div class="em-portfolio-container">
      <h2 id="services" class="em-portfolio-section-title wow fadeInUp" data-wow-duration="0.5s" style="visibility: visible; animation-duration: 0.5s; animation-name: fadeInUp;">
         Services
      </h2>
      <div class="em-portfolio-featured-post-wrap em-portfolio-clearfix">
         <?php
            $services_post_args = array(
            	'post_type' => 'esmond-services',
            	'post_status' => 'publish',
            	'posts_per_page' => 3,
            	'orderby'   => 'date',
                   'order' => 'ASC',
            
            );
            
            // Variable to call WP_Query.
            $services_post_the_query = new WP_Query($services_post_args);
            if ( $services_post_the_query->have_posts() ) :
            	// Start the Loop
               $services_query_count = 1;
            	while ( $services_post_the_query->have_posts() ) : $services_post_the_query->the_post();
            		// Start the Loop

            
            			$title = get_the_title();
            			$excerpt = get_the_excerpt();
            			$post_id = get_the_ID();
            			$meta = get_post_meta($post_id, 'services_post_icon_class_value', true);
            			?>
         <div class="em-portfolio-featured-post em-portfolio-featured-post-<?php echo $services_query_count;?> wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0s" style="visibility: visible; animation-duration: 0.5s; animation-delay: 0s; animation-name: fadeInLeft;">
            <div class="em-portfolio-featured-icon"><i class="<?php echo $meta; ?>"></i></div>
            <h3><?php echo $title; ?></h3>
            <div class="em-portfolio-featured-excerpt"><?php echo get_the_excerpt(); ?></div>
         </div>
         <?php
            $services_query_count++;
            endwhile;
            else:
            // If no posts match this query, output this text.
            	_e( 'Sorry, no posts matched your criteria.', 'em-client' );
            endif; 
            
            // If no posts match this query, output this text. 
            wp_reset_postdata();
            
            ?> 
      </div>
   </section>

   <section class="em-portfolio-contact-section" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/img/bg.jpg"?>');">

   <div class="em-portfolio-contact-overlay"> 
        <h2 class="em-contact-section-title wow fadeInUp" data-wow-duration="0.5s" style="visibility: visible; animation-duration: 0.5s; animation-name: fadeInUp;">Contact</h2>
        <div class="em-portfolio-contact-form">
         <?php echo do_shortcode( '[gravityform id="1" title="false" description="false" ajax="true"]' );?>
        </div> 
   </div>
   </section>
</article>
<?php get_footer(); ?>