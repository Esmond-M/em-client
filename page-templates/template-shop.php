<?php
/* Template Name: Shop */
/*
 * Shop Page Template
 *
 * This template displays a WooCommerce shop page with product filtering and pagination.
 * Features:
 * - Product filter sidebar with search and category checkboxes
 * - Displays products with thumbnail, name, price, and add-to-cart button
 * - Handles pagination and shows results count
 * - Uses WP_Query to fetch products and applies filters from GET parameters
 * - Shows placeholder image if product has no thumbnail
 */

get_header();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("em-shop-page"); ?>>
<h1>Shop</h1>

    <!-- Product Filter Sidebar -->
    <aside class="product-filter-sidebar">
        <!-- Product Filter Form -->
        <form role="search" method="get" action="<?php echo the_permalink(); ?>">
            <label class="em-search-label" for="em-search-input-1">Search</label>
            <div class="search-wrapper">
                <input class="search-input" id="em-search-input-1" placeholder="Search products…" value="" type="search" name="product-search">
            </div>
            <ul>
                <?php
                // Get product categories for filter checkboxes
                $categories = get_terms(array(
                    'taxonomy' => 'product_cat',
                    'orderby' => 'name',
                    'order' => 'ASC',
                ));
                ?>
                <?php
                foreach ($categories as $category) {
                    // Check if category is selected in filter
                    $checked = (isset($_GET['product-cate']) && in_array($category->slug, $_GET['product-cate'])) ? "checked" : "";
                    ?>
                    <li>
                        <label>
                            <input type="checkbox" name="product-cate[]" value="<?php echo $category->slug; ?>" <?php echo $checked; ?> />
                            <?php echo $category->name; ?>
                        </label>
                    </li>
                    <?php
                }
                // Optionally handle empty categories
                if (empty($categories)) {
                    // No categories found
                }
                ?>
            </ul>
            <div class="btn-wrappers">
                <a href="<?php echo the_permalink(); ?>"><button aria-label="Reset">Clear</button></a>
                <button aria-label="Filter" type="submit">Filter</button>
            </div>
        </form>
    </aside>

    <!-- Shop Results Section -->
    <section class="shop-results">
        <?php
        // Setup pagination and query arguments
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = 2;
        $shop_post_args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'ASC',
        );

        // Add taxonomy and search filters if set
        if (isset($_GET['product-cate'])) {
            $shop_post_args["tax_query"] = [
                "relation" => "OR",
                [
                    "taxonomy" => "product_cat",
                    "field" => "slug",
                    "terms" => $_GET['product-cate'],
                ]
            ];
            // Add search filter if provided
            if (strlen($_GET['product-search']) > 0 && strlen(trim($_GET['product-search'])) !== 0) {
                $shop_post_args['s'] = EMCLIENT_Theme_Class::em_client_str_wrap_global($_GET['product-search']);
            }
        }

        // Run the product query
        $shop_post_the_query = new WP_Query($shop_post_args);

        // Calculate results count for pagination display
        $total_items = $shop_post_the_query->found_posts;
        $start_item = ($paged - 1) * $posts_per_page + 1;
        $end_item = $start_item + $shop_post_the_query->post_count - 1;
        ?>
        <div class="number-results">
            <p>
                <?php if ($total_items > 0): ?>
                    Items <?php echo $start_item; ?>-<?php echo $end_item; ?> of <?php echo $total_items; ?>
                <?php else: ?>
                    No items found.
                <?php endif; ?>
            </p>
        </div>
        <?php

        // Product Loop
        if ($shop_post_the_query->have_posts()) :
            while ($shop_post_the_query->have_posts()) : $shop_post_the_query->the_post();
                $title = get_the_title();
                $excerpt = get_the_excerpt();
                $link = get_the_permalink();
                $post_id = get_the_ID();
                $shop_category = get_the_category($post_id);
                $shop_post_url_link_value = get_post_meta($post_id, 'portfolio_post_url_link_value', true);
                $product = wc_get_product($post_id);
                $product_url = $product->add_to_cart_url();
                $product_price = $product->get_price();
                ?>
                <div class="product-item">
                    <?php
                    // Product thumbnail or placeholder
                    if (get_the_post_thumbnail_url()) {
                        ?>
                        <div class="featured-img" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>
                        <?php
                    } else {
                        ?>
                        <div class="featured-img" style="background-image: url('<?php echo get_stylesheet_directory_uri() . "/assets/img/product-placeholder.png" ?>');"></div>
                        <?php
                    }
                    ?>
                    <a href="<?php echo $link; ?>" class="product-name"><?php echo $title; ?></a>
                    <p class="product-price">$<?php echo $product_price; ?></p>
                    <a href="<?php echo $product_url ?>" class="product-link"><button>Add to cart</button></a>
                </div>
                <?php
            endwhile;
        else:
            // No products found
            _e('Sorry, no posts matched your criteria.', 'em-client');
        endif;

        // Reset post data after custom query
        wp_reset_postdata();
        ?>

        <!-- Pagination Links -->
        <div class="pagination">
            <?php
            echo paginate_links(array(
                'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                'total'        => $shop_post_the_query->max_num_pages,
                'current'      => max(1, get_query_var('paged')),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => 2,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf('<i>←</i> %1$s', __('', 'em-client')),
                'next_text'    => sprintf('%1$s <i>→</i>', __('', 'em-client')),
                'add_args'     => false,
                'add_fragment' => '',
            ));
            ?>
        </div>
    </section> <!-- .shop-results -->

	
</article>
<?php get_footer(); ?>