<?php
   /* Template Name: Shop*/ 
   get_header(); 
   
   ?>
<article id="post-<?php the_ID(); ?>" <?php post_class("em-shop-page"); ?>>
<h1>Shop</h1>
    <aside class="product-filter-sidebar">
	
	<form role="search" method="get" action="<?php echo the_permalink();?>">
		<label class="em-search-label" for="em-search-input-1">Search</label>
		<div class="search-wrapper ">
		<input class="search-input" id="em-search-input-1" placeholder="Search products…" value="" type="search" name="product-search" >
	    </div>
		<ul> 
		<?php
        $categories = get_terms( array(
			'taxonomy' => 'product_cat', 
			'orderby' => 'name',
			'order' => 'ASC',
	   ) );
    ?>	
    <?php
	   foreach( $categories as $category ) {
		?> 
		<li>
			<label>
			<input type="checkbox" <?php if ( in_array($category->slug, $_GET['product-cate'])  ) echo 'checked="checked"" '; ?> value="<?php echo $category->slug ; ?>" name="product-cate[]">
			<?php echo $category->name; ?></label>
		</li> 
	   <?php
	   } 


		
		?>
		</ul> 
		<div class="btn-wrappers">
		<a href="<?php echo the_permalink();?>"><button aria-label="Reset" >Clear</button></a>
		<button aria-label="Filter" type="submit">Filter</button>	
		</div>

    </form>	

	</aside>

	<section class="shop-results">
		
		<?php
	function em_client_str_wrap_global($string = '', $char = '"')
	{
		return str_pad($string, strlen($string) + 2, $char, STR_PAD_BOTH);
	}

		$shop_post_args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 8,
		'orderby'   => 'date',
			'order' => 'ASC',
		);
		if(isset($_GET['product-cate'])){
			
			$shop_post_args["tax_query"] = [
				"relation" => "OR",
				[
					"taxonomy" => "product_cat",
					"field" => "slug",
					"terms" => $_GET['product-cate'],
				]
			];
		}
		if ( strlen($_GET['product-search']) > 0 && strlen(trim($_GET['product-search'])) !== 0) { 
			$shop_post_args['s'] = em_client_str_wrap_global($_GET['product-search']) ;
	
		}

		$shop_post_the_query = new WP_Query($shop_post_args);
		if ( $shop_post_the_query->have_posts() ) :

		$shop_query_count = 1;
		while ( $shop_post_the_query->have_posts() ) : $shop_post_the_query->the_post();
			// Start the Loop
			$title = get_the_title();
			$excerpt = get_the_excerpt();
			$link = get_the_permalink();
			$post_id = get_the_ID();
			$shop_category = get_the_category($post_id);
			$shop_post_url_link_value = get_post_meta($post_id, 'portfolio_post_url_link_value', true);
			$product = wc_get_product($post_id);
			$product_url = $product->add_to_cart_url();
			?>
        <div class="product-item">
		  <?php
		if( get_the_post_thumbnail_url() ){

			?>
			<div class="featured-img" style="background-image: url('<?php echo get_the_post_thumbnail_url();?>');"> 
			</div>
			<?php
			}

			else{
			?>	
			<div class="featured-img" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/blog-placholder.jpg"?>');"></div>
			<?php
			}
			?>
		  <p class="product-name"><?php echo $title; ?></p>
		  <a href="<?php echo $product_url ?>" class="product-link"><button >Add to cart</button></a>	
		</div>	
		<?php
		$shop_query_count++;
		endwhile;
		else:
		// If no posts match this query, output this text.
		_e( 'Sorry, no posts matched your criteria.', 'em-client' );
		endif; 

		wp_reset_postdata();

		?> 

	</section> 	<!-- .em-shop-page -->

	
</article>
<?php get_footer(); ?>