<?php
/**
 * Category Slider
 *
 * @package SimpleMag
 * @since 	SimpleMag 2.0
**/
?>


<?php if ( ! is_paged() ) : // Output the slider only on first category page ?>

<section class="category-slider">

    <div class="global-sliders content-over-image posts-slider content-over-image-tint">
    
    <?php 
	$cat = get_query_var( 'cat' );
    $ti_cat_slider = new WP_Query(
        array(
            'post_type' => 'post',
            'meta_key' => 'category_slider_add',
            'meta_value' => 1,
            'posts_per_page' => 10,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $cat,
                )
            )
        )
    );
    
	if ( $ti_cat_slider->have_posts() ) : 

        while ( $ti_cat_slider->have_posts() ) : $ti_cat_slider->the_post(); ?>
    
            <div>

                <figure class="entry-image">
                    <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                    <?php if ( has_post_thumbnail() ) { ?>
                        <?php the_post_thumbnail( 'big-size' ); ?>
                    <?php } else { ?>
                        <img class="alter" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_title_attribute(); ?>" />
                    <?php } ?>
                </figure>

                <header class="entry-header">
                    <div class="inner">
                        <div class="inner-cell">
                            <div class="entry-frame">
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                </h2>
                                <a class="read-more" href="<?php the_permalink() ?>"><?php _e( 'Read More', 'themetext' ); ?></a>
                            </div>
                        </div>
                    </div>
                </header>

            </div>
        
        <?php endwhile; ?>
            
        <?php wp_reset_postdata(); ?>
            
    <?php endif; ?>
    
    </div>
    
</section><!-- Slider -->

<?php endif; ?>