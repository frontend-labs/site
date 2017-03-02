<?php 
/**
 * Homepage Posts Carosuel
 * Page Composer Section
 *
 * @package SimpleMag
 * @since 	SimpleMag 3.0
**/
?>

<section class="home-section full-width-section posts-carousel">

    <?php
    /** 
     * Add posts to slider only if the 'Add To Slider' 
     * custom field checkbox was checked on the Post edit page
    **/
    $carousel_slides_num = get_sub_field( 'carousel_slides_to_show' );
    $ti_posts_carousel = new WP_Query(
        array(
            'post_type' => 'post',
            'posts_per_page' => $carousel_slides_num,
            'meta_key' => 'homepage_slider_add',
            'meta_value' => '1'
        )
    );
    ?>

    <?php if ( $ti_posts_carousel->have_posts() ) : ?>
    
    <div id="gallery-carousel" class="global-sliders content-over-image content-over-image-tint">
        
        <?php while ( $ti_posts_carousel->have_posts() ) : $ti_posts_carousel->the_post(); ?>
        
            <div class="gallery-item">
            	<figure class="entry-image">
                    <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                    <?php 
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail( 'gallery-carousel' );
                    } ?>
                </figure>
				<header class="entry-header">
                    <div class="inner">
                        <div class="inner-cell">
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
                </header>
            </div>
            
        <?php endwhile; ?>
        
        <?php wp_reset_postdata(); ?>

    </div>
    
    <?php else: ?>
        
        <p class="message">
			<?php _e( 'Sorry, there are no posts in the carousel', 'themetext' ); ?>
        </p>
         
    <?php endif; ?>

</section><!-- Posts Carousel -->