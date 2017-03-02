<?php 
/**
 * FUnctions for content-post.php which displays 
 * the post item for: 
 * 1. Page Composer sections.
 * 2. Posts page.
 * 3. Archives such as categories, author page, tags.
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/



/**
 * Post Image
**/
function content_post_item_image() {
    
    // Start image buffer
    ob_start();
?>

        <div class="entry-image">
            <div class="entry-image-inner">

                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <span class="image-tint">
                        <?php
                        /** 
                        * Different image size based on layout selection for
                        * Homepage, Categories and Posts Page
                        **/
                        do_action( 'post_item_image' );
                        ?>
                    </span>
                </a>

                <?php
                /**
                 * Behaviour based on post format
                **/

                // Gallery
                if ( 'gallery' == get_post_format() ) :

                    echo '<i class="icomoon-camera-retro"></i>';

                // Video
                elseif ( 'video' == get_post_format() ) :

                    $url_value = 'add_video_url';
                    echo '<a href="#" class="load-media-content" data-postid="' . get_the_ID() . '" data-metakey="' . esc_attr( $url_value ) . '"></a><div class="media-content"></div>';

                // Audio
                elseif ( 'audio' == get_post_format() ) :

                    $url_value = 'add_audio_url';
                    echo '<a href="#" class="load-media-content" data-postid="' . get_the_ID() . '" data-metakey="' . esc_attr( $url_value ) . '"></a><div class="media-content"></div>';

                endif;
                ?>

                <?php
                // If post has rating, show the score.
                if ( get_field( 'enable_rating' ) == 'true' ) :

                    // Call total score calculation function
                    $get_result = apply_filters( 'ti_score_total', '' );

                    // Get the final score
                    $total_score = number_format( $get_result, 1, '.', '' );

                    // If final score is decimal like 5.0 or is equal to 10.0
                    // remove .0 to display it as integer
                    if ( strlen ( $total_score ) || $total_score == '10.0' ) {
                        $final_result = str_replace( ".0", "", $total_score );
                    } else {
                        $final_result = $total_score;
                    }
                    ?>

                    <span class="score-line" style="width:<?php echo ($total_score * 10) ?>%;">
                        <span><i class="show-total"><?php echo $final_result; ?></i></span>
                    </span>

                <?php endif; ?>

            </div>
        </div>

<?php
    $content_post_image = ob_get_clean();
    // End image buffer
    
    
    /* Output in Page Composer */
    if ( is_page_template ( 'page-composer.php' ) ) :
    
        $sd_image = get_sub_field( 'post_item_displays' );
        $displays_image = is_array( $sd_image ) && in_array ( 'sd_image', $sd_image );
    
    
        /* Output the the image */
        if ( $displays_image ) :

           echo $content_post_image;

        endif;
    
    /* Output in Archives */
    else :
    
            echo $content_post_image;
    
    endif;
    
} // End Image




/**
 * Category & Date Display
**/
function content_post_item_meta() {
    
    /* Output in Page Composer */
    if ( is_page_template ( 'page-composer.php' ) ) :
    
        $sd_meta = get_sub_field( 'post_item_displays' );
        $displays_cat = is_array( $sd_meta ) && in_array ( 'sd_category', $sd_meta );
        $displays_date = is_array( $sd_meta ) && in_array ( 'sd_date', $sd_meta );
        ?>
        
        <div class="entry-meta">
            <?php if ( $displays_cat ) { ?>
                <span class="entry-category">
                    <?php the_category( ', ' ); ?>
                </span>
            <?php } ?>

            <?php if ( $displays_date ) { ?>
                 <time class="entry-date published" datetime="<?php the_time( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
                 <time class="updated" datetime="<?php the_modified_time( 'c' ); ?>"><?php the_modified_time( get_option( 'date_format' ) ); ?></time>
            <?php } ?>
        </div>
    
    <?php
    /* Output in Archives */
    else :
    ?>
        
        <div class="entry-meta">
            <?php if ( ! is_category() ) { // Do not display category name in category pages  ?>
            <span class="entry-category">
                <?php the_category( ', ' ); ?>
            </span>
            <?php } ?>

            <?php 
            // Date
            global $ti_option;
            if ( $ti_option['post_item_date'] == '1' ) : 
            ?>
                <time class="entry-date published" datetime="<?php the_time( 'c' ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></time>
                <time class="updated" datetime="<?php the_modified_time( 'c' ); ?>"><?php the_modified_time( get_option( 'date_format' ) ); ?></time>
            <?php endif; ?>
        </div>

    <?php
    endif;

} // End Category & Date Display



/**
 * Post Title
**/
function content_post_item_title() {
    
    /* Output in Page Composer */
    if ( is_page_template( 'page-composer.php') ) :
    
        $sd_title = get_sub_field( 'post_item_displays' );
        $displays_title = is_array( $sd_title ) && in_array ( 'sd_title', $sd_title );
        ?>
    
        <?php if ( $displays_title ) : ?>
            <h2 class="entry-title">
                <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
            </h2>
        <?php endif;
    
    /* Output in Archives */
    else :
    ?>

        <h2 class="entry-title">
            <a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>

    <?php
    endif;

} // End Post Title



/**
 * Post Author
**/
function content_post_item_author() {
    
    /* Output in Page Composer */
    if ( is_page_template( 'page-composer.php' ) ) :
        
        $sd_title = get_sub_field( 'post_item_displays' );
        $displays_author = is_array( $sd_title ) && in_array ( 'sd_author', $sd_title );
        ?>
        
        <?php if ( $displays_author ) : ?>
            <span class="written-by"><?php _e( 'by','themetext' ); ?></span>
            <span class="author vcard">
                <a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
                    <?php the_author_meta( 'display_name' ); ?>
                </a>
            </span>
        <?php endif;
    
    /* Output in Archives */
    elseif ( ! is_author() ) : // Do not display author name in author pages
    ?>
        <?php 
        global $ti_option;
        if ( $ti_option['post_item_author'] == '1' ) : 
        ?>
            <span class="written-by"><?php _e( 'by','themetext' ); ?></span>
            <span class="author vcard">
                <a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
                    <?php the_author_meta( 'display_name' ); ?>
                </a>
            </span>
        <?php endif; ?>

    <?php
    endif;
        
} // End Post Author



/**
 * Post Excerpt
**/
function content_post_item_excerpt() {
    
    /* Output in Page Composer */
    if ( is_page_template( 'page-composer.php' ) ) :
    
        $sd_excerpt = get_sub_field( 'post_item_displays' );
        $displays_excerpt = is_array( $sd_excerpt ) && in_array ( 'sd_excerpt', $sd_excerpt );
        ?>

        <?php if ( $displays_excerpt ) : ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>
        <?php endif; ?>
    
    <?php
    /* Output in Archives */
    else :
    ?>
        
        <?php
        global $ti_option;
        if ( $ti_option['post_item_excerpt'] == '1' ) :
        ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div>
        <?php endif; ?>
    
    <?php
    endif;

} // End Excerpt



/**
 * Post Social Icons
**/
function content_post_item_social_icons() {
    
    /* Output in Page Composer */
    if ( is_page_template( 'page-composer.php' ) ) :
    
        $sd_social = get_sub_field( 'post_item_displays' );
        $displays_social = is_array( $sd_social ) && in_array ( 'sd_social', $sd_social );
        
        if ( $displays_social ) :
             social_share_icons();
        endif;

    /* Output in Archives */
    else :
        
        global $ti_option;
        if ( $ti_option['post_item_share'] == '1' ) :
            social_share_icons();
        endif;

    endif;

} // End Social Icons



/**
 * Post Read More Link
**/
function content_post_item_read_more() {
    
    /* Output in Page Composer */
    if ( is_page_template( 'page-composer.php' ) ) :
    
        $sd_read_more = get_sub_field( 'post_item_displays' );
        $displays_read_more = is_array( $sd_read_more ) && in_array ( 'sd_read', $sd_read_more );
        
        if ( $displays_read_more ) :
             echo '<a class="read-more-link" href="' . get_the_permalink(). '">' . __( 'Read More', 'themetext' ) . '</a>';
        endif;

    /* Output in Archives */
    else :
        
        global $ti_option;
        if ( $ti_option['post_item_read_more'] == '1' ) :
            echo '<a class="read-more-link" href="' . get_the_permalink(). '">' . __( 'Read More', 'themetext' ) . '</a>';
        endif;

    endif;

} // End Read More Link