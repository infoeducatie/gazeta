<?php
/*
Plugin Name: Open Graph for Facebook, Google+ and Twitter Card Tags
Plugin URI: https://www.webdados.pt/produtos-e-servicos/internet/desenvolvimento-wordpress/facebook-open-graph-meta-tags-wordpress/
Description: Inserts Facebook Open Graph, Google+/Schema.org, Twitter Card and SEO Meta Tags into your WordPress Blog/Website for more effective and efficient Facebook, Google+ and Twitter sharing results. You can also choose to insert the "enclosure" and "media:content" tags to the RSS feeds, so that apps like RSS Graffiti and Twitterfeed post the image to Facebook correctly.
Version: 2.2.5
Author: Webdados
Author URI: https://www.webdados.pt
Text Domain: wonderm00ns-simple-facebook-open-graph-tags
Domain Path: /lang
WC tested up to: 3.5.3
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'WEBDADOS_FB_VERSION', '2.2.5' );
define( 'WEBDADOS_FB_PLUGIN_NAME', 'Open Graph for Facebook, Google+ and Twitter Card Tags' );
define( 'WEBDADOS_FB_W', 1200 );
define( 'WEBDADOS_FB_H', 630 );

/* Include core class */
require plugin_dir_path( __FILE__ ) . 'includes/class-webdados-fb-open-graph.php';

/* Uninstall hook */
register_uninstall_hook(__FILE__, 'webdados_fb_uninstall');
function webdados_fb_uninstall() {
	$options = get_option( 'wonderm00n_open_graph_settings' );
	if ( intval($options['fb_keep_data_uninstall'])==0 ) {
		//Settings
		delete_option( 'wonderm00n_open_graph_settings' );
		delete_option( 'wonderm00n_open_graph_version' );
		delete_option( 'wonderm00n_open_graph_admin_notice' );
		global $wpdb;
		//Post meta
		$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key LIKE '_webdados_fb_open_graph%'" );
		//Transients - Image size cache
		$wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE '%webdados_og_image_size_%'" );
	}
}

/* Run it */
function webdados_fb_run() {
	if ( $webdados_fb = new Webdados_FB( WEBDADOS_FB_VERSION ) ) {
		return $webdados_fb;
	} else {
		return false;
	}

}

$webdados_fb = webdados_fb_run();