<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $ti_option, $product;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Stick/Unstick Product Details
if ( $ti_option['smwc_product_page_slider'] == 'images_list' ) {
    $sticky_product_details = ' sticky-product-details';
}

?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<?php
/**
 * Displays the product title Full Width
**/
if ( $ti_option['smwc_single_title_position'] == 'fullwidth' ) {
?>

<header class="wrapper entry-header page-header">
    <div class="page-title title-with-sep single-title single-title-full">
        <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
    </div>
</header>
<?php } ?>

<article itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="grids single-product-columns">
        <div class="grid-7 column-1">
            <div class="single-product-image">
            <?php
                /**
                 * woocommerce_before_single_product_summary hook
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action( 'woocommerce_before_single_product_summary' );
            ?>
            </div>
        </div><!-- .grid-6 -->

        <div class="grid-5 column-2<?php echo isset( $sticky_product_details ) ? $sticky_product_details : ''; ?>">       
            <?php
                /**
                 * woocommerce_single_product_summary hook
                 *
                 * @hooked woocommerce_template_single_title - 5
                 * @hooked woocommerce_template_single_rating - 10
                 * @hooked woocommerce_template_single_price - 10
                 * @hooked woocommerce_template_single_excerpt - 20
                 * @hooked woocommerce_template_single_add_to_cart - 30
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 */
                //do_action( 'woocommerce_single_product_summary' );
            ?>
            
            <div class="single-product-details">

                <?php
                /**
                 * Displays the product title Above The Content
                **/
                if ( $ti_option['smwc_single_title_position'] == 'abovecontent' ) {
                ?>
                <div class="page-title single-title above-content-title">
                    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                </div>
                <?php } ?>
                
                <?php woocommerce_template_single_price(); ?>
                
                <?php woocommerce_show_product_sale_flash(); ?>

                <div class="entry-content">
                    <?php woocommerce_template_single_excerpt(); ?>
                </div>

                <?php woocommerce_template_single_meta(); ?>

                <?php woocommerce_template_single_add_to_cart(); ?>

                <?php woocommerce_template_single_sharing(); ?>

                <?php //get_template_part( 'inc/single', 'share' ); ?>

            </div><!-- .single-product-details -->
        </div><!-- .grid-6 -->
    </div><!-- .grids -->

    <?php
        /**
         * woocommerce_after_single_product_summary hook
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        //do_action( 'woocommerce_after_single_product_summary' );
        woocommerce_output_product_data_tabs();
    ?>
    
    
    <div class="single-box tab-box related-posts-tabs">

        <ul class="tab-box-button clearfix">
            
            <li><a href="#related-posts"><?php _e( 'Related Products', 'woocommerce' ); ?></a></li>
            
            <?php // Hide the button if there no upsells products
            $upsells = $product->get_upsells();

            if (count($upsells) > 0) { ?>
                <li><a href="#upsell-posts"><?php _e( 'You may be interested in&hellip;', 'woocommerce' ); ?></a></li>
            <?php } ?>
            
        </ul>

        <div class="tab-box-content">
            <div id="related-posts">
                <?php woocommerce_output_related_products(); ?>
            </div>
            <div id="upsell-posts">
                <?php woocommerce_upsell_display(); ?>
            </div>
        </div>
        
    </div>

    <?php //get_template_part( 'woocommerce/inc/product', 'nav' ); ?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />
</article><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
