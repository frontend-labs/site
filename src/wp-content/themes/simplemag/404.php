<?php 
/**
 * 404 error page
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/ 
get_header(); ?>
	
    <section id="content" role="main" class="clearfix anmtd">
    
    	<div class="wrapper">
    
            <article id="post-0" class="post error404 not-found">
                
                <?php global $ti_option; $error_image = $ti_option['error_image']; ?>

            	<?php if( $error_image == true ){ ?>
                    <img src="<?php echo esc_url( $error_image['url'] ); ?>" alt="<?php _e( 'Ooops! That page can not be found', 'themetext' ); ?>" width="<?php echo esc_attr( $error_image['width'] ); ?>" height="<?php echo esc_attr( $error_image['height'] ); ?>" />
                <?php } ?>
                <h1><?php _e( 'Ooops! That page can not be found', 'themetext' ); ?></h1>
                
            </article><!-- #post-0 .post .error404 .not-found -->
            
    	</div>
        
    </section><!-- #content -->
	
<?php get_footer(); ?>