<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Stag_Customizer
 * @subpackage Ink
 */

get_header(); ?>

<script type="text/javascript" src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

	<?php get_template_part( '_post', 'cover-wrap' ); ?>

    <?php if (get_the_ID()!=1669){ ?>
    <div class="banners">
		<div class="after_all">
			<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- after_all -->
			<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-9151106315507816" data-ad-slot="1949147488"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>	
		</div>
	</div>
	<?php } ?>

	<main id="main" class="site-main">

	<?php /* Start the Loop */ ?>
	<?php while ( have_posts() ) : the_post(); ?>

		<?php get_template_part( 'content', 'single' ); ?>

		<?php stag_related_posts(); ?>

		<?php get_template_part( '_post', 'comments' ); ?>

	<?php endwhile; // end of the loop. ?>

	</main><!-- #main -->

<?php get_footer();
