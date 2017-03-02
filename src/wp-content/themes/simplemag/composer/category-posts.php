<?php 
/**
 * Latest Posts by Category
 * Page Composer Section
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


/**
 * Section Colors: 
 * Background, elements and post titles.
**/
include locate_template( 'composer/assets/section-colors.php' );
?>


<section class="home-section penta-box category-posts<?php echo $section_bg . '' . $section_text. '' . $section_links; ?>">
    
    <div class="wrapper">
        
        <?php
        /**
         * Section Main & Sub titles
        **/
        $main_title = get_sub_field( 'category_main_title' );
        $sub_title = get_sub_field( 'category_sub_title' );

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


        <div class="grids grid-layout entries">

            <?php
            $cats_to_show = get_sub_field( 'category_posts_per_page');
            $cat_id = get_sub_field( 'category_section_name' );

            $ti_cat_posts = new WP_Query(
                array(
                    'posts_per_page' => 5,
                    'cat' => $cat_id
                )
            );


            if ( $ti_cat_posts->have_posts() ) :


                $posts_column = 0; // Count the posts

                while ( $ti_cat_posts->have_posts() ) : $ti_cat_posts->the_post();



                    if ( $posts_column == 0 ) : // Middle column - latest post

                        echo '<div class="grid-6 column-middle">';

                    elseif ( $posts_column % 2 == 1 ) : // Left & Right columns

                        if ( $posts_column == 1 ) :
                            $column_position = 'left'; // Left column class
                        else :
                            $column_position = 'right'; // Right column class
                        endif;

                        echo '<div class="grid-3 column-secondary column-' . $column_position . '">';

                    endif;
                    ?>

                        <article <?php post_class(); ?>>
                            
                            <figure class="entry-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php
                                    if ( has_post_thumbnail() ) {
                                        if ( $posts_column == 0 ) {
                                            the_post_thumbnail( 'rectangle-size-big' ); // Big image for middle column
                                        } else {
                                            the_post_thumbnail( 'rectangle-size-small' ); // Rectangle size for left & right columns
                                        }
                                    } elseif( first_post_image() ) { // Set the first image from the editor
                                        echo '<img src="' . first_post_image() . '" class="wp-post-image" />';
                                    } ?>
                                </a>
                            </figure>

                            
                            <header class="entry-header">
                                
                                <span class="written-by"><?php _e( 'by','themetext' ); ?></span>
                                <a class="author" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
                                    <?php the_author_meta( 'display_name' ); ?>
                                </a>
                                
                                <h2 class="entry-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                            </header>

                            <?php if ( $posts_column == 0 ) : ?>
                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
                            <?php endif; ?>
                        </article>

                    <?php
                    if ( $posts_column % 2 == 0 ) :

                        echo '</div>'; // Close all columns: left, middle and right

                    endif;
                
                    $posts_column++;

                endwhile;

                wp_reset_postdata();


            endif; 
            ?>

        </div>


        <?php
        // Enable/Disable View The Category button
        if ( get_sub_field( 'category_button' ) == 'cat_but_enable' ) :

            latest_by_category_button();

        endif; 
        ?>
    
    </div><!-- .wrapper -->
    
</section><!-- Latest By Category: <?php echo get_category( $cat_id )->name; ?> -->