<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	    http://docs.woothemes.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop, $ti_option;

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

        <figure class="entry-image">
            
            <?php
            /**
            * woocommerce_before_subcategory hook.
            *
            * @hooked woocommerce_template_loop_category_link_open - 10
            */
            do_action( 'woocommerce_before_subcategory', $category );

            /**
            * woocommerce_before_subcategory_title hook
            *
            * @hooked woocommerce_subcategory_thumbnail - 10
            */
            do_action( 'woocommerce_before_subcategory_title', $category );

            /**
            * woocommerce_after_subcategory hook.
            *
            * @hooked woocommerce_template_loop_category_link_close - 10
            */
            do_action( 'woocommerce_after_subcategory', $category );
            ?>
            
        </figure>
        
        <div class="entry-details product-details">

            <div class="inner">
                <div class="inner-cell">

                        <header class="entry-header entry-header-category">
                            <h2 class="entry-title">
                                <?php
                                /**
                                 * woocommerce_shop_loop_subcategory_title hook.
                                 *
                                 * @hooked woocommerce_template_loop_category_title - 10
                                 */
                                //do_action( 'woocommerce_shop_loop_subcategory_title', $category );

                                /**
                                 * woocommerce_after_subcategory_title hook.
                                 */
                                //do_action( 'woocommerce_after_subcategory_title', $category );
                                ?>
                                
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

                </div>
            </div>

        </div><!-- product-details -->
        
    </div>
</article>