<?php 
/**
 * WordPress Native Editor
 * Page Composer Section
 *
 * @package SimpleMag
 * @since 	SimpleMag 3.0
**/
?>

<section class="wrapper home-section wp-editor-section">
    
    <?php 
    // If Sidebar
    if ( get_sub_field( 'wp_ti_sidebar' ) != '' ) :
    ?>
        <div class="grids">
            <div class="grid-8 column-1">
    <?php endif; // End if sidebar ?>
    
    <div class="entry-content clearfix">
        <?php the_sub_field( 'wp_ti_editor' ); ?>
    </div>
                
    <?php
    // If Sidebar
    if ( get_sub_field( 'wp_ti_sidebar' ) != '' ) :
    ?>
            </div>
            
            <?php global $ti_option; ?>
            <div class="grid-4 column-2<?php if ( $ti_option['site_sidebar_fixed'] == true ) { echo ' sidebar-fixed'; } ?>">
                <aside class="sidebar">
                    <?php dynamic_sidebar( get_sub_field( 'wp_ti_sidebar' ) ); ?>
                </aside>
                
            </div>
            
        </div>
    <?php endif; // End if sidebar ?>
    
</section><!-- WP Editor -->