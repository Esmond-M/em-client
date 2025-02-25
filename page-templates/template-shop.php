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
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$shop_post_args = array(
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 2,
		'paged' => $paged ,
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
			$product_price = $product->get_price();
		
		if($shop_query_count == 1){
		?>
		<div class="number-results">
		<p>Results: <?php echo $shop_post_the_query->found_posts; ?></p>
		</div>	
		<?php	
		}
		
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
			<div class="featured-img" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/product-placeholder.png"?>');"></div>
			<?php
			}
			?>
		  <a href="<?php echo $link;?>" class="product-name"><?php echo $title; ?></a>
		  <p class="product-price">$<?php echo $product_price;?></p>
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
	<div class="pagination">
    <?php 
        echo paginate_links( array(
            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
            'total'        => $shop_post_the_query->max_num_pages,
            'current'      => max( 1, get_query_var( 'paged' ) ),
            'format'       => '?paged=%#%',
            'show_all'     => false,
            'type'         => 'plain',
            'end_size'     => 2,
            'mid_size'     => 1,
            'prev_next'    => true,
            'prev_text'    => sprintf( '<i>←</i> %1$s', __( '', 'em-client' ) ),
            'next_text'    => sprintf( '%1$s <i>→</i>', __( '', 'em-client' ) ),
            'add_args'     => false,
            'add_fragment' => '',
        ) );
    ?>
</div>
	</section> 	<!-- .em-shop-page -->

	
</article>
<?php get_footer(); ?>