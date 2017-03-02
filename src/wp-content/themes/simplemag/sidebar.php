<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.4
**/
global $ti_option;
?>

<div class="grid-4 column-2<?php if ( $ti_option['site_sidebar_fixed'] == true ) { echo ' sidebar-fixed'; } ?>">
    <aside class="sidebar" role="complementary">
        <?php
        // Sidebar for pages besides homepage
        if ( is_page() && !is_page_template( 'page-composer.php' ) ) {
            if ( is_active_sidebar( 'sidebar-2' ) ) {
                dynamic_sidebar( 'sidebar-2' );
            }
            
        // Sidebar for WooCommerce
        } elseif ( function_exists( 'is_really_woocommerce_page' ) && is_really_woocommerce_page() ) {
            if ( is_active_sidebar( 'woocommerce-sidebar' ) ) {
                dynamic_sidebar( 'woocommerce-sidebar' );
            }
            
        // Sidebar for bbPress
        } elseif ( function_exists( 'is_bbpress' ) && is_bbpress() ) {
            if ( is_active_sidebar( 'bbpress-sidebar' ) ) {
                dynamic_sidebar( 'bbpress-sidebar' );
            }
            
        // Sidebar for homepage, categories and posts
        } else { 
            if ( is_active_sidebar( 'sidebar-1' ) ) {
                dynamic_sidebar( 'sidebar-1' );
            }
        }
        ?>
    </aside><!-- .sidebar -->
</div>