
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<header class="entry-header">
								<div class="entry-meta" xmlns:v="http://rdf.data-vocabulary.org/#">
									<?php 
									if ( function_exists('yoast_breadcrumb') ) {
										yoast_breadcrumb('<div class="breadcrumb" id="breadcrumbs">','</div>');
									}
									?>
								</div>
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
								<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Páginas:', 'wpmedium' ), 'after' => '</div>' ) ); ?>
							</div><!-- .entry-content -->



<div class="after_post">

	<script type="text/javascript"> 
	clicksor_enable_adhere = false; 

	clicksor_default_url = '';
	clicksor_banner_border = '#99CC33'; 
	clicksor_banner_ad_bg = '#FFFFFF';
	clicksor_banner_link_color = '#5765ad'; 
	clicksor_banner_text_color = '#666666';
	clicksor_layer_border_color = '';
	clicksor_layer_ad_bg = ''; 
	clicksor_layer_ad_link_color = '';
	clicksor_layer_ad_text_color = ''; 
	clicksor_text_link_bg = '';
	clicksor_text_link_color = ''; 
	clicksor_enable_text_link = false;
			 
	clicksor_banner_text_banner = true;
	clicksor_banner_image_banner = true; 
	clicksor_enable_layer_pop = false;
	clicksor_enable_pop = false;
	</script>
	<script type="text/javascript" src="http://ads.clicksor.com/newServing/showAd.php?nid=1&amp;pid=324831&amp;adtype=1&amp;sid=553142"></script>
	

	

</div>


<?php if ( get_the_tags() ) : ?>
							<div class="entry-tags">
								<?php wpmedium_the_taxonomy( sprintf( '%s ', __( 'Esta entrada también aparece en', 'wpmedium' ) ), ', ', '' ); ?>
							</div><!-- .entry-tags -->
<?php endif; ?>

							<div class="entry-author entry-author-bottom">
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
 <?php if ( comments_open() ): ?>
							<div class="entry-comment">
								<?php /*
								<a class="toggle-comments" id="show_comments" href="#comments"><?php _e( 'Mostrar comentarios', 'wpmedium' ); ?></a>
								<a class="toggle-comments" id="hide_comments" href="#comments"><?php _e( 'Ocultar comentarios', 'wpmedium' ); ?></a>
								*/ ?>
								<?php comments_template(); ?>
							</div>
<?php endif; ?>

						</article>
