<?php
/**
 * @package WordPress
 * @subpackage WPMedium
 * @since WPMedium 1.0
 */
get_header(); $term = get_queried_object(); ?>

		<div id="archive" class="hfeed site">

			<header id="masthead" class="site-header" role="banner">
				<hgroup>
					<div class="site-logo"><img class="site-avatar" src="<?php wpmedium_the_taxonomy_image(); ?>" alt="" /></div>
					<h1 class="site-title"><?php single_term_title( '' ); ?></h1>
<?php if ( term_description() ) : ?>
					<h2 class="site-description"><?php echo term_description(); ?></h2>
<?php endif; ?>
				</hgroup>
			</header><!-- #masthead -->
		
			<div id="main" class="wrapper">

				<div id="primary" class="site-content">
				
					<nav class="archive-menu">
						<ul class="archive-controls">
							<?php wpmedium_the_archive_controls(); ?>
						</ul>
						<span class="archive-infos archive-post-count"><?php printf( _n( '%d Post', '%d Posts', wpmedium_get_taxonomy_count( $term->taxonomy ), 'wpmedium' ), wpmedium_get_taxonomy_count( $term->taxonomy ) ); ?></span>
						<span class="archive-infos archive-post-backlink"><?php printf( __( 'Posted On %s %s', 'wpmedium' ), ''.home_url(), get_bloginfo( 'name' ) ); ?></span>
					</nav>
				
					<div id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content', 'archive' ); ?>
<?php endwhile; ?>
						<div style="clear:both"></div>

					</div><!-- #content -->

					<div class="pagination">
						<a id="loadmore" href="#">Load More</a>
						<?php posts_nav_link( ' &#183; ', sprintf( '<span class="pagination-left">%s</span>', __( 'Prev page', 'wpmedium' ) ), sprintf( '<span class="pagination-right">%s</span>', __( 'Next page', 'wpmedium' ) ) ); ?> 
					</div>
<?php else : ?>
<?php get_template_part( 'content', 'none' ); ?>

					</div><!-- #content -->
<?php endif; // end have_posts() check ?>

				</div><!-- #primary -->

			</div><!-- #main -->

<?php get_footer(); ?> 