<?php
/**
 * Relatest Posts from
 * the same Category or the same Tag
 *
 * @package SimpleMag
 * @since 	SimpleMag 3.0
**/

global $ti_option; 


/**
 * Display relted posts by tag or by category
**/
if ( $ti_option['single_related_posts_show_by'] == 'related_cat' ) {
	$ti_taxs = get_the_category( $post->ID ); // Display related posts by category
} else {
	$ti_taxs = wp_get_post_tags( $post->ID ); // Display related posts by tag
}

$ti_tax_ids = array();

foreach($ti_taxs as $individual_tax) $ti_tax_ids[] = $individual_tax->term_id;

    $posts_to_show = $ti_option['single_related_posts_to_show'];

    if ( $ti_option['single_related_posts_show_by'] == 'related_cat' ) {
        // Loop argumnetsnts show posts by category
        $args = array(
            'category__in' => $ti_tax_ids,
            'post__not_in' => array( $post->ID ),
            'orderby' => 'rand',
            'posts_per_page' => $posts_to_show,
            'ignore_sticky_posts' => 1
        );
    } else { 
        // Loop argumnetsnts show posts by category
        $args = array(
            'tag__in' => $ti_tax_ids,
            'post__not_in' => array( $post->ID ),
            'orderby' => 'rand',
            'posts_per_page' => $posts_to_show,
            'ignore_sticky_posts' => 1
        );
}

$ti_related_posts = new WP_Query( $args );



/**
 * Three latest posts by current single post author
**/
$latest_by_author = new WP_Query( array (
    'posts_per_page' => 3,
    'author' => get_the_author_meta( 'ID' )
));
?>

	
<div class="single-box tab-box related-posts-tabs">

    <ul class="tab-box-button clearfix">
        <li><a href="#related-posts"><?php _e( 'You may also like', 'themetext' ); ?></a></li>
        <li><a href="#author-posts"><span><?php _e( 'Latest by', 'themetext' ); ?></span> <span><?php printf( ( '%s' ), get_the_author() ); ?></span></a></li>
    </ul>


    <div class="tab-box-content">

        <div id="related-posts" class="related-posts">
            
            <div class="grids entries carousel">

            <?php 
            if( $ti_related_posts->have_posts() ) :
                while ( $ti_related_posts->have_posts() ) : $ti_related_posts->the_post();
            ?>

                    <div class="item">
                      <figure class="entry-image">
                          <a href="<?php the_permalink(); ?>">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'rectangle-size-small' );
                            } elseif( first_post_image() ) { // Set the first image from the editor
                                echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" alt="' . esc_attr( get_the_title() ) . '" />';
                            } ?>
                          </a>
                      </figure>
                      <header class="entry-header">
                          <div class="entry-meta">
                              <?php the_date(); ?>
                          </div>
                          <h4>
                              <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                          </h4>
                      </header>
                    </div>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>
                
            </div><!--.carousel-->

        </div><!--#related-posts-->


        <div id="author-posts" class="related-posts">
            
            <div class="grids entries carousel">
                
            <?php
            if( $latest_by_author->have_posts() ) :
                while ( $latest_by_author->have_posts() ) : $latest_by_author->the_post(); 
            ?>

                <div class="item">
                    <figure class="entry-image">
                        <a href="<?php the_permalink(); ?>">
                            <?php 
                            if ( has_post_thumbnail() ) {
                                the_post_thumbnail( 'rectangle-size-small' );
                            } elseif( first_post_image() ) { // Set the first image from the editor
                            echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" alt="' . esc_attr( get_the_title() ) . '" />';
                            } ?>
                        </a>
                    </figure>
                    <header class="entry-header">
                        <div class="entry-meta">
                            <?php $cat = get_the_category(); $cat = $cat[0]; ?>
                            <span class="entry-category">
                                <a href="<?php echo get_category_link( $cat );?>"><?php echo $cat->cat_name; ?></a>
                            </span>
                        </div>
                        <h4>
                            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                        </h4>
                    </header>
                </div>

                <?php endwhile; ?>

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>
                
            </div><!--.carousel-->
        
            <a class="see-more" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><span><?php _e( 'See More', 'themetext' ); ?></span><i class="icomoon-arrow-right"></i></a>
            
        </div><!--#author-posts-->

     </div>

</div><!-- .single-box .related-posts -->