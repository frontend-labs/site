<?php
/**
 * The main template file
 * for Posts Page or Your latest Posts options
 * in Settings -> Reading
 *
 * @package SimpleMag
 * @since   SimpleMag 1.0
**/

get_header();

global $ti_option;
?>

<?php $archive_sidebar = get_field( 'page_sidebar', get_option( 'page_for_posts' ) ); ?>

    <section id="content" role="main" class="clearfix anmtd">
    
		<?php if ( $ti_option['posts_page_title'] == 'full_width_title' ) : ?>
        <header class="entry-header page-header">
            <div class="wrapper title-with-sep page-title">
                <h1 class="entry-title">
                    <?php
                    $posts_page_id = get_option( 'page_for_posts' );
                    echo esc_html( get_the_title( $posts_page_id ) );
                    ?>
                </h1>
            </div>
        </header>
        <?php endif; ?>
        
        
        <div class="wrapper">
		<?php
        // Enable/Disable sidebar based on the field selection
        if ( ! $archive_sidebar || $archive_sidebar == 'page_sidebar_on' ):
        ?>
            <div class="grids">
                <div class="grid-8 column-1 with-sidebar">
		<?php endif; ?>
                
                <?php if ( $ti_option['posts_page_title'] == 'above_content_title' ) : ?>
                <header class="entry-header page-header">
                    <div class="title-with-sep page-title">
                        <h1 class="entry-title">
							<?php
                            $posts_page_id = get_option( 'page_for_posts' );
                            echo esc_html( get_the_title( $posts_page_id ) );
                            ?>
                        </h1>
                    </div>
                </header>
                <?php endif; ?>
                    
                    
                <?php
                /** 
                 * Add posts to slider only if the 'Add To Slider' 
                 * custom field checkbox was checked on the Post edit page
                **/
                if ( ! is_paged() ) :

                    if ( $ti_option['posts_page_slider'] == '1' ) :

                        $ti_hp_slider = new WP_Query(
                            array(
                                'post_type' => 'post',
                                'meta_key' => 'homepage_slider_add',
                                'meta_value' => '1'
                            )
                        );
                        ?>

                        <?php if ( $ti_hp_slider->have_posts() ) : ?>

                        <div class="global-sliders posts-slider content-over-image content-over-image-tint post-page-slider">

                            <?php while ( $ti_hp_slider->have_posts() ) : $ti_hp_slider->the_post(); ?>

                                <div <?php post_class(); ?>>
                                    <figure class="image-tint">
                                        <a class="entry-link" href="<?php the_permalink(); ?>"></a>
                                        <?php if ( has_post_thumbnail() ) { ?>
                                            <?php the_post_thumbnail( 'medium-size' ); ?>
                                        <?php } else { ?>
                                            <img class="alter" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_title(); ?>" />
                                        <?php } ?>
                                    </figure>
                                    <header class="entry-header">
                                        <div class="inner">
                                            <div class="inner-cell">
                                                <div class="entry-meta">
                                                    <span class="entry-category"><?php the_category(', '); ?></span>
                                                </div>
                                                <h2 class="entry-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>
                                                <a class="read-more" href="<?php the_permalink(); ?>"><?php _e( 'Read More', 'themetext' ); ?></a>
                                            </div>
                                        </div>
                                    </header>
                                </div>

                            <?php endwhile; ?>

                            <?php wp_reset_postdata(); ?>

                            <?php endif; ?>

                        </div><!-- Slider -->

                    <?php endif; ?>
                    
                <?php endif; ?>
                
                    
                <?php
                if ( $ti_option['posts_page_layout'] == 'masonry-layout' || $ti_option['posts_page_layout'] == 'grid-layout' ) :
                    $cols_numb = ' ' . sanitize_html_class( $ti_option['posts_page_columns'] );
                else :
                    $cols_numb = '';
                endif;
                ?>

                <div class="grids entries <?php echo $ti_option['posts_page_layout'] . '' . $cols_numb; ?>">
					<?php 
                    if ( have_posts() ) : while ( have_posts()) : the_post();

                    	get_template_part( 'content', 'post' );

                    endwhile;
                    ?>
                </div>
                    
                <?php the_posts_pagination( array(
                    'mid_size' => 4,
                    'prev_text' => __( '<i class="icomoon-arrow-left"></i>' ),
                    'next_text' => __( '<i class="icomoon-arrow-right"></i>' ),
                ) ); ?>
                
                <?php else : ?>
                
                <p class="message">
                	<?php _e( 'Sorry, no posts were found', 'themetext' ); ?>
                </p>
                
                <?php endif;?>
                
                <?php
                // Enable/Disable sidebar based on the field selection
                if ( ! $archive_sidebar || $archive_sidebar == 'page_sidebar_on' ):
                ?>
                </div><!-- .grid-8 -->
                
                <?php 
                if ( ! $archive_sidebar || $archive_sidebar == 'page_sidebar_on' ):
                    get_sidebar();
                endif;
                ?>

            </div><!-- .grids -->
    		<?php endif; ?>
        
        </div><!-- .wrapper -->
        
    </section><!-- #content -->
    
<?php get_footer(); ?>