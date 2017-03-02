<?php
/**
 * Function for different Page Composer sections
**/



/**
 * Latest By Format composer section.
 *
 * Retrieve video, audio or gallery
 * based on the Format.
**/
function ajax_format_get_media() {

    // Verify nonce
    if( ! isset( $_POST['ti_nonce'] ) || ! wp_verify_nonce( $_POST['ti_nonce'], 'ti_nonce' ) ) {
        die( 'Permission denied' );
    }
    
    $postid = $_POST['postid'];
    $metakey = $_POST['metakey'];
    
    // Echo the video or audio iframe through the oEmbed function
    echo '<figure class="format-media-item">' . wp_oembed_get( get_post_meta( $postid, $metakey, true ) ) . '</figure>';
    
    die();
    
}

add_action( 'wp_ajax_load_custom_field_data', 'ajax_format_get_media' );
add_action( 'wp_ajax_nopriv_load_custom_field_data', 'ajax_format_get_media' );




/**
 * Button for Latest By Category.
 * Displayed in Sections:
 * 1. Latest By Category
 * 2. Posts Section - Latest By Category option
**/
function latest_by_category_button() {
?>

    <div class="composer-button">
        <?php
        // Link to the selected category
        $latest_by_cat_name = get_sub_field( 'category_section_name' );
        $posts_section_cat_name = get_sub_field( 'latest_select_category' );
        
        if ( $latest_by_cat_name ) :
            $cat_name = $latest_by_cat_name;
        elseif( $posts_section_cat_name ) :
            $cat_name = $posts_section_cat_name;
        endif;
    
        $cat_section_name = $cat_name;
        $category_link = get_category_link( $cat_section_name );

        // Add category name from the select field the the button
        $cat_section = get_category( $cat_section_name );
        $button_text = $cat_section->name;
        ?>
        <a class="read-more" href="<?php echo esc_url( $category_link ); ?>"><?php _e( 'View', 'themetext' ); echo ' ' . $button_text; ?></a>
    </div>

<?php }