<?php
/**
 * @package WordPress
 * @subpackage WPMedium
 * @since WPMedium 1.0
 */
get_header(); ?>
    
		<div id="home" class="hfeed site">

			<header id="masthead" class="site-header" role="banner" style="background-image:url(<?php header_image(); ?>);">

				<div class="site-header-overlay"></div>

				<hgroup>
					<div class="site-logo">
						<div class="wrapper-logo">
						<?php wpmedium_the_site_logo(); ?>		
						<span class="bubble b1"><span class="glow"></span></span>
	  					<span class="bubble b2"><span class="glow"></span></span>
  						<span class="bubble b3"><span class="glow"> </span></span>
						<span class="bubble b4"><span class="glow"> </span></span>
						</div>
					</div>
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
					<p><?php wpmedium_the_social_links(); ?></p>
				</hgroup>
        
<?php if ( is_active_sidebar( 'header-sidebar' ) ) : ?>
			    <div id="header-sidebar" class="widget-area header-sidebar" role="complementary">
				    <?php dynamic_sidebar( 'header-sidebar' ); ?>
			    </div><!-- #secondary -->
<?php endif; ?>

			</header><!-- #masthead -->

			<div id="main" class="wrapper">

				<div id="primary" class="site-content">

					<nav class="site-menu">
						<ul class="site-menu-links">
<?php if ( has_nav_menu( 'primary' ) ) : ?>
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => '', 'items_wrap' => '%3$s' ) ); ?>
<?php else : ?>
							<?php wpmedium_primary_menu(); ?>
<?php endif; ?>
							<li id="menu-item-search" class="menu-item menu-item-search"><?php get_search_form(); ?></li>
						</ul>

					</nav>

					<nav class="site-categories">
						<ul class="site-categories-order">
							<?php wpmedium_the_index_controls(); ?>
							<li class="site-categories-count"><a><?php printf( _n( '%d Post', '%d Posts', $wp_query->found_posts, 'wpmedium' ), $wp_query->found_posts ); ?></a></li>
						</ul>
					</nav>

					<div id="content" role="main">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php get_template_part( 'content' ); ?>
<?php endwhile; ?>
						<div style="clear:both"></div>

					</div><!-- #content -->

					<div class="pagination">
						<?php wpmedium_nav_link(); ?>
					</div>
<?php else : ?>
<?php get_template_part( 'content', 'none' ); ?>

					</div><!-- #content -->
<?php endif; // end have_posts() check ?>

				</div><!-- #primary -->

			</div><!-- #main .wrapper -->

<?php get_footer(); ?> 