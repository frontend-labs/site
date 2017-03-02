<?php 
/**
 * Quote Format
 * Display quote if Quote option was selected in the Format box
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


if ( has_post_thumbnail() ) {
    $quote_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
    $quote_image_bg = 'style="background-image:url(' . esc_url( $quote_image_url[0] ) . ');"';
}
?>

<div class="entry-quote" <?php echo isset( $quote_image_bg ) ? $quote_image_bg : ''; ?>>
        
    <blockquote class="entry-summary">
        <?php the_excerpt(); ?>
    </blockquote>

    <div class="quote-format-title">
        <span itemprop="headline">- <?php the_title(); ?></span>
    </div>
    
</div>