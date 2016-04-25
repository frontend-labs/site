<?php 
/**
 * Single Post - Gallery (Carousel) format
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.3
**/ 

/**
 * Check if gallery was uploaded
**/
if( get_field( 'post_upload_gallery' ) ) : ?>

    <?php 
    /**
     * Output the gallery when Above The Conetnt option 
     * is selected in Theme Options site wide or per post
    **/
    global $ti_option;

    if (   $ti_option['single_media_position'] == 'useperpost' 
        && get_post_meta( $post->ID, 'post_media_position', true ) == 'media_above_content'
        || $ti_option['single_media_position'] == 'abovecontent' ) :
    ?>
    
        <?php
        // Output the uploaded images as gallery
        $images = get_field( 'post_upload_gallery' );
        ?>

        <div class="above-content-slider-container">

            <div class="above-content-slider">

            <?php
            if ( $images ):
                foreach( $images as $image ):

                    if ( !empty ( $image['caption'] ) ) {
                        $alt = $image['caption'];
                    } elseif ( !empty ( $image['alt'] ) ) {
                        $alt = $image['alt'];
                    } else {
                        $alt = $image['title'];
                    }

                    $img_src = $image['sizes']['gallery-carousel'];
                    $img_width = $image['sizes']['gallery-carousel-width'];
                    $img_height = $image['sizes']['gallery-carousel-height'];

                    echo '<div class="gallery-item">
                            <figure>
                                <img src="' . esc_url( $img_src ) . '" alt="' . esc_attr( strip_tags( $alt ) ) . '" width="' . esc_attr( $img_width ) . '" height="' . esc_attr( $img_height ) . '" />';
                   echo'    </figure>
                        </div>';

                endforeach;
            endif;
            ?>

            </div><!-- Gallery Above: Images -->

            <div class="above-content-caption">
                <?php
                // Display Image caption and/or description if exists
                if ( $images ):
                    foreach( $images as $image ):

                    echo '<div>';
                         if ( $image['caption'] ) {
                                echo '<figcaption class="image-caption-bottom">' . $image['caption'] . '</figcaption>';
                            }
                            if ( $image['description'] ) {
                                echo '<div class="image-desc-bottom">' . $image['description'] . '</div>';
                            }
                    echo '</div>';

                    endforeach;
                endif;
                ?>
            </div><!-- Gallery Above: Captions -->
            
        </div><!-- Gallery Above Container -->


    <?php 
    /**
     * Output the gallery full width
    **/
    else : ?>

        <div id="gallery-carousel" class="global-sliders">
            <?php
            // Output the uploaded images as gallery
            $images = get_field( 'post_upload_gallery' );

            if ( $images ):
                foreach( $images as $image ):

                    if ( !empty ( $image['caption'] ) ) {
                        $alt = $image['caption'];
                    } elseif ( !empty ( $image['alt'] ) ) {
                        $alt = $image['alt'];
                    } else {
                        $alt = $image['title'];
                    }

                    $img_src = $image['sizes']['gallery-carousel'];
                    $img_width = $image['sizes']['gallery-carousel-width'];
                    $img_height = $image['sizes']['gallery-carousel-height'];

                    echo '<div class="gallery-item">
                            <figure>
                                <img src="' . esc_url( $img_src ) . '" alt="' . esc_attr( strip_tags( $alt ) ) . '" width="' . esc_attr( $img_width ) . '" height="' . esc_attr( $img_height ) . '" />';
                                if ( $image['caption'] ) {
                                  echo '<span class="icon"></span><figcaption class="image-caption">' . $image['caption'] . '</figcaption>';
                                }
                            echo'
                            </figure>
                        </div>';

                endforeach;
            endif;
            ?>
        </div><!-- Gallery Full Width -->

    <?php endif; // Gallery Full Width or Above The Content ?>

<?php endif; // Check if gallery was uploaded ?>