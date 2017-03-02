<?php
/**
 * The base class for the templates
 *
 * @package adblock-notify-pro
 */

/**
 * The base class for the templates
 *
 * @package adblock-notify-pro
 */
abstract class AnTemplate {

	/**
	 * Template class props
	 *
	 * @var string the options */
	protected $options;

	/**
		Get the options for the admin interface
	 */
	public function get_options() {
		return $this->options;
	}

	/**
		Build the common features
	 */
	abstract function setup_constants();

	/**
		The builder
	 */
	public final function build( $file ) {
		$this->setup_constants( );
		include_once $file;
	}

}
