<?php 
/**
 * Media Posts
 * Displays the three formats from the Format box:
 * Video, Audio, Gallery
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


/**
 * Section Colors:
 * Background, elements and post titles.
**/
include locate_template( 'composer/assets/section-colors.php' );


/**
 * Loop Arguments
 * Get the format name which will filter the section
**/
$format_name = get_sub_field( 'format_section_name' );
$posts_to_show = get_sub_field( 'format_posts_per_page' );

$media_query_args = array(
    'taxonomy' => 'post_format',
    'field' => 'slug',
    'terms' => 'post-format-'.$format_name
);

$media_query = new WP_Query(
    array(
        'post_type' => 'post',
        'posts_per_page' => $posts_to_show,
        'tax_query' => array( $media_query_args )
    )
);

/**
 * Section layout
**/
$format_layout = get_sub_field( 'format_section_layout' );

/**
 * Layout class
**/
if ( $format_layout == 'flayout_one' ) :
    $layout_class = 'media-layout-one';
elseif ( $format_layout == 'flayout_two' ) :
    $layout_class = 'media-layout-two full-width-section';
endif;
?>

<section class="home-section media-posts <?php echo $layout_class . ' media-posts-' . $format_name . '' . $section_bg . '' . $section_text. '' . $section_links; ?>">
    
    <div class="media-post-content">
    
        <?php
        /**
         * Section Main & Sub titles
        **/
        $main_title = get_sub_field( 'format_main_title' );
        $sub_title = get_sub_field( 'format_sub_title' );

        if( $main_title || $sub_title ) : ?>
        <header class="wrapper section-header">
            <div class="section-title<?php echo $title_with_sep; ?>">
                <h2 class="title"><?php echo $main_title; ?></h2>
            </div>
            <?php if ( $sub_title ): ?>
            <span class="sub-title"><?php echo $sub_title; ?></span>
            <?php endif; ?>
        </header>
        <?php endif; ?>
    
            
        <?php
        /**
         * Section layout
        **/
        if ( $format_layout == 'flayout_one' ) :
            include locate_template( 'composer/assets/media-posts-one.php' );
        elseif ( $format_layout == 'flayout_two' ) :
            include locate_template( 'composer/assets/media-posts-two.php' );
        endif;
        ?>
        
    </div><!-- media-post-content -->
    
</section><!-- Latest By Format -->