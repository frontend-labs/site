<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $woocommerce, $product, $ti_option;
?>

<?php if ( $ti_option['smwc_product_page_slider'] == 'images_slider' ) {
    $product_page_image_class = "global-sliders product-page-slider";
} else {
    $product_page_image_class = "product-page-images";
}
?>

<div class="images">

    <div class="<?php echo esc_attr( $product_page_image_class ); ?>">

        <?php
            if ( has_post_thumbnail() ) {

                $image_title 	= esc_attr( get_the_title( get_post_thumbnail_id() ) );
                $image_caption 	= get_post( get_post_thumbnail_id() )->post_excerpt;
                $image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
                $image       	= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
                    'title'	=> $image_title,
                    'alt'	=> $image_title
                    ) );

                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s">%s</a>', $image_link, $image_caption, $image ), $post->ID );

            } else {

                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

            }
        ?>

        <?php do_action( 'woocommerce_product_thumbnails' ); ?>

    </div>

<?php if ( $ti_option['smwc_product_page_slider'] == 'images_slider' ) :
    $product_page_image_class = "global-sliders product-page-slider";
?>
    <div class="product-slider-thumbs">

        <?php
        $image = get_the_post_thumbnail( $post->ID, apply_filters( '', 'masonry-size' ) );
        echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div>%s</div>', $image ), $post->ID );
        ?>

        <?php
        $attachment_ids = $product->get_gallery_attachment_ids();

        if ( $attachment_ids ) {
            $loop 		= 0;

            foreach ( $attachment_ids as $attachment_id ) {

                $image = wp_get_attachment_image( $attachment_id, apply_filters( '', 'masonry-size' ) );
                echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div>%s</div>', $image ), $attachment_id, $post->ID );

                $loop++;
            }

        } 
        ?>

    </div>
    
<?php endif; ?>
    
</div>

