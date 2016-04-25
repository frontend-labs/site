<?php
/**
 * Posts Section
 * Page Composer section.
 *
 * @package SimpleMag
 * @since   SimpleMag 1.1
**/


 if ( get_sub_field( 'latest_posts_sidebar' ) != '' ) {
    $with_sidebar = ' with-sidebar';
}
?>

<section class="wrapper home-section posts-section<?php echo isset( $with_sidebar ) ? $with_sidebar : ''; ?>">
    
    <?php
    // If Sidebar
    if ( get_sub_field( 'latest_posts_sidebar' ) != '' ) :
    ?>
        <div class="grids">
            <div class="grid-8 column-1">
    <?php endif; // End if sidebar ?>
        
        
        <?php
        /**
         * Section Main & Sub titles
        **/
        $main_title = get_sub_field( 'latest_main_title' );
        $sub_title = get_sub_field( 'latest_sub_title' );

        if( $main_title || $sub_title ) : ?>
        <header class="section-header">
            <div class="section-title title-with-sep ">
                <h2 class="title"><?php echo $main_title; ?></h2>
            </div>
            <?php if ( $sub_title ): ?>
            <span class="sub-title"><?php echo $sub_title; ?></span>
            <?php endif; ?>
        </header>
        <?php endif; ?>
        
                
        <?php
        // Exclude Categories from loop. Selected in Latest Post section.
        $latest_posts_exclude = get_sub_field( 'latest_posts_exclude' );
        if ( $latest_posts_exclude ):
            foreach( $latest_posts_exclude as $term ):
                $get_cats[] = '-'.$term->term_id;
            endforeach;
            $excluded_cats = implode( ",",$get_cats );
        else:
            $excluded_cats = '';
        endif;
        
        
        // How many posts to show
        $posts_to_show = get_sub_field( 'latest_posts_per_page' );

        // Start the section from post a selected post number:
        $offset_numb = get_sub_field( 'latest_start_from' ) - 1;


        // Pass all loops arguments for all section types
        // Each loop args accepts $posts_to_show & $offset_numb vars
        include locate_template( 'composer/assets/posts-section-loop-args.php' );
        
        
        /**
         * Start The Loop
        **/
        $ti_latest_posts = new WP_Query( $univer_posts_section );
        
        if ( $ti_latest_posts->have_posts() ) :
            
    
            $posts_layout = get_sub_field( 'latest_posts_layout' ); //--> Posts layout
            $cols_number = get_sub_field( 'latest_cols_number' ); //--> Number of columns
    
        ?>
            
            <div class="grids <?php echo $posts_layout . ' ' . $cols_number; ?> entries">

                <?php
                while ( $ti_latest_posts->have_posts() ) : $ti_latest_posts->the_post();

                    // Get all posts
                    get_template_part( 'content', 'post' );

                    // Insert ad only if the option is not equal to No Ad option
                    include locate_template( 'composer/assets/insert-ad.php' );

                endwhile;
                ?>
                
            </div>
          
            <?php wp_reset_postdata(); ?>
            
            
                
            <?php
            // Button for Latest  By Category
            if ( get_sub_field( 'latest_section_type' ) == 'latest_by_category' ) :
                    latest_by_category_button();
            endif;
            ?>
            
                
         <?php else: ?>

            <p class="grid-12 message">
                <?php _e( 'Sorry, no posts were found', 'themetext' ); ?>
            </p>

         <?php endif; ?>
                
    
    <?php 
    // If Sidebar
    if ( get_sub_field( 'latest_posts_sidebar' ) != '' ) :
    ?>
            </div><!-- .grid-8 .column-1 -->
            
            <?php 
            global $ti_option; 
            if ( $ti_option['site_sidebar_fixed'] == true ) { 
                $sidebar_fixed = ' sidebar-fixed'; 
            }
            ?>
            <div class="grid-4 column-2<?php echo isset( $sidebar_fixed ) ? $sidebar_fixed : ''; ?>">
                <aside class="sidebar">
                    <?php dynamic_sidebar( get_sub_field( 'latest_posts_sidebar' ) ); ?>
                </aside>
            </div><!-- .grid-4 .column-2 -->
            
        </div><!-- .grids -->
    
    <?php endif; // End if sidebar ?>
    
</section><!-- Latest Posts -->