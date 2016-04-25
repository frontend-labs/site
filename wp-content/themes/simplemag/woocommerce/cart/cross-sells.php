<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$crosssells = WC()->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => apply_filters( 'woocommerce_cross_sells_total', $posts_per_page ),
	'orderby'             => $orderby,
	'post__in'            => $crosssells,
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = apply_filters( 'woocommerce_cross_sells_columns', $columns );

if ( $products->have_posts() ) : ?>
    
	<div class="single-box related-posts cross-sells">

		<h3 class="title single-box-title"><?php _e( 'You may be interested in&hellip;', 'woocommerce' ); ?></h3>
        
        <div class="grids entries">
            <div class="carousel">
				<?php while ( $products->have_posts() ) : $products->the_post(); ?>
                    
                    <div class="item">
                        <figure class="entry-image">
                          <a href="<?php the_permalink(); ?>">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'masonry-size' );
                            } elseif( first_post_image() ) { // Set the first image from the editor
                                echo '<img src="' . first_post_image() . '" class="wp-post-image" />';
                            } ?>
                          </a>
                        </figure>
                        <header class="entry-header">
                            <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            <?php woocommerce_template_loop_price(); ?>
                        </header>
                    </div>
                    
                <?php endwhile; // end of the loop. ?>
        	</div>
		</div>
        
	</div><!-- #related-products -->

<?php endif;

wp_reset_query();
