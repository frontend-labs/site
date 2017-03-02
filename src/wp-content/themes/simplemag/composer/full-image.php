<?php 
/**
 * Full Width Image
 * Page Composer Section
 *
 * @package SimpleMag
 * @since 	SimpleMag 3.0
**/


/**
 * Get image and it's ID and pass it as a class
**/
$get_image_bg = get_sub_field( 'full_image_upload' );
if ( ! empty( $get_image_bg ) ) {
    $image_bg = sanitize_html_class( 'image-' . $get_image_bg['id'] );
}


/**
 * Section styling based on field selection:
 * White, Black or Tint
**/
$section_style = get_sub_field( 'full_image_style' );

if ( $section_style == 'image_bg_white' ) :
    $section_style_class = 'content-over-image-white';
elseif ( $section_style == 'image_bg_black' ) :
     $section_style_class = 'content-over-image-black';
else :
    $section_style_class = 'content-over-image-tint';
endif;

$section_style = sanitize_html_class( $section_style_class );


/**
 * Get the button URL
**/
$button_url = get_sub_field( 'full_image_button_url' );


/**
 * Main & Sub titles
**/
$main_title = get_sub_field( 'full_image_main_title' );
$sub_title = get_sub_field( 'full_image_sub_title' );
?>


<section class="home-section full-width-section title-with-bg full-width-image <?php echo ( isset ( $image_bg ) ? $image_bg : '' ) . ' ' . $section_style; ?>">
    <div class="entry-header">
        <div class="inner">
            <div class="inner-cell">
                <div class="entry-frame">
        
                <?php if ( ! empty( $button_url ) ) { ?>
                    <h2 class="title"><a href="<?php echo esc_url( $button_url ); ?>"><?php echo esc_html( $main_title ); ?></a></h2>
                <?php } else { ?>
                    <h2 class="title"><?php echo esc_html( $main_title ); ?></h2>
                <?php } ?>

                <?php if( $sub_title ): ?>
                <span class="sub-title"><?php echo esc_html( $sub_title ); ?></span>
                <?php endif; ?>

                <?php 
                // Button
                $button_text = get_sub_field( 'full_image_button_text' );

                if ( ! empty( $button_text ) ) {
                    echo '<a class="read-more" href="' . esc_url( $button_url ) . '">' . esc_html( $button_text ) .'</a>';
                }
                ?>

                </div>
                
            </div>
        </div>

    </div>
</section><!-- Full Width Image -->