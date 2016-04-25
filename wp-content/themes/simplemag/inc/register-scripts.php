<?php
/**
 * Register jQuery scripts and 
 * CSS Styles only for the front-end
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/

function ti_theme_scripts(){
	
	/**
	 * Register CSS styles
	 */
	
	/* Main theme style */
	wp_enqueue_style( 'main-style', get_stylesheet_uri(), 'all' );


    /**
     * WooCommerce style
     * Loads only if WC plugin is activated
     */
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_style( 'wc-main-style', get_template_directory_uri() . '/woocommerce/style.css', 'all' );  
    }

    
    /**
     * bbPress style
     * Loads only if bbPress plugin is activated
    **/
    if ( class_exists( 'bbPress' ) ) {
        
        // Load SimpleMag bbPress CSS only in forum pages
        if ( is_bbpress() ) {
            wp_enqueue_style( 'bbpress-style', get_stylesheet_directory_uri() . '/bbpress/bbpress-style.css', 'all' );
        }
        
        // Load default bbPress CSS  only in forum pages
        if ( ! is_bbpress() ) {
            wp_dequeue_style( 'bbp-default' );
        }
        
    }
    
    
	/**
	 * Register jQuery scripts
	 */
	
	/* Always load only the latest jQuery library version */
	wp_enqueue_script( 'jquery' );

    
	/* Blog single comments reply */
	if (is_singular()) { wp_enqueue_script('comment-reply'); }
  		
    
	/* jQuery plugins */
	wp_enqueue_script( 'ti-assets', get_template_directory_uri() . '/js/jquery.assets.js', 'jquery', '1.0', true );
		
    
	/* Custom jQuery scripts */
	wp_enqueue_script( 'ti-custom', get_template_directory_uri() . '/js/jquery.custom.js', 'jquery', '1.0', true );

    
    /**
     * Woocommerce jQuery script.
     * Loads only if WC plugin is activated
     */
    if ( class_exists( 'WooCommerce' ) ) {
        wp_enqueue_script( 'ti-wc-custom', get_template_directory_uri() . '/woocommerce/js/wc-jquery.custom.js', 'jquery', '1.0', true );
    }
    
    
    /**
     * Load bbPress Editor JS only in forum pages
    **/
    if ( class_exists( 'bbPress' ) ) {
      if ( ! is_bbpress() ) {
          wp_dequeue_script('bbpress-editor');
      }
    }
    
    
    /**
     * Ajax for Latest By Format section, Mega Menu, Audio and Video post items.
    **/
    wp_register_script( 'ti_async_script', get_template_directory_uri() . '/js/jquery.async.js', 'jquery', '1.0', true );
    wp_enqueue_script( 'ti_async_script' );

    wp_localize_script( 'ti_async_script', 'ti_async',
        array(
            'ti_nonce' => wp_create_nonce( 'ti_nonce' ), // Nonce which verifies AJAX request
            'ti_ajax_url' => admin_url( 'admin-ajax.php' )
        )
    );
    
}
	
add_action( 'wp_enqueue_scripts', 'ti_theme_scripts' );


/* Header custom JS */
function header_scripts(){
	global $ti_option;
	if ( ! empty ( $ti_option['custom_js_header'] ) ){
		echo '<script type="text/javascript">'."\n",
				$ti_option['custom_js_header']."\n",
			 '</script>'."\n";
	}
}
add_action('wp_head', 'header_scripts');


/* Footer custom JS */
function footer_scripts(){
	global $ti_option;
	if ( ! empty ( $ti_option['custom_js_footer'] ) ) {
		echo '<script type=\'text/javascript\'>'.$ti_option['custom_js_footer'].'</script>'."\n";
	}
}
add_action( 'wp_footer', 'footer_scripts', 100 );