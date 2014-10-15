<?php
/*
Plugin Name: Post Author 
Plugin URI: http://wordpress.org/extend/plugins/post-author/
Description: Adds the name of author at the top or bottom of the content or excerpts (post / page / archive), plus optional publishing and last editing date, complete with surrounding text and a per-post hide option for exceptions.
Author: David Shabtai
Version: 1.1.1
Author URI: http://www.glanum.com
Copyright (C) 2014 David Shabtai
david@glanum.com
http://www.glanum.com
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 3
of the License, or any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

function ad_post_author_option($name, $value, $type)
{
        $value = 'off';
    if( ($type == 'bool') && (strlen($value) == 0) )
    if( get_option($name) == FALSE )
        add_option($name, $value);
    else
        update_option($name, $value);
    echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></div>';
}

function post_author_init()
{
	/* === OBSOLETE since version 1.1
    $locale = get_locale();
    if( empty($locale) )
        $locale = 'en_US';
    $mofile = dirname(__FILE__) . "/languages/$locale.mo";
    load_textdomain('post_author', $mofile);
	*/
	
	/**
	 * Load the plugin translation files
	 *
	 * Used instead of load_textdomain() function.
	 * The .mo and .po files are now prefixed by plugin name
	 *
	 * @since version 1.1
	 */
	load_plugin_textdomain('post_author',false, dirname( plugin_basename( __FILE__ ) ). '/languages/' ); 
	
    if( !get_option('Post_Author_Options') )
    {

        $defaults = array( );
        if( !get_option('post_author_txt_before') )
        {
            $defaults['post_author_txt_before'] = __('Written by: ', 'post_author');
        }
        else
        {
            $defaults['post_author_txt_before'] = get_option('post_author_txt_before');
            delete_option('post_author_txt_before');
        }
        if( !get_option('post_author_txt_after') )
        {
            $defaults['post_author_txt_after'] = ' ';
        }
        else
        {
            $defaults['post_author_txt_after'] = get_option('post_author_txt_after');
            delete_option('post_author_txt_after');
        }
        if( !get_option('post_author_type_post') )
        {
            $defaults['post_author_type_post'] = 'on';
        }
        else
        {
            $defaults['post_author_type_post'] = get_option('post_author_type_post');
            delete_option('post_author_type_post');
        }
        if( !get_option('post_author_type_page') )
        {
            $defaults['post_author_type_page'] = 'on';
        }
        else
        {
            $defaults['post_author_type_page'] = get_option('post_author_type_page');
            delete_option('post_author_type_page');
        }
        if( !get_option('post_author_author_link') )
        {
            $defaults['post_author_author_link'] = 'on';
        }
        else
        {
            $defaults['post_author_author_link'] = get_option('post_author_author_link');
            delete_option('post_author_author_link');
        }
        if( !get_option('post_author_author_link_to_url') )
        {
            $defaults['post_author_author_link_to_url'] = 'on';
        }
        else
        {
            $defaults['post_author_author_link_to_url'] = get_option('post_author_author_link_to_url');
            delete_option('post_author_author_link_to_url');
        }
        
        if( !get_option('post_author_author_avatar') )
        {
            $defaults['post_author_author_avatar'] = 'on';
        }
        else
        {
            $defaults['post_author_author_avatar'] = get_option('post_author_author_avatar');
            delete_option('post_author_author_avatar');
        }
        if( !get_option('post_author_author_avatar_size') )
        {
            $defaults['post_author_author_avatar_size'] = '32';
        }
        else
        {
            $defaults['post_author_author_avatar_size'] = get_option('post_author_author_avatar_size');
            delete_option('post_author_author_avatar_size');
        }
        if( !get_option('post_author_author_avatar_float') )
        {
            $defaults['post_author_author_avatar_float'] = 'left';
        }
        else
        {
            $defaults['post_author_author_avatar_float'] = get_option('post_author_author_avatar_float');
            delete_option('post_author_author_avatar_float');
        }
        
        //added
        $defaults['post_author_author_avatar_on_post'] = get_option('post_author_author_avatar_on_post', 'on');
        delete_option('post_author_author_avatar_on_post');
        $defaults['post_author_author_avatar_on_cat'] = get_option('post_author_author_avatar_on_cat', 'on');
        delete_option('post_author_author_avatar_on_cat');
            
        $defaults['post_author_author_avatar_size_on_post'] = get_option('post_author_author_avatar_size_on_post', '32');
        delete_option('post_author_author_avatar_size_on_post');
        $defaults['post_author_author_avatar_size_on_cat'] = get_option('post_author_author_avatar_size_on_cat', '32');
        delete_option('post_author_author_avatar_size_on_cat');
        
        $defaults['post_author_author_avatar_float_on_post'] = get_option('post_author_author_avatar_float_on_post', 'left');
        delete_option('post_author_author_avatar_float_on_post');
        $defaults['post_author_author_avatar_float_on_cat'] = get_option('post_author_author_avatar_float_on_cat', 'left');
        delete_option('post_author_author_avatar_float_on_cat');
        $defaults['post_author_modified_after_follow'] = get_option('post_author_modified_after_follow', __(', our reviewer, on ', 'post_author'));
        delete_option('post_author_modified_after_follow');
        // end added
        
        
        
        if( !get_option('post_author_create_dat') )
        {
            $defaults['post_author_create_dat'] = 'on';
        }
        else
        {
            $defaults['post_author_create_dat'] = get_option('post_author_create_dat');
            delete_option('post_author_create_dat');
        }
        if( !get_option('post_author_modify_author') )
        {
            $defaults['post_author_modify_author'] = 'on';
        }
        else
        {
            $defaults['post_author_modify_author'] = get_option('post_author_modify_author');
            delete_option('post_author_modify_author');
        }
        if( !get_option('post_author_modify_dat') )
        {
            $defaults['post_author_modify_dat'] = 'on';
        }
        else
        {
            $defaults['post_author_modify_dat'] = get_option('post_author_modify_dat');
            delete_option('post_author_modify_dat');
        }
        if( !get_option('post_author_dat_before') )
        {
            $defaults['post_author_dat_before'] = __('on ', 'post_author');
        }
        else
        {
            $defaults['post_author_dat_before'] = get_option('post_author_dat_before');
            delete_option('post_author_dat_before');
        }
        if( !get_option('post_author_dat_after') )
        {
            $defaults['post_author_dat_after'] = '.';
        }
        else
        {
            $defaults['post_author_dat_after'] = get_option('post_author_dat_after');
            delete_option('post_author_dat_after');
        }
        if( !get_option('post_author_modified_before') )
        {
            $defaults['post_author_modified_before'] = '<br/>' . __('Last revised by: ', 'post_author');
        }
        else
        {
            $defaults['post_author_modified_before'] = get_option('post_author_modified_before');
            delete_option('post_author_modified_before');
        }
        if( !get_option('post_author_modified_after') )
        {
            $defaults['post_author_modified_after'] = ' ';
        }
        else
        {
            $defaults['post_author_modified_after'] = get_option('post_author_modified_after');
            delete_option('post_author_modified_after');
        }
        if( !get_option('post_author_modified_dat_before') )
        {
            $defaults['post_author_modified_dat_before'] = __('on ', 'post_author');
        }
        else
        {
            $defaults['post_author_modified_dat_before'] = get_option('post_author_modified_dat_before');
            delete_option('post_author_modified_dat_before');
        }
        if( !get_option('post_author_modified_dat_after') )
        {
            $defaults['post_author_modified_dat_after'] = '.';
        }
        else
        {
            $defaults['post_author_modified_dat_after'] = get_option('post_author_modified_dat_after');
            delete_option('post_author_modified_dat_after');
        }
        if( !get_option('post_author_top') )
        {
            $defaults['post_author_top'] = 'off';
        }
        else
        {
            $defaults['post_author_top'] = get_option('post_author_top');
            delete_option('post_author_top');
        }
        
        
        $defaults['post_author_top_on_post'] = get_option('post_author_top_on_post','off');
        delete_option('post_author_top_on_post');
        
        
        if( !get_option('post_author_type_cat') )
        {
            $defaults['post_author_type_cat'] = 'on';
        }
        else
        {
            $defaults['post_author_type_cat'] = get_option('post_author_type_cat');
            delete_option('post_author_type_cat');
        }
        if( !get_option('post_author_cat_top') )
        {
            $defaults['post_author_cat_top'] = 'off';
        }
        else
        {
            $defaults['post_author_cat_top'] = get_option('post_author_cat_top');
            delete_option('post_author_cat_top');
        }
        if( !get_option('post_author_cat_home') )
        {
            $defaults['post_author_cat_home'] = 'on';
        }
        else
        {
            $defaults['post_author_cat_home'] = get_option('post_author_cat_home');
            delete_option('post_author_cat_home');
        }

        $defaults['post_author_link_name'] = '';

        update_option('Post_Author_Options', $defaults);
    }
}

// Surcharge avatar function

if( !function_exists('get_avatar') )
{

    function get_avatar($id_or_email, $size = '96', $default = '', $alt = false, $align = '')
    {
        if( !get_option('show_avatars') )
            return false;

        if( false === $alt )
            $safe_alt = '';
        else
            $safe_alt = esc_attr($alt);

        if( !is_numeric($size) )
            $size = '96';

        $email = '';
        if( is_numeric($id_or_email) )
        {
            $id = (int) $id_or_email;
            $user = get_userdata($id);
            if( $user )
                $email = $user->user_email;
        } elseif( is_object($id_or_email) )
        {
            // No avatar for pingbacks or trackbacks
            $allowed_comment_types = apply_filters('get_avatar_comment_types', array( 'comment' ));
            if( !empty($id_or_email->comment_type) && !in_array($id_or_email->comment_type, (array) $allowed_comment_types) )
                return false;

            if( !empty($id_or_email->user_id) )
            {
                $id = (int) $id_or_email->user_id;
                $user = get_userdata($id);
                if( $user )
                    $email = $user->user_email;
            } elseif( !empty($id_or_email->comment_author_email) )
            {
                $email = $id_or_email->comment_author_email;
            }
        }
        else
        {
            $email = $id_or_email;
        }

        if( empty($default) )
        {
            $avatar_default = get_option('avatar_default');
            if( empty($avatar_default) )
                $default = 'mystery';
            else
                $default = $avatar_default;
        }

        if( !empty($email) )
            $email_hash = md5(strtolower($email));

        if( is_ssl() )
        {
            $host = 'https://secure.gravatar.com';
        }
        else
        {
            if( !empty($email) )
                $host = sprintf("http://%d.gravatar.com", ( hexdec($email_hash{0}) % 2));
            else
                $host = 'http://0.gravatar.com';
        }

        if( 'mystery' == $default )
            $default = "$host/avatar/ad516503a11cd5ca435acc9bb6523536?s={$size}"; // ad516503a11cd5ca435acc9bb6523536 == md5('unknown@gravatar.com')
        elseif( 'blank' == $default )
            $default = includes_url('images/blank.gif');
        elseif( !empty($email) && 'gravatar_default' == $default )
            $default = '';
        elseif( 'gravatar_default' == $default )
            $default = "$host/avatar/s={$size}";
        elseif( empty($email) )
            $default = "$host/avatar/?d=$default&amp;s={$size}";
        elseif( strpos($default, 'http://') === 0 )
            $default = add_query_arg('s', $size, $default);

        if( !empty($email) )
        {
            $out = "$host/avatar/";
            $out .= $email_hash;
            $out .= '?s=' . $size;
            $out .= '&amp;d=' . urlencode($default);

            $rating = get_option('avatar_rating');
            if( !empty($rating) )
                $out .= "&amp;r={$rating}";

            $avatar = "<img alt='{$safe_alt}' src='{$out}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' align='{$align}' />";
        } else
        {
            $avatar = "<img alt='{$safe_alt}' src='{$default}' class='avatar avatar-{$size} photo avatar-default' height='{$size}' width='{$size}' align='{$align}' />";
        }

        return apply_filters('get_avatar', $avatar, $id_or_email, $size, $default, $alt);
    }

}

// Appends content with author name and link

function add_author_to_post($content)
{
    $content_org = $content;
    $options = get_option('Post_Author_Options');
    $post_author_modify_link_name = '';
    $post_id = get_the_ID();
    $author_exception = get_post_meta($post_id, 'hide_author_value', TRUE);

    
    
    
    if( $options['post_author_link_name'] == '' )
    {
        $options['post_author_link_name'] = get_author_posts_url(get_the_author_ID());
        $post_author_modify_link_name = get_author_posts_url(get_post_meta($post_id, '_edit_last', true));
    }
    
    
    
    //$post_date = get_the_time(get_option('date_format'));
    $post_date = get_the_date(); // Edit 2011/11/21 by Christophe Serra <christophe[at]glanum.com>

    //$modified_date = get_the_modified_time(get_option('date_format'));
    $modified_date = get_the_modified_date();  // Edit 2011/11/21 by Christophe Serra <christophe[at]glanum.com>
    
    $author = get_the_author();
    $modified_author = get_the_modified_author();
    $moreabout = sprintf(__("More about %s", "post_author"), attribute_escape($author));
    $moreabout_modified = sprintf(__("More about %s", "post_author"), attribute_escape($modified_author));
    $author_link_start = '';
    $author_link_end = '';
    $author_modify_link_start = '';
    
    $author_modify_infos = get_userdata(get_post_meta($post_id, '_edit_last', true));
    
    if( $options['post_author_author_link'] == 'on' )
    {
        if( function_exists('esc_attr') )
        {
            // personal URL on profile
            if( $options['post_author_author_link_to_url'] == 'on' && get_the_author_meta('user_url', $author->ID) != NULL )
            { 
                $author_link_start = '<a href="' . esc_attr(get_the_author_meta('user_url', $author->ID)) . '" target="_blank" title="' . $moreabout . ' ">';
                
            }
            // simple link to author page on WP
            else
            { 
                $author_link_start = '<a href="' . esc_attr($options['post_author_link_name']) . '" title="' . $moreabout . ' ">';
                
            }
            
            // personal editor URL on profile
            if( $options['post_author_author_link_to_url'] == 'on' && $author_modify_infos->user_url != "")
            {   
                $author_modify_link_start = '<a href="' . esc_attr($author_modify_infos->user_url) . '" target="_blank" title="' . $moreabout_modified . ' ">';
            }
            // simple link to editor page on WP
            else
            { 
                $author_modify_link_start = '<a href="' . esc_attr($post_author_modify_link_name) . '" title="' . $moreabout_modified . ' ">';
            }
         
        }
        else
        {
            // personal URL on profile
            if( $options['post_author_author_link_to_url'] == 'on' && get_the_author_meta('user_url', $author->ID) != NULL )
            { 
                $author_link_start = '<a href="' . attribute_escape(get_the_author_meta('user_url', $author->ID)) . '" target="_blank" title="' . $moreabout . ' ">';
                
            }
            // simple link to author page on WP
            else
            { 
                $author_link_start = '<a href="' . attribute_escape($options['post_author_link_name']) . '" title="' . $moreabout . ' ">';
                
            }
            
            // personal editor URL on profile
            if( $options['post_author_author_link_to_url'] == 'on' && $author_modify_infos->user_url != "")
            {   
                $author_modify_link_start = '<a href="' . attribute_escape($author_modify_infos->user_url) . '" target="_blank" title="' . $moreabout_modified . ' ">';
            }
            // simple link to editor page on WP
            else
            { 
                $author_modify_link_start = '<a href="' . attribute_escape($post_author_modify_link_name) . '" title="' . $moreabout_modified . ' ">';
            }
            
            
        }
        $author_link_end = '</a>';
    }

    
        
    // Edit 2011/11/21 by Christophe Serra <christophe[at]glanum.com>
    // added the && in_the_loop() condition
    // to check if the_content is called within the loop
    if( (is_page() && ($options['post_author_type_page'] == 'on') && in_the_loop() ) || (is_single() && ($options['post_author_type_post'] == 'on') && in_the_loop() ) )
    {

        
        
        // IF NO EXCEPTION FOR THIS POST, ADD ORIGINAL AUTHOR INFORMATION
        if( $author_exception != 'on' )
        {
            $content = '<div class="post_author_plugin">';
            
            if( is_page() && $options['post_author_author_avatar'] == 'on' )
            {
                $content .='<div class="post_author_avatar">';
                $content .= $author_link_start;
                $content .= get_avatar(get_the_author_meta('user_email'), $options['post_author_author_avatar_size'], '', $moreabout, $options['post_author_author_avatar_float']);
                $content .= $author_link_end;
                $content .= '</div>';
            }else if( !is_page() && $options['post_author_author_avatar_on_post'] == 'on'){
                $content .='<div class="post_author_avatar">';
                $content .= $author_link_start;
                $content .= get_avatar(get_the_author_meta('user_email'), $options['post_author_author_avatar_size_on_post'], '', $moreabout, $options['post_author_author_avatar_float_on_post']);
                $content .= $author_link_end;
                $content .= '</div>';
            }
            
            
            
            
            $content .='<span class="post_author_author">' . $options['post_author_txt_before'] . ' ';
            $content .= $author_link_start;
            $content .= $author;
            $content .= $author_link_end;
            $content .= $options['post_author_txt_after'] . '</span>';
            // ADD OPTIONAL DATE
            if( $options['post_author_create_dat'] == 'on' )
            {
                $content .= '<span class="post_author_create">' . $options['post_author_dat_before'] . $post_date . $options['post_author_dat_after'] . '</span>';
            }
				
			
            // NOW ADD REVISION
            if( $options['post_author_modify_author'] == 'on' AND $modified_author != $author)
            {
				$content .= '<span class="post_author_modify">' . $options['post_author_modified_before'];
				$content .= $author_modify_link_start;
				$content .= $modified_author; 
				$content .= $author_link_end;
				if( $post_date != $modified_date AND $options['post_author_modify_dat'] == 'on')
				{
					$content .= $options['post_author_modified_after_follow'] ;
				}else{
					$content .= $options['post_author_modified_after'] ;
				}
				$content .= '</span>';
            }
            
            
            
            if( $options['post_author_modify_dat'] == 'on' )
            {
                if( $post_date != $modified_date )
                {
                    $content .= '<span class="post_author_modify_dat">';
                    if( $modified_author == $author OR $options['post_author_modify_author'] != 'on')
                    {
                        $content .= $options['post_author_modified_dat_before'];
                    }
                    $content .= $modified_date . $options['post_author_modified_dat_after'] . '</span>';
                }
            }

            // END REVISION
            $content .= '</div>';
            if( (is_page() &&  $options['post_author_top'] == 'on') OR (!is_page() &&  $options['post_author_top_on_post'] == 'on') )
            {
                $content .= $content_org;
            }
            else
            {
                $content = $content_org . $content;
            }
        }
    }
    //$content .= var_dump(the_author_meta( 'user_url', $author->ID ) == NULL);
        
    return($content);
}

/*
 * If activated in option,
 * displays the author on a category page
 */

function add_author_to_cat($content)
{
    $content_org = $content;
    $options = get_option('Post_Author_Options');
//    $post_author_modify_link_name = '';
    $post_id = get_the_ID();
    $author_exception = get_post_meta($post_id, 'hide_author_value', TRUE);
    if( $options['post_author_link_name'] == '' )
    {
        $options['post_author_link_name'] = get_author_posts_url(get_the_author_ID());
        $post_author_modify_link_name = get_author_posts_url(get_post_meta($post_id, '_edit_last', true));
    }
    //$post_date = get_the_time(get_option('date_format'));
    $post_date = get_the_date(); // Edit 2011/11/21 by Christophe Serra <christophe[at]glanum.com>
    $author = get_the_author();
    $modified_date = get_the_modified_time(get_option('date_format'));
    $modified_author = get_the_modified_author();


    if( ((is_home() && !($options['post_author_cat_home'] == 'on')) || is_category()) && ($options['post_author_type_cat'] == 'on') )
    {
        if( $author_exception != 'on' )
        {
            $content = '<div class="post_author_plugin_cat"><span class="post_author_author">' . $options['post_author_txt_before'] . ' ';
            
            // Author link 
            if( $options['post_author_author_link'] == 'on' )
            {
                
                // Avatar on cat
                if( $options['post_author_author_avatar_on_cat'] == 'on' )
                {
                    $content .='<div class="post_author_avatar">';
                    $content .= $author_link_start;
                    $content .= get_avatar(get_the_author_meta('user_email'), $options['post_author_author_avatar_size_on_cat'], '', $moreabout, $options['post_author_author_avatar_float_on_cat']);
                    $content .= $author_link_end;
                    $content .= '</div>';
                }
                
                
                
                
                if( function_exists('esc_attr') )
                {
                    // personal URL on profile
                    if( $options['post_author_author_link_to_url'] == 'on' && get_the_author_meta('user_url', $author->ID) != NULL )
                    { 
                        $content .= '<a href="' . esc_attr(get_the_author_meta('user_url', $author->ID)) . '" target="_blank" title="' . $moreabout . ' ">';

                    }
                    // simple link to author page on WP
                    else
                    { 
                        $content .= '<a href="' . esc_attr($options['post_author_link_name']) . '" title="' . $moreabout . ' ">';

                    }

                }
                else
                {
                    // personal URL on profile
                    if( $options['post_author_author_link_to_url'] == 'on' && get_the_author_meta('user_url', $author->ID) != NULL )
                    { 
                        $content .= '<a href="' . attribute_escape(get_the_author_meta('user_url', $author->ID)) . '" target="_blank" title="' . $moreabout . ' ">';

                    }
                    // simple link to author page on WP
                    else
                    { 
                        $content .= '<a href="' . attribute_escape($options['post_author_link_name']) . '" title="' . $moreabout . ' ">';

                    }
                }
            }
            
            $content .= $author;
            
            if( $options['post_author_author_link'] == 'on' )
            {
                $content .= '</a>';
            }
            
            $content .= $options['post_author_txt_after'] . '</span>';
            
            // ADD OPTIONAL DATE
            if( $options['post_author_create_dat'] == 'on' )
            {
                $content .= '<span class="post_author_create">' . $options['post_author_dat_before'] . $post_date . $options['post_author_dat_after'] . '</span>';
            }
            $content .= '</div>';
            
            // Place before or after excerpt
            if( ($options['post_author_cat_top'] == 'on' ) )
            {
                $content .= $content_org;
            }
            else
            {
                $content = $content_org . $content;
            }
        }
    }
    return($content);
}

// post page

$post_author_meta_boxes =
        array(
            'my_post_author' => array(
                'name' => 'hide_author',
                'std' => 'off' )
);

function post_author_add_custom_box()
{
    if( function_exists('add_meta_box') )
    {
        add_meta_box('authordiv', __('Author'), 'post_author_custom_box', 'post', 'normal');
        add_meta_box('authordiv', __('Author'), 'post_author_custom_box', 'page', 'normal');
    }
}

function post_author_custom_box()
{
    global $post, $post_author_meta_boxes, $pagenow;
    foreach($post_author_meta_boxes as $post_author_box)
    {
        $post_author_box_value = get_post_meta($post->ID, $post_author_box['name'] . '_value', true);
        if( $post_author_box_value == '' )
            $post_author_box_value = $post_author_box['std'];
    }
    /* if ( ('page' == get_post_type($post)) || ($pagenow == 'page-new.php') ) {
      $original_wp_author_box = page_author_meta_box($post);
      } else {
      $original_wp_author_box = post_author_meta_box($post);
      } */
    if( function_exists('page_author_meta_box') )
    {
        if( ('page' == get_post_type($post)) || ($pagenow == 'page-new.php') )
        {
            $original_wp_author_box = page_author_meta_box($post);
        }
        else
        {
            $original_wp_author_box = post_author_meta_box($post);
        }
    }
    else
    {
        $original_wp_author_box = post_author_meta_box($post);
    }

    $post_author_custom = '<span style="margin-left:50px">';
    $post_author_custom .= '<input type="hidden" name="' . $post_author_box['name'] . '_noncename" id="' . $post_author_box['name'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
    $post_author_custom .= '<input type="checkbox" name="' . $post_author_box['name'] . '_value" id="' . $post_author_box['name'] . '_value"';
    if( $post_author_box_value == 'on' )
    {
        $post_author_custom .= 'checked="checked"';
    }
    $post_author_custom .= '/> <label for="' . $post_author_box['name'] . '_value">' . __("Hide author for this article (<i>Post Author plugin</i>)", "post_author") . '</label>';
    $post_author_custom .= '</span>';
    echo $original_wp_author_box . $post_author_custom;
}

function post_author_save_postdata($post_id)
{
    global $post, $post_author_meta_boxes;
    foreach($post_author_meta_boxes as $post_author_box)
    {
        if( !wp_verify_nonce($_POST[$post_author_box['name'] . '_noncename'], plugin_basename(__FILE__)) )
        {
            return $post_id;
        }
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        {
            return $post_id;
        }
        if( 'page' == get_post_type($post) )
        {
            if( !current_user_can('edit_page', $post_id) )
                return $post_id;
        } else
        {
            if( !current_user_can('edit_post', $post_id) )
                return $post_id;
        }
        $post_author_data = $_POST[$post_author_box['name'] . '_value'];
        if( get_post_meta($post_id, $post_author_box['name'] . '_value') == '' )
            add_post_meta($post_id, $post_author_box['name'] . '_value', $post_author_data, true);
        elseif( $post_author_data != get_post_meta($post_id, $post_author_box['name'] . '_value', true) )
            update_post_meta($post_id, $post_author_box['name'] . '_value', $post_author_data);
        elseif( ($post_author_data == '') || ($post_author_data = FALSE) )
            delete_post_meta($post_id, $post_author_box['name'] . '_value', get_post_meta($post_id, $post_author_box['name'] . '_value', true));
    }
}

// admin page

function postauthor_adminpage()
{
    add_options_page('Post author setup', 'Post author', 8, __FILE__, 'postauthor_optionpage');
}

function postauthor_optionpage()
{

    $options = get_option('Post_Author_Options');

    if( isset($_POST['Submit']) )
    {
        $new_options = array( );

        $new_options['post_author_txt_before'] = stripslashes($_POST['txt_before']);
        $new_options['post_author_txt_after'] = stripslashes($_POST['txt_after']);
        $new_options['post_author_author_avatar_size'] = stripslashes($_POST['author_avatar_size']);
        $new_options['post_author_author_avatar_float'] = stripslashes($_POST['author_avatar_float']);
        
        $new_options['post_author_author_avatar_size_on_post'] = stripslashes($_POST['author_avatar_size_on_post']);
        $new_options['post_author_author_avatar_float_on_post'] = stripslashes($_POST['author_avatar_float_on_post']);
        $new_options['post_author_author_avatar_size_on_cat'] = stripslashes($_POST['author_avatar_size_on_cat']);
        $new_options['post_author_author_avatar_float_on_cat'] = stripslashes($_POST['author_avatar_float_on_cat']);
        
        $new_options['post_author_link_name'] = stripslashes($_POST['link_name']);
        $new_options['post_author_dat_before'] = stripslashes($_POST['dat_before']);
        $new_options['post_author_dat_after'] = stripslashes($_POST['dat_after']);
        $new_options['post_author_modified_before'] = stripslashes($_POST['modified_before']);
        $new_options['post_author_modified_after'] = stripslashes($_POST['modified_after']);
        $new_options['post_author_modified_after_follow'] = stripslashes($_POST['modified_after_follow']);
        $new_options['post_author_modified_dat_before'] = stripslashes($_POST['modified_dat_before']);
        $new_options['post_author_modified_dat_after'] = stripslashes($_POST['modified_dat_after']);

        if( strlen($_POST['type_post']) == 0 )
        {
            $_POST['type_post'] = 'off';
        }
        if( strlen($_POST['type_page']) == 0 )
        {
            $_POST['type_page'] = 'off';
        }
        if( strlen($_POST['author_link']) == 0 )
        {
            $_POST['author_link'] = 'off';
        }
        if( strlen($_POST['author_avatar']) == 0 )
        {
            $_POST['author_avatar'] = 'off';
        }
        if( strlen($_POST['author_avatar_on_post']) == 0 )
        {
            $_POST['author_avatar_on_post'] = 'off';
        }
        if( strlen($_POST['author_avatar_on_cat']) == 0 )
        {
            $_POST['author_avatar_on_cat'] = 'off';
        }
        if( strlen($_POST['create_dat']) == 0 )
        {
            $_POST['create_dat'] = 'off';
        }
        if( strlen($_POST['modify_dat']) == 0 )
        {
            $_POST['modify_dat'] = 'off';
        }
        if( strlen($_POST['modify_author']) == 0 )
        {
            $_POST['modify_author'] = 'off';
        }
        if( strlen($_POST['top']) == 0 )
        {
            $_POST['top'] = 'off';
        }
        if( strlen($_POST['post_author_top_on_post']) == 0 )
        {
            $_POST['post_author_top_on_post'] = 'off';
        }
        if( strlen($_POST['type_cat']) == 0 )
        {
            $_POST['type_cat'] = 'off';
        }
        if( strlen($_POST['cat_top']) == 0 )
        {
            $_POST['cat_top'] = 'off';
        }
        if( strlen($_POST['cat_home']) == 0 )
        {
            $_POST['cat_home'] = 'off';
        }

        $new_options['post_author_type_post'] = $_POST['type_post'];
        $new_options['post_author_type_page'] = $_POST['type_page'];
        $new_options['post_author_author_link'] = $_POST['author_link'];
        $new_options['post_author_author_link_to_url'] = $_POST['author_link_to_url'];
        $new_options['post_author_author_avatar'] = $_POST['author_avatar'];
        $new_options['post_author_author_avatar_on_post'] = $_POST['author_avatar_on_post'];
        $new_options['post_author_author_avatar_on_cat'] = $_POST['author_avatar_on_cat'];
        $new_options['post_author_create_dat'] = $_POST['create_dat'];
        $new_options['post_author_modify_dat'] = $_POST['modify_dat'];
        $new_options['post_author_modify_author'] = $_POST['modify_author'];
        $new_options['post_author_top'] = $_POST['top'];
        $new_options['post_author_top_on_post'] = $_POST['post_author_top_on_post'];
        $new_options['post_author_type_cat'] = $_POST['type_cat'];
        $new_options['post_author_cat_top'] = $_POST['cat_top'];
        $new_options['post_author_cat_home'] = $_POST['cat_home'];

        update_option('Post_Author_Options', $new_options);
        $options = $new_options;
        echo '<div id="message" class="updated fade"><p><strong>' . __("Settings saved.", "post_author") . '</strong></div>';
    }
    ?>

    <div class="wrap" style="max-width:950px ! important;">
        <div id="icon-options-general" class="icon32"><br /></div>
        <h2><?php _e('Options for Post Author', 'post_author') ?></h2>

        <form action="" method="post">
            <h3><?php _e('Surrounding text', 'post_author') ?></h3>
            <p>
                <input type="text" name="txt_before" id="txt_before"  value="<?php echo attribute_escape($options['post_author_txt_before']) ?>" />
                <label for="txt_before"><?php _e('Text to be displayed before the name of the author', 'post_author') ?></label>
            </p>
            <p>
                <input type="text" name="txt_after" id="txt_after"  value="<?php echo attribute_escape($options['post_author_txt_after']) ?>" />
                <label for="txt_after"><?php _e('Text to be displayed after the name', 'post_author') ?></label>
            </p>

            
            <p>
                <input type="checkbox" name="create_dat" id="create_dat" <?php if( $options['post_author_create_dat'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="create_dat"><?php _e('Add first publication date', 'post_author') ?></label>
            </p>
            <p style="margin-left:30px;">
                <input type="text" name="dat_before" id="dat_before"  value="<?php echo attribute_escape($options['post_author_dat_before']) ?>" />
                <label for="dat_before"><?php _e('Text to be displayed before the initial publication date', 'post_author') ?></label>
            </p>
            <p style="margin-left:30px;">
                <input type="text" name="dat_after" id="dat_after"  value="<?php echo attribute_escape($options['post_author_dat_after']) ?>" />
                <label for="dat_after"><?php _e('Text to be displayed after the date', 'post_author') ?></label>
            </p>

            <h3><?php _e('Post revision', 'post_author') ?></h3>

            
            
            
            
            <p>
                <input type="checkbox" name="modify_author" id="modify_author" <?php if( $options['post_author_modify_author'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="modify_author"><?php _e('Add revision author (only if update date is different from publication date)', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="text" name="modified_before" id="modified_before"  value="<?php echo attribute_escape($options['post_author_modified_before']) ?>" />
                <label for="modified_before"><?php _e('Text to be displayed before the last revising author', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="text" name="modified_after" id="modified_after"  value="<?php echo attribute_escape($options['post_author_modified_after']) ?>" />
                <label for="modified_after"><?php _e('Text to be displayed after the last revising author', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <input type="text" name="modified_after_follow" id="modified_after_follow"  value="<?php echo attribute_escape($options['post_author_modified_after_follow']) ?>" />
                <label for="modified_after_follow"><?php _e('Text to be displayed instead, if followed by date revision', 'post_author') ?></label>
            </p>
            
            
            
            
            <p>
                <input type="checkbox" name="modify_dat" id="modify_dat" <?php if( $options['post_author_modify_dat'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="modify_dat"><?php _e('Add last revision date (only if update date is different from publication date)', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="text" name="modified_dat_before" id="modified_dat_before"  value="<?php echo attribute_escape($options['post_author_modified_dat_before']) ?>" />
                <label for="modified_dat_before"><?php _e('Text to be displayed before the last revision date', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="text" name="modified_dat_after" id="modified_dat_after"  value="<?php echo attribute_escape($options['post_author_modified_dat_after']) ?>" />
                <label for="modified_dat_after"><?php _e('Text to be displayed after the last revision date', 'post_author') ?></label>
            </p>

            
            
            
            <!-- Display condition -->
            <h3 style="clear:left;"><?php _e('Display condition', 'post_author') ?></h3>
            
            
            <!-- POSTS -->
            <p>
                <input type="checkbox" name="type_post" id="type_post" <?php if( $options['post_author_type_post'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="type_post"><?php _e('Add author to Posts', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="post_author_top_on_post" id="post_author_top_on_post" <?php if( $options['post_author_top_on_post'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="post_author_top_on_post"><?php _e('Place author box before content', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="author_avatar_on_post" id="author_avatar_on_post" <?php if( $options['post_author_author_avatar_on_post'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="author_avatar_on_post"><?php _e('Add avatar to author box', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <input type="text" size="5" name="author_avatar_size_on_post" id="author_avatar_size_on_post" value="<?php echo attribute_escape($options['post_author_author_avatar_size_on_post']) ?>"/>
                <label for="author_avatar_size_on_post"><?php _e('Avatar size', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <select type="text" size="1" name="author_avatar_float_on_post" id="author_avatar_float_on_post">
                    <option value="left" <?php if( $options['post_author_author_avatar_float_on_post'] == 'left' ) echo 'selected'; ?>>left</option>
                    <option value="right" <?php if( $options['post_author_author_avatar_float_on_post'] == 'right' ) echo 'selected'; ?>>right</option>
                    <option value="none" <?php if( $options['post_author_author_avatar_float_on_post'] == 'none' ) echo 'selected'; ?>>none</option>
                </select>
                <label for="author_avatar_float_on_post"><?php _e('Avatar float', 'post_author') ?></label>
            </p>
            
            
            <!-- PAGES -->
            <p>
                <input type="checkbox" name="type_page" id="type_page" <?php if( $options['post_author_type_page'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="type_page"><?php _e('Add author to Pages', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="top" id="top" <?php if( $options['post_author_top'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="top"><?php _e('Place author box before content', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="author_avatar" id="author_avatar" <?php if( $options['post_author_author_avatar'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="author_avatar"><?php _e('Add avatar to author box', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <input type="text" size="5" name="author_avatar_size" id="author_avatar_size" value="<?php echo attribute_escape($options['post_author_author_avatar_size']) ?>"/>
                <label for="author_avatar_size"><?php _e('Avatar size', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <select type="text" size="1" name="author_avatar_float" id="author_avatar_float">
                    <option value="left" <?php if( $options['post_author_author_avatar_float'] == 'left' ) echo 'selected'; ?>>left</option>
                    <option value="right" <?php if( $options['post_author_author_avatar_float'] == 'right' ) echo 'selected'; ?>>right</option>
                    <option value="none" <?php if( $options['post_author_author_avatar_float'] == 'none' ) echo 'selected'; ?>>none</option>
                </select>
                <label for="author_avatar_float"><?php _e('Avatar float', 'post_author') ?></label>
            </p>
            
            <!-- CATEGORIES -->
            <p>
                <input type="checkbox" name="type_cat" id="type_cat" <?php if( $options['post_author_type_cat'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="type_cat"><?php _e('Add author to Categories', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="cat_top" id="cat_top" <?php if( $options['post_author_cat_top'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="cat_top"><?php _e('Place author box before excerpt', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="author_avatar_on_cat" id="author_avatar_on_cat" <?php if( $options['post_author_author_avatar_on_cat'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="author_avatar_on_cat"><?php _e('Add avatar to author box', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <input type="text" size="5" name="author_avatar_size_on_cat" id="author_avatar_size_on_cat" value="<?php echo attribute_escape($options['post_author_author_avatar_size_on_cat']) ?>"/>
                <label for="author_avatar_size_on_cat"><?php _e('Avatar size', 'post_author') ?></label>
            </p>
            <p style="margin-left:40px;">
                <select type="text" size="1" name="author_avatar_float_on_cat" id="author_avatar_float_on_cat">
                    <option value="left" <?php if( $options['post_author_author_avatar_float_on_cat'] == 'left' ) echo 'selected'; ?>>left</option>
                    <option value="right" <?php if( $options['post_author_author_avatar_float_on_cat'] == 'right' ) echo 'selected'; ?>>right</option>
                    <option value="none" <?php if( $options['post_author_author_avatar_float_on_cat'] == 'none' ) echo 'selected'; ?>>none</option>
                </select>
                <label for="author_avatar_float_on_cat"><?php _e('Avatar float', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="cat_home" id="cat_home" <?php if( $options['post_author_cat_home'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="cat_home"><?php _e('Hide author box on home category', 'post_author') ?></label>
            </p>

            
            
            <!-- OPTIONS -->
            <h3><?php _e('Options', 'post_author') ?></h3>
            <p>
                <input type="checkbox" name="author_link" id="author_link" <?php if( $options['post_author_author_link'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="author_link"><?php _e('Add link to author page', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="checkbox" name="author_link_to_url" id="author_link_to_url" <?php if( $options['post_author_author_link_to_url'] == 'on' ) echo 'checked="checked"'; ?>/>
                <label for="author_link_to_url"><?php _e('Use author website URL in user profile instead', 'post_author') ?></label>
            </p>
            <p style="margin-left:20px;">
                <input type="text" name="link_name" id="link_name"  value="<?php echo attribute_escape($options['post_author_link_name']) ?>" />
                <label for="link_name"><?php _e('Specific link target - default (<i>blank</i>) links to author/username page', 'post_author') ?></label>
            </p>
            <p class="submit">
                <input name="Submit" type="submit" class="button-primary" value="<?php _e('Save changes', 'post_author') ?>" />
            </p>
            
        </form>
    </div>

    <div class="updated" style="background:aliceblue; border:1px solid lightblue; float:right;max-width: 250px ! important; margin-left:25px;padding-bottom:30px">
        <h3><?php _e('Quick help', 'post_author'); ?></h3>
        <h4><?php _e('Multilingual', 'post_author'); ?></h4>
        <p><?php _e('Integrates great with qTranslate for multilingual or international blogs, using <a href="http://www.qianqin.de/qtranslate/forum/viewtopic.php?f=3&t=3&p=15#p15">Quicktags</a>', 'post_author'); ?></p>
        <p><?php _e('Example : <i>&#91;:en&#93;Written by &#91;:fr&#93;Ecrit par</i>.', 'post_author'); ?></p>

        <h4><?php _e('Hide it on specific post or page?', 'post_author'); ?></h4>
        <p><?php _e('You can specifically hide the post author plugin on specific pages or posts. Simply go to the edit page and check the &quot;hide author for this article&quot; box, in the author box.', 'post_author'); ?></p>

        <h4><?php _e('Style it', 'post_author'); ?></h4>
        <p><?php _e('Text is CSS-ready, displayed in nested div\'s and span\'s: it\'s up to you to do the styling to your taste to float text left, right, add bold, color, rulers, borders, images...', 'post_author'); ?></p>

        <h4><?php _e('Specific link on name', 'post_author'); ?></h4>
        <p><?php _e('You can specify an absolute URL<br/>(e.g.: http://www.my.com/profile)<br/> <br/>or a relative, if you start with a slash<br/>(e.g.: /myauthorpage).', 'post_author'); ?></p>
    </div>

    <?php
}

add_action('init', 'post_author_init');
add_action('admin_menu', 'post_author_add_custom_box');
add_action('save_post', 'post_author_save_postdata');
add_action('admin_menu', 'postauthor_adminpage', 100);



add_filter('the_content', 'add_author_to_post', 20);//add_filter('get_the_excerpt', 'add_author_to_post', 20); //inappropriate, prefer to filter the output function, not the excerpt itself
add_filter('the_excerpt', 'add_author_to_cat', 20); //sometimes, category page display content instead of excerpt, as Tweenty Twelve Template, so this filter is ignored !!!


?>