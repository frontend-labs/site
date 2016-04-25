<?php 
/**
 * Search Results
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/
get_header(); ?>

	<section id="content" role="main" class="clearfix anmtd">
    	<div class="wrapper">
        
            <header class="entry-header page-header">
				<?php printf( __( '<small>Search Results for:</small><br />', 'themetext' ) ); ?>
                <div class="page-title title-with-sep single-title">
                    <h1 class="entry-title"><?php echo get_search_query(); ?></h1>
                </div>
            </header><!-- .page-header -->
            
            <?php if ( is_active_sidebar( 'sidebar-1' ) ) : // If the sidebar has widgets ?>
            <div class="grids">
                <div class="grid-8 column-1">
			<?php endif; ?>

				<?php if (have_posts()) : ?>
                    
                    <div class="entries list-layout">
                    
					<?php while ( have_posts() ) : the_post(); ?>
                        
                    <article id="post-<?php the_ID(); ?>" <?php post_class("clearfix"); ?>>
                        <div class="post-item-inner">
                    
                            <figure class="entry-image">
                                <div class="entry-image-inner">

                                    <a href="<?php the_permalink(); ?>">
                                        <?php 
                                        if ( has_post_thumbnail() ) {
                                            the_post_thumbnail( 'rectangle-size' );
                                        } elseif( first_post_image() ) { // Set the first image from the editor
                                            echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" />';
                                        } ?>
                                    </a>

                                    <?php
                                    // Add icon to different post formats
                                    if ( 'gallery' == get_post_format() ): // Gallery
                                        echo '<i class="icomoon-camera-retro"></i>';
                                    elseif ( 'video' == get_post_format() ): // Video
                                        echo '<i class="icomoon-camera"></i>';
                                    elseif ( 'audio' == get_post_format() ): // Audio
                                        echo '<i class="icomoon-music"></i>';
                                    endif;
                                    ?>
                                    
                                </div>
                            </figure>
                            
                            <div class="entry-details">
                                <header class="entry-header">
                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                    </h2>
                                </header>

                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                    <a class="read-more-link" href="<?php the_permalink() ?>"><?php _e( 'Read More', 'themetext' ); ?></a>
                                </div>
                            </div>
                        
                        </div>
                    </article>
                    
                    <?php endwhile; ?>
            
					</div>
                    
				<?php else : ?>
            
					<p class="message"><?php _e( 'Sorry, nothing found', 'themetext' ); ?></p>
            
                <?php endif; ?>
                    
                <?php the_posts_pagination( array(
                    'mid_size' => 4,
                    'prev_text' => __( '<i class="icomoon-arrow-left"></i>' ),
                    'next_text' => __( '<i class="icomoon-arrow-right"></i>' ),
                ) ); ?>
    
			<?php if ( is_active_sidebar( 'sidebar-1' ) ) : // If the sidebar has widgets ?>
                </div><!-- .grid-8 -->
            
                <?php get_sidebar(); ?>

            </div><!-- .grids -->
            <?php endif; ?>
        
    	</div>
    </section>

<?php get_footer(); ?>