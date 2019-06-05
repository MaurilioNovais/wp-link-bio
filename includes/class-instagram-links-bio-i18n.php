<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://nanoincub.com.br
 * @since      1.0.0
 *
 * @package    Instagram_Links_Bio
 * @subpackage Instagram_Links_Bio/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Instagram_Links_Bio
 * @subpackage Instagram_Links_Bio/includes
 * @author     Nano Incub <desenvolvimento@email.com.br>
 */
class Instagram_Links_Bio_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'instagram-links-bio',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
