<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://antonionovak.com
 * @since      1.0.1
 *
 * @package    Warp_Cache
 * @subpackage Warp_Cache/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->


<div class="wrap">
	<?php echo '<div class="wrap"><h2></h2></div>'; // Stupid hack for WordPress alerts and warnings ?>
	<?php settings_errors(); ?>
	<div id="warp-cache">
		<div class="warp-cache-header">
			<div class="warp-cache-logo">
				<h1>Warp Cache</h1>
			</div>
			<div class="warp-cache-status active"><?php _e('Active', 'warp-cache'); ?></div>
		</div>
		<div class="warp-cache-speed-insights">
			<div id="warp-cache-before">
				<h2><?php _e('Before', 'warp-cache'); ?></h2>
				<div class="warp-cache-speed-status" id="warp-cache-before-speed-status"><?php echo get_option('warpStatusSpeedBefore');?>/100</div>
				<p><?php _e('Google PageSpeed Insights Result', 'warp-cache'); ?></p>
			</div>
			<div id="warp-cache-after">
				<h2><?php _e('After', 'warp-cache'); ?></h2>
				<div class="warp-cache-speed-status" id="warp-cache-after-speed-status"></div>
				<p><?php _e('Google PageSpeed Insights Result', 'warp-cache'); ?></p>
			</div>
		</div>
		<div class="warp-cache-suggestions" id="warp-cache-suggestions">
			<h2 class="title"><?php _e('Suggestions for better performance', 'warp-cache'); ?></h2>
			<?php /*<div class="warp-cache-suggestion">
				<div class="warp-cache-suggestion-title">Optimize images</div>
				<div class="warp-cache-suggestion-button">Fix</div>
			</div> */ ?>
		</div>
	</div>
</div>

