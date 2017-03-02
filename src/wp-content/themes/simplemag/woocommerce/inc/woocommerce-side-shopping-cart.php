<?php
/*
Plugin Name: WooCommerce Cart Tab
Plugin URI: http://jameskoster.co.uk/tag/cart-tab/
Version: 0.3.1
Description: Displays a sitewide link to the cart which reveals the cart contents on hover.
Author: jameskoster
*/

// Check if WooCommerce is active
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


	//Accepted Payment Methods class
	if ( ! class_exists( 'WC_ct' ) ) {

		class WC_ct {
			public function __construct() {
				add_action( 'wp_footer', array( $this, 'woocommerce_cart_tab' ) ); // The cart tab function
				add_filter( 'add_to_cart_fragments', array( $this, 'wcct_add_to_cart_fragment' ) ); // The cart fragment
			}

			// The cart fragment (ensures the cart button updates via AJAX)
			function wcct_add_to_cart_fragment( $fragments ) {
				global $woocommerce;
				ob_start();
				wcct_cart_button();
				$fragments['#side-shopping-cart-button'] = ob_get_clean();
				return $fragments;
			}

			// Display the cart tab and widget
			function woocommerce_cart_tab() {
                global $woocommerce, $ti_option;
                
                // Hide empty cart
                // Compatible with WP Super Cache as long as "late init" is enabled
                /*if ( $woocommerce->cart->get_cart_contents_count() == 0 ) {
                        $visibility		= ' hidden';
                    } else {
                        $visibility		= ' visible';
                }*/

                if ( $ti_option['smwc_enable_cart_ste_wide'] == true ) :
                
                    //echo '<div class="side-shopping-cart' . esc_attr( $visibility ) . '">';
                    echo '<div class="side-shopping-cart">';
                    echo '<div class="ssc-button">';
                    wcct_cart_button();
                    echo '</div>';

                        // Check for WooCommerce 2.0 and display the cart widget
                        if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
                            the_widget( 'WC_Widget_Cart', 'title=' );
                        } else {
                            the_widget( 'WooCommerce_Widget_Cart', 'title=' );
                        }
                    echo '</div>';
                
                elseif ( is_woocommerce() ) :

                    //echo '<div class="side-shopping-cart' . esc_attr( $visibility ) . '">';
                    echo '<div class="side-shopping-cart">';
                    echo '<div class="ssc-button">';
                    wcct_cart_button();
                    echo '</div>';

                        // Check for WooCommerce 2.0 and display the cart widget
                        if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) {
                            the_widget( 'WC_Widget_Cart', 'title=' );
                        } else {
                            the_widget( 'WooCommerce_Widget_Cart', 'title=' );
                        }
                    echo '</div>';
                
                endif;
                
				}
			}

		// Displays the cart button
		function wcct_cart_button() {
			global $woocommerce;
			?>
            
            <div id="side-shopping-cart-button">
                <?php
                echo '<div class="cart-count">' . sprintf( _n( '%d', '%d', intval( $woocommerce->cart->get_cart_contents_count() ), 'woocommerce-cart-tab' ), intval( $woocommerce->cart->get_cart_contents_count() ) ) . '</div>';
                echo wp_kses_post( $woocommerce->cart->get_cart_total() );
                ?>
            </div>
            
			<?php
		}

		$WC_ct = new WC_ct();
	}
}
?>