<?php 
/**
 * Prev/Next navigation for single product
 *
 * @package SimpleMag - WooCommerce child theme
 * @since 	SimpleMag 4.0
**/
?>

<nav class="single-box clearfix nav-single">
    <div class="clearfix nav-previous">
        <?php
        // Get the previous product with thumbnail
        $prev_product = get_previous_post();
        if ( !empty( $prev_product ) ) {
            $prev_product_thumb = get_the_post_thumbnail( $prev_product->ID, 'shop_thumbnail' );
            previous_post_link('%link', '<i class="icomoon-chevron-left"></i>'.$prev_product_thumb.'<span class="sub-title">' . __( 'Previous product', 'themetext' ) . '</span>%title' );
        } 
        ?>
    </div>

    <div class="clearfix nav-next">
        <?php
        // Get the next product with thumbnail
        $next_product = get_next_post();
        if ( !empty( $next_product ) ) {
            $next_product_thumb = get_the_post_thumbnail( $next_product->ID, 'shop_thumbnail' );
            next_post_link('%link', '<i class="icomoon-chevron-right"></i>'.$next_product_thumb.'<span class="sub-title">' . __( 'Next product', 'themetext' ) . '</span>%title' );
        } 
        ?>
    </div>
</nav>