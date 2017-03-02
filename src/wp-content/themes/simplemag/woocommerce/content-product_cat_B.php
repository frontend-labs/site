<?php
/**
 * The template for displaying product category thumbnails within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product_cat.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
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

// Increase loop count
$woocommerce_loop['loop'] ++;

// Extra post classes
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

        <?php do_action( 'woocommerce_before_subcategory', $category ); ?>

            <figure class="entry-image">
                <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
                    <?php
                        /**
                         * woocommerce_before_subcategory_title hook
                         *
                         * @hooked woocommerce_subcategory_thumbnail - 10
                         */
                        do_action( 'woocommerce_before_subcategory_title', $category );
                    ?>
                </a>
            </figure>
        
            <div class="entry-details product-details">

            <div class="inner">
                <div class="inner-cell">

                        <header class="entry-header entry-header-category">
                            <h2 class="entry-title">
                                <a href="<?php echo get_term_link( $category->slug, 'product_cat' ); ?>">
                                    <?php
                                        echo $category->name;

                                        if ( $category->count > 0 ) {
                                            echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
                                        }
                                    ?>
                                </a>
                            </h2>
                        </header>

                        <?php
                            /**
                             * woocommerce_after_subcategory_title hook
                             */
                            do_action( 'woocommerce_after_subcategory_title', $category );
                        ?>

                    <?php do_action( 'woocommerce_after_subcategory', $category ); ?>

                </div>
            </div>
                
        </div><!-- product-details -->
    </div>
</article>
