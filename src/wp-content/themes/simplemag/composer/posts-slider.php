<?php 
/**
 * Posts Slider
 * Page Composer Section
 *
 * @package SimpleMag
 * @since   SimpleMag 1.1.0
 * @version 4.0
**/


/** 
 * Add posts to slider only if the 'Add To Slider' 
 * custom field checkbox was checked on the Post edit page
**/
$ti_posts_slider = new WP_Query(
    array(
        'post_type' => 'post',
        'meta_key' => 'homepage_slider_add',
        'meta_value' => '1'
    )
);


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
   
<?php if ( $ti_posts_slider->have_posts() ) : ?>

    <div class="global-sliders content-over-image posts-slider <?php echo sanitize_html_class( $section_style_class ); ?>">

        <?php while ( $ti_posts_slider->have_posts() ) : $ti_posts_slider->the_post(); ?>

            <div <?php post_class(); ?>>

                <?php 
                /**
                 * Slider "Full Width" option is slected
                 * Slide image is being added as a background
                **/
                if ( get_sub_field ( 'posts_slider_type' ) == 'slider_full_width' ): ?>

                    <?php if ( has_post_thumbnail() ) {
                        $slide_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
                        $slide_bg_image = 'style="background-image:url(' . esc_url( $slide_image_url[0] ) . ');"';
                    } ?>
                    <div class="entry-image full-width-slider-image" <?php echo isset( $slide_bg_image ) ? $slide_bg_image : ''; ?>>
                        <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                    </div>
                <?php 
                /**
                 * Slider "Regular" option is slected
                 * Slide image is being added as an image tag
                **/
                else : 
                ?>
                    <figure class="entry-image">
                        <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                        <?php if ( has_post_thumbnail() ) { ?>
                            <?php the_post_thumbnail( 'big-size' ); ?>
                        <?php } else { ?>
                            <img class="alter" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_title_attribute(); ?>" />
                        <?php } ?>
                    </figure>

                <?php endif; ?>

                <header class="entry-header">
                    <div class="inner">
                        <div class="inner-cell">
                            <div class="entry-frame">
                                <div class="entry-meta">
                                    <span class="entry-category">
                                       <?php the_category(', '); ?>
                                    </span>
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
    </div>

<?php else: ?>

    <p class="message">
        <?php _e( 'Sorry, there are no posts in the slider', 'themetext' ); ?>
    </p>

<?php endif; ?>