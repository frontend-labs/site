<?php
/**
 * Theme Styling Options Helpers.
 * Refer to Theme Options & Page Composer sections.
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/
function ti_custom_styling() {
global $ti_option;

?>
<style type="text/css">
.header .logo{max-width:<?php echo $ti_option['site_logo']['width']; ?>px;}
.main-menu .sub-links .active-link,
.main-menu .mega-menu-item:hover .item-title a,
.main-menu > ul > .sub-menu-columns > .sub-menu > .sub-links > li > a {color:<?php echo $ti_option['main_sub_links_left']['hover']; ?>;}
    
.main-menu .sub-menu-two-columns > .sub-menu > .sub-links li a:after {background-color:<?php echo $ti_option['main_sub_links_left']['hover']; ?>;}

.main-menu .posts-loading:after {border-top-color:<?php echo $ti_option['main_sub_links_left']['hover']; ?>;border-bottom-color:<?php echo $ti_option['main_sub_links_left']['hover']; ?>;}
 
.secondary-menu ul > li:hover > a {color:<?php echo $ti_option['site_top_strip_links']['hover']; ?>;}
 
.main-menu > ul > .link-arrow > a:after {border-color:transparent transparent <?php echo $ti_option['main_sub_menu_pointer']; ?>;}

.main-menu > ul > li > .sub-menu {border-top-color:<?php echo $ti_option['main_sub_menu_pointer']; ?>;}
    
.main-menu .mega-menu-container .mega-menu-posts-title:hover:after{color:<?php echo $ti_option['main_sub_links_left']['regular']; ?>;}
 
.top-strip #searchform input,
.top-strip #searchform button{color:<?php echo $ti_option['site_top_strip_links']['regular']; ?>}

.modern .content-over-image-tint .entry-image:before,
.modern .content-over-image-tint.full-width-image:before{opacity:<?php echo $ti_option['slider_tint_strength']; ?>;}
.modern .content-over-image-tint:hover .entry-image:before,
.modern .content-over-image-tint.full-width-image:hover:before,
.modern .content-over-image-tint .gallery-item:not(.slick-active) .entry-image:before{opacity:<?php echo $ti_option['slider_tint_strength_hover']; ?>;}

.sidebar .widget{border-bottom:1px solid <?php echo $ti_option['sidebar_border']['border-color']; ?>;}

.footer-sidebar .widget_rss li:after,
.footer-sidebar .widget_pages li a:after,
.footer-sidebar .widget_nav_menu li a:after,
.footer-sidebar .widget_categories ul li:after,
.footer-sidebar .widget_recent_entries li:after,
.footer-sidebar .widget_recent_comments li:after{background-color:<?php echo $ti_option['footer_links']['regular']; ?>;}

.entry-title {text-transform:<?php echo $ti_option['post_title_style']; ?>;}
    
<?php if ($ti_option['titles_background_switch'] == true && $ti_option['titles_background_image'] == true  ){ ?>
.title-with-sep{background:url("<?php echo get_template_directory_uri(); ?>/images/section-header.png") repeat-x 0 50%;}
<?php } ?>

<?php
/**
 * Woocommerce style
**/
if( function_exists ( 'is_woocommerce' ) && is_woocommerce() ) {
?>
.price, .stock, .side-shopping-cart .ssc-button .amount, span.onsale, .button, .added_to_cart, td.product-name{font-family:<?php echo $ti_option['font_titles']['font-family']; ?>;}
<?php } ?>
    
<?php
/**
 * Posts Section Background & Text Colors
 *
 * If selected displays in five places:
 * Featued Posts, Latest By Category, Latest By Format, Latest Reviews & Latest Posts
**/
if( have_rows( 'page_composer' ) ) :
    
    while( have_rows( 'page_composer' ) ) : the_row();
        

        /**
         * Colors For Different Sections:
         * Latest Posts, Featured Posts, Latest By Category, Latest By Format
        **/
        $latest_posts = get_row_layout() == 'newest_posts';
        $featured_posts = get_row_layout() == 'hp_featured_posts';
        $cat_posts = get_row_layout() == 'latest_by_category';
        $format_posts = get_row_layout() == 'latest_by_format';
    
        
        if ( $latest_posts ) :
            
            $section_bg = get_sub_field( 'newest_bg_color' );
            $section_links = get_sub_field( 'newest_links_color' );
            $section_text = get_sub_field( 'newest_text_color' );
    
        elseif( $featured_posts ) :
            
            $section_bg = get_sub_field( 'featured_bg_color' );
            $section_links = get_sub_field( 'featured_links_color' );
            $section_text = get_sub_field( 'featured_text_color' );
        
        elseif ( $cat_posts ) :
            
            $section_bg = get_sub_field( 'category_bg_color' );
            $section_links = get_sub_field( 'category_links_color' );
            $section_text = get_sub_field( 'category_text_color' );
    
        
        elseif ( $format_posts ) :
    
            $section_bg = get_sub_field( 'format_bg_color' );
            $section_links = get_sub_field( 'format_links_color' );
            $section_text = get_sub_field( 'format_text_color' );
                
        endif;
        
    
        /**
         * Print the colors based on section
        **/
        if( $latest_posts || $featured_posts || $cat_posts || $format_posts ) :
    
            // Section background color
            if ( $section_bg != '#ffffff' && ! empty( $section_bg ) ) {
                
                // Set HEX bg color as class name without #
                $section_bg = substr( $section_bg, 1 );
                $section_class = '.bg-' . $section_bg;
                
                echo $section_class . ', '.$section_class . ' .entry-details, '.$section_class . ' .read-more, '.$section_class . ' .carousel-navigation, '.$section_class . ' .column-left .entry-header .entry-meta .entry-category, '.$section_class . ' .column-middle .entry-header .entry-meta .entry-category {background-color:#' . $section_bg . ';}';
               
            }
    

            // Section Links color
            if ( $section_links != '000000' && ! empty( $section_links ) ) {
                
                $section_links = substr( $section_links, 1 );
                $section_class = '.links-' . $section_links;
                
                echo $section_class.' a,' . $section_class . ' .slick-dots li,' . $section_class . ' .slick-dots li button{color:#' . $section_links . ';}';
                
                if ( $cat_posts || $format_posts ) {
                    echo $section_class.' .read-more{color:#' . $section_links . ';border-color:#' . $section_links . ';}' . $section_class.' .media-post-thumbs .thumbs-item:after{border-color:#' . $section_links . ';}' . $section_class.' .read-more:hover{box-shadow:1px 1px #' . $section_links . ', 2px 2px #' . $section_links . ', 2px 2px #' . $section_links . ';}';
                }
            }
    
    
            // Section Text color
            if ( $section_text != '000000' && ! empty( $section_text ) ) {
                
                $section_text = substr( $section_text, 1 );
                $section_class = '.text-' . $section_text;
                
                echo $section_class.' h2, '.$section_class.' .sub-title, '.$section_class.' .entry-header .written-by, '.$section_class.' .entry-summary{color:#' . $section_text . ';}';
                
                if ( $featured_posts ) {
                     echo '.featured-posts' . $section_class . ' .slider-nav-arrow{color:#' . $section_text . ';border-color:#' . $section_text . ';}.featured-posts' . $section_class . ' .column-right .post-item-inner:before{background-color:#' . $section_text . ';}';
                }
                
                if ( $latest_posts ) {
                     echo '.latest-posts' . $section_class . ' .column-right .post-item:after{background-color:#' . $section_text . ';}';
                }
                
            }
    
        endif;

        
    
        /**
         * Full Width Image section background
        **/
        if( get_row_layout() == 'full_width_image' ) :
            
            $get_image_bg = get_sub_field( 'full_image_upload' );

            if ( ! empty( $get_image_bg ) ) {
                $image_bg = '.image-' . $get_image_bg['id'];
            }
    
            echo $image_bg . '{background-image:url(' . $get_image_bg['url'] . ');}';
    
        endif;
     
    
    endwhile;
    
endif;
?>
    
<?php if ($ti_option['titles_background_switch'] == true && $ti_option['titles_background_image'] == false ){ ?>
.title-with-sep{background:url("<?php echo $ti_option['titles_background_upload']['url']; ?>") repeat-x 50%;}
<?php } ?>
@media only screen and (min-width: 960px) {#gallery-carousel,#gallery-carousel .gallery-item{height:<?php echo $ti_option['site_carousel_height'] ?>px;}}
<?php if ( $ti_option['custom_css'] != '' ) { ?>
/* Custom CSS */
<?php echo $ti_option['custom_css']; ?>
<?php } ?>
</style>
<?php } ?>
<?php add_action( 'wp_head', 'ti_custom_styling' ); ?>