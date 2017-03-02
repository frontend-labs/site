<?php 
/**
 * The template for displaying all forum pages
 *
 * @package SimpleMag - bbPress child theme
 * @since 	SimpleMag 4.0
**/ 
get_header();
?>
	
<section id="content" role="main" class="clearfix anmtd">

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="wrapper">
            <div class="grids">
                <div class="grid-8 column-1">

                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                        <div class="page-title wrapper title-with-sep">
                            <header class="entry-header page-header">  
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </header>
                        </div>

                        <article class="entry-content">

                            <?php the_content(); ?>

                        </article>

                    <?php endwhile; endif; ?>

                </div><!-- .grid-8 -->

                <?php get_sidebar(); ?>

            </div><!-- .grids -->
        </div>

    </div>
</section><!-- #content -->

<?php get_footer(); ?>