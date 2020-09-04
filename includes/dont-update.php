<?php
/**
 * This file prevents auto-updates from the WordPress plugin repository.
 *
 * @package SEOSlider
 */

add_filter( 'http_request_args', 'dont_update_seo_slider_plugin', 5, 2 );
/**
 * Dont Update the Plugin
 * If there is a plugin in the repo with the same name, this prevents WP from prompting an update.
 *
 * @url https://github.com/billerickson/EA-Core-Functionality/blob/master/inc/general.php
 *
 * @param array  $r   Existing request arguments
 * @param string $url Request URL
 * @return array Amended request arguments
 */
function dont_update_seo_slider_plugin( $r, $url ) {
	// Not a plugin update request. Bail immediately.
	if ( 0 !== strpos( $url, 'https://api.wordpress.org/plugins/update-check/1.1/' ) ) {
		return $r;
	}

	$plugins = json_decode( $r['body']['plugins'], true );

	unset( $plugins['plugins'][ plugin_basename( EA_DIR . '/core-functionality.php' ) ] );

	$r['body']['plugins'] = json_encode( $plugins );

	return $r;
}
