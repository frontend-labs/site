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
 * Register the Dashboard Widget display function
 ***************************************************************/
function an_dashboard_widgets() {
	$an_option = TitanFramework::getInstance( 'adblocker_notify' );
	if ( isset( $an_option ) && $an_option->getOption( 'an_option_stats' ) != 2 ) {
		wp_add_dashboard_widget( 'an_dashboard_widgets', '<img src="' . AN_URL . 'img/icon-adblock-notify.png" class="bweb-logo" alt="addblock-notify" style="display:none"/>&nbsp;&nbsp;' . __( 'Adblock Notify Stats', 'an-translate' ), 'an_get_counters' );
		// Chart JS
		wp_enqueue_script( 'an_chart_js', AN_URL . 'vendor/chart-js/Chart.min.js', array( 'jquery' ), null );
		// CSS & JS
		add_action( 'admin_footer', 'an_register_admin_scripts' );
	}
}
add_action( 'wp_dashboard_setup', 'an_dashboard_widgets' );


/**

 * ************************************************************
 * Page views & page blocked counter
 ***************************************************************/
function an_adblock_counter() {
	if ( current_user_can( 'manage_options' ) || empty( $_POST['an_state'] ) ) {
		return;
	}
	$an_states = $_POST['an_state'];
	$anCount = an_get_option( 'adblocker_notify_counter' );
	foreach ( $an_states as $an_state ) {

		if ( empty( $anCount ) ) {
			$anCount = array( 'total' => 0, 'blocked' => 0, 'deactivated' => 0, 'history' => array() );
			an_update_option( 'adblocker_notify_counter', $anCount );
		}

		// update option with new values
		$anCount[ $an_state ] ++;

		// then update history
		$anCount = an_history_counter( $anCount, $an_state );
	}

	// update db
	an_update_option( 'adblocker_notify_counter', $anCount );
	exit;
}
add_action( 'wp_ajax_call_an_adblock_counter', 'an_adblock_counter' );
add_action( 'wp_ajax_nopriv_call_an_adblock_counter', 'an_adblock_counter' );


/**

 * ************************************************************
 * Calcul date diff
 ***************************************************************/
function an_date_diff( $toDay, $toCheck ) {
	$todayObj = new DateTime( $toDay );
	$expiredObj = new DateTime( $toCheck );
	$dateDiff = $todayObj->diff( $expiredObj );
	return $dateDiff->days;
}


/**

 * ************************************************************
 * Page history counter
 ***************************************************************/
function an_history_counter( $anCount, $val = null ) {
	$anToday = date( 'Y-m-d', current_time( 'timestamp', 0 ) );
	// $anToday = date( 'Y-m-d', strtotime( '1 day', strtotime( date( 'Y-m-d', current_time( 'timestamp', 0 ) ) ) ) );
	if ( empty( $anCount['history'][0] ) ) {

		$anCount['history'][0] = array( 'date' => $anToday, 'total' => $anCount['total'], 'blocked' => $anCount['blocked'] );
	} else {

		$anDate = $anCount['history'][0]['date'];
		$anDiff = an_date_diff( $anToday, $anDate );

		if ( $anDate == $anToday ) {

			// increase current date
			if (  'total' == $val  ) {
				$anCount['history'][0]['total'] = $anCount['history'][0]['total'] + 1;
			} elseif ( 'blocked' == $val ) {
				$anCount['history'][0]['blocked'] = $anCount['history'][0]['blocked'] + 1;
			}
		} elseif ( $anDiff > 0 ) {

			// remove last + add new one
			if (  'total' == $val ) {
				$anNew = array( 'date' => $anToday, 'total' => 1, 'blocked' => 0 );
			} elseif ( 'blocked' == $val    ) {
				$anNew = array( 'date' => $anToday, 'total' => 1, 'blocked' => 1 );
			}
			$anCount['history'] = array_merge( array( $anNew ), $anCount['history'] );

			if (  8 == count( $anCount['history'] ) ) {
				$anOld = an_date_diff( $anToday, $anCount['history'][7]['date'] );
				if (  7 == $anOld && 8 == count( $anCount['history'] ) ) {
					// remove last + add new one ($anRemove is a rubbish var)
					array_pop( $anCount['history'] );
				}
			}
		}
	}

	return $anCount;
}


/**

 * ************************************************************
 * Data history extraction & order revert for chart
 ***************************************************************/
function an_widget_data_histoty( $anCount, $val = null ) {
	if ( empty( $anCount['history'][0] ) ) {
		return; }

	foreach ( $anCount['history'] as $row ) {
		$anOutput[] = $row[ $val ];
	}
	return $anOutput;
}


/**

 * ************************************************************
 * Display the Dashboard Widget
 ***************************************************************/
function an_get_counters() {
	$anCount = an_get_option( 'adblocker_notify_counter' );
	if ( empty( $anCount ) ) {
		echo '<p>No data</p>';
		return;
	}

	// prevent plugin's counter to be higher than the page counter if page is refreshed during the ajax call or if wordpress caching systeme in not badly configured
	if ( ( $anCount['blocked'] > $anCount['total']) || ($anCount['history'][0]['blocked'] > $anCount['history'][0]['total'] ) ) {

		if ( $anCount['blocked'] > $anCount['total'] ) {
			$anCount['total'] = $anCount['blocked'];
		}
		if ( $anCount['history'][0]['blocked'] > $anCount['history'][0]['total'] ) {
			$anCount['history'][0]['total'] = $anCount['history'][0]['blocked'];
		}

		// update db
		an_update_option( 'adblocker_notify_counter', $anCount );
	}

	if ( empty( $anCount['total'] ) ) {
		$anCount['total'] = 0; }

	if ( empty( $anCount['history'][0]['total'] ) ) {
		$anCount['history'][0]['total'] = 0; }

	if ( empty( $anCount['blocked'] ) ) {
		$anCount['blocked'] = 0; }

	if ( empty( $anCount['history'][0]['blocked'] ) ) {
		$anCount['history'][0]['blocked'] = 0; }

	if ( empty( $anCount['deactivated'] ) ) {
		$anCount['deactivated'] = 0; }

	$totalNoBlocker = $anCount['total'] - $anCount['blocked'];
	$average = 0;
	if ( $anCount['total'] != 0 ) {
		$average = round( ( $anCount['blocked'] / $anCount['total'] ) * 100, 2 );
	}

	$totalNoBlockerToday = $anCount['history'][0]['total'] - $anCount['history'][0]['blocked'];
	$averageToday = 0;
	if ( $anCount['total'] != 0 ) {
		$averageToday = round( ( $anCount['history'][0]['blocked'] / $anCount['history'][0]['total'] ) * 100, 2 );
	}

	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	// Load WP_Filesystem API
	WP_Filesystem();
	global $wp_filesystem;

	$css = $wp_filesystem->get_contents( AN_PATH . 'css/an-dashboard-widget.css' );

	$output = "<style type='text/css'>" . $css . '</style>';
	$output .= '
        <table class="an-stats-table">
            <tr class="an-top">
			  <td><span class="antooltip" data-antooltip="' . __( 'Admins are excluded from this statistics.', 'an-translate' ) . '"><span class="dashicons dashicons-info"></span></span></td>
			  <td>' . __( 'Total', 'an-translate' ) . '</td> 
			  <td>' . __( 'Today', 'an-translate' ) . '</td>
            </tr>
            <tr>
			  <td style="text-align:left;"><span style="color:#34495e">&#9608</span> ' . __( 'Pages Views', 'an-translate' ) . '</td>
			  <td>' . $anCount['total'] . '</td> 
			  <td>' . $anCount['history'][0]['total'] . '</td>
            </tr>
            <tr>
			  <td style="text-align:left;"><span style="color:#e74c3c">&#9608</span> ' . __( 'Pages with Adblock', 'an-translate' ) . '</td>
			  <td>' . $anCount['blocked'] . '</td> 
			  <td>' . $anCount['history'][0]['blocked'] . '</td>
            </tr>
        </table>

        <div class="an-canvas-container-donut">
			<div class="an-average"><span>' . __( 'Total', 'an-translate' ) . '</span>' . $average . '%<span>' . __( 'Ads blocked', 'an-translate' ) . '</span></div>
            <canvas id="an-canvas-donut" height="180"></canvas>
        </div>

        <div class="an-canvas-container-donut">
			<div class="an-average"><span>' . __( 'Today', 'an-translate' ) . '</span>' . $averageToday . '%<span>' . __( 'Ads blocked', 'an-translate' ) . '</span></div>
            <canvas id="an-canvas-donut-today" height="180"></canvas>
        </div>
        <p class="an-deactivated">
			<strong>' . $anCount['deactivated'] . '</strong> ' . __( 'Ad Blocker software deactivated', 'an-translate' ) . '
			<span class="antooltip" data-antooltip="' . __( 'You may probably increase this number by improving your custom messages', 'an-translate' ) . '."><span class="dashicons dashicons-info"></span></span>
        </p>
        <div id="an-canvas-container-line">
            <canvas id="an-canvas-line"></canvas>
        </div>
        <ul class="subsubsub">
            <li class="an-options">
				<a href="options-general.php?page=' . AN_ID . '">' . __( 'Settings', 'an-translate' ) . '</a> |
            </li>
            <li class="an-reset">
				<a href="options-general.php?page=' . AN_ID . '&an-reset=true"  
				onclick="javascript:if(!confirm(\'' . __( 'Are you sure you want to delete permanently your datas?', 'an-translate' ) . '\' )) return false;" 
				>' . __( 'Reset Stats', 'an-translate' ) . '</a>
            </li>
		</ul>';

	$output .= '<script type="text/javascript">';
	$output .= '/* <![CDATA[ */';
	$output .= 'var anWidgetOptions =' .
			json_encode( array(
				'totalNoBlocker' => $totalNoBlocker,
				'anCountBlocked' => $anCount['blocked'],
				'totalNoBlockerToday' => $totalNoBlockerToday,
				'anCountBlockedHistory' => $anCount['history'][0]['blocked'],
				'anDataHistotyTotal' => an_widget_data_histoty( $anCount, 'total' ),
				'anDataHistotyBlocked' => an_widget_data_histoty( $anCount, 'blocked' ),
			) );
	$output .= '/* ]]> */';
	$output .= '</script>';

	echo $output;
}
