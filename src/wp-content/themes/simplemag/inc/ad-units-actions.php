<?php 
/**
 * Actions for Ad Units
 * Seetings for all ads are located in:
 * Theme Options, Ad Units tab.
 *
 * Ads are displayed in: Header, Footer, 
 * Single Post above and below the content
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


/**
 * All Actions
**/
add_action( 'header_ad', 'main_header_ad_unit' );
add_action( 'single_post_above_content_ad', 'single_post_above_content_ad_unit' );
add_action( 'single_post_below_content_ad', 'single_post_below_content_ad_unit' );
add_action( 'footer_ad', 'main_footer_ad_unit' );




/**
 * Header Ad
**/
function main_header_ad_unit() {
        
        global $ti_option;
    
        $header_ad = $ti_option['header_image_ad'];
        // Image Ad
        if ( $header_ad['url'] == true ) : 
        ?>

        <div class="inner-cell">
            <div class="ad-block">
                <a href="<?php echo esc_url( $ti_option['header_image_ad_url'] ); ?>" rel="nofollow" target="_blank">
                    <img src="<?php echo esc_url( $header_ad['url'] ); ?>" width="<?php echo esc_attr( $header_ad['width'] ); ?>" height="<?php echo esc_attr( $header_ad['height'] ); ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                </a>
             </div>
        </div>
        
		<?php 
        // Code Ad
        elseif( $ti_option['header_code_ad'] == true ) :
        ?>

        <div class="inner-cell">
            <div class="ad-block">
        		<?php echo $ti_option['header_code_ad']; ?>
             </div>
        </div>

		<?php endif;
    
} // End Header Ad



/**
 * Single Post ad above the content
**/
function single_post_above_content_ad_unit() {
        
        global $ti_option;
    
        if ( $ti_option['single_image_top_ad']['url'] == true || ! empty ( $ti_option['single_code_top_ad'] ) ) :
        ?>

            <div class="advertisement">

                <?php
                // Image Ad
                $single_banner_top = $ti_option['single_image_top_ad'];

                if ( $single_banner_top['url'] == true ) { ?>

                    <a href="<?php echo esc_url( $ti_option['single_image_top_ad_url'] ); ?>" rel="nofollow" target="_blank">
                        <img src="<?php echo esc_url( $single_banner_top['url'] ); ?>" width="<?php echo esc_attr( $single_banner_top['width'] ); ?>" height="<?php echo esc_attr( $single_banner_top['height'] ); ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                    </a>

                <?php                           
                // Code Ad
                } elseif( $ti_option['single_code_top_ad'] == true ) {

                    echo $ti_option['single_code_top_ad'];
                    
                }
                ?>

            </div><!-- .advertisment -->

        <?php endif;

} // Single Post above the content ad




/**
 * Single Post ad below the content
**/
function single_post_below_content_ad_unit() {
        
        global $ti_option;
    
        // Ad Unit
        if ( $ti_option['single_image_bottom_ad']['url'] == true || ! empty ( $ti_option['single_code_bottom_ad'] ) ) : 
        ?>

            <div class="single-box advertisement">
                
                <?php
                // Image Ad
                $single_banner_botom = $ti_option['single_image_bottom_ad'];
            
                if ( $ti_option['single_image_bottom_ad']['url'] == true ) { ?>
                
                    <a href="<?php echo esc_url( $ti_option['single_image_bottom_ad_url'] ); ?>" rel="nofollow" target="_blank">
                        <img src="<?php echo esc_url( $single_banner_botom['url'] ); ?>" width="<?php echo esc_attr( $single_banner_botom['width'] ); ?>" height="<?php echo esc_attr( $single_banner_botom['height'] ); ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                    </a>
                
                <?php
                // Code Ad
                } elseif ( $ti_option['single_code_bottom_ad'] == true ) {
                    
                    echo $ti_option['single_code_bottom_ad'];
                    
                } ?>
                
            </div><!-- .advertisment -->

        <?php endif;

} // Single Post above the content ad




/**
 * Footer Ad
**/
function main_footer_ad_unit() {
        
        global $ti_option;
    
        if ( $ti_option['footer_image_ad']['url'] == true || ! empty ( $ti_option['footer_code_ad'] ) ) :
        ?>

            <div class="advertisement">
                <div class="wrapper">
                    
        			<?php
                    
                    // Image Ad
                    $footer_ad = $ti_option['footer_image_ad'];
                    if ( $footer_ad['url'] == true ) { ?>
                        <a href="<?php echo esc_url( $ti_option['footer_image_ad_url'] ); ?>" rel="nofollow" target="_blank">
                            <img src="<?php echo esc_url( $footer_ad['url'] ); ?>" width="<?php echo esc_attr( $footer_ad['width'] ); ?>" height="<?php echo esc_attr( $footer_ad['height'] ); ?>" alt="<?php _e( 'Advertisement', 'themetext' ); ?>" />
                        </a>
                    <?php 
                                                      
        			// Code Ad
                    } elseif( $ti_option['footer_code_ad'] == true ) {
                        
                        echo $ti_option['footer_code_ad'];
                        
                    } ?>
                </div>
                
            </div><!-- .advertisment -->

        <?php endif;
    
} // End Header Ad