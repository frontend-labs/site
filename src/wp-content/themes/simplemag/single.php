<?php 
/**
 * The Template for displaying all single blog posts
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/

get_header();

global $ti_option;

$single_sidebar = get_post_meta( $post->ID, 'post_sidebar', true );
?>

    <main id="content" class="clearfix anmtd" role="main">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <?php
            // Post title full width
            single_title_full_width(); 
            ?>
            
            <?php
            // Post media full width
            if ( $paged == 1 || $page == 1 ) {
                single_media_full_width();
            }
            ?>
            
            <div class="wrapper">
                <div class="grids">
                    
            <?php 
            if ( ! $single_sidebar || $single_sidebar == "post_sidebar_on" ) : // Enable/Disable post sidebar ?>
                    <div class="grid-8 column-1">
            <?php else : ?>
                <div class="grid-8 grid-centered content-without-sidebar">
            <?php endif; ?>

                    <?php 
                    // Post title above the content
                    single_title_above_content(); 
                    ?>

                    <?php
                    // Post media above the content
                    if ( $paged == 1 || $page == 1 ) {
                        single_media_above_content();
                    }
                    ?>               

                    <?php 
                    // Ad above the content
                    do_action('single_post_above_content_ad'); 
                    ?>               

                    <?php
                    // Output manual excerpt if it's not empty
                    if ( $ti_option['single_manual_excerpt'] == true && has_excerpt() ) {
                        // If post has pagination using the <!--nextpage--> short tag, output the excerpt only on the first page
                        if ( $paged == 1 || $page == 1 ) {
                            echo '<div class="manual-excerpt">' . get_the_excerpt() . '</div>';
                        }
                    }
                    ?>

                    <?php
                    // Post Rating
                    if ( $ti_option['single_rating_box'] == 'rating_top' ) {
                        if ( get_field( 'enable_rating' ) == true ) {
                            get_template_part( 'inc/single', 'rating' );
                        }
                    }
                    ?>

                    <article class="clearfix single-box entry-content">        
                        <?php single_main_content(); ?>              
                    </article><!-- .entry-content -->
                    
                    <?php
                    // Ad below the content
                    do_action( 'single_post_below_content_ad' );
                    ?>
                    
                    <?php
                    // Post Rating output at the bottom
                    if ( $ti_option['single_rating_box'] == 'rating_bottom' ) {
                        if ( get_field( 'enable_rating' ) == true ) {
                            get_template_part( 'inc/single', 'rating' );
                        }
                    }
                    ?> 
                    
                    <div class="clearfix single-box single-tags">
                        
                        <?php
                        // Show/Hide tags list
                        if ( $ti_option['single_tags_list'] == 1 ) {
                            the_tags('<div class="col-1 tag-box"><div class="written-by tag-box-title">' . __( 'Tags from the story', 'themetext' ) . '</div>', ', ', '</div>'); 
                        }
                        ?>
                        
                        <?php if ('open' == $post->comment_status) : ?>
                        <div class="col-2">
                            <a href="#comments" class="add-comment">
                                <span class="add-comment-arrow"><i class="icomoon-arrow-left"></i></span>
                                <i class="icomoon-comments"></i>
                                <i class="score-number">
                                    <?php
                                    // Comments Count
                                    comments_number( '0', '1', '%' ); ?>
                                </i>
                            </a>
                        </div>
                        <?php endif ?>
                        
                    </div>
                    
                    
                    <?php
                    // Show/Hide share links
                    if ( $ti_option['single_social'] == 1 ) { ?>
                        <div class="single-box single-social">
                            <?php social_share_icons(); ?>
                        </div>
                    <?php } ?>
                    

                    <?php
                    // Show/Hide author box
                    if ( $ti_option['single_author'] == 1 ) {
                        get_template_part( 'inc/author', 'box' );
                    }
                    ?>
                    

                    <?php
                    // Show/Hide related posts
                    if ( $ti_option['single_related'] == 1 ) {
                        get_template_part( 'inc/related', 'posts' );
                    }
                    ?>
                    
                    
                    <?php
                    // Show/Hide Previous Post / Next Post Navigation
                    if ( $ti_option['single_nav_arrows'] == 1 ) {
                       single_posts_nav();
                    }
                    ?>
                

                    <?php comments_template(); // Post Comments ?>        

                    
                <?php if ( ! $single_sidebar || $single_sidebar == "post_sidebar_on" ) : // Enable/Disable post sidebar ?>
                    
                    </div><!-- .grid-8 -->
                    <?php get_sidebar(); ?>
                        
                <?php endif; ?>
                        
                </div><!-- .grids -->
            </div><!-- .wrapper -->
                
        
            <?php single_schema_markup(); // Rich Snippets Markup ?>
                
                
        </div><!-- .post -->
            
    <?php endwhile; endif; ?>

    </main><!-- #content -->

    <?php
    // Show/Hide random posts slide dock
    if ( $ti_option['single_slide_dock'] == 1 ) :
        get_template_part( 'inc/slide', 'dock' );
    endif;
    ?>
    
<?php get_footer(); ?>