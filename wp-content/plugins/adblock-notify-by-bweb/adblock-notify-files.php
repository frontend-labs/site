<?php
/**
 * ************************************************************
 *
 * @package adblock-notify
 * SECURITY : Exit if accessed directly
 ***************************************************************/
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct acces not allowed!' );
}


/**

 * ************************************************************
 * Generate random selector or file name
 ***************************************************************/
function an_random_slug() {
	$alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
	$prefix = array();
	$alphaLength = strlen( $alphabet ) - 1;
	for ( $i = 0; $i < 12; $i++ ) {
		$n = rand( 0, $alphaLength );
		$prefix[] = $alphabet[ $n ];
	}
	return implode( $prefix );
}


/**

 * ************************************************************
 * Create new Style and Script files in a temp directory
 ***************************************************************/
function an_change_files_css_selectors( $flush, $tempFolderPath, $tempFolderURL, $file, $oldFileName, $newFileName, $oldSelectors, $newSelectors, $content = '' ) {

	// Get default css and js files
	$fileExt = pathinfo( $file, PATHINFO_EXTENSION );
	$fileResponse = wp_remote_get( $file );
	$fileContent = wp_remote_retrieve_body( $fileResponse ) . $content;

	// Flush selectors
	if ( true == $flush ) {
		// Replace default selectors with new ones
		$defaultSelectors = array( 'an-Modal', 'reveal-modal', 'an-alternative' );
		$fileContent = str_replace( $defaultSelectors, $newSelectors, $fileContent );
	} else {
		// Replace default selectors with existings ones
		$defaultSelectors = array( 'an-Modal', 'reveal-modal', 'an-alternative' );
		$fileContent = str_replace( $defaultSelectors, $oldSelectors, $fileContent );

	}
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	// Load WP_Filesystem API
	WP_Filesystem();
	global $wp_filesystem;

	// Verify that we can create the file
	if ( $wp_filesystem->exists( $tempFolderPath . $oldFileName ) ) {
		if ( ! $wp_filesystem->is_writable( $tempFolderPath . $oldFileName ) ||
			! $wp_filesystem->is_readable( $tempFolderPath . $oldFileName ) ) {
			return false;
		}
	}
	// Verify directory
	$uploadDir = wp_upload_dir();
	if ( ! $wp_filesystem->is_dir( $uploadDir['basedir'] ) ||
		! $wp_filesystem->is_writable( $uploadDir['basedir'] ) ) {
		return false;
	}

	// Create new dir and files
	if ( $wp_filesystem->is_dir( $tempFolderPath ) ) {
		array_map( 'unlink', glob( $tempFolderPath . '*.' . $fileExt ) );
	} else {
		$wp_filesystem->mkdir( $tempFolderPath );
	}

	// Create new file (flush) or update old one
	if ( true == $flush ) {
		$wp_filesystem->put_contents( $tempFolderPath . $newFileName . '.' . $fileExt, $fileContent, 0644 );
		return $newFileName . '.' . $fileExt;
	} else {
		$wp_filesystem->put_contents( $tempFolderPath . $oldFileName, $fileContent, 0644 );
		return $oldFileName;
	}

}


/**

 * ************************************************************
 * Save scripts and styles with new random selectors after saving Titan Options
 ***************************************************************/
function an_save_setting_random_selectors( $force = false ) {

	// Restart cookie on every options save.
	if ( isset( $_COOKIE[ AN_COOKIE ] ) ) {
		setcookie( AN_COOKIE, null, -1, '/' );
	}

	$an_option = unserialize( an_get_option( 'adblocker_notify_options' ) );
	$anScripts = unserialize( an_get_option( 'adblocker_notify_selectors' ) );

	if ( true == $an_option['an_option_selectors'] || $force ) {

		// Define new temp path
		$uploadDir = wp_upload_dir();
		$tempDirName = an_random_slug();
		$tempFolderPath = trailingslashit( $uploadDir['basedir'] ) . $tempDirName . '/';
		$tempFolderURL = trailingslashit( $uploadDir['baseurl'] ) . $tempDirName . '/';

		// Retrieve old files infos
		if ( ! isset( $anScripts['files']['css'] ) ) { $anScripts['files']['css'] = ''; }
		if ( ! isset( $anScripts['files']['js'] ) ) { $anScripts['files']['js'] = ''; }
		if ( ! isset( $anScripts['selectors'] ) ) { $anScripts['selectors'] = ''; }
		if ( ! isset( $anScripts['temp-path'] ) ) { $anScripts['temp-path'] = false; }

		// Define new selectors
		$newSelectors = array( an_random_slug(), an_random_slug(), an_random_slug() );

		$flush = false;
		if ( true == $an_option['an_option_flush']  || ! file_exists( $anScripts['temp-path'] ) || false == $anScripts['temp-path']  ) { $flush = true; }

		// Keep old directory name and selectors if no flushed
		if ( false == $flush  ) {
			$newSelectors = $anScripts['selectors'];
			if ( isset( $anScripts['temp-path'] ) &&   false != $anScripts['temp-path'] ) {
				$tempFolderPath = $anScripts['temp-path'];
				$tempFolderURL = $anScripts['temp-url'];
			}
		} else {
			// Or remove it before new files creation
			if ( isset( $anScripts['temp-path'] ) &&  false != $anScripts['temp-path'] ) {
				an_delete_temp_folder( $anScripts['temp-path'] );
			}
		}

		// Generate new css and js files
		$titanCssContent = an_update_titan_css_selectors( $an_option );
		$newCSS = an_change_files_css_selectors(
			$flush,
			$tempFolderPath,
			$tempFolderURL,
			AN_URL . 'css/an-style.css',
			$anScripts['files']['css'],
			an_random_slug(),
			$anScripts['selectors'],
			$newSelectors,
			$titanCssContent
		);
		$newJS = an_change_files_css_selectors(
			$flush,
			$tempFolderPath,
			$tempFolderURL,
			AN_URL . 'js/an-scripts.js',
			$anScripts['files']['js'],
			an_random_slug(),
			$anScripts['selectors'],
			$newSelectors
		);

		// Upload dir and temp dir are not writable
		if ( false == $newCSS  || false == $newJS ) {
			$tempFolderPath = false;
		}

		// Store data
		$newFiles = array(
			'temp-path' => $tempFolderPath,
			'temp-url' => $tempFolderURL,
			'files' => array(
				'css' => $newCSS,
				'js' => $newJS,
			),
			'selectors' => $newSelectors,
		);

		an_update_option( 'adblocker_notify_selectors', serialize( $newFiles ) );
		// remove option flush
		$an_option['an_option_flush'] = false;
		an_update_option( 'adblocker_notify_options', serialize( $an_option ) );
	} else {

		// Remove temp files
		if ( isset( $anScripts['temp-path'] ) ) {
			an_delete_temp_folder( $anScripts['temp-path'] );
		}
	}
}
add_action( 'tf_admin_options_saved_adblocker_notify', 'an_save_setting_random_selectors', 99 );


/**

 * ************************************************************
 * Admin Panel notice if wrong CHMOD on "wp-content/uploads"
 ***************************************************************/
function an_error_admin_notices() {
	$prefix = an_is_pro() && is_multisite() ? '-network' : '';

	$screen = get_current_screen();
	if ( 'toplevel_page_' . AN_ID . $prefix != $screen->id ) {
		return; }

	$anScripts = unserialize( an_get_option( 'adblocker_notify_selectors' ) );

	if ( ! empty( $anScripts ) &&  false == $anScripts['temp-path'] ) {
		echo '
                <div class="error warning">
                    <p>
                        ' . __( 'WARNING: There was an error creating Adblock Notify CSS and JS files. Upload directory is not writable. Please CHMOD "wp-content/uploads" to 0664 and verify your server settings', 'an-translate' ) . ' &nbsp;&nbsp;&nbsp;&nbsp;
                        [ <a href="http://codex.wordpress.org/Changing_File_Permissions" target="_blank" title="Changing File Permissions"> Changing File Permissions</a> ]
                    </p>
                    <p>
                        ' . __( 'Don\'t worry, we thought about it. Adblock Notify will print the scripts directly in your DOM, but for performance purpose it is recommended to change your uploads directory CHMOD.', 'an-translate' ) . '
                    </p>
                </div>
        ';
	}
}
add_action( 'admin_notices', 'an_error_admin_notices' );


/**

 * ************************************************************
 * Edit Titan Generated CSS
 ***************************************************************/
function an_update_titan_css_selectors( $an_option ) {

	$tfStyle = '';
	if ( isset( $an_option['an_alternative_custom_css'] ) ) {
		$tfStyle .= $an_option['an_alternative_custom_css'];
	}
	if ( isset( $an_option['an_option_modal_custom_css'] ) ) {
		$tfStyle .= $an_option['an_option_modal_custom_css'];
	}

	// Remove TitanFramework Generated Style
	$uploadDir = wp_upload_dir();
	$TfCssFile = trailingslashit( $uploadDir['basedir'] ) . 'titan-framework-adblocker_notify-css.css';

	if ( file_exists( $TfCssFile ) ) {
		unlink( $TfCssFile ); }

	return $tfStyle;
}


/**

 * ************************************************************
 * Print Style & Sripts if temp dir. is not writable LOW PERF
 ***************************************************************/
function an_print_change_files_css_selectors( $an_option, $anScripts ) {

	// Get AN style and script
	$anCSS = AN_URL . 'css/an-style.css';
	$anJS = AN_URL . 'js/an-scripts.js';

	$newSelectors = $anScripts['selectors'];
	$defaultSelectors = array( 'an-Modal', 'reveal-modal', 'an-alternative' );

	$tfStyle = '';
	$tfStyle .= $an_option->getOption( 'an_alternative_custom_css' );
	$tfStyle .= $an_option->getOption( 'an_option_modal_custom_css' );

	$anCSSFileContent = wp_remote_get( $anCSS );
	$anCSSFileContent = wp_remote_retrieve_body( $anCSSFileContent );
	$anCSSFileContent = str_replace( $defaultSelectors, $newSelectors, $anCSSFileContent . $tfStyle );

	$anJSFileContent = wp_remote_get( $anJS );
	$anJSFileContent = wp_remote_retrieve_body( $anJSFileContent );
	$anJSFileContent = str_replace( $defaultSelectors, $newSelectors, $anJSFileContent );

	return '    
            <style type="text/css">
                ' . $anCSSFileContent . '
            </style>
            <script>// <![CDATA[
				var ajax_object = { ajaxurl : "' . admin_url( 'admin-ajax.php' ) . '" };
            // ]]></script>
            <script type="text/javascript">
                ' . $anJSFileContent . '
            </script>
         ';
}
