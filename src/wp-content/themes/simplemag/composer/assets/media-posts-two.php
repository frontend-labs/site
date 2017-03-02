<?php 
/**
 * Media Posts
 * Section Layout Two
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0.1
**/


if ( $media_query->have_posts() ) : ?>

    <div class="wrapper global-sliders media-post-slides">

        <?php while ( $media_query->have_posts() ) : $media_query->the_post(); ?>

            <div id="postid-<?php the_ID(); ?>" class="grids media-post-item">

                <div class="entry-image">
                    
                    <?php
                    /* Main Image */
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'big-size' );
                    } else {
                        echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" alt="' . get_the_title() . '" />';
                    }
                    ?>

                    <?php
                    // Link for Video & Audio
                    if( $format_name == 'video' || $format_name == 'audio' ) { 

                        if ( $format_name == 'video' ) {
                            $url_value = 'add_video_url';
                        } elseif( $format_name == 'audio' ) {
                            $url_value = 'add_audio_url';
                        }
                    ?>
                        <a href="#" class="load-media-content" data-postid="<?php the_ID(); ?>" data-metakey="<?php echo esc_attr( $url_value ); ?>"></a>

                     <?php  
                    // Link for Gallery
                    } else {

                    ?>
                        <a href="<?php the_permalink(); ?>" class="icomoon-camera-retro"></a>

                    <?php } ?>

                    <div class="media-content"></div>

                    <div class="entry-header">

                        <div class="entry-meta">
                            <span class="entry-category">
                               <?php the_category(', '); ?>
                            </span>
                        </div>

                        <h2 class="entry-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h2>

                    </div>
                    
                </div>

            </div>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

    </div>

<?php endif; ?>

<?php
/* Thumbnails */
if ( $media_query->have_posts() ) : ?>

   <div class="media-post-thumbs-wrapper">
       <div class="media-post-thumbs">

        <?php while ( $media_query->have_posts() ) : $media_query->the_post(); ?>

            <div class="thumbs-item">
                <?php 
                /* Thumbnail */
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail( 'rectangle-size-small' );
                } else {
                    echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" alt="' . get_the_title() . '" />';
                }
                ?>
            </div>

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

       </div>
    </div>

<?php endif; ?>
    
<?php
/* Section Background Image */
if ( get_sub_field( 'format_bg_image' ) == 'bg_image_on' ) :

    if ( $media_query->have_posts() ) : ?>

        <div class="global-sliders media-post-bg">
        <?php 
        while ( $media_query->have_posts() ) : $media_query->the_post();

            // Posts Featured Image as section background
            if ( has_post_thumbnail() ) {
                $video_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
                $video_image_bg = 'background-image:url(' . esc_url( $video_image_url[0] ) . ');';
            } else {
                $video_image_bg = 'background-image:url(' . esc_url( first_post_image() ) . ');';
            }
            ?>
            <div class="bg-item" style="<?php echo esc_attr( $video_image_bg ); ?>"></div>
        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

        </div>

    <?php endif; ?>

<?php endif; ?>