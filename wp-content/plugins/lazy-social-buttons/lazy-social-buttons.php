<?php
/*
Plugin Name: Lazy Social Buttons
Plugin URI: http://wordpress.org/extend/plugins/lazy-social-buttons/
Description: Delayed loading of Google +1, Twitter and Facebook social buttons on your posts. Have your cake and eat it too; social buttons and performance.
Version: 1.0.7
Author: Godaddy.com
Author URI: http://www.godaddy.com/

Copyright (c) 2012 Go Daddy Operating Company, LLC

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
DEALINGS IN THE SOFTWARE.
 
*/

define( 'LazySocialButtons_URL', plugin_dir_url(__FILE__) );

if (!class_exists("LazySocialButtons")) {

	class LazySocialButtons {
	
		function LazySocialButtons()
		{
			$this->__construct();
		}
		function __construct()
		{
			new LazySocialButtons_Options;
			add_action( 'init', array( &$this, 'lazysocialbuttons_head' ) );	
			add_action( 'wp_footer', array( &$this, 'lazysocialbuttons_footer' ) );			
			add_filter( 'the_content', array( &$this, 'lazysocialbuttons_content' ) );
			$excerpt = get_option('lazysocialbuttons_excerpt');
			if ( $excerpt && $excerpt!='manual' )
				add_filter( 'the_excerpt', array( &$this, 'lazysocialbuttons_excerpt' ) );
		}
		function lazysocialbuttons_head()
		{
			$jquerycdn = get_option('lazysocialbuttons_jquerycdn');
			if ( $jquerycdn != "yes" )
			{
				wp_enqueue_script('jquery');
			}
			else
			{
				wp_deregister_script('jquery');
				wp_register_script('jquery', ($_SERVER['HTTPS'] ? 'https:' : 'http:').'//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', false, false);
				wp_enqueue_script('jquery', false, false, null); // null is supposed to remove the ver=3.4.2 but it doesn't
			}
		}
		function lazysocialbuttons_footer()
		{
			$script = "
<script type='text/javascript'>
// **** Start Plugin Implementation ****************************
// Uncomment the code line below to specify the path to the two images
// under two circumstances: 1) you are using the HTML decoration auto-wireup
// and 2) your images are not in the same root folder as the executing script
// (which would be used automatically if not specified)
var lazySocialButtonsImagePath = '".LazySocialButtons_URL."';

// This is the asynchronous loader for the plugin script.
// It also handles a ready callback if specified, by checking
// to see if the plugin is fully loaded before trying to execute
// the callback.
(function (loaded){
  var d = document,
  id = 'LazySocialButtonsScript',
  src = '".LazySocialButtons_URL."lazySocialButtons.min.js';
  var js, st = d.getElementsByTagName('script')[0];
  if (d.getElementById(id)) { return; }
  js = d.createElement('script');
  js.id = id; js.type = 'text/javascript'; js.async = true; js.src = src;
  st.parentNode.insertBefore(js, st);

  // if we have a callback, execute it
  if (typeof(loaded) === 'function') {
    (function checkLoaded() {
      if (!$.fn.lazySocialButtons) setTimeout(checkLoaded, 100);
      else loaded();
    })();
  }
})();
</script>
";	
			echo $script;
		}
		function lazysocialbuttons_decoration($buttons = array("google","twitter","facebook"), $facebook_share=true) 
		{
			global $wp_query;
			$post = $wp_query->post; //get post content
			$id = $post->ID; //get post id
			$postlink = get_permalink($id); //get post link
			$title = trim($post->post_title); // get post title
			$backgroundtype = get_option('lazysocialbuttons_backgroundtype');

			$return_social = '<div class="lazysocialbuttons" data-float="left" data-buttons="'.implode(",", $buttons).'" data-twshareurl="'.$postlink.'" data-twtext="'.htmlspecialchars($title).'" data-shareurl="'.$postlink.'" data-fbhideflyout="'.($facebook_share ? "false" : "true").'" data-backgroundtype="'.($backgroundtype=="dark" ? "dark" : "light").'"></div>';

			return $return_social;
		}
		function lazysocialbuttons_content( $content )
		{
			$position = get_option('lazysocialbuttons_position');
			if (!$position) $position = "before";
			$buttons = array();
			$google = get_option('lazysocialbuttons_google');
			if ( $google!="no" ) $buttons[] = "google";
			$twitter = get_option('lazysocialbuttons_twitter');
			if ( $twitter!="no"  ) $buttons[] = "twitter";
			$facebook = get_option('lazysocialbuttons_facebook');
			if ( $facebook!="no") $buttons[] = "facebook";
			$facebook_share = get_option('lazysocialbuttons_facebook_share');
			if ( $facebook_share!="no") $facebook_share=true; else $facebook_share=false;

			switch($position){
				case 'before':
					$content = $this->lazysocialbuttons_decoration($buttons, $facebook_share) . $content;
					break;
				case 'after':
					$content .= $this->lazysocialbuttons_decoration($buttons, $facebook_share);
					break;
			}
			return $content;
		}
		function lazysocialbuttons_excerpt( $content )
		{
			$position = get_option('lazysocialbuttons_excerpt');
			if (!$position) $position = "manual";
			$buttons = array();
			$google = get_option('lazysocialbuttons_google');
			if ( $google!="no" ) $buttons[] = "google";
			$twitter = get_option('lazysocialbuttons_twitter');
			if ( $twitter!="no"  ) $buttons[] = "twitter";
			$facebook = get_option('lazysocialbuttons_facebook');
			if ( $facebook!="no") $buttons[] = "facebook";
			$facebook_share = get_option('lazysocialbuttons_facebook_share');
			if ( $facebook_share!="no") $facebook_share=true; else $facebook_share=false;

			switch($position){
				case 'before':
					$content = $this->lazysocialbuttons_decoration($buttons, $facebook_share) . $content;
					break;
				case 'after':
					$content .= $this->lazysocialbuttons_decoration($buttons, $facebook_share);
					break;
			}
			return $content;
		}
	}
}

if (!class_exists("LazySocialButtons_Options")) {
	class LazySocialButtons_Options {
		function LazySocialButtons_Options()
		{
			$this->__construct();
		}
		function __construct()
		{
			add_action('admin_init', array( &$this, 'admin_init' ) );
			add_filter('plugin_action_links', array(&$this, 'lazysocialbuttons_settings_link'), 10, 2);
			add_action('admin_menu', array( &$this, 'lazysocialbuttons_add_admin_page') );
		}
		function admin_init()
		{

			add_settings_section('lazysocialbuttons_main', 'Main Settings', array(&$this, 'lazysocialbuttons_main_text'), 'lazysocialbuttons');

			add_settings_field(
			    $id = 'lazysocialbuttons_position',
			    $title = "Lazy-Social-Buttons Position",
			    $callback = array( &$this, 'lazysocialbuttons_position' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_position' );

			add_settings_field(
			    $id = 'lazysocialbuttons_excerpt',
			    $title = "Lazy-Social-Buttons Excerpt",
			    $callback = array( &$this, 'lazysocialbuttons_excerpt' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_excerpt' );

			add_settings_field(
			    $id = 'lazysocialbuttons_google',
			    $title = "Lazy-Social-Buttons Google Button",
			    $callback = array( &$this, 'lazysocialbuttons_google' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_google' );

			add_settings_field(
			    $id = 'lazysocialbuttons_twitter',
			    $title = "Lazy-Social-Buttons Twitter Button",
			    $callback = array( &$this, 'lazysocialbuttons_twitter' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_twitter' );

			add_settings_field(
			    $id = 'lazysocialbuttons_facebook',
			    $title = "Lazy-Social-Buttons Facebook Button",
			    $callback = array( &$this, 'lazysocialbuttons_facebook' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_facebook' );

			add_settings_field(
			    $id = 'lazysocialbuttons_facebook_share',
			    $title = "Lazy-Social-Buttons Facebook Share",
			    $callback = array( &$this, 'lazysocialbuttons_facebook_share' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_facebook_share' );

			add_settings_field(
			    $id = 'lazysocialbuttons_jquerycdn',
			    $title = "Lazy-Social-Buttons CDN jquery",
			    $callback = array( &$this, 'lazysocialbuttons_jquerycdn' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_jquerycdn' );

			add_settings_field(
			    $id = 'lazysocialbuttons_backgroundtype',
			    $title = "Lazy-Social-Buttons Background Type",
			    $callback = array( &$this, 'lazysocialbuttons_backgroundtype' ),
			    $page = 'lazysocialbuttons',
			    $section = 'lazysocialbuttons_main'
			);
			register_setting( $option_group = 'lazysocialbuttons_group', $option_name = 'lazysocialbuttons_backgroundtype' );

		}
		function lazysocialbuttons_position()
		{
			$value = get_option('lazysocialbuttons_position');
			$options = '<option value="before"'.(!$value || $value == 'before' ? ' selected="selected"' : '').'>Before</option>';
			$options .= '<option value="after"'.($value == 'after' ? ' selected="selected"' : '').'>After</option>';
			$options .= '<option value="manual"'.($value == 'manual' ? ' selected="selected"' : '').'>Manual</option>';
					
			echo '<label for="lazysocialbuttons_position">
			      <select name="lazysocialbuttons_position" id="lazysocialbuttons_position">
			      '.$options.'
			      </select>
			      Select the position for the social buttons to appear in relations to the content.
			      </label>';
		}
		function lazysocialbuttons_excerpt()
		{
			$value = get_option('lazysocialbuttons_excerpt');
			$options = '<option value="manual"'.(!$value || $value == 'manual' ? ' selected="selected"' : '').'>Manual</option>';
			$options .= '<option value="before"'.($value == 'before' ? ' selected="selected"' : '').'>Before</option>';
			$options .= '<option value="after"'.($value == 'after' ? ' selected="selected"' : '').'>After</option>';
					
			echo '<label for="lazysocialbuttons_excerpt">
			      <select name="lazysocialbuttons_excerpt" id="lazysocialbuttons_excerpt">
			      '.$options.'
			      </select>
			      Select the position for the social buttons to appear in relations to the excerpt.
			      </label>';
		}
		function lazysocialbuttons_google()
		{
			$google = get_option('lazysocialbuttons_google');
			$options = '<option value="yes"'.($google!="no" ? ' selected="selected"' : '').'>Yes</option>';
			$options .= '<option value="no"'.($google=="no" ? ' selected="selected"' : '').'>No</option>';
			echo '<label for="lazysocialbuttons_google">
			      <select name="lazysocialbuttons_google" id="lazysocialbuttons_google">
			      '.$options.'
			      </select>
			      Would you like the Google button displayed?
			      </label>';
		}
		function lazysocialbuttons_twitter()
		{
			$twitter = get_option('lazysocialbuttons_twitter');
			$options = '<option value="yes"'.($twitter!="no" ? ' selected="selected"' : '').'>Yes</option>';
			$options .= '<option value="no"'.($twitter=="no" ? ' selected="selected"' : '').'>No</option>';
			echo '<label for="lazysocialbuttons_twitter">
			      <select name="lazysocialbuttons_twitter" id="lazysocialbuttons_twitter">
			      '.$options.'
			      </select>
			      Would you like the Twitter button displayed?
			      </label>';
		}
		function lazysocialbuttons_facebook()
		{
			$facebook = get_option('lazysocialbuttons_facebook');
			$options = '<option value="yes"'.($facebook!="no" ? ' selected="selected"' : '').'>Yes</option>';
			$options .= '<option value="no"'.($facebook=="no" ? ' selected="selected"' : '').'>No</option>';
			echo '<label for="lazysocialbuttons_facebook">
			      <select name="lazysocialbuttons_facebook" id="lazysocialbuttons_facebook">
			      '.$options.'
			      </select>
			      Would you like the Facebook button displayed?
			      </label>';
		}
		function lazysocialbuttons_facebook_share()
		{
			$facebook_share = get_option('lazysocialbuttons_facebook_share');
			$options = '<option value="yes"'.($facebook_share!="no" ? ' selected="selected"' : '').'>Yes</option>';
			$options .= '<option value="no"'.($facebook_share=="no" ? ' selected="selected"' : '').'>No</option>';
			echo '<label for="lazysocialbuttons_facebook_share">
			      <select name="lazysocialbuttons_facebook_share" id="lazysocialbuttons_facebook_share">
			      '.$options.'
			      </select>
			      Would you like the Facebook share flyout to appear? (requires: Facebook Button displayed)
			      </label>';
		}
		function lazysocialbuttons_jquerycdn()
		{
			$jquerycdn = get_option('lazysocialbuttons_jquerycdn');
			$options = '<option value="no"'.($jquerycdn!="yes" ? ' selected="selected"' : '').'>No</option>';
			$options .= '<option value="yes"'.($jquerycdn=="yes" ? ' selected="selected"' : '').'>Yes</option>';
			echo '<label for="lazysocialbuttons_jquerycdn">
			      <select name="lazysocialbuttons_jquerycdn" id="lazysocialbuttons_jquerycdn">
			      '.$options.'
			      </select>
			      Would you like to load jquery from Google\'s CDN? (May conflict with some themes and plugins)
			      </label>';
		}
		function lazysocialbuttons_backgroundtype()
		{
			$backgroundtype = get_option('lazysocialbuttons_backgroundtype');
			$options = '<option value="light"'.($backgroundtype!="dark" ? ' selected="selected"' : '').'>Light</option>';
			$options .= '<option value="dark"'.($backgroundtype=="dark" ? ' selected="selected"' : '').'>Dark</option>';
			echo '<label for="lazysocialbuttons_jbackgroundtype">
			      <select name="lazysocialbuttons_backgroundtype" id="lazysocialbuttons_backgroundtype">
			      '.$options.'
			      </select>
			      Match to the background color of your site for improved display of the spinner (animated gif)
			      </label>';
		}
		function lazysocialbuttons_settings_link($links, $file) {
			static $this_plugin;
			if (!$this_plugin) $this_plugin = plugin_basename(__FILE__);

			if ($file == $this_plugin){
				$settings_link = '<a href="options-general.php?page=lazysocialbuttons">'.__("Settings", "lazysocialbuttons").'</a>';
				array_unshift($links, $settings_link);
			}
			return $links;
		}
		function lazysocialbuttons_add_admin_page() {
			add_options_page('Lazy Social Buttons Options', 'Lazy Social Buttons', 'manage_options', 'lazysocialbuttons', array( &$this, 'lazysocialbuttons_admin_page'));
		}	
		function lazysocialbuttons_main_text() {
			?>
			<!-- Could say something here to introduce the main options area -->
			<?php
		}
		function lazysocialbuttons_admin_page() {
			?>
			<div class="wrap">
				<h2>Lazy Social Buttons Options</h2>
				<form method="post" action="options.php">
					<?php settings_fields('lazysocialbuttons_group'); ?>
					<?php do_settings_sections('lazysocialbuttons'); ?>
					<p class="submit">
						<input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" />
					</p>
				</form>
			</div>
			<?php
		}
	} 
}

$lazysocialbuttons = new lazysocialbuttons;
