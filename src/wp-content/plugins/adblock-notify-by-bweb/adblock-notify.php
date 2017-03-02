<?php
/**
 * Main plugin loader
 *
 * @package adblock-notify
 *
 * Plugin Name: Adblock Notify Lite
 * Plugin URI: http://themeisle.com/plugins/adblock-notify-lite/
 * Description: An Adblock detection and nofitication plugin with get around options and a lot of settings. Dashboard widget with adblock counter included!
 * Version: 2.0.9
 * Author: Themeisle
 * Author URI: http://themeisle.com
 * Text Domain: an-translate
 * Domain Path: /languages
 */

/**
 * ************************************************************
 * SECURITY : Exit if accessed directly
 ***************************************************************/
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct acces not allowed!' );
}


/**

*************************************************************
 * Define constants
 */
if ( ! defined( 'AN_PATH' ) ) {
	define( 'AN_PATH', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'AN_URL' ) ) {
	define( 'AN_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'AN_BASE' ) ) {
	define( 'AN_BASE', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'AN_NAME' ) ) {
	define( 'AN_NAME', 'Adblock Notify' );
}
if ( ! defined( 'AN_ID' ) ) {
	define( 'AN_ID', 'adblock-notify' );
}
if ( ! defined( 'AN_COOKIE' ) ) {
	define( 'AN_COOKIE', 'anCookie' );
}
if ( ! defined( 'AN_VERSION' ) ) {
	define( 'AN_VERSION', '2.0.9' );
}
if ( ! defined( 'AN_TEMP_DEVELOPMENT' ) ) {
	define( 'AN_TEMP_DEVELOPMENT', false );
}
if ( ! defined( 'AN_TEMPLATES_DIRECTORY' ) ) {
	define( 'AN_TEMPLATES_DIRECTORY', 'an-templates/' );
}
if ( ! defined( 'AN_PRO_URL' ) ) {
	define( 'AN_PRO_URL','http://bit.ly/2fb0Dre' );
}


/**

 * ************************************************************
 * Set priority to properly load plugin translation
 ***************************************************************/
function an_translate_load_textdomain() {
	$path = basename( dirname( __FILE__ ) ) . '/languages/';
	load_plugin_textdomain( 'an-translate', false, $path );

	do_action( 'an_upgrade_routine' );
}

add_action( 'plugins_loaded', 'an_translate_load_textdomain', 1 );


/**

*************************************************************
 * Load plugin files
 */
require_once( AN_PATH . 'vendor/titan-framework/titan-framework-embedder.php' );

$anFiles = array( 'adblock-notify-options', 'adblock-notify-functions', 'adblock-notify-widget', 'adblock-notify-files','inc/template-functions' );
$anFiles = apply_filters( 'an_files_include',$anFiles );
foreach ( $anFiles as $anFile ) {
	require_once( AN_PATH . $anFile . '.php' );
}


/**

 * ************************************************************
 * Front-End Scripts & Styles enqueueing
 ***************************************************************/
function an_enqueue_an_sripts() {
	if ( ! is_admin() ) {
		$anVersion = AN_VERSION;
		$anScripts = unserialize( an_get_option( 'adblocker_notify_selectors' ) );
		$an_option = TitanFramework::getInstance( 'adblocker_notify' );

		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		// Load WP_Filesystem API
		WP_Filesystem();
		global $wp_filesystem;
		$content_style = '';
		// Disabled due to too many bug repports
		// wp_enqueue_script( 'an_fuckadblock', AN_URL . 'js/an-detect.min.js', array( 'jquery' ), NULL, true );
		if ( $an_option->getOption( 'an_option_selectors' ) == false ) {

			wp_register_script( 'an_scripts', AN_URL . 'js/an-scripts.js', array( 'jquery' ),  $anVersion, true );
			wp_register_style( 'an_style', AN_URL . 'css/an-style.css', array(),  $anVersion, null );

		} elseif ( $anScripts['temp-path'] != false ) {

			// check if server is SSL
			if ( is_ssl() ) {
				$anScripts['temp-url'] = preg_replace( '/^http:/i', 'https:', $anScripts['temp-url'] ); }

			wp_register_script( 'an_scripts', $anScripts['temp-url'] . $anScripts['files']['js'], array( 'jquery' ), $anVersion, true );
			wp_register_style( 'an_style', $anScripts['temp-url'] . $anScripts['files']['css'], array(),  $anVersion, null );

			$content_style = $wp_filesystem->get_contents( $anScripts['temp-path'] . $anScripts['files']['css'] );
		}

		if ( $anScripts['temp-path'] == false && $an_option->getOption( 'an_option_selectors' ) == true ) {

			// Print Style and script in the footer with an_prepare (functions.php)
			// CSS file does not exist anymore
			wp_dequeue_style( 'tf-compiled-options-adblocker_notify' );

		}

		wp_enqueue_script( 'an_scripts' );
	    wp_enqueue_style( 'an_style' );
		$content_style = str_replace( array( "\r\n", "\r", "\n" ), '', $content_style );
		wp_add_inline_style( 'an_style',$content_style );

		// AJAX
		wp_localize_script( 'an_scripts', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );

		// CSS file does not exist anymore
		if ( $an_option->getOption( 'an_option_selectors' ) == true ) {
			wp_dequeue_style( 'tf-compiled-options-adblocker_notify' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'an_enqueue_an_sripts', 100 );


/**

 * ************************************************************
 * Back-End Styles enqueueing
 ***************************************************************/
function an_register_admin_styles() {
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	// Load WP_Filesystem API
	WP_Filesystem();
	global $wp_filesystem;
	$content_style = $wp_filesystem->get_contents( AN_PATH . 'css/an-admin-style.css' );

	$ttfcss = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/css/admin-styles.css' );
	?>
	<style type="text/css">
		<?php
		 echo $content_style;
		?>
		<?php
		 echo $ttfcss ;
		?>
	</style>

	<?php
}

/**

 * ************************************************************
 * Back-End Scripts enqueueing
 ***************************************************************/
function an_register_admin_scripts() {
	// JS
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	// Load WP_Filesystem API
	WP_Filesystem();
	global $wp_filesystem;
	$content_script = $wp_filesystem->get_contents( AN_PATH . 'js/an-admin-scripts.js' );

	$ttfjs1 = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/js/admin-styling.js' );
	$ttfjs2 = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/js/min/serialize-min.jss' );
	$ttfjs3 = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/js/min/wp-color-picker-alpha-min.js' );
	$ttfjs4 = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/js/ace-min-noconflict/ace.js' );
	$ttfjs5 = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/js/ace-min-noconflict/theme-chrome.js' );
	$ttfjs6 = $wp_filesystem->get_contents( AN_PATH . 'vendor/titan-framework/js/ace-min-noconflict/mode-css.js' );
	?>
	<script type="text/javascript" id="content_script">
		var an_admin = <?php echo json_encode( array( 'pro_url' => AN_PRO_URL, 'pro' => (an_is_pro()) ? 'yes': 'no' ) ); ?>;
		<?php
		echo $content_script;
		?>
	</script>

	<script type="text/javascript" id="ttfjs1">
		<?php
		echo $ttfjs1;
		?>
	</script>
	<script type="text/javascript" id="ttfjs2">
		<?php
		echo $ttfjs2;
		?>
	</script>
	<script type="text/javascript" id="ttfjs3">
		try {
		<?php
			echo $ttfjs3;

		?>
		}catch(e){

		}
	</script>
	<script type="text/javascript" id="ttfjs4">
		<?php
		echo $ttfjs4;
		?>
	</script>
	<script type="text/javascript" id="ttfjs5">
		<?php
		echo $ttfjs5;
		?>
	</script>
	<script type="text/javascript" id="ttfjs6">
		<?php
		echo $ttfjs6;
		?>
	</script>

	<?php
}

/**
 * Enqueue admin scripts
 */
function an_enqueue_admin_scripts() {
	$prefix = an_is_bussiness() ? '-network' : '';

	$screen = get_current_screen();
	if ( $screen->id != 'toplevel_page_' . AN_ID . $prefix ) {
		return; }

	an_register_admin_scripts();
}

/**
 * Enqueue admin scripts
 */
function an_enqueue_admin_syles() {
	$prefix = an_is_bussiness() ? '-network' : '';

	$screen = get_current_screen();
	if ( $screen->id != 'toplevel_page_' . AN_ID . $prefix ) {
		return; }

	an_register_admin_styles();
}

add_action( 'admin_head', 'an_enqueue_admin_syles' );
add_action( 'admin_footer', 'an_enqueue_admin_scripts' );


/**

 * ************************************************************
 * Add settings link on plugin list page
 ***************************************************************/
function an_settings_link_init() {
	if ( an_is_bussiness() ) {
		add_filter( 'network_admin_plugin_action_links_' . AN_BASE, 'an_settings_link' );
	} else {
		add_filter( 'plugin_action_links_' . AN_BASE, 'an_settings_link' );
	}
}

/**

 * ************************************************************
 * Add settings link on plugin list page
 ***************************************************************/
function an_settings_link( $links ) {
	$url    = an_is_bussiness() ? network_admin_url( 'admin.php' ) : admin_url( 'options-general.php' );
	$links[] = '<a href="' . $url . '?page=' . AN_ID . '">' . __( 'Settings', 'an-translate' ) . '</a>';
	return $links;
}

add_action( 'plugins_loaded', 'an_settings_link_init' );



/**

 * ************************************************************
 * Add custom meta link on plugin list page
 ***************************************************************/
function an_meta_links( $links, $file ) {
	if ( $file === 'adblock-notify-by-bweb/adblock-notify.php' ) {
		$links[] = '<a href="http://themeisle.com/wordpress-plugins/" target="_blank" title="' . __( 'More Plugins', 'an-translate' ) . '">' . __( 'More Plugins', 'an-translate' ) . '</a>';
	}
	return $links;
}

add_filter( 'plugin_row_meta', 'an_meta_links', 10, 2 );


/**

 * ************************************************************
 * Admin Panel Favico
 ***************************************************************/
function an_add_favicon() {
	$prefix = an_is_bussiness() ? '-network' : '';

	$screen = get_current_screen();
	if ( $screen->id != 'toplevel_page_' . AN_ID . $prefix ) {
		return;
	}

	$favicon_url = AN_URL . 'img/icon-adblock-notify.png';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';

	an_register_admin_scripts();
}

add_action( 'admin_head', 'an_add_favicon' );


/**

 * ************************************************************
 * Create random selectors and files on plugin activation
 ***************************************************************/
function adblocker_notify_activate() {
	add_action( 'tf_create_options', 'an_create_options' );
	an_save_setting_random_selectors();
}

if ( function_exists( 'adblocker_notify_activate' ) ) {
	register_activation_hook( __FILE__, 'adblocker_notify_activate' );
}


/**

*************************************************************
 * Remove Plugin settings from DB on uninstallation (= plugin deletion)
 */
// Hooks for install
if ( function_exists( 'register_uninstall_hook' ) ) {
	register_uninstall_hook( __FILE__, 'adblocker_notify_uninstall' );
}

/**
 * Delete the tempoarary folder
 *
 * @param string $dirPath the path to temp directory.
 */
function an_delete_temp_folder( $dirPath ) {
	try {
		if ( file_exists( $dirPath ) ) {

			$files = glob( $dirPath . '*', GLOB_MARK );
			foreach ( $files as $file ) {
				if ( is_dir( $file ) ) {
					deleteDir( $file );
				} else {
					unlink( $file );
				}
			}
			rmdir( $dirPath );
		}
	} catch (Exception $e) {
		error_log( $e->getMessage() );
	}
}

/**
 * Uninstall routine
 */
function adblocker_notify_uninstall() {
	// Remove temp files
	$anTempDir = unserialize( an_get_option( 'adblocker_notify_selectors' ) );
	if ( isset( $anTempDir['temp-path'] ) ) {
		an_delete_temp_folder( $anTempDir['temp-path'] );
	}

	// Remove TitanFramework Generated Style
	$uploadDir = wp_upload_dir();
	$TfCssFile = trailingslashit( $uploadDir['basedir'] ) . 'titan-framework-adblocker_notify-css.css';

	if ( file_exists( $TfCssFile ) ) {
		unlink( $TfCssFile ); }

	// Remove option from DB
	an_delete_option( 'adblocker_notify_options' );
	an_delete_option( 'adblocker_notify_counter' );
	an_delete_option( 'adblocker_notify_selectors' );
}

/**
 *  Added Freemius support
 *
 * @return Freemius
 */
function anbb_fs() {
	global $anbb_fs;

	if ( ! isset( $anbb_fs ) ) {
		// Include Freemius SDK.
		require_once AN_PATH . 'vendor/freemius/start.php';

		$anbb_fs = fs_dynamic_init( array(
			'id'                => '503',
			'slug'              => 'adblock-notify-by-bweb',
			'type'              => 'plugin',
			'public_key'        => 'pk_80661c61db7cdcbedd0f6461d6a1b',
			'is_premium'        => false,
			'has_addons'        => false,
			'has_paid_plans'    => false,
			'menu'              => array(
				'slug'       => 'adblock-notify',
			),
		) );
	}

	return $anbb_fs;
}

// Init Freemius.
anbb_fs();
