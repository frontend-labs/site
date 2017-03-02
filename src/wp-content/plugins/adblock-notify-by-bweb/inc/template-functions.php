<?php
/**
 *  Helper functions for templates
 *
 * @package   adblock-notify-by-bweb
 * @author    Marius Cristea<marius@themeisle.com>
 * @license   GPL-2.0+
 * @copyright 2016 Vertigo Studio SRL
 */

/**
 * ************************************************************
 * Get the heading style
 ***************************************************************/
function an_template_heading_style() {
	$class = an_get_template_class();
	$instance = call_user_func( array( $class, 'instance' ) );

	echo $instance->heading_style;
}

/**
 * ************************************************************
 * Get the title
 ***************************************************************/
function an_template_title() {
	$class = an_get_template_class();
	$instance = call_user_func( array( $class, 'instance' ) );

	echo $instance->title;
}

/**
 * ************************************************************
 * Get the content
 ***************************************************************/
function an_template_content() {

	$class = an_get_template_class();
	$instance = call_user_func( array( $class, 'instance' ) );
	echo $instance->content;
}

/**
 * ************************************************************
 * Get the footer
 ***************************************************************/
function an_template_footer() {

	$class = an_get_template_class();
	$instance = call_user_func( array( $class, 'instance' ) );
	echo $instance->footer;
}

/**
 * ************************************************************
 * Get the extra
 ***************************************************************/
function an_template_extra() {
	$class = an_get_template_class();
	$instance = call_user_func( array( $class, 'instance' ) );
	echo $instance->extra;
}
/**
 * ************************************************************
 * Get random selector
 ***************************************************************/
function an_get_random_selector( $key ) {
	$options = unserialize( an_get_option( 'adblocker_notify_selectors' ) );
	if ( $key == 'reveal-modal' ) {
		return isset( $options['selectors'][1] ) ? $options['selectors'][1] : $key;
	}
}

/**
 * Get template name value
 *
 * @return string
 */
function an_get_template() {

	$an_option         = unserialize( an_get_option( 'adblocker_notify_options' ) );
	$selected_template = isset( $an_option['an_option_modal_template'] ) ? $an_option['an_option_modal_template'] : 'an-default';
	return $selected_template;
}

/**
 * Return the template class
 *
 * @param string $name The name of the template file.
 *
 * @return mixed|string
 */
function an_get_template_class( $name = '' ) {
	if ( empty( $name ) ) {
		$name = an_get_template();
	}
	$name = str_replace( ' ', '', ucwords( str_replace( '-', ' ', $name ) ) );
	return $name;
}
