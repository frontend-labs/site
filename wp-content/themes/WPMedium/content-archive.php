<?php 
$class = '';
if ( is_sticky() && !is_paged() ) $class .= 'sticky';
if ( ! has_post_thumbnail() && ! wpmedium_o( 'use_post_thumbnail' ) ) $class .= ' no-thumbnail'; ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class( $class ); ?>>
							<header class="entry-header">
								<div class="entry-header-image">
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php wpmedium_the_post_thumbnail( null, 'medium-featured-image' ); ?></a>
								</div>
								<h1 class="entry-title">
									<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'wpmedium' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
								</h1>
							</header><!-- .entry-header -->
							    
							<div class="entry-content">
								<?php ( is_sticky() ? wpmedium_the_long_excerpt( get_the_content() ) : the_excerpt() ); ?>
							</div><!-- .entry-content -->
							
							<footer class="entry-meta">
								<div class="wrap">
									<?php wpmedium_post_entry_meta(); ?>
								</div>
							</footer><!-- .entry-meta -->
						</article>
