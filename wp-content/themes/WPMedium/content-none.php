
						<article id="post-0" class="post no-results not-found">
<?php if ( current_user_can( 'edit_posts' ) ) : ?>
							<header class="entry-header">
								<h1 class="entry-title"><?php _e( 'No posts', 'wpmedium' ); ?></h1>
							</header>
							
							<div class="entry-content">
								<p><?php printf( __( 'Get Started %s', 'wpmedium' ), admin_url( 'post-new.php' ) ); ?></p>
							</div><!-- .entry-content -->
<?php else : ?>
							<header class="entry-header">
								<h1 class="entry-title"><?php _e( 'Nothing Found', 'wpmedium' ); ?></h1>
							</header>
							
							<div class="entry-content">
								<p><?php _e( 'No Results Found', 'wpmedium' ); ?></p>
								<?php get_search_form(); ?>
							</div><!-- .entry-content -->
<?php endif; // end current_user_can() check ?>
						</article><!-- #post-0 -->

						<article id="post-0-1" class="post empty">
							<h1 class="entry-title"><?php _e( 'Coming soon', 'wpmedium' ); ?></h1>
						</article><!-- #post-0-1 -->

						<article id="post-0-2" class="post empty">
							<h1 class="entry-title"><?php _e( 'Coming soon', 'wpmedium' ); ?></h1>
						</article><!-- #post-0-2 -->
