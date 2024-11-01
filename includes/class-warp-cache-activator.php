<?php

/**
 * Fired during plugin activation
 *
 * @link       http://antonionovak.com
 * @since      1.0.0
 *
 * @package    Warp_Cache
 * @subpackage Warp_Cache/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Warp_Cache
 * @subpackage Warp_Cache/includes
 * @author     Antonio Novak <plugins@antonionovak.com>
 */
class Warp_Cache_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Get Page Speed before cache activation
		$apiKey = 'AIzaSyAGSsnZvEQhnJkL7z1LjNvwClp9F9NRAec';
		$siteUrl = get_site_url();
		$apiUrl = 'https://www.googleapis.com/pagespeedonline/v2/runPagespeed?';

		//$s = 'https://developers.google.com/speed/pagespeed/insights/optimizeContents?url=http%3A%2F%2Fnibatours.hr%2F&strategy=desktop';

		//call api
		$response = wp_remote_get($apiUrl . 'url=' . $siteUrl . '&key=' . $apiKey, array('timeout' => 15));

		$json = wp_remote_retrieve_body( $response );

		$status = wp_remote_retrieve_response_code( $response );

		$json = json_decode($json);

		$score = $json->ruleGroups->SPEED->score;

		if ($status != 200) {
			$score = __('Not available', 'warp-cache');
		}

		add_option( 'warpStatusSpeedBefore', $score, '', false);
		
		// Get path to main .htaccess for WordPress
		$htaccess = get_home_path().".htaccess";

		// Get server configuration
		$serverEncoding = $_SERVER['HTTP_ACCEPT_ENCODING'];
		$serverEncoding = explode(",", $serverEncoding);

		$lines = array();

		$lines[] = '<IfModule mod_headers.c>';
			$lines[] = 'Header unset Pragma';
			$lines[] = 'FileETag None';
			$lines[] = 'Header unset ETag';
			$lines[] = 'Header set Connection keep-alive';
		$lines[] = '</IfModule>';

		$lines[] = '<IfModule mod_gzip.c>';
			$lines[] = 'mod_gzip_on Yes';
			$lines[] = 'mod_gzip_dechunk Yes';
			$lines[] = 'mod_gzip_item_include file \.(html?|txt|css|js|php|pl)$';
			$lines[] = 'mod_gzip_item_include handler ^cgi-script$';
			$lines[] = 'mod_gzip_item_include mime ^text/.*';
			$lines[] = 'mod_gzip_item_include mime ^application/x-javascript.*';
			$lines[] = 'mod_gzip_item_exclude mime ^image/.*';
			$lines[] = 'mod_gzip_item_exclude rspheader ^Content-Encoding:.*gzip.*';
		$lines[] = '</IfModule>';

		$lines[] = '<FilesMatch "\\.(js|css|html|htm|php|xml)$">';
			$lines[] = 'SetOutputFilter DEFLATE';
		$lines[] = '</FilesMatch>';


		if (true) :
			// Expires
			$lines[] = '<IfModule mod_expires.c>';
				$lines[] = 'ExpiresActive On';
				$lines[] = 'ExpiresByType image/jpg "access 1 year"';
				$lines[] = 'ExpiresByType image/jpeg "access 1 year"';
				$lines[] = 'ExpiresByType image/gif "access 1 year"';
				$lines[] = 'ExpiresByType image/png "access 1 year"';
				$lines[] = 'ExpiresByType text/css "access 1 month"';
				$lines[] = 'ExpiresByType text/html "access 1 month"';
				$lines[] = 'ExpiresByType application/pdf "access 1 month"';
				$lines[] = 'ExpiresByType text/x-javascript "access 1 month"';
				$lines[] = 'ExpiresByType application/x-shockwave-flash "access 1 month"';
				$lines[] = 'ExpiresByType image/x-icon "access 1 year"';
				$lines[] = 'ExpiresDefault "access 1 month"';
			$lines[] = '</IfModule>';
		else :
			// One month for most static assets / Cache Control
			$lines[] = '<filesMatch ".(css|jpg|jpeg|png|gif|js|ico)$">';
				$lines[] = 'Header set Cache-Control "max-age=2628000, public"';
			$lines[] = '</filesMatch>';
		endif;

		insert_with_markers($htaccess, "WarpCache", $lines);

	}

}
