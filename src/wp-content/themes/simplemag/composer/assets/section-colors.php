<?php 
/**
 * Background, elements and titles colors 
 * for sections Page Composer sections:
 *
 * Latest Posts (Newest)
 * Featured Posts
 * Latest By Category
 * Latest By Format
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


/**
 * Section Background, elements and title colors
**/
if ( get_row_layout() == 'newest_posts' ) :

    $get_section_bg = get_sub_field( 'newest_bg_color' );
    $get_section_links = get_sub_field( 'newest_links_color' );
    $get_section_text = get_sub_field( 'newest_text_color' );

elseif ( get_row_layout() == 'hp_featured_posts' ) :

    $get_section_bg = get_sub_field( 'featured_bg_color' );
    $get_section_links = get_sub_field( 'featured_links_color' );
    $get_section_text = get_sub_field( 'featured_text_color' );

elseif ( get_row_layout() == 'latest_by_category') :

    $get_section_bg = get_sub_field( 'category_bg_color' );
    $get_section_links = get_sub_field( 'category_links_color' );
    $get_section_text = get_sub_field( 'category_text_color' );


elseif ( get_row_layout() == 'latest_by_format' ) :

    $get_section_bg = get_sub_field( 'format_bg_color' );
    $get_section_links = get_sub_field( 'format_links_color' );
    $get_section_text = get_sub_field( 'format_text_color' );

endif;



if (   get_row_layout() == 'newest_posts'
    || get_row_layout() == 'hp_featured_posts'
    || get_row_layout() == 'latest_by_category'
    || get_row_layout() == 'latest_by_format' ) :

    // Class for section background
    if ( $get_section_bg != '#ffffff' && ! empty( $get_section_bg ) ) :
        $get_section_bg = substr( $get_section_bg, 1 );
        $section_bg = ' full-width-section bg-' . sanitize_html_class( $get_section_bg );
        $title_with_sep = '';
    else :
        $section_bg = '';
        $title_with_sep = ' title-with-sep';
    endif;


    // Class for section elements
    if ( $get_section_links != '000000' && ! empty( $get_section_links ) ) :
        $get_section_links = substr( $get_section_links, 1 );
        $section_links = ' links-' . sanitize_html_class( $get_section_links );
    else :
        $section_links = '';
    endif;


    // Class for posts titles
    if ( $get_section_text != '000000' && ! empty( $get_section_text ) ) :
        $get_section_text = substr( $get_section_text, 1 );
        $section_text = ' text-' . sanitize_html_class( $get_section_text );
    else :
        $section_text = '';
    endif;

endif;