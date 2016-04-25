<?php 
/**
 * Media Posts
 * Section Layout One
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0.1
**/
?>

<div class="wrapper">
    <div class="grids">

        <div class="grid-7">

        <?php if ( $media_query->have_posts() ) : ?>

            <div class="global-sliders media-post-slides">

                <?php while ( $media_query->have_posts() ) : $media_query->the_post(); ?>

                    <div id="postid-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> media-post-item">

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

                        </div>

                    </div>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            </div><!-- .media-post-slides -->


            <div class="media-post-thumbs">

                <?php while ( $media_query->have_posts() ) : $media_query->the_post(); ?>

                    <?php 
                    // Link for Video & Audio
                    if( $format_name == 'video' || $format_name == 'audio' ) { 

                        if ( $format_name == 'video' ) {
                            $url_value = 'add_video_url';
                        } elseif( $format_name == 'audio' ) {
                            $url_value = 'add_audio_url';
                        }

                        $load_media = ' thumb-load-media-content';

                    // Link for Gallery
                    } else {

                        $load_media = '';
                        $url_value = '';
                    }
                    ?>

                    <div class="post-<?php the_ID(); ?> thumbs-item<?php echo $load_media; ?>" data-postid="<?php the_ID(); ?>" data-metakey="<?php echo esc_attr( $url_value ); ?>">
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

            </div><!-- .media-post-thumbs -->

        <?php endif; ?>

        </div><!-- .grid-7 -->


        <div class="grid-5">

            <?php if ( $media_query->have_posts() ) : ?>

            <div class="global-sliders media-post-details">

                <?php while ( $media_query->have_posts() ) : $media_query->the_post(); ?>

                    <div class="post-<?php the_ID(); ?> media-post-item entry-details">

                        <header class="entry-header">      
                            <div class="entry-meta">
                               <?php the_category(', '); ?>
                            </div>

                            <h2 class="entry-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>

                            <span class="written-by"><?php _e( 'by','themetext' ); ?></span>
                            <a class="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
                                <?php the_author_meta( 'display_name' ); ?>
                            </a>
                        </header>

                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>

                        <a class="see-more" href="<?php the_permalink(); ?>"><span><?php _e( 'Read More', 'themetext' ); ?></span><i class="icomoon-arrow-right"></i></a>

                    </div>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            </div>

            <?php endif; ?>

        </div><!-- .grid-5 -->
    </div><!-- .grids -->
</div><!-- .wrapper -->