<?php
/**
 * Create a welcomepage with all the information about theme
 * and redirect to this page right after the theme was activated.
 *
 * @package SimpleMag
 * @since 	SimpleMag 4.0
**/


/**
 * Create the welcomepage.
 * Redirect to the welcomepage after theme activation.
**/
function ti_welcome_page() {

	// Add the welcome page
    add_theme_page( 'Welcome to SimpleMag', 'Welcome to SimpleMag', 'edit_theme_options', 'simplemag-welcome', 'ti_welcome_page_content' );

	// Redirect to welcome page after theme activation
	if ( isset( $_GET['activated'] ) ) {

	    // Do redirect
	    wp_redirect( admin_url( 'themes.php?page=simplemag-welcome' ) );

	}
}
add_action( 'admin_menu', 'ti_welcome_page' );


/* Hide welcomepage menu item from the menu */
function ti_admin_css() {
  echo '<style>#adminmenu .wp-submenu a[href="themes.php?page=simplemag-welcome"], .appearance_page_simplemag-welcome #setting-error-tgmpa{display:none;}</style>';
}
add_action( 'admin_head', 'ti_admin_css' );


/**
 * Function for the add_menu_page to show
 * the Welcome page after theme activation
**/
function ti_welcome_page_content() {
?>

	<style>
	.welcome-wrap {
		margin-bottom:60px;
	}
	.ti-author {
		color:#777;
		margin-top:20px;
	}
	.ti-theme-badge {
		position: absolute;
		top: 0;
		right: 0;
		width: 160px;
		text-align:center;
	}
	.badge {
		padding:142px 0 20px;
		color: #fff;
		font-weight: bold;
		font-size: 14px;
		text-align: center;
		margin: 0 0 12px;
		background:#ffcc0d url('<?php bloginfo('template_url'); ?>/admin/images/sm-theme-badge.png') no-repeat top center;
	}
	.ti-block {
		margin-bottom:60px;
	}
	.white-panel {
		background:#fff;
		padding:10px 30px;
	}
	</style>

	<div class="wrap about-wrap">

		<div class="welcome-wrap">

			<p class="ti-block">Thank you for installing the theme!</p>

			<?php $ti_current_theme = wp_get_theme(); ?>

			<h1>
				Welcome to <?php echo $ti_current_theme->get( 'Name' ) . ' ' . $ti_current_theme->get( 'Version' ); ?>
			</h1>

			<h2>
				<?php echo $ti_current_theme->get( 'Description' ); ?>
			</h2>

			<div class="ti-author">
				<i>by</i> 
                <a href="http://themesindep.com" target="_blank"><?php echo $ti_current_theme->get( 'Author' ); ?></a>&nbsp; | &nbsp;
                <a href="http://themesindep.com/showcase" target="_blank">Showcase</a> &nbsp;&middot;&nbsp;
                <a href="http://themesindep.com/support/" target="_blank">Support Center</a> &nbsp;&middot;&nbsp;
                <a href="http://facebook.com/ThemesIndep" target="_blank">Facebook</a> &nbsp;&middot;&nbsp;
                <a href="https://twitter.com/themesindep" target="_blank">Twitter</a>
            </div>
            
			<div class="ti-theme-badge">
				<div class="badge">
					Version <?php echo $ti_current_theme->get( 'Version' ); ?>
				</div>
				<a href="http://www.themesindep.com/support/simplemag-change-log/" class="button" target="_blank">See Change Log</a>
			</div>
		</div>
        
        
        <div class="white-panel ti-block">
            <h2>What's new in version 4.1</h2>
			<hr>
			<div class="feature-section under-the-hood three-col">
                <div class="col">
					<h4>Latest Posts Section</h4>
					<p>New Latest Posts section to show your most latest posts in a fresh unique way.</p>
				</div>

				<div class="col">
					<h4>Posts Section Item</h4>
					<p>After adding the Posts Section, click on Post Item tab. Show or remove different post item features.</p>
				</div>
                
                <div class="col">
					<h4>Latest By Format</h4>
					<p>We've added another layout for this section so you can controll the look and feel of your site media.</p>
				</div>
            </div>
            <hr>
            <h5>For more extened info about new features and bug fixes see <a href="http://www.themesindep.com/support/simplemag-change-log/" target="_blank">Change Log</a></h5>
        </div>
        
        
		<div class="ti-block">
			<h2>Version 4.0</h2>
			<hr>
			<div class="feature-section under-the-hood three-col">
				<div class="col">
					<h4>WooCommerce</h4>
					<p>Full support and styling for WooCommerce in accordence to the new SimpleMag 4.0 look &amp; feel.</p>
				</div>
			
				<div class="col">
					<h4>bbPress Forum</h4>
					<p>Run a community forum on your site with our designed bbPress forum plugin.</p>
				</div>

				<div class="col">
					<h4>Extended Page Composer</h4>
					<p>Variety of new drag &amp; drop customizable sections, sidebar select for all Posts related sections.</p>
				</div>
			</div>
            <div class="feature-section under-the-hood three-col">
				<div class="col">
					<h4>Beautiful Layouts</h4>
					<p>Big or Small thumbnails list, Grid &amp; Masonry in two, three or four columns with enable/disable sidebar option.</p>
				</div>
			
				<div class="col">
					<h4>Typography</h4>
					<p>Separate control options over Site Menus, Titles &amp; Headings and editor text.</p>
				</div>

				<div class="col">
					<h4>Rich Snippets</h4>
					<p>Makes your site being displayed visually richer in search results and gives a more descriptive information about page content.</p>
				</div>
			</div>
            <div class="feature-section under-the-hood three-col">
                <div class="col">
					<h4>Ajax Technology</h4>
					<p>Ajax based features for faster site loading times such as Mega Menu, Latest By Format embeds and more.</p>
				</div>
                
                <div class="col">
					<h4>Single Post Title Position</h4>
					<p>Change title position in the single post. Works the same as Media Position feature.</p>
				</div>
                
                <div class="col">
					<h4>Full Width Footer</h4>
					<p>Full width footer widget area for widgets such as Instagram.</p>
				</div>
            </div>
		</div>


		<div class="ti-block">
			<h2>Theme Setup &amp; Customization</h2>
			<hr>
			<div class="feature-section under-the-hood two-col">
				<div class="col">
					<h4>Install Plugins</h4>
					<p>SimpleMag comes with a small list of recommended and required plugins which are needed to get more from the theme</p>
					<a href="<?php echo admin_url(); ?>themes.php?page=tgmpa-install-plugins" class="button-primary" target="_blank">Install Plugins</a>
				</div>
			
				<div class="col">
					<h4>Theme Options</h4>
					<p>Configure and customize the theme using the intuitive and easy to use theme options panel</p>
					<a href="<?php echo admin_url(); ?>themes.php?page=<?php echo $ti_current_theme->get( 'Name' ); ?>" class="button-primary" target="_blank">Configure</a>
				</div>
			</div>
		</div>

		<div class="ti-block">
			<h2>Support Center</h2>
            <hr>
			<div class="feature-section under-the-hood three-col">
				<div class="col">
					<h4>Knowledge Base</h4>
					<p>Contains all the most important topics and code snippets.</p>
					<a href="http://www.themesindep.com/support/knowledgebase/" class="button-primary" target="_blank">Learn It</a>
				</div>
				<div class="col">
					<h4>Video Tutorials</h4>
					<p>Videos about theme configuration and features usage</p>
					<a href="http://www.themesindep.com/support/video-tutorials/" class="button-primary" target="_blank">Watch It</a>
				</div>
				<div class="col">
					<h4>Support Forum</h4>
					<p>Have difficulties in theme setup and configuration? Speak to us directly.</p>
					<a href="http://www.themesindep.com/support/forums/forum/simplemag/" class="button-primary" target="_blank">View the forums</a>
				</div>
			</div>
		</div>
        
        <hr>
        <br>
        <br>
        
        <div class="ti-block">
            <a href="http://themesindep.com/showcase" target="_blank">Showcase</a> &nbsp;&middot;&nbsp;
            <a href="http://themesindep.com/support/" target="_blank">Support Center</a> &nbsp;&middot;&nbsp;
            <a href="http://facebook.com/ThemesIndep" target="_blank">Facebook</a> &nbsp;&middot;&nbsp;
            <a href="https://twitter.com/themesindep" target="_blank">Twitter</a>
        </div>
	
	</div>

<?php } ?>