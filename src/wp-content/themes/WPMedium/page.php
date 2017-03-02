<?php
/**
 * @package WordPress
 * @subpackage WPMedium
 * @since WPMedium 1.0
 */
get_header(); ?>

		<div id="page" class="hfeed site">

			<div id="main" class="wrapper">

				<div id="primary" class="site-content">
				
					<div id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<div class="entry-author entry-author-side">
							<div class="author-avatar">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
							</div><!-- .author-avatar -->
							<div class="author-description">
								<h6><?php the_author_link(); ?></h6>
								<p><?php the_author_meta( 'description' ); ?></p>
							</div><!-- .author-description -->
							<div class="entry-date">
								<?php printf( '<h6>%s</h6> <span class="date">%s</span>', __( 'Published', 'wpmedium' ), get_the_date( 'F j, Y' ) ); ?>
							</div>
							<div style="clear:both"></div>
						</div><!-- .entry-author -->

<?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; else : ?>
<?php get_template_part( 'content', 'none' ); ?>
<?php endif; // end have_posts() check ?>
					</div><!-- #content -->

				</div><!-- #primary -->

			</div><!-- #main -->

<?php get_footer(); ?> 