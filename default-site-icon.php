<?php
/*
Plugin Name: Default Site Icon
Plugin URI: https://kraft.im/
Description: On multisite, sets the default site icon to the main site's site icon.
Version: 1.0
Author: Brandon Kraft
Author Email: public@brandonkraft.com
License: GPLv2 or later
*/

add_filter( 'get_site_icon_url', 'bk_dsi_get_main_site_icon', 10, 3 );

function bk_dsi_get_main_site_icon( $url, $size, $blog_id ){
	if ( ! is_multisite() ){
		return $url; // Barking up the wrong tree with this plugin.
	}

	if ( '' === $url ){ // strict compare to avoid an infinite loop
		// get the current network's main site
		$network = get_network();
		$blog_id = $network->$blog_id;

		// get the main site's site icon, setting false for the fallback intentially
		$url = get_site_icon_url( $size, false, $blog_id);

		// restore expected null-type if the main site doesn't have a site icon set either
		if ( false === $url) {
			$url = '';
		}
	}

	return $url;
}
