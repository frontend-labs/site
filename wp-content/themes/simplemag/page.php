<?php 
/**
 * The template for displaying all pages
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.2
**/ 
get_header();
global $ti_option; 
?>
	
	<section id="content" role="main" class="clearfix anmtd">

        <?php
        /**
         * If Featured Image is uploaded set it as a background
         * and change page title color to white
        **/
        if ( has_post_thumbnail() ) {
            $page_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), '' );
            $page_bg_image = 'style="background-image:url(' . esc_url( $page_image_url[0] ) . ');"';
            $title_with_bg = 'title-with-bg full-width-image content-over-image-tint page-title-bg';
        } else {
            $title_with_bg = 'wrapper title-with-sep';
        } ?>

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="page-title <?php echo isset( $title_with_bg ) ? $title_with_bg : ''; ?>" <?php echo isset( $page_bg_image ) ? $page_bg_image : ''; ?>>
                <header class="entry-header page-header">  
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                </header>
            </div>
                
        	<div class="wrapper">
    			<?php
    			// Enable/Disable sidebar based on the field selection
    			if ( ! get_field( 'page_sidebar' ) || get_field( 'page_sidebar' ) == 'page_sidebar_on' ) :
    			?>
                <div class="grids">
                    <div class="grid-8 column-1">
                <?php endif; ?>
                    
                    <?php if ( have_posts()) : while (have_posts() ) : the_post(); ?>
                    
                        <article class="entry-content">                       
                            <?php
                            // Output the main editor content
                            the_content();
                            
                            // Output pagination if post uses <!--nextpage--> short tag
                            $args = array(
                                'before' => '<div class="link-pages"><h3 class="title">' . __( 'Continue Reading', 'themetext' ) . '</h3>',
                                'after' => '</div>',
                                'link_before' => '<span>',
                                'link_after' => '</span>',
                                'nextpagelink'     => '&rarr;',
                                'previouspagelink' => '&larr;',
                                'next_or_number'   => 'next_and_number',
                            );
                            wp_link_pages( $args );
                            ?>
                        </article>
                    
                    <?php endwhile; endif; ?>
            		
                    <?php 
    				// Enable/Disable comments
    				if ( $ti_option['site_page_comments'] == 1 ) {
    					comments_template();
    				}
    				?>
                    
    				<?php
    				// Enable/Disable sidebar based on the field selection
    				if ( ! get_field( 'page_sidebar' ) || get_field( 'page_sidebar' ) == 'page_sidebar_on' ):
    				?>
                    </div><!-- .grid-8 -->
                
                    <?php get_sidebar(); ?>

                </div><!-- .grids -->
                <?php endif; ?>
            
            </div>

        </div>
    </section><!-- #content -->

<?php get_footer(); ?>