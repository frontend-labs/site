<?php
/**
 * Social Share Icons with count
 * displays in Single Post and each 
 * post item accross the site:
 * page composer sections and archives
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/

function social_share_icons() {
    
    if ( is_single() ) :
        
        global $ti_option;

        // Add class if social share links is selected as Colorful
        $social_type = $ti_option['single_social_style'];
        if ( $social_type == 'social_default' ) {
            $social_style = ' link-layout social-minimal';
        } elseif ( $social_type == 'social_colors' ) {
            $social_style = ' link-layout social-colors';
        } elseif ( $social_type == 'social_default_buttons' ) {
            $social_style = ' button-layout social-minimal-buttons';
        } else {
            $social_style = ' button-layout social-colors-buttons';
        }

        // Twitter username defined in Theme Option
        if ( ! empty ( $ti_option['single_twitter_user'] ) ) {
            $twitter_user = $ti_option['single_twitter_user'];
        }
    
        // Labels for Single Post
        $label_facebook = '<span class="share-label">' . __( 'Facebook', 'themetext' ). '</span>';
        $label_twitter = '<span class="share-label">' . __( 'Twitter', 'themetext' ). '</span>';
        $label_pinterest = '<span class="share-label">' . __( 'Pinterest', 'themetext' ). '</span>';
    
    endif;

?>

    <div class="clearfix social-sharing<?php echo isset( $social_style ) ? $social_style : ''; ?>" data-permalink="<?php the_permalink();?>">
        
        <a class="share-item share-facebook" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title_attribute(); ?>" target="blank">
            <i class="icomoon-facebook"></i>
            <?php echo isset( $label_facebook ) ? $label_facebook : ''; ?>
        </a>

        <a class="share-item share-twitter" href="https://twitter.com/intent/tweet?original_referer=<?php the_permalink(); ?>&text=<?php the_title_attribute(); ?>&tw_p=tweetbutton&url=<?php the_permalink(); ?><?php echo isset( $twitter_user ) ? '&via='.$twitter_user : ''; ?>" target="_blank">
            <i class="icomoon-twitter"></i>
            <?php echo isset( $label_twitter ) ? $label_twitter : ''; ?>
        </a>

        <?php
        if ( has_post_thumbnail() ) {
            global $post;
            $pinimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
            $showpinimage = $pinimage[0];
        } elseif( first_post_image() ) {
            $showpinimage = first_post_image();
        }
        ?>
        <a class="share-item share-pinterest" href="//pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php echo esc_url( isset( $showpinimage ) ? $showpinimage : '' ); ?>&description=<?php the_title_attribute(); ?>" target="_blank">
            <i class="icomoon-pinterest"></i>
            <?php echo isset( $label_pinterest ) ? $label_pinterest : ''; ?>
        </a>
        
        
        <?php 
        // Display other icons only in single post
        if ( is_single() ) {
        ?>
        
        <div class="share-item share-more">

            <span class="share-plus"></span>

            <div class="share-more-items">
                <a class="share-gplus" href="https://plusone.google.com/_/+1/confirm?hl=en-US&url=<?php the_permalink(); ?>">
                    <span class="share-label"><?php _e( 'Google +', 'themetext' ); ?></span>
                </a>

                <a class="share-linkedin" href="https://www.linkedin.com/countserv/count/share?url=<?php the_permalink(); ?>">
                    <span class="share-label"><?php _e( 'LinkedIn', 'themetext' ); ?></span>
                </a>

                <a class="share-mail" href="mailto:?subject=<?php the_title_attribute(); ?>&body=<?php the_permalink(); ?>">
                    <span class="share-label"><?php _e( 'Email', 'themetext' ); ?></span>
                </a>
            </div>

        </div>
        
        <?php } ?>
        

    </div><!-- social-sharing -->

<?php }