<?php 
/**
 * Author Box for single post
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/
?>

<div class="clearfix single-box author-box single-author-box">

    <div class="avatar">
        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
            <?php
            // Author Image
            echo get_avatar( get_the_author_meta( 'email' ), '96', '', get_the_author_meta( 'display_name' ) ); 
            ?>
        </a>
    </div><!-- .avatar -->

    <div class="author-info">
        <div class="written-by"><?php _e( 'Written By', 'themetext' ); ?></div>
        <span class="author vcard">
            <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                <?php printf( __( '%s', 'themetext' ), get_the_author() ); ?>
            </a>
        </span>
        <p><?php the_author_meta( 'description' ); ?></p>
    </div><!-- .info -->
    
    <ul class="author-social">
        <?php
        $author_link = array ( 
            'user_url' => 'sphere',
            'sptwitter' => 'twitter',
            'spfacebook' => 'facebook',
            'spgoogle' => 'google-plus',
            'sppinterest' => 'pinterest',
            'splinkedin' => 'linkedin',
            'spinstagram' => 'instagram',
        );
        foreach ( $author_link as $link => $name ) {
        ?>
            <?php  
            if ( get_the_author_meta( $link ) ) {
                if ( $link == 'spgoogle' ) { $rel_author = '?rel=author'; }
                else { $rel_author = ''; }
            ?>
                <li>
                    <a href="<?php echo wp_kses( get_the_author_meta( $link ), null ) . $rel_author; ?>">
                        <i class="icomoon-<?php printf( $name, get_the_author() ); ?>"></i>
                    </a>
                </li>
            <?php } ?>
        <?php } ?>
    </ul><!-- .author-social -->
    
</div><!-- .author-box -->