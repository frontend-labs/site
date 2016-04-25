<?php
/**
 * Content Post - Item Post
 *
 * Dispalys post item in Page Composer
 * sections, categories and other archives.
 * Same markup is used for all avalibale layout types:
 * Masonry, Grid, Big and Small Thumbs Lis and Classic.
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/
?>

<article id="postid-<?php the_ID(); ?>" <?php post_class('grid-4'); ?>>
    
    <div class="post-item-inner">
    
        <?php
        // Format Quote
        if ( 'quote' == get_post_format() ):

            get_template_part( 'formats/format', 'quote' );

        // All Other Formats
        else :
        ?>

            <?php content_post_item_image(); ?>

            <div class="entry-details">
                
                <header class="entry-header">
                    
                    <?php content_post_item_meta(); ?>
                   
                    <?php content_post_item_title(); ?>
                    
                    <?php content_post_item_author(); ?>

                </header>

                <?php content_post_item_excerpt(); ?>

                <footer class="entry-footer">
                    
                    <?php content_post_item_social_icons(); ?>
                    
                    <?php content_post_item_read_more(); ?>

                </footer>
                
            </div>

        <?php endif; ?>

    </div>
    
</article>