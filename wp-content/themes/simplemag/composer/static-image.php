<?php 
/**
 * Static Image
 * Page Composer Section
 *
 * @package SimpleMag
 * @since 	SimpleMag 2.0
**/
?>

<section class="wrapper home-section advertising">
<?php
$image = get_sub_field( 'ad_banner_url' );
$image_link = get_sub_field( 'ad_banner_link' );

// Output the image
if ( !empty( $image ) ) {
	if (  !empty( $image_link ) ) {
		if ( get_sub_field( 'static_image_mode' ) == 'static_image_banner' ) {
			$new_window = 'target="_blank"'; 
		} else {
			$new_window = '';
		}
		echo '<a href="' . esc_url( $image_link ) . '"' . $new_window . '>';
	}
	echo '<figure class="base-image">
	<img src="' . esc_url( $image['url'] ) . '" alt="' . esc_attr( $image['alt'] ) . '" width="' . esc_attr( $image['width'] ) . '" height="' . esc_attr( $image['height'] ) . '" />';
	if ( $image['caption'] ) {
		echo '<span class="icon"></span><figcaption class="image-caption">' . $image['caption'] . '</figcaption>';
	}
	echo '</figure>';
	if (  !empty( $image_link ) ) { echo '</a>'; }
}
?>
</section><!-- Static Image -->