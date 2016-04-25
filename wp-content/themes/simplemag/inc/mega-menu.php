<?php
/**
 * Walker class for for dropdown menu with latest posts
 * Add posts if 'latest_posts' field is set to 'Add' 
 * and only for parent category.
 *
 *
 * 1. Query to retriev the caetegory drop down
 * 2. Menu Walker Class which builds the drop down
 *
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
 *
**/ 




/**
 * Query to retriev the caetegory drop down
**/
function ajax_mega_menu_get_posts( $taxonomy ) {

    // Verify nonce
    if( ! isset( $_POST['ti_nonce'] ) || ! wp_verify_nonce( $_POST['ti_nonce'], 'ti_nonce' ) ) {
        die( 'Permission denied' );
    }
    

    $taxonomy = $_POST['taxonomy'];

    /**
     * Show categpry title and link
    **/ 
    $menu_cat_name = new WP_Query( 
        array(
            'category_name'     => $taxonomy,
            'post_type'         => 'post',
            'posts_per_page'    => 1
        )
    );

    if ( $menu_cat_name->have_posts() ) :

        while ( $menu_cat_name->have_posts() ) : $menu_cat_name->the_post();
            
            $categories = get_the_category();
            //$separator = '/';
            $output = '';
            
            if ( ! empty( $categories ) ) {
                foreach( $categories as $category ) {
                    $output .= '<a class="mega-menu-posts-title alignleft" href="' . esc_url( get_category_link( $category->term_id ) ) . '">';
                    $output .= esc_html( $category->name );
                    $output .= '</a>';
                }
                echo $output;
            }
            
        
            /*
            if ( !empty( $categories ) ) {
                echo '<a class="clearfix mega-menu-posts-title" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">';
                echo '<span class="alignleft title">' . esc_html( $categories[0]->name ) . '</span>';
                echo '<span class="alignright see-more"><span>' . __( 'See More', 'themetext' ) . '</span><i class="icomoon-arrow-right"></i></span>';
                echo '</a>';
            }
            */
    
        endwhile; 
    
        wp_reset_postdata();
    
    endif;
    
    
    
    /**
     * Show posts from the category
    **/ 
    $menu_cat_posts = new WP_Query( 
        array(
            'category_name'     => $taxonomy,
            'post_type'         => 'post',
            'post_status'       => 'publish',
            'posts_per_page'    => 3
        )
    );

    if ( $menu_cat_posts->have_posts() ) :

        echo '<ul class="mega-menu-posts">';

            while ( $menu_cat_posts->have_posts() ) : $menu_cat_posts->the_post();

                echo '<li class="mega-menu-item">';

                        echo '<figure><a href="' . get_the_permalink() . '">';
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'rectangle-size' );
                        } elseif( first_post_image() ) { // Set the first image from the editor
                            echo '<img src="' . esc_url( first_post_image() ) . '" class="wp-post-image" alt="' . esc_attr( get_the_title() ) . '" />';
                        } else {
                            echo '<img class="alter" src="' . get_template_directory_uri() . '/images/pixel.gif" alt="' . esc_attr( get_the_title() ) . '" />';   
                        }
                        echo '</a></figure>';
    
                        echo '<div class="item-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></div>';

                echo '</li>';

            endwhile;

            wp_reset_postdata();
            
        echo '</ul>';

    else:
    
        echo '<small>' . __( 'Add some posts to this category', 'themetext' ) . '</small>';
    
    endif;
 
  die();
    
}

add_action('wp_ajax_filter_posts', 'ajax_mega_menu_get_posts');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_mega_menu_get_posts');





/** 
 * Menu Walker Class which builds the drop down
**/
class TI_Menu extends Walker_Nav_Menu {
		
    function start_lvl(&$output, $depth = 0, $args = array() ) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-links\">\n";
    }
	
    function end_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
	
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
        global $ti_option;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$class_names = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
        
        //$attributes  = ( 'category' == $item->object ) ? ' data-category="'  . esc_attr( $item->url ) .'"' : '';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
        $item_output = $args->before;
        
        $item_output .= '<a'. $attributes . '>';
        $item_output .= '<span>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</span>';
        $item_output .= '</a>';
		
		if ( $ti_option['site_mega_menu'] == true ) {
			if ( 'category' == $item->object ){
				$item_output  .= '<div class="sub-menu">';
			}
		}
				
        $item_output .= $args->after;
        
		
		/**
         * Add Mega menu only for: 
		 * Parent category if the option is enabled in Theme Options
        **/
		if ( $ti_option['site_mega_menu'] == true ) {

			if ( $depth == 0 && $item->object == 'category' ) {
                
                /**
                 * Mega Menu output
                **/
                $item_output .= '<div class="sub-posts">';
				    $item_output .= '<div class="clearfix mega-menu-container"></div>';
                $item_output .= '</div>';
				
			}

		}
		
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
	
	
    function end_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		
		global $ti_option;
		if ( $ti_option['site_mega_menu'] == true ) {	
			if ( 'category' == $item->object ){
				$output .= "</div>\n";
			}
		}
		
		$output .= "</li>\n";
    }
	
}