<?php
/**
 * SimpleMag Functions and Definitions
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/


// Welcome page after theme activation. Loads only in the admin.
if ( is_admin() && ! is_child_theme() ) {
	require_once( 'admin/simplemag-welcome.php' );
}


/* Install plugins for theme use */
include_once ( 'admin/tgm/tgm-init.php' );


/* Theme Options */
require_once( 'admin/theme-options.php' );


/**
 * Add Custom Fields
**/
// Path
function ti_acf_settings_path( $path ) {
    $path = get_template_directory() . '/admin/acf/';
    return $path;
}
add_filter('acf/settings/path', 'ti_acf_settings_path');

// Dir 
function ti_acf_settings_dir( $dir ) {
    $dir = get_template_directory_uri() . '/admin/acf/';
    return $dir;
}
add_filter('acf/settings/dir', 'ti_acf_settings_dir');

// Hide Updates Note
add_filter('acf/settings/show_updates', '__return_false');

// Lite Mode
add_filter('acf/settings/show_admin', '__return_false');
add_filter('acf/settings/show_updates', '__return_false');

// Include
include_once( get_template_directory() . '/admin/acf/acf.php' );

// Fields Array
include_once( 'admin/acf-fields/acf-fields.php' );

// Sections Sidebars
function ti_register_fields(){
    include_once('admin/acf-fields/add-ons/acf-sidebar-selector/acf-sidebar_selector-v5.php');
}
add_action('acf/include_fields', 'ti_register_fields');



/* Content Width */
if ( ! isset( $content_width ) ) {
    $content_width = 1170; /* pixels */
}


/* Theme Setup */
function ti_theme_setup() {
    
	/*
	 * Let WordPress manage the document title.
	 * Declare that this theme does not use a hard-coded <title>
	 * tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

    
	/* Register Menus  */
	register_nav_menus( array(
		'main_menu' => __( 'Main Menu', 'themetext' ), // Main site menu
		'secondary_menu' => __( 'Top Strip Menu', 'themetext' ) // Main site menu
	));
    
    
    /*
	 * Default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
    add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
    

	/*
	 * Enable support for Post Formats.
	 */
	add_theme_support( 'post-formats', array( 
        'video', 
        'gallery', 
        'audio', 
        'quote' 
    ) );

    
    
	/* Images */
	add_theme_support( 'post-thumbnails' );
    
        // Hard crop for grid layouts
        add_image_size( 'rectangle-size', 370, 247, true );
        add_image_size( 'rectangle-size-small', 270, 180, true );
        add_image_size( 'rectangle-size-big', 570, 381, true );

        // Variable height for masonry layouts
        add_image_size( 'masonry-size', 370, 9999 );
        add_image_size( 'masonry-size-big', 570, 9999 );
        add_image_size( 'medium-size', 770, 9999 );

        // Single Post
        add_image_size( 'big-size', 1170, 9999 );

        // Gallery
        global $ti_option;
        add_image_size( 'gallery-carousel', 9999, $ti_option['site_carousel_height'] );
    

    
	/* Enable post and comment RSS feed links */
	add_theme_support( 'automatic-feed-links' );

    
	/* Theme localization */
	load_theme_textdomain( 'themetext', get_template_directory() . '/languages' );
    
    
    
    /* Extra post class for design */
    function post_design_class( $design_class ) {
        if ( ! is_single() ) {
            $design_class[] = 'post-item';
        }
        return $design_class;
    }
    add_filter( 'post_class', 'post_design_class' );

    
    
    /* Enable theme gallery if it was turned ON in Theme Options */
    if ( $ti_option['site_custom_gallery'] == true ) {
	   include_once( 'inc/wp-gallery.php' );
    }
    
    
    /**
     * Post formats for Media Position option in Single Post.
     * Passed into the single.php
     **/
    function post_format_output() { 
        if ( ! get_post_format() ): // Standard
            get_template_part( 'formats/format', 'standard' );
        elseif ( 'gallery' == get_post_format() ): // Gallery
            get_template_part( 'formats/format', 'gallery' );
        elseif ( 'video' == get_post_format() ): // Video
            get_template_part( 'formats/format', 'video' );
        elseif ( 'audio' == get_post_format() ): // Audio
            get_template_part( 'formats/format', 'audio' );
        endif;
    }
    
    
    /**
     * Calculate to total score for posts with Rating feature is enabled
     *
     * Applies to:
     * 1. Latest Reviews & Latest Posts sections
     * 2. Latest Reviews widget
     * 3. Single Post
    **/
    function ti_rating_calc() {

        $score_rows = get_field( 'rating_module' );
        $score = array();

        // Loop through the scores
        if ( $score_rows ){
            foreach( $score_rows as $key => $row ){
                $score[$key] = $row['score_number'];
            }

            $score_items = count( $score ); // Count the scores
            $score_sum = array_sum( $score ); // Get the scores summ
            $score_total = $score_sum / $score_items; // Get the score result

            return $score_total;

        }
    }
    add_filter( 'ti_score_total', 'ti_rating_calc' );

}
add_action( 'after_setup_theme', 'ti_theme_setup' );


/* Includes */
include_once( 'inc/social-share.php' );
include_once( 'inc/user-fields.php' );
include_once( 'inc/mega-menu.php' );
include_once( 'inc/styling-options.php' );
include_once( 'inc/single-post-actions.php' );
include_once( 'inc/content-post-actions.php' );
include_once( 'inc/ad-units-actions.php' );


/* Register jQuery Scripts and CSS Styles */
include_once( 'inc/register-scripts.php' );


/* Functions for Composer Sections */
include_once( 'composer/assets/sections-functions.php' );


/* Widgets */
locate_template( 'widgets/ti-video.php', true );
locate_template( 'widgets/ti-authors.php', true );
locate_template( 'widgets/ti-about-site.php', true );
locate_template( 'widgets/ti-latest-posts.php', true );
locate_template( 'widgets/ti-code-banner.php', true );
locate_template( 'widgets/ti-image-banner.php', true );
locate_template( 'widgets/ti-latest-reviews.php', true );
locate_template( 'widgets/ti-featured-posts.php', true );
locate_template( 'widgets/ti-most-commented.php', true );
locate_template( 'widgets/ti-latest-comments.php', true );
locate_template( 'widgets/ti-latest-category-posts.php', true );


/**
 * Add classes to the body tag
**/
function ti_body_classes( $classes ){

	global $post, $ti_option;
	
	if ( !is_rtl() ) {
		$classes[] = 'ltr';
	}

	// Page Name as class name
	if ( is_page() ) {
		$page_name = $post->post_name;
		$classes[] = 'page-'.$page_name;
 	}
    
    // If category have sidebar enabled
	if ( get_field( 'category_sidebar', 'category_' . get_query_var('cat') ) == 'cat_sidebar_on' ) {
        $classes[] = 'with-sidebar';
	}

	// Text Alignmnet Left for the whole site
	if ( $ti_option['text_alignment'] == '2' ) {
		$classes[] = 'text-left';
	}

	// Category Name as class name only in single post of given category
	if ( is_single() ) {
        
		global $post;
		$categories = get_the_category( $post->ID );
		foreach( $categories as $category ) {
			$classes[] = 'single-'.$category->category_nicename;
		}

	}
    
    // Hide/Show top strip
	if ( $ti_option['site_top_strip'] == 0 ) { 
        $classes[] = 'hide-strip';
    }

	// Make top strip fixed
	if ( $ti_option['site_fixed_menu'] == '2' ) {
        $classes[] = 'top-strip-fixed';
    }

	// If top strip have white background
	if ( $ti_option['site_top_strip_bg'] == '#ffffff' ) { 
        $classes[] = 'color-site-white';
    }

    // Check for a layout options: Full Width or Boxed
    if ( $ti_option['site_layout'] == '2' ) {
        $classes[] = 'layout-boxed'; 
    } else { 
        $classes[] = 'layout-full';
    }

	return $classes;
}
add_filter( 'body_class', 'ti_body_classes' );




/**
 * Add Previous & Next links to a numbered link list 
 * of wp_link_pages() if single post is paged
 */
function ti_wp_link_pages( $args ){

    global $page, $numpages, $more;

    if ( !$args['next_or_number'] == 'next_and_number' ) {
        return $args;
    }
	
	// Keep numbers for the main part
    $args['next_or_number'] = 'number';
    if (!$more){
        return $args;
    }
	
	// If previous page exists
    if( $page-1 ) {
        $args['before'] .= _wp_link_page($page-1) . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>';
    }

	// If next page exists
    if ( $page<$numpages ) {
        $args['after'] = _wp_link_page($page+1) . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>' . $args['after'];
    }

    return $args;
}
add_filter( 'wp_link_pages_args', 'ti_wp_link_pages' );




/**
 * Helper Functions
*/

// Get The First Image From a Post
function first_post_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	if( preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches ) ){
		$first_img = $matches[1][0];
		return $first_img;
	}
}

/**
 * Excerpt length
 * Excerpt more
*/
// Excerpt Length
function ti_excerpt_length( $length ) {
	global $ti_option;
	return $ti_option['site_wide_excerpt_length'];
}
add_filter( 'excerpt_length', 'ti_excerpt_length', 999 );

// Excerpt more
function ti_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'ti_excerpt_more' );



/**
 * Different image size based on layout 
 * selection for Homepage, Categories and Posts Page.
*/
function layout_based_post_image() {
    
    global $ti_option;

	if ( has_post_thumbnail() ) { // Set Featured Image
        
        // List or Grid
        if (   get_sub_field( 'latest_posts_layout' ) == 'list-layout'
            || get_sub_field( 'latest_posts_layout' ) == 'big-list-layout'
            || get_field( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'list-layout'
            || $ti_option['posts_page_layout'] == 'list-layout'
            && $ti_option['posts_page_layout'] == 'grid-layout'
            || get_sub_field( 'latest_posts_layout' ) == 'grid-layout'
               && get_sub_field( 'latest_cols_number' ) != 'columns-size-2' ) {

                    the_post_thumbnail( 'rectangle-size' );
        
        // Two columns Grid
        } elseif (  get_sub_field( 'latest_posts_layout' ) == 'grid-layout'
                        && get_sub_field( 'latest_cols_number' ) == 'columns-size-2'
                        && get_sub_field( 'latest_posts_sidebar' ) == ''
                    || get_field( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'grid-layout'
                        && get_field( 'category_cols_num', 'category_' . get_query_var('cat') ) == 'columns-size-2'
                        && get_field( 'category_sidebar', 'category_' . get_query_var('cat') ) == 'cat_sidebar_off' ) {
            
                    the_post_thumbnail( 'rectangle-size-big' );
        
        // Classic List   
        } elseif (   get_sub_field( 'latest_posts_layout' ) == 'classic-layout'
                  || get_field( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'classic-layout'
                  || $ti_option['posts_page_layout'] == 'classic-layout' ) {

                    the_post_thumbnail( 'big-size' );
        
        // Two columns Masonry
        } elseif (   get_sub_field( 'latest_posts_layout' ) == 'masonry-layout'
                        && get_sub_field( 'latest_cols_number' ) == 'columns-size-2'
                        && get_sub_field( 'latest_posts_sidebar' ) == ''
                  || get_field( 'category_posts_layout', 'category_' . get_query_var('cat') ) == 'masonry-layout'
                        && get_field( 'category_cols_num', 'category_' . get_query_var('cat') ) == 'columns-size-2'
                        && get_field( 'category_sidebar', 'category_' . get_query_var('cat') ) == 'cat_sidebar_off' ) {
            
                    the_post_thumbnail( 'masonry-size-big' );
            
        //Masonry
        } else {

                    the_post_thumbnail( 'masonry-size' );

        }
            
    	
    } elseif( first_post_image() ) { // Set the first image from the editor
        echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" alt="' . get_the_title() . '" />';
    }

}
add_action( 'post_item_image', 'layout_based_post_image' );



    
/**
 * Define Five Sidebar areas
 * Magazine for Page Composer, Pages for static pages, Three Footer Sidebars
**/
function ti_register_theme_sidebars() {

	if ( function_exists('register_sidebars') ) {
		
		// Sidebar for blog section of the site
		register_sidebar(
		   array(
			'name' => __( 'Magazine', 'themetext' ),
			'id' => 'sidebar-1',
			'description'   => __( 'Sidebar for categories and single posts', 'themetext' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);

		register_sidebar(
		   array(
			'name' => __( 'Pages', 'themetext' ),  
			'id' => 'sidebar-2',
			'description'   => __( 'Sidebar for static pages', 'themetext' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);

		register_sidebar(
		   array(
			'name' => __( 'Footer Area One', 'themetext' ),  
			'id' => 'sidebar-3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);
		
		register_sidebar(
		   array(
			'name' => __( 'Footer Area Two', 'themetext' ),
			'id' => 'sidebar-4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);
		
		register_sidebar(
		   array(
			'name' => __( 'Footer Area Three', 'themetext' ),  
			'id' => 'sidebar-5',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);
        
        register_sidebar(
		   array(
			'name' => __( 'Footer Full Width', 'themetext' ),  
			'id' => 'sidebar-full-width',
            'description'   => __( 'Can be used for your Instagram feed', 'themetext' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
		   )
		);
        
        if ( class_exists( 'WooCommerce' ) ) {
            register_sidebar(
               array(
                'name' => __( 'WooCommerce', 'themetext' ),  
                'id' => 'woocommerce-sidebar',
                'description'   => __( 'Sidebar for Woocommerce', 'themetext' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
               )
            );
        }
        
        if ( class_exists( 'bbPress' ) ) {
            register_sidebar(
               array(
                'name' => __( 'bbPress', 'themetext' ),  
                'id' => 'bbpress-sidebar',
                'description'   => __( 'Sidebar for bbPress', 'themetext' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
               )
            );
        }

	}

}
add_action( 'widgets_init', 'ti_register_theme_sidebars' );


/* Count the number of footer sidebars to enable dynamic classes for the footer */
function ti_footer_sidebar_class() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-3' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-4' ) )
		$count++;

	if ( is_active_sidebar( 'sidebar-5' ) )
		$count++;

	$class = '';

	switch ( $count ) {
		case '1':
			$class = ' col-1';
			break;
		case '2':
			$class = ' col-2';
			break;
		case '3':
			$class = ' col-3';
			break;
	}

	if ( $class )
		echo $class;
}


/**
 * Indicators in admin posts list
 *
 * 1. If post was marked as featured
 * 2. If post was added into the homepage slider
**/
function admin_post_header_columns($columns) {  
        
	$columns['slider_add'] = "Home Slider";
    $columns['featured_add'] = "Featured";
      	
	return $columns;
}

function admin_post_data_row( $column_name, $post_id ) {
    
    $checked = '<span style="color:#00a0d2;font-weight:bold;">&#10003;</span>';
    $deafult = '<span style="color:#ddd;font-weight:bold;">&#10003;</span>';
    
	switch( $column_name ) {
        
		case 'featured_add':

            if ( get_post_meta( $post_id , 'featured_post_add' , 'true' ) ) {
                echo $checked;
            } else {
                echo $deafult;
            }

            break;
        
        case 'slider_add':
        
            if ( get_post_meta( $post_id , 'homepage_slider_add' , 'true' ) ) {
                echo $checked;
            } else {
                echo $deafult;
            }
    
            break;
	}
}

add_filter( 'manage_edit-post_columns', 'admin_post_header_columns', 10, 1 );
add_action( 'manage_posts_custom_column', 'admin_post_data_row', 10, 2 );




/**
 * SimpleMag & WooCommerce functions and definitions
 *
 * @package SimpleMag
 * @since SimpleMag 4.0
**/

if ( class_exists ( 'WooCommerce' ) ) :

    /**
    * Declare WooCommerce support 
    */
    add_action( 'after_setup_theme', 'woocommerce_support' );
    function woocommerce_support() {
        add_theme_support( 'woocommerce' );
    }

    /**
     * Disabling default WooCommerce css file.
     */
    add_filter( 'woocommerce_enqueue_styles', '__return_false' );
    //add_action( 'wp_enqueue_scripts', 'child_add_scripts' );

    /**
    * Disabling WooCommerce Pretty Photo
    */
    // scripts
    function my_deregister_javascript() {
        wp_deregister_script( 'prettyPhoto' );
        wp_deregister_script( 'prettyPhoto-init' );
    }
    add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );

    // style
    function my_deregister_styles() {
        wp_deregister_style( 'woocommerce_prettyPhoto_css' );
    }
    add_action( 'wp_print_styles', 'my_deregister_styles', 100 );


    /**
    * is_realy_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
    *
    * @access public
    * @return bool
    */
    function is_really_woocommerce_page () {
            if(  function_exists ( "is_woocommerce" ) && is_woocommerce()) {
                return true;
            }
            $woocommerce_keys   =   array ( "woocommerce_shop_page_id" ,
                                            "woocommerce_terms_page_id" ,
                                            "woocommerce_cart_page_id" ,
                                            "woocommerce_checkout_page_id" ,
                                            "woocommerce_pay_page_id" ,
                                            "woocommerce_thanks_page_id" ,
                                            "woocommerce_myaccount_page_id" ,
                                            "woocommerce_edit_address_page_id" ,
                                            "woocommerce_view_order_page_id" ,
                                            "woocommerce_change_password_page_id" ,
                                            "woocommerce_logout_page_id" ,
                                            "woocommerce_lost_password_page_id" ) ;
            foreach ( $woocommerce_keys as $wc_page_id ) {
                    if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
                        return true ;
                    }
            }
            return false;
    }


    /**
     * Breadcrumbs shop home URL
    **/
    function woo_custom_breadrumb_home_url() {
        $shop_home = get_permalink( woocommerce_get_page_id( 'shop' ) );
        return $shop_home;
    }
    add_filter( 'woocommerce_breadcrumb_home_url', 'woo_custom_breadrumb_home_url' );


    /**
     * Unhook WooCommerce wrappers
     */
    add_action('woocommerce_before_main_content', 'smwc_wrapper_start', 10);
    add_action('woocommerce_after_main_content', 'smwc_wrapper_end', 10);

    function smwc_wrapper_start() {
        echo '<section id="content" role="main" class="clearfix anmtd"><div class="wrapper">';
    }

    function smwc_wrapper_end() {
        echo '</div></section>';
    }


    /**
     * Shopping Cart.
     */

    require_once( 'woocommerce/inc/woocommerce-side-shopping-cart.php' );
    //require_once( 'inc/cart-drop-down.php' );

endif;