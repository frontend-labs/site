<?php 
/**
 * Single Post - Audio format
 * Display audio embed code from SoundCloud from custom meta field
 *
 * @package SimpleMag
 * @since 	SimpleMag 1.4
**/ 


/**
 * Get Audio field value
**/
$audio_page_url = get_post_meta( $post->ID, 'add_audio_url', true );


/**
 * Output SoundCloud iframe by page url
**/
$audio_embed = wp_oembed_get( $audio_page_url, array( 'width' => '1170' ) );
echo $audio_embed;