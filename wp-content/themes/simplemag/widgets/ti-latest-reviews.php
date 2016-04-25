<?php
/*
 * Plugin Name: Latest Reviews Widget
 * Plugin URI: http://www.themesindep.com
 * Description: A widget that show latest posts with reviews
 * Version: 1.0
 * Author: ThemesIndep
 * Author URI: http://www.themesindep.com
 */

class TI_Latest_Reviews extends WP_Widget {
	
	
	/**
	 * Register widget
	**/
	public function __construct() {
		
		parent::__construct(
	 		'ti_latest_reviews', // Base ID
			__( 'TI Latest Reviews', 'themetext' ), // Name
			array( 'description' => __( 'Display the latest posts with reviews', 'themetext' ), ) // Args
		);
		
	}

	
	/**
	 * Front-end display of widget
	**/
	public function widget( $args, $instance ) {
				
		extract( $args );

		$title = apply_filters('widget_title', isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : 'Latest Reviews' );
		$items_num = isset( $instance['items_num'] ) ? esc_attr( $instance['items_num'] ) : '5';
		
		/** 
		 * Latest Reviews
		**/
		global $post;
		$ti_latest_reviews = new WP_Query(
			array(
				'post_type' => 'post',
				'meta_key' => 'enable_rating',
				'meta_value' => 1,
				'posts_per_page' => $items_num,
				'post__not_in' => array( $post->ID ),
				'ignore_sticky_posts' => 1
			)
		);

		if ( $ti_latest_reviews->have_posts() ):

			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			?>
            
	            <div class="clearfix widget-posts-entries">
	            <?php while ( $ti_latest_reviews->have_posts() ) : $ti_latest_reviews->the_post(); ?>
	                <div class="clearfix widget-post-item">
                        <figure class="entry-image">
                            <a href="<?php the_permalink(); ?>">
                            <?php if ( has_post_thumbnail() ) { ?>
                                <?php the_post_thumbnail( 'rectangle-size' ); ?>
                            <?php } elseif( first_post_image() ) { // Set the first image from the editor ?>
                                <img src="<?php echo first_post_image(); ?>" class="wp-post-image" alt="<?php the_title(); ?>" />
                            <?php } else { ?>
                                <img class="alter" src="<?php echo get_template_directory_uri(); ?>/images/pixel.gif" alt="<?php the_title(); ?>" />
                            <?php } ?>
                            </a>
                        </figure>
                        
                        <?php
                        if ( get_field( 'enable_rating' ) == true ) :
                        // Call total score calculation function
                        $get_result = apply_filters( 'ti_score_total', '' );

                        // Get the final score
                        $total_score = number_format( $get_result, 1, '.', '' );

                        // If final score is decimal like 5.0 or is equal to 10.0
                        // remove .0 to display it as integer
                        if ( strlen ( $total_score ) || $total_score == '10.0' ) {
                            $final_result = str_replace( ".0", "", $total_score );
                        } else {
                            $final_result = $total_score;
                        }

                        // Multiply by 10 to remove the decimal value
                        // Displayed in data-cirlce attr.
                        $final_result_no_decimal = $total_score * 10;
                        ?>

                        <div class="rating-total-indicator" data-circle="<?php echo esc_attr( $final_result_no_decimal ); ?>">

                            <i class="show-total"><?php echo esc_html( $final_result ); ?></i>

                            <div class="sides left-side"><span></span></div>
                            <div class="sides right-side"><span></span></div>

                        </div>
                        <?php endif; ?>
                        
                        <div class="widget-post-details">
                            <?php $cat = get_the_category(); $cat = $cat[0]; ?> 
                            <a class="widget-post-category" href="<?php echo get_category_link( $cat );?>"><?php echo $cat->cat_name; ?></a>

                            <h4 class="widget-post-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                        </div>
	                </div>
	            <?php endwhile; ?>			
	            </div>

	    	<?php
	        echo $after_widget;
        
			wp_reset_postdata();
    
		endif;
		
	}
	
	
	/**
	 * Sanitize widget form values as they are saved
	**/
	public function update( $new_instance, $old_instance ) {
		
		$instance = array();

		/* Strip tags to remove HTML. For text inputs and textarea. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['items_num'] = strip_tags( $new_instance['items_num'] );
		
		return $instance;
		
	}
	
	
	/**
	 * Back-end widget form
	**/
	public function form( $instance ) {
		
		/* Default widget settings. */
		$defaults = array(
			'title' => 'Latest Reviews',
			'items_num' => '5',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
	?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'themeText'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
        	<label for="<?php echo $this->get_field_id( 'items_num' ); ?>"><?php _e('Maximum posts to show:', 'themetext'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'items_num' ); ?>" name="<?php echo $this->get_field_name( 'items_num' ); ?>" value="<?php echo $instance['items_num']; ?>" size="1" />
		</p>
	<?php
	}

}

register_widget( 'TI_Latest_Reviews' );