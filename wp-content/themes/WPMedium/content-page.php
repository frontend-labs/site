
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<div class="entry-thumb">
									<?php wpmedium_the_post_thumbnail(); ?>
									<?php wpmedium_the_post_thumbnail_credit(); ?>
								</div>
								<div class="entry-meta">
									<?php wpmedium_post_entry_meta(); ?>
								</div><!-- .entry-meta -->
								<h1 class="entry-title">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpmedium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h1>
							</header><!-- .entry-header -->
							
							<div class="entry-content">
								<?php the_content(); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'wpmedium' ), 'after' => '</div>' ) ); ?>
							</div><!-- .entry-content -->

							<div class="entry-author entry-author-bottom">
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
 <?php if ( comments_open() ): ?>
							<div class="entry-comment">
								<?php /*
								<a class="toggle-comments" id="show_comments" href="#comments"><?php _e( 'Show Comments', 'wpmedium' ); ?></a>
								<a class="toggle-comments" id="hide_comments" href="#comments"><?php _e( 'Hide Comments', 'wpmedium' ); ?></a>
								*/ ?>
								<?php comments_template(); ?>
							</div>
<?php endif; ?>

						</article>
