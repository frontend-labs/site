<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop, $ti_option;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}

if ( $ti_option['smwc_rating_stars'] == '0' ) {
    $classes[] = 'no-rating';
}

if ( $ti_option['smwc_add_cart_button'] == '0' ) {
    $classes[] = 'no-add-cart-button';
}

if ( $woocommerce_loop['loop'] % 2 == 0 ) {
    $classes[] = 'even-post clearfix';
} else {
    $classes[] = 'odd-post clearfix';
}
?>

<article <?php post_class( $classes ); ?>>
    <div class="post-item-inner">

        <?php
        /**
         * woocommerce_before_shop_loop_item hook.
         *
         * @hooked woocommerce_template_loop_product_link_open - 10
         */
        //do_action( 'woocommerce_before_shop_loop_item' );
        ?>
        
        <figure class="entry-image">
            <a href="<?php the_permalink(); ?>">    
                <?php
                /**
                 * woocommerce_before_shop_loop_item_title hook.
                 *
                 * @hooked woocommerce_show_product_loop_sale_flash - 10
                 * @hooked woocommerce_template_loop_product_thumbnail - 10
                 */
                do_action( 'woocommerce_before_shop_loop_item_title' );
                ?>
            </a>
        </figure>

        <div class="entry-details product-details">

            <div class="inner">
                <div class="inner-cell">

                    <header class="entry-header">
        
                        <?php
                        /**
                         * woocommerce_shop_loop_item_title hook.
                         *
                         * @hooked woocommerce_template_loop_product_title - 10
                         */
                        //do_action( 'woocommerce_shop_loop_item_title' );
                        ?>
                        
                        <?php 
                        if ( $ti_option['smwc_category_name'] == '1' ) {
                            $size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
                            echo $product->get_categories( ', ', '<div class="entry-meta"><span class="entry-category">' . _n( '', '', $size, 'woocommerce' ) . ' ', '</span></div>' );
                        } ?>

                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                        <?php
                        /**
                         * woocommerce_after_shop_loop_item_title hook.
                         *
                         * @hooked woocommerce_template_loop_rating - 5
                         * @hooked woocommerce_template_loop_price - 10
                         */
                        do_action( 'woocommerce_after_shop_loop_item_title' );
                        ?>
                        
                    </header>

                    <?php if (( $post->post_excerpt ) && ( $ti_option['smwc_add_excerpt'] == '1' )) {?>
                    <div class="entry-summary" itemprop="description">
                        <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );?>
                    </div>
                    <?php } ?>
                    
                    <?php
                    /**
                     * woocommerce_after_shop_loop_item hook.
                     *
                     * @hooked woocommerce_template_loop_product_link_close - 5
                     * @hooked woocommerce_template_loop_add_to_cart - 10
                     */
                    //do_action( 'woocommerce_after_shop_loop_item' );
                    ?>
                    
                    <?php woocommerce_template_loop_add_to_cart(); ?>

                </div>
            </div>
            
        </div><!-- product-details -->

    </div>
</article>
