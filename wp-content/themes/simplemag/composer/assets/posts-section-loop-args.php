<?php
/**
 * Loop arguments for Posts Section
 *
 * Applies to four section types:
 * Featured Posts, Latest By Category, Latest Reviews and Latest Posts.
**/


// The $posts_to_show & $offset_numb variables are declared in composer/posts-section.php


/**
 * Latest Posts 
**/
if ( get_sub_field ( 'latest_section_type' ) == 'latest_posts' ) :

    /** 
     * Latest Posts
    **/

    // Loop arguments
    $univer_posts_section = array(
        'posts_per_page' => $posts_to_show,
        'cat' => $excluded_cats,
        'offset' => $offset_numb,
        'post__not_in' => array( $post->ID ),
        'ignore_sticky_posts' => 1
    );



/**
 * Featured Posts 
**/
elseif ( get_sub_field ( 'latest_section_type' ) == 'hp_featured_posts' ) :

    /**
     * Loop Arguments
     * Add posts to this section only if the 'Make Featured'
     * custom field checkbox was checked on the Post edit screen
    **/

    $univer_posts_section = array(
        'meta_key' => 'featured_post_add',
        'meta_value' => '1',
        'posts_per_page' => $posts_to_show,
        'offset' => $offset_numb,
        'post__not_in' => array( $post->ID ),
        'ignore_sticky_posts' => 1
    );



/**
 * Latest By Category
**/
elseif ( get_sub_field ( 'latest_section_type' ) == 'latest_by_category' ) :

    /**
    * Loop Arguments.
    * Select how many posts to show and
    * get the category id which will filter the section
    **/

    $cat_id = get_sub_field( 'latest_select_category' );

    $univer_posts_section = array(
        'cat' => $cat_id,
        'posts_per_page' => $posts_to_show,
        'offset' => $offset_numb,
        'post__not_in' => array( $post->ID ),
        'ignore_sticky_posts' => 1
    );




/**
 * Latest Reviews 
**/
elseif ( get_sub_field ( 'latest_section_type' ) == 'latest_reviews' ) :

   /** 
     * Loop Arguments
     * Posts with reviews.
     * Display posts only if Rating is enabled
    **/

    $univer_posts_section = array(
        'meta_key' => 'enable_rating',
        'meta_value' => '1',
        'posts_per_page' => $posts_to_show,
        'offset' => $offset_numb,
        'post__not_in' => array( $post->ID ),
        'ignore_sticky_posts' => 1
    );




/**
 * Latest By Format 
**/
elseif ( get_sub_field ( 'latest_section_type' ) == 'latest_by_format' ) :


   /** 
     * Loop Arguments
     * Posts with reviews.
     * Display posts only if Rating is enabled
    **/

    $show_format = get_sub_field( 'latest_select_format' );
    
    $format_query = array(
        'taxonomy' => 'post_format',
        'field' => 'slug',
        'terms' => 'post-format-'.$show_format
    );

    $univer_posts_section = array(
        'posts_per_page' => $posts_to_show,
        'tax_query' => array( $format_query ),
        'offset' => $offset_numb,
        'post__not_in' => array( $post->ID ),
        'ignore_sticky_posts' => 1
    );

endif;