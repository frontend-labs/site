<?php 
/**
 * Featured Posts
 * Page Composer section.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/


/**
 * Section Colors: 
 * Background, elements and post titles.
**/
include locate_template( 'composer/assets/section-colors.php' );

/** 
 * Add posts to this section only if the 'Make Featured'
 * custom field checkbox was checked on the Post edit page
**/
$ti_featured_posts = new WP_Query(
    array(
        //'post_type' => 'post',
        'meta_key' => 'featured_post_add',
        'meta_value' => '1',
        'posts_per_page' => '15',
    )
);
?>

<section class="home-section featured-posts<?php echo $section_bg . '' . $section_text. '' . $section_links; ?>">
    
    <div class="wrapper">
        
        <?php
        /**
         * Section Main & Sub titles
        **/
        $main_title = get_sub_field( 'featured_main_title' );
        $sub_title = get_sub_field( 'featured_sub_title' );

        if( $main_title || $sub_title ) : ?>
        <header class="section-header">
            <div class="section-title<?php echo $title_with_sep; ?>">
                <h2 class="title"><?php echo $main_title; ?></h2>
            </div>
            <?php if ( $sub_title ): ?>
            <span class="sub-title"><?php echo $sub_title; ?></span>
            <?php endif; ?>
        </header>
        <?php endif; ?>

        <?php
        if ( $ti_featured_posts->have_posts() ) :
        
            $posts_column = 0; // Count the posts
            ?>

            <div class="grids entries">
               
                
                <?php
                while ( $ti_featured_posts->have_posts() ) : $ti_featured_posts->the_post();


                if ( $posts_column == 0 ) : // Middle column
                    
                    $posts_image_size = 'rectangle-size-big';
                    $posts_width = '';
                    echo '<div class="grid-6 column-middle">';

                elseif ( $posts_column == 1 ) : // Right column

                    $posts_width = 'grid-6';
                    $posts_image_size = 'rectangle-size-small';
                    echo '<div class="grid-6 column-right"><div class="grids grid-layout featured-carousel">';

                endif;
                ?>

                    <article <?php post_class($posts_width); ?>>
                        <div class="post-item-inner">

                            <figure class="entry-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php 
                                    if ( has_post_thumbnail() ) {
                                        the_post_thumbnail( $posts_image_size );
                                    } elseif( first_post_image() ) { // Set the first image from the editor
                                        echo '<img src="' . first_post_image() . '" class="wp-post-image" />';
                                    } ?>
                                </a>
                            </figure>
                            
                            <div class="entry-details">

                                <header class="entry-header">
                                    <div class="entry-meta">
                                       <?php the_category(', '); ?>
                                    </div>

                                    <h2 class="entry-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h2>

                                    <?php if ( $posts_column == 0 ) : ?>
                                    <span class="written-by"><?php _e( 'by','themetext' ); ?></span>
                                    <a class="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
                                        <?php the_author_meta( 'display_name' ); ?>
                                    </a>
                                    <?php endif; ?>
                                </header>

                                <?php if ( $posts_column == 0 ) : ?>
                                <div class="entry-summary">
                                    <?php the_excerpt(); ?>
                                </div>
                                <?php endif; ?>
                                
                            </div>

                        </div>        
                    </article>

                <?php
                    if ( $posts_column == 0 ) :

                        echo '</div><!-- .middle-right -->'; // Close middle column

                    elseif ( ( $ti_featured_posts->current_post + 1 ) == ( $ti_featured_posts->post_count ) ) : // Close right column

                        echo '</div><!-- .featured-carousel --></div><!-- .column-right -->';

                    endif;

                    $posts_column++;

                endwhile;
                ?>

                <?php wp_reset_postdata(); ?>

            </div><!-- .grids -->
        
            <div class="carousel-navigation"></div>

            <?php else : ?>

                <p class="message">
                    <?php _e( 'There are no featured posts yet', 'themetext' ); ?>
                </p>

    <?php endif; ?>
        
    </div><!-- .wrapper -->
</section><!-- Featured Posts -->