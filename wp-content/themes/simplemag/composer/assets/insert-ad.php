<?php
/**
 * Insert Ads in Latest Posts section if
 * Image Ad or Code Ad options are selected.
 * Insert the ad after selected number of posts.
**/


// Enable post count for ads
if ( get_sub_field( 'latest_insert_ad' ) != 'latest_no_ad_option' ) :

    $latest_showad = get_sub_field( 'latest_after_post_ad' );

    if ( $ti_latest_posts->current_post == $latest_showad && ! is_paged() ) :

        echo '<article class="grid-4 post-item post-ad"><div class="post-item-inner">';

            // Image Ad
            if ( get_sub_field( 'latest_insert_ad' ) == 'latest_image_ad_option' ):

                $ad_image = get_sub_field( 'latest_image_ad' );
                $ad_image_link = get_sub_field( 'latest_image_ad_link' );
                if( !empty( $ad_image ) ):
                    $size = 'full';
                    if ( $ad_image_link ){ echo '<a href="' . esc_url( $ad_image_link ) . '">'; }
                        echo wp_get_attachment_image( $ad_image, $size );
                    if ( $ad_image_link ){ echo '</a>'; }
                endif;

            // Code Ad
            elseif ( get_sub_field( 'latest_insert_ad' ) == 'latest_code_ad_option' ):

               echo '<div class="code-ad">' . get_sub_field( 'latest_code_ad' ) . '</div>';

            endif;

        echo '</div></article>';

    endif;

endif;