<?php
/**
 * @package WordPress
 * @subpackage WPMedium
 * @since WPMedium 1.0
 */
get_header(); ?>

<script type="text/javascript" src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

<div id="single" class="hfeed site">

			<div id="main" class="wrapper">

				<div id="primary" class="site-content">

					<div id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

						<?php 
						$author = get_the_author();
						$nickname = "" ;
						?>
						<?php switch($author){
							case "Jan Sanchez":
								$fullname = "Jan Sanchez";
								$nickname = "+JanSanchez27";
							break;
							case "Erik Flores":
								$fullname = "Erik Flores";
								$nickname = "+ErikFlores";
							break;
							case "Ana Reyna":
								$fullname = "Ana Reyna";
								$nickname = "116009012807412102885";
							break;
							case "Andrés Muñoz":
								$fullname = "Andrés Muñoz";
								$nickname = "114603827794858187873";
							break;
							case "Victor Sandoval":
								$fullname = "Victor Sandoval";
								$nickname = "+victorSandovalValladolid";
							break;
							default:
								$fullname = "none";
								$nickname = "none";
							break;
						} ?>
						<?php /*
						<link rel="author" href="https://plus.google.com/<?php echo $nickname; ?>" />
						*/ ?>
						<div class="entry-author entry-author-side">
							<div class="author-avatar">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
							</div><!-- .author-avatar -->
							<div class="author-description">
								<h6><?php the_author_link(); ?></h6>
								<p><?php the_author_meta( 'description' ); ?></p>
							</div><!-- .author-description -->
							<div class="entry-date">
								<?php printf( '<h6>%s</h6> <span class="date">%s</span>', __( 'Publicado', 'wpmedium' ), get_the_date( 'F j, Y' ) ); ?>
							</div>


							<div style="clear:both"></div>
						</div><!-- .entry-author -->
						<?php /*
						<a style="display:none;" href="https://plus.google.com/<?php echo $nickname; ?>?rel=author">+<?php echo $fullname; ?></a>
						*/ ?>

<?php get_template_part( 'content', 'single' ); ?>

<?php endwhile; else :
	get_template_part( 'content', 'none' );
endif; // end have_posts() check ?>
					</div><!-- #content -->

				</div><!-- #primary -->

			</div><!-- #main -->

<?php get_footer(); ?>