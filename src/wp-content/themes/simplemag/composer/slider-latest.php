<?php 
/**
 * Posts Slider & Two Latest Posts
 * Page Composer Section
 *
 * @package SimpleMag
 * @since   SimpleMag 3.0
**/


/**
 * Section styling based on field selection:
 * White, Black or Tint
**/
$section_style = get_sub_field( 'posts_slider_style' );

if ( $section_style == 'slider_bg_white' ) :
    $section_style_class = 'content-over-image-white';
elseif ( $section_style == 'slider_bg_black' ) :
     $section_style_class = 'content-over-image-black';
else :
    $section_style_class = 'content-over-image-tint';
endif;

?>

<section class="wrapper home-section slider-latest">
    
    <div class="grids">
        <div class="grid-8 columns column-1">

            <?php
            /** 
             * Add posts to slider only if the 'Add To Slider' 
             * custom field checkbox was checked on the Post edit page
            **/
            $slides_num = get_sub_field( 'slides_to_show' );
            $ti_slider_combined = new WP_Query(
                array(
                    'post_type' => 'post',
                    'posts_per_page' => $slides_num,
                    'meta_key' => 'homepage_slider_add',
                    'meta_value' => '1'
                )
            );
            ?>

            <?php if ( $ti_slider_combined->have_posts() ) : ?>
                
            <div class="global-sliders content-over-image posts-slider <?php echo sanitize_html_class( $section_style_class ); ?>">
               
                <?php while ( $ti_slider_combined->have_posts() ) : $ti_slider_combined->the_post(); ?>
                
                    <div <?php post_class(); ?>>
                        <figure class="entry-image">
                            <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                            <?php if ( has_post_thumbnail() ) { ?>
                            	<?php the_post_thumbnail( 'medium-size' ); ?>
                            <?php } else { ?>
                                <img class="alter" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_title(); ?>" />
                            <?php } ?>
                        </figure>
                        <header class="entry-header <?php echo sanitize_html_class( $section_style_class ); ?>">
                            <div class="inner">
                                <div class="inner-cell">
                                    <div class="entry-frame">
                                        <div class="entry-meta">
                                            <span class="entry-category"><?php the_category(', '); ?></span>
                                        </div>
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <a class="read-more" href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'themetext' ); ?></a>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </div>
                    
                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>
                
            </div><!-- Slider -->
        
            <?php else: ?>
                
            <p class="message">
                <?php _e( 'Sorry, there are no posts in the slider', 'themetext' ); ?>
            </p>
                 
            <?php endif; ?>

        </div><!-- Grid 8 -->

        <div class="grid-4 entries columns column-2">
            
            <?php
            // Two latest posts
            if ( get_sub_field ( 'posts_slider_type' ) == 'slider_and_latest' ) :

                $ti_latest_combined = new WP_Query(
                    array(
                        'post_type' => 'post',
                        'posts_per_page' => 2,
                        'ignore_sticky_posts' => 1
                    )
                );

            // Two featured posts
            elseif( get_sub_field ( 'posts_slider_type' ) == 'slider_and_featured' ) :

                $ti_latest_combined = new WP_Query(
                    array(
                        'post_type' => 'post',
                        'posts_per_page' => 2,
                        'meta_key' => 'featured_post_add',
                        'meta_value' => '1',
                        'ignore_sticky_posts' => 1
                    )
                );

            endif;
            
            if (   get_sub_field ( 'posts_slider_type' ) == 'slider_and_latest'
                || get_sub_field ( 'posts_slider_type' ) == 'slider_and_featured' ) :

                if ( $ti_latest_combined->have_posts() ) :

                    while ( $ti_latest_combined->have_posts() ) : $ti_latest_combined->the_post(); ?>

                        <article class="post-item content-over-image content-over-image-tint">
                            <figure class="entry-image">
                                <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                                <?php 
                                if ( has_post_thumbnail() ) {
                                    the_post_thumbnail( 'rectangle-size' );
                                } elseif( first_post_image() ) { // Set the first image from the editor
                                    echo '<img src="' . first_post_image() . '" class="wp-post-image" alt="' . the_title_attribute( 'echo=0' ) . '" />';
                                } else {
                                    echo '<img class="alter" src="' . get_template_directory_uri() . '/images/pixel.gif" alt="' . the_title_attribute( 'echo=0' ) . '" />';
                                }?>
                            </figure>
                            <header class="entry-header">
                                <div class="inner">
                                    <div class="inner-cell">
                                        <h2 class="entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                    </div>
                                </div>
                            </header>
                        </article>

                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                    <?php else: ?>

                    <p class="message">
                        <?php _e( 'There are no latest posts yet', 'themetext' ); ?>
                    </p>

                <?php endif; ?>
            
            <?php endif; ?>
            
        </div><!-- Grid 4 -->

    </div><!-- Grids -->

</section>