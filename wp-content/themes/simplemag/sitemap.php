<?php 
/**
 * Template Name: Sitemap
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/
get_header(); ?>

	<section id="content" role="main" class="clearfix anmtd">

        <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <div class="page-title wrapper title-with-sep">
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
                    
                        <section class="sitemap">
                                <div class="row">
                                    <h3 class="trigger entry-title active"><?php _e( 'Categories','themetext' ); ?></h3>
                                    <ul>
                                        <?php wp_list_categories( array( 'title_li' => '' ) ); ?>
                                    </ul>
                                </div>

                                <div class="row">
                                    <h3 class="trigger entry-title"><?php _e( 'Authors','themetext' ); ?></h3>
                                    <ul>
                                        <?php wp_list_authors(); ?>
                                    </ul>
                                </div>

                                <div class="row">
                                    <h3 class="trigger entry-title"><?php _e( 'Pages','themetext' ); ?></h3>
                                    <ul>
                                        <?php wp_list_pages( array( 'title_li' => '' ) ); ?>
                                    </ul>
                                </div>

                                <div class="row">
                                    <h3 class="trigger entry-title"><?php _e( 'Archives','themetext' ); ?></h3>
                                    <ul>
                                        <?php wp_get_archives('type=monthly&show_post_count=true'); ?> 
                                    </ul>
                                </div>    
                        </section>
                    
                    <?php endwhile; endif; ?>
            		
                    
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