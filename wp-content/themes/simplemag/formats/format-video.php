<?php 
/**
 * Single Post - Video format
 * Display video embed code from custom meta field
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.0
**/ 


/**
 * Get Video field value
**/
$video_page_url = get_post_meta( $post->ID, 'add_video_url', true );

/**
 * Output the video by page url
**/
$video_embed = wp_oembed_get( $video_page_url );
echo '<figure class="video-wrapper">' . $video_embed . '</figure>';