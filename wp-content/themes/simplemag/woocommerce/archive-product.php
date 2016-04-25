<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $ti_option;

get_header( 'shop' ); ?>

    <?php
        /**
        * woocommerce_before_main_content hook
        *
        * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
        * @hooked woocommerce_breadcrumb - 20
        */
        do_action( 'woocommerce_before_main_content' );
    ?>

    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
        <header class="entry-header page-header">
        <div class="page-title wrapper title-with-sep">
            <div class="wrapper">
                <h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>
            </div>
        </div>
        </header>
    <?php endif; ?>

    <?php do_action( 'woocommerce_archive_description' ); ?>

    <?php if ( have_posts() ) : ?>

        <?php
        // Show 2 columns if sidebar appears
        if ( $ti_option['smwc_enable_sidebar'] == '1' ) : ?>

        <div class="grids">
            <div class="grid-8 column-1">

        <?php endif ?>
                

            <?php if ( $ti_option['smwc_product_sorting'] == true ) : ?>
                
                <div class="clearfix order-filter-strip">
                <?php
                    /**
                     * woocommerce_before_shop_loop hook
                     *
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action( 'woocommerce_before_shop_loop' );
                ?>
                </div>
                
            <?php endif ?>

            <?php woocommerce_product_loop_start(); ?>

                <?php woocommerce_product_subcategories(); ?>

                <?php while ( have_posts() ) : the_post(); ?>
                    <?php wc_get_template_part( 'content', 'product' ); ?>
                <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php
                /**
                 * woocommerce_after_shop_loop hook
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action( 'woocommerce_after_shop_loop' );
            ?>

        <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

        <?php wc_get_template( 'loop/no-products-found.php' ); ?>

        <?php endif; ?>

    <?php
        /**
        * woocommerce_sidebar hook
        *
        * @hooked woocommerce_get_sidebar - 10
        */
        if ( $ti_option['smwc_enable_sidebar'] == true ) : ?>
                
            </div><!-- .column-1 -->

            <?php do_action( 'woocommerce_sidebar' ); ?>
        </div><!-- .grids -->

    <?php endif ?>

    <?php
        /**
        * woocommerce_after_main_content hook
        *
        * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
        */
        do_action( 'woocommerce_after_main_content' );
    ?>

<?php get_footer( 'shop' ); ?>