<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://antonionovak.com
 * @since      1.0.0
 *
 * @package    Warp_Cache
 * @subpackage Warp_Cache/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Warp_Cache
 * @subpackage Warp_Cache/includes
 * @author     Antonio Novak <plugins@antonionovak.com>
 */
class Warp_Cache_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		delete_option('warpStatusSpeedBefore');

		$htaccess = get_home_path().".htaccess";
		 
		$lines = array();
		$lines[] = '';
	 
		insert_with_markers($htaccess, "WarpCache", $lines);
	}

}
