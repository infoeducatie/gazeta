<?php
/*
Plugin Name: DP Social Timeline
Description: The DP Social Timeline plugin lets you retrieve status/posts/videos/images from different social networks in a timeline format from the newest to the oldest.
Version: 1.7.7
Author: Diego Pereyra
Author URI: http://www.dpereyra.com/
Wordpress version supported: 3.0 and above
*/

//on activation
//defined global variables and constants here
global $dpSocialTimeline, $table_prefix, $wpdb;
$dpSocialTimeline = get_option('dpSocialTimeline_options');
define('DP_SOCIALTIMELINE_TABLE','dpSocialTimeline'); //timelines TABLE NAME
define("DP_SOCIALTIMELINE_VER","1.7.7",false);//Current Version of this plugin
if ( ! defined( 'DP_SOCIALTIMELINE_PLUGIN_BASENAME' ) )
	define( 'DP_SOCIALTIMELINE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
if ( ! defined( 'DP_SOCIALTIMELINE_CSS_DIR' ) ){
	define( 'DP_SOCIALTIMELINE_CSS_DIR', WP_PLUGIN_DIR.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__)).'/css/' );
}
// Create Text Domain For Translations
load_plugin_textdomain('dpSocialTimeline', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

function checkMU_install_dpSocialTimeline($network_wide) {
	global $wpdb;
	if ( $network_wide ) {
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			install_dpSocialTimeline();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		install_dpSocialTimeline();
	}
}

function install_dpSocialTimeline() {
	global $wpdb, $table_prefix;
	$table_name = $table_prefix.DP_SOCIALTIMELINE_TABLE;
	
	if($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$sql = "CREATE TABLE $table_name (
					id int(11) NOT NULL AUTO_INCREMENT,
					active tinyint(1) NOT NULL,
					title varchar(80) NOT NULL,
					items text NOT NULL,
					custom text NOT NULL,
					layoutMode varchar(80) NOT NULL,
					addColorbox TINYINT(1) DEFAULT 0 NOT NULL,
					showSocialIcons TINYINT(1) DEFAULT 1 NOT NULL,
					allowMultipleFilters TINYINT(1) DEFAULT 1 NOT NULL,
					cache TINYINT(1) DEFAULT 0 NOT NULL,
					cacheTime varchar(80) DEFAULT '900',
					showFilter TINYINT(1) DEFAULT 1 NOT NULL,
					showLayout TINYINT(1) DEFAULT 1 NOT NULL,
					showTime TINYINT(1) DEFAULT 1 NOT NULL,
					rtl TINYINT(1) DEFAULT 0 NOT NULL,
					share TINYINT(1) DEFAULT 1 NOT NULL,
					total INT(11) DEFAULT 10 NOT NULL,
					itemWidth VARCHAR(80) NOT NULL,
					timelineItemWidth VARCHAR(80) NOT NULL,
					columnsItemWidth VARCHAR(80) NOT NULL,
					oneColumnItemWidth VARCHAR(80) NOT NULL  DEFAULT '100%',
					skin VARCHAR(80) NOT NULL,
					width char(5) NOT NULL,
					width_unity char(2) NOT NULL DEFAULT 'px',
					lang_week varchar(80) NOT NULL, 
					lang_weeks varchar(80) NOT NULL, 
					lang_day varchar(80) NOT NULL, 
					lang_days varchar(80) NOT NULL, 
					lang_hour varchar(80) NOT NULL, 
					lang_hours varchar(80) NOT NULL, 
					lang_minute varchar(80) NOT NULL, 
					lang_minutes varchar(80) NOT NULL, 
					lang_about varchar(80) NOT NULL, 
					lang_ago varchar(80) NOT NULL, 
					lang_less varchar(80) NOT NULL,
					UNIQUE KEY id(id)
				);";
		$rs = $wpdb->query($sql);
	}
	
   $default_social_timeline = array(
   						   'version' 				=> 		DP_SOCIALTIMELINE_VER,
						   'tranlations'			=>		true,
						   'show_time'				=>		true,
						   'share'					=>		true,
						   'widthLayouts'			=>		true,
						   'twitter_consumer_key'	=>		'',
						   'twitter_consumer_secret'=>		'',
						   'twitter_access_key'		=>		'',
						   'twitter_access_secret'	=>		'',
						   'rtl'					=>		false,
						   'cache'					=>		true
			              );
   
	$dpSocialTimeline = get_option('dpSocialTimeline_options');
	
	if(!$dpSocialTimeline) {
	 $dpSocialTimeline = array();
	}
	
	foreach($default_social_timeline as $key=>$value) {
	  if(!isset($dpSocialTimeline[$key])) {
		 $dpSocialTimeline[$key] = $value;
	  }
	}
	
	delete_option('dpSocialTimeline_options');	  
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}
register_activation_hook( __FILE__, 'checkMU_install_dpSocialTimeline' );

/* Uninstall */
function checkMU_uninstall_dpSocialTimeline($network_wide) {
	global $wpdb;
	if ( $network_wide ) {
		$blog_list = get_blog_list( 0, 'all' );
		foreach ($blog_list as $blog) {
			switch_to_blog($blog['blog_id']);
			uninstall_dpSocialTimeline();
		}
		switch_to_blog($wpdb->blogid);
	} else {
		uninstall_dpSocialTimeline();
	}
}

function uninstall_dpSocialTimeline() {
	global $wpdb, $table_prefix;
	delete_option('dpSocialTimeline_options'); 
	
	$table = $table_prefix.DP_SOCIALTIMELINE_TABLE;
	$sql = "DROP TABLE $table;";
	$wpdb->query($sql);
	
}
register_uninstall_hook( __FILE__, 'checkMU_uninstall_dpSocialTimeline' );

/* Add new Blog */

add_action( 'wpmu_new_blog', 'newBlog_dpSocialTimeline', 10, 6); 		
 
function newBlog_dpSocialTimeline($blog_id, $user_id, $domain, $path, $site_id, $meta ) {
	global $wpdb;
 
	if (is_plugin_active_for_network('dpSocialTimeline/dpSocialTimeline.php')) {
		$old_blog = $wpdb->blogid;
		switch_to_blog($blog_id);
		install_dpSocialTimeline();
		switch_to_blog($old_blog);
	}
}

/*******************/
/* UPDATES 
/*******************/

$table_name_timelines = $table_prefix.DP_SOCIALTIMELINE_TABLE;

if(!isset($dpSocialTimeline['cache'])) {
	$dpSocialTimeline['cache'] = true;
	
	$sql = "ALTER TABLE $table_name_timelines ADD (allowMultipleFilters TINYINT(1) DEFAULT 1 NOT NULL);";
	$wpdb->query($sql);
	
	$sql = "ALTER TABLE $table_name_timelines ADD (cache TINYINT(1) DEFAULT 0 NOT NULL);";
	$wpdb->query($sql);
	
	$sql = "ALTER TABLE $table_name_timelines ADD (cacheTime varchar(80) DEFAULT '900');";
	$wpdb->query($sql);
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}

if(!isset($dpSocialTimeline['rtl'])) {
	$dpSocialTimeline['rtl'] = true;
	
	$sql = "ALTER TABLE $table_name_timelines ADD (rtl TINYINT(1) DEFAULT 0 NOT NULL);";
	$wpdb->query($sql);
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}

if(!isset($dpSocialTimeline['widthLayouts'])) {
	$dpSocialTimeline['widthLayouts'] = true;
	
	$sql = "ALTER TABLE $table_name_timelines ADD (timelineItemWidth VARCHAR(80) NOT NULL, columnsItemWidth VARCHAR(80) NOT NULL, oneColumnItemWidth VARCHAR(80) NOT NULL DEFAULT '100%');";
	$wpdb->query($sql);
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}

if(!isset($dpSocialTimeline['share'])) {
	$dpSocialTimeline['share'] = true;
	
	$sql = "ALTER TABLE $table_name_timelines ADD (share TINYINT(1) DEFAULT 1 NOT NULL);";
	$wpdb->query($sql);
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}

if(!isset($dpSocialTimeline['show_time'])) {
	$dpSocialTimeline['show_time'] = true;
	
	$sql = "ALTER TABLE $table_name_timelines ADD (showTime TINYINT(1) DEFAULT 1 NOT NULL);";
	$wpdb->query($sql);
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}

if(!isset($dpSocialTimeline['tranlations'])) {
	$dpSocialTimeline['tranlations'] = true;
	
	$sql = "ALTER TABLE $table_name_timelines ADD (lang_week varchar(80) NOT NULL, lang_weeks varchar(80) NOT NULL, lang_day varchar(80) NOT NULL, lang_days varchar(80) NOT NULL, lang_hour varchar(80) NOT NULL, lang_hours varchar(80) NOT NULL, lang_minute varchar(80) NOT NULL, lang_minutes varchar(80) NOT NULL, lang_about varchar(80) NOT NULL, lang_ago varchar(80) NOT NULL, lang_less varchar(80) NOT NULL);";
	$wpdb->query($sql);
	update_option('dpSocialTimeline_options',$dpSocialTimeline);
}


require_once (dirname (__FILE__) . '/functions.php');
require_once (dirname (__FILE__) . '/includes/core.php');
require_once (dirname (__FILE__) . '/settings/settings.php');
?>