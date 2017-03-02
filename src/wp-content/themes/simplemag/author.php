<?php 
/**
 * Author template. Display the author 
 * info and all posts by the author
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/ 

get_header(); ?>
		
	<section id="content" role="main" class="clearfix anmtd author-page">
    	<div class="wrapper">
    		
            <?php if ( have_posts() ) : ?>
			
            <div class="grids">
                <div class="grid-4 columns column-1 sidebar-fixed">
                    
                    <div class="author-box" itemprop="author" itemscope="itemscope" itemtype="http://schema.org/Person">
                        
                        <?php $curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug', $author_name ) : get_userdata( intval( $author ) ); ?>

                        <div class="avatar">
                            <?php
                            // Author Image
                            $itemprop = array( 'extra_attr' => 'itemprop="image"' );
                            echo get_avatar( $curauth->ID, 180, '', $curauth->display_name, $itemprop );
                            ?>
                        </div>

                        <div class="author-info">
                            <h1 itemprop="name"><?php echo $curauth->display_name; ?></span></h1>
                            <p itemprop="description">
                                <?php echo $curauth->user_description; ?>
                            </p>
                        </div>
                        
                        <ul class="author-social">
                            <?php
                            $author_link = array ( 
                                'user_url' => 'sphere',
                                'sptwitter' => 'twitter',
                                'spfacebook' => 'facebook',
                                'spgoogle' => 'google-plus',
                                'sppinterest' => 'pinterest',
                                'splinkedin' => 'linkedin',
                                'spinstagram' => 'instagram',
                            );
                            foreach ( $author_link as $link => $name ) {
                            ?>
                                <?php  
                                if ( get_the_author_meta( $link ) ) { 
                                    if ( $link == 'spgoogle' ) { $rel_author = '?rel=author'; }
                                    else { $rel_author = ''; }
                                ?>
                                    <li>
                                        <a href="<?php echo wp_kses( get_the_author_meta( $link ), null ) . $rel_author; ?>">
                                            <i class="icomoon-<?php printf( $name, get_the_author() ); ?>"></i>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul><!-- .author-social -->

                    </div>
                </div><!-- .grid-4 -->
                
                <div class="grid-8">
                
                    <div class="grids list-layout entries">
                        <?php
                            while ( have_posts() ) : the_post();

                                get_template_part( 'content', 'post' );

                            endwhile;
                        
                            wp_reset_query();
                        ?>
                    </div>
                
                </div><!-- .grid-8 -->
            </div><!--.grids-->
                    
            <?php the_posts_pagination( array(
                'mid_size' => 4,
                'prev_text' => __( '<i class="icomoon-arrow-left"></i>' ),
                'next_text' => __( '<i class="icomoon-arrow-right"></i>' ),
            ) ); ?>
            
            <?php else: ?>
            
			     <p class="message"><?php _e('This author has no posts yet', 'themetext' ); ?></p>
            
    		<?php endif; ?>
            
    	</div>
    </section>
		
<?php get_footer(); ?>