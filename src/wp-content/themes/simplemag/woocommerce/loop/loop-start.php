<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

global $ti_option;
    
$smwc_layout_field = $ti_option['smwc_page_layout'];
$smwc_product_overlay = $ti_option['smwc_description_on_image'] == true;

if ( $smwc_layout_field == 'masonry-layout' && $smwc_product_overlay ) {
    $product_layout_class = 'grids masonry-layout details-hover';
} elseif ( $smwc_layout_field == 'masonry-layout' ) {
    $product_layout_class = 'grids masonry-layout';
} elseif ( $smwc_layout_field == 'grid-layout' && $smwc_product_overlay ) {
    $product_layout_class = 'grids grid-layout columns-3 details-hover';
} elseif ( $smwc_layout_field == 'grid-layout' ) {
    $product_layout_class = 'grids grid-layout columns-3';
} elseif ( $smwc_layout_field == 'list-layout' ) {
    $product_layout_class = 'list-layout';
} elseif ( $smwc_layout_field == 'classic-layout' ) {
    $product_layout_class = 'classic-layout';
} elseif ( $smwc_layout_field == 'asym-layout' ) {
    $product_layout_class = 'asym-layout';
}
?>

<div class="entries <?php echo $product_layout_class; ?>">