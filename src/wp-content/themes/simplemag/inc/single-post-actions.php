<?php 
/**
 * Actions for single.php file
 * which displays the single post
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/



/**
 * Posts Header. H1, Category, Date and Author.
**/
function single_post_header_output() {

    global $ti_option;
    
?>

    <header class="wrapper entry-header page-header">
        <div class="entry-meta">
            <?php 
            // Post meta data: Category & Date 
            if ( $ti_option['single_post_cat_name'] == true ) {
                echo '<span class="entry-category">'; the_category(', '); echo '</span>';
            }

            if ( $ti_option['single_post_date'] == 1 ) {
                echo '<time class="entry-date published" datetime="' . get_the_time( 'c' ) . '">' . get_the_time( get_option( 'date_format' ) ) . '</time>';
                echo '<time class="updated" datetime="' . get_the_modified_date( 'c' ) . '">' . get_the_modified_date( get_option( 'date_format' ) ) . '</time>';
            }
            ?>
        </div>
        <div class="page-title title-with-sep single-title">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </div>
        <?php 
        // Post Author
        if( $ti_option['single_author_name'] == 1 ) :
        ?>
        <span class="entry-author">
            <span class="written-by"><?php _e( 'by','themetext' ); ?></span>
            <span class="author vcard">
                <a class="url fn n" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author"><?php the_author_meta( 'display_name' ); ?></a>
            </span>
        </span>
        <?php endif; ?>
    </header>


<?php
} // Post Header



/**
 * Full Width Title
**/
function single_title_full_width() {
    
    global $ti_option;
    
    if (   $ti_option['single_title_position'] == 'fullwidth' 
        || $ti_option['single_title_position'] == 'useperpost' 
        && ! get_field( 'post_title_position' ) == 'title_full_width' ) :
   
        // Post Header
        single_post_header_output();
    
    elseif (   $ti_option['single_title_position'] == 'useperpost'
            && get_field( 'post_title_position' ) == 'title_full_width' ) :

        // Post Header
        single_post_header_output();
    
    endif;
    
} // Single Post Title



/**
 * Above The Content Title
**/
function single_title_above_content() {
    
    global $ti_option;
    
    if ( $ti_option['single_title_position'] == 'abovecontent' ) :
    
        // Post Header
        single_post_header_output();
    
    elseif (   $ti_option['single_title_position'] == 'useperpost' 
            && get_field( 'post_title_position' ) == 'title_above_content' ) :
    
        // Post Header
        single_post_header_output(); 
    
    endif;
    
} // Single Post Title



/**
 * Full Width Media Position
**/
function single_media_full_width() {

    global $post, $ti_option;
        
    // Output media from every post by Full Width option
    if (   $ti_option['single_media_position'] == 'useperpost'
        && get_post_meta( $post->ID, 'post_media_position', true ) == 'media_full_width'
        || $ti_option['single_media_position'] == 'fullwidth' ) :
    ?>

        <div class="entry-media">
            <?php post_format_output(); // Output post format selected from the Format box ?>
        </div>

    <?php
    endif;
    
}


/**
 * Above The Content Media Position
**/
function single_media_above_content() {

    global $post, $ti_option;
        
    // Output media from every post by Above The Content option
    if (   $ti_option['single_media_position'] == 'useperpost' 
        && get_post_meta( $post->ID, 'post_media_position', true ) == 'media_above_content' 
        || $ti_option['single_media_position'] == 'abovecontent' ) :
    ?>

        <div class="entry-media">
             <?php post_format_output(); // Output post format selected from the Format box ?>
        </div>

    <?php 
    endif;
    
}


/**
 * Main Content which comes from the editor
**/
function single_main_content() {
 
    
    // Output the main editor content
    the_content();

    
    // Output pagination if post uses <!--nextpage--> short tag
    $args = array(
        'before' => '<div class="link-pages"><h3 class="single-box-title">' . __( 'Continue Reading', 'themetext' ) . '</h3>',
        'after' => '</div>',
        'link_before' => '<span>',
        'link_after' => '</span>',
        'nextpagelink'     => '&rarr;',
        'previouspagelink' => '&larr;',
        'next_or_number'   => 'next_and_number',
    );
    wp_link_pages( $args );
    
}



/**
 * Previous Post/ next Post navigation
**/
function single_posts_nav() {
   
    $prev_post = get_previous_post();
    $next_post = get_next_post();
    ?>
    <nav class="single-box clearfix nav-single">
        <?php if ( !empty( $prev_post ) ) { ?>
        <div class="nav-previous">
            <?php previous_post_link ( '%link', '<i class="icomoon-chevron-left"></i><span class="nav-title">' . __( 'Previous article', 'themetext' ) . '</span>%title', TRUE ); ?>
        </div>
        <?php } ?>

        <?php if ( !empty( $next_post ) ){ ?>
        <div class="nav-next">
            <?php next_post_link( '%link', '<i class="icomoon-chevron-right"></i><span class="nav-title">' . __( 'Next article', 'themetext' ) . '</span>%title', TRUE ); ?>
        </div>
        <?php } ?>
    </nav><!-- .nav-single -->

    <?php
}



/**
 * Rich Snippets (Schema) markup for single post.
 * Can consits data about:
 * article, author, image, video, review and rating.
**/
function single_schema_markup() {
?>
    <div itemscope itemtype="http://schema.org/Article">
        <meta itemscope itemprop="mainEntityOfPage" itemType="https://schema.org/WebPage" itemid="<?php the_permalink(); ?>" />
        <div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
            <?php global $ti_option; $itemprop_logo = $ti_option['site_logo']; ?>
            <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                <meta itemprop="url" content="<?php echo esc_url( $itemprop_logo['url'] ); ?>" />
            </div>
            <meta itemprop="name" content="<?php esc_attr( bloginfo( 'name' ) ); ?>" />
        </div>
        <meta itemprop="headline" content="<?php the_title(); ?>" />
        <meta itemprop="datePublished" content="<?php the_time( 'c' ); ?>"/>
        <meta itemprop="dateModified" content="<?php the_modified_date( 'c' ); ?>" />
        <div itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
            <meta itemprop="name" content="<?php printf( __( '%s', 'themetext' ), get_the_author() ); ?>" />
        </div>
        <meta itemprop="description" content="<?php echo get_the_excerpt(); ?>" />
        <?php
        /**
         * Get featured image or first 
         * image from a post and pass the 
         * URL into meta tag for Schema markup.
        **/
        if ( has_post_thumbnail() ) :
            $article_image_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'rectangle-size-big' );
            $article_image = $article_image_src[0];
        else :
            $article_image = first_post_image();
        endif;

        /**
         *  Video Object
        **/
        if ( 'video' == get_post_format() ) :
            /**
             * Get Video field value
            **/
            global $post;
            $video_page_url = get_post_meta( $post->ID, 'add_video_url', true );
            ?>
            <div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
                <meta itemprop="name" content="<?php the_title(); ?>" />
                <meta itemprop="thumbnailUrl" content="<?php echo esc_attr( $article_image ); ?>" />
                <meta itemprop="embedURL" content="<?php echo esc_attr( $video_page_url ); ?>" />
                <meta itemprop="uploadDate" content="<?php the_time( 'c' ); ?>" />
                <meta itemprop="description" content="<?php echo get_the_excerpt(); ?>" />
            </div>
        <?php endif; ?>
        
        <?php if ( has_post_thumbnail() || first_post_image() ) : ?>
            <div itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
                 <meta itemprop="url" content="<?php echo esc_attr( $article_image ); ?>" />
                 <meta itemprop="width" content="570" />
                 <meta itemprop="height" content="381" />
            </div>
        <?php endif; ?>
        
        <?php if ( get_field( 'enable_rating' ) == true ) : ?>
            <div itemscope itemtype="http://schema.org/Review">
                <?php 
                $rating_note = get_field( 'rating_note' );        
                if ( $rating_note ) : 
                ?>
                <meta itemprop="description" conten="<?php echo $rating_note; ?>" />
                <?php endif; ?>
                <meta itemprop="itemReviewed" content="<?php the_title(); ?>" />
                <meta itemprop="author" content="<?php the_author_meta( 'display_name' ); ?>" />
                <meta itemprop="datePublished" content="<?php the_time( 'c' ); ?>" />
                    <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                        <?php
                        $get_result = apply_filters( 'ti_score_total', '' );
                        $total_score = number_format( $get_result, 1, '.', '' );
                        if ( strlen ( $total_score ) || $total_score == '10.0' ) :
                            $final_result = str_replace( ".0", "", $total_score );
                        else :
                            $final_result = $total_score;
                        endif;
                        ?>      
                        <meta itemprop="worstRating" content="1">
                        <meta itemprop="ratingValue" content="<?php echo esc_html( $final_result ); ?>">
                        <meta itemprop="bestRating" content="10">
                    </div>
            </div>
        <?php endif; ?>
        
    </div>
    
<?php }