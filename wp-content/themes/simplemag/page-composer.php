<?php 
/**
 * Template Name: Page Composer
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.1
**/
get_header(); ?>
	
    <section id="content" role="main" class="clearfix anmtd">
        
        <?php 
		/**
		 *  Page Composer
		**/ 
		if( have_rows( 'page_composer' ) ) :

			while( have_rows( 'page_composer' ) ) : the_row();
                    
                
                /* Title or Text */ 
	            if( get_row_layout() == 'title_or_text' ):
					
					get_template_part ( 'composer/title', 'text' );
					
				

				/* WP Editor */ 
	            elseif( get_row_layout() == 'wp_section_editor' ) :
					
					get_template_part ( 'composer/wp', 'editor' );



	            /* Posts Slider */
	            elseif( get_row_layout() == 'hp_posts_slider' ) :
					
						// Regular
						if ( get_sub_field ( 'posts_slider_type' ) == 'slider_content' ) :
							
							echo '<section class="wrapper home-section posts-slider-section">';
								get_template_part ( 'composer/posts', 'slider' );
							echo '</section>';
							
						// With two latest posts, with two featured posts or with two custom
						elseif (   get_sub_field ( 'posts_slider_type' ) == 'slider_and_latest'
                                || get_sub_field ( 'posts_slider_type' ) == 'slider_and_featured' ) :
					
                            get_template_part ( 'composer/slider', 'latest' );


						// Full Width
						elseif ( get_sub_field ( 'posts_slider_type' ) == 'slider_full_width' ) :
					
							echo '<section class="home-section full-width-section posts-slider-section">';
                                get_template_part ( 'composer/posts', 'slider' );
                            echo '</section>';
						
						endif;


				/* Posts Carousel */
				elseif ( get_row_layout() == 'hp_posts_carousel' ) :

				    get_template_part ( 'composer/posts', 'carousel' );



				/* Custom Slider */ 
				elseif( get_row_layout() == 'custom_slider' ) :
					
                    // Regular and/or With two posts
                    if (   get_sub_field ( 'custom_slider_type' ) == 'custom_slider_content' 
                        || get_sub_field ( 'custom_slider_type' ) == 'custom_slider_with_two' ) :

                        echo '<section class="wrapper home-section custom-slider-section">';
                            get_template_part ( 'composer/custom', 'slider' );
                        echo '</section>';


                    // Full Width
                    elseif ( get_sub_field ( 'custom_slider_type' ) == 'custom_slider_full' ) :
                        
                        echo '<section class="home-section full-width-section custom-slider-section">';
                            get_template_part ( 'composer/custom', 'slider' );
                        echo '</section>';

                    endif;

					

                /**
                 * Universal Posts Section
                 * Main output is Latest Posts
                 * &: Featured Posts, Latest Reviews, Latest By Catgeory, Latest By Format
                **/ 
				elseif( get_row_layout() == 'universal_posts_section' ) :
					
                    get_template_part ( 'composer/posts', 'section' );
                
                

                /* Latest Posts (Newest Posts) */ 
				elseif( get_row_layout() == 'newest_posts' ) :
                    
                    get_template_part ( 'composer/latest', 'posts' );



                /* Featured Posts */ 
				elseif( get_row_layout() == 'hp_featured_posts' ) :
                    
                    get_template_part ( 'composer/featured', 'posts' );



                /* Latest By Category */ 
				elseif( get_row_layout() == 'latest_by_category' ) :
                    
                    get_template_part ( 'composer/category', 'posts' );


                
                /* Latest Reviews */ 
				elseif( get_row_layout() == 'latest_reviews' ) :
                    
                    get_template_part ( 'composer/latest', 'reviews' );



                /* Latest By Format */ 
				elseif( get_row_layout() == 'latest_by_format' ) :
					
                    get_template_part ( 'composer/media', 'posts' );



				/* Full Width Image */ 
	            elseif( get_row_layout() == 'full_width_image' ) :
					
					get_template_part ( 'composer/full', 'image' );
				


				/* Static Image */ 
	            elseif( get_row_layout() == 'image_advertising' ) :
					
					get_template_part ( 'composer/static', 'image' );
									
				

				/* Code Box */ 
	            elseif( get_row_layout() == 'code_advertising' ) :
					
					get_template_part ( 'composer/code', 'box' );


				endif;
	            
			endwhile;

		endif;
		?>
        
		<?php 
		/**
         * Enable/Disable the Posts Page link
         * The Posts Page is defined in admin Settings -> Reading
        **/
		if ( get_field ( 'comp_posts_page_link' ) == 'comp_posts_page_on' ) :
		?>
	    	<div class="wrapper all-news-link">
				<?php $posts_page_id = get_option( 'page_for_posts' ); ?>
            	<a class="read-more" href="<?php echo esc_url( get_permalink( $posts_page_id ) ); ?>">
                    <?php echo esc_html( get_the_title( $posts_page_id ) ); ?>
                </a>
            </div>
		<?php endif; ?>
        
    </section>

<?php get_footer(); ?>