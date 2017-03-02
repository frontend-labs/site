<?php
/**
 * The template for displaying the footer.
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/
global $ti_option;
?>

        <footer id="footer" class="no-print anmtd" role="contentinfo">

        	<?php do_action( 'footer_ad' ); ?>

            <?php 
            /**
             * Footer Sidebars:
             * 1. Widegtized footer. Outputs three Footer sidebars
             * 2. Full width sidebar
            **/
            get_sidebar( 'footer' );
            ?>
            
            <div class="copyright">
                <div class="wrapper">
                	<div class="grids">
                        <div class="grid-10">
                            <?php echo $ti_option['copyright_text']; ?>
                        </div>
                        <div class="grid-2">
                            <a href="#" class="alignright back-top"><?php _e( 'Back to top', 'themetext' ); ?> <i class="icomoon-chevron-left"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
        </footer><!-- #footer -->
    </div><!-- .site-content -->
</section><!-- #site -->
<?php wp_footer(); ?>
</body>
</html>