<?php // Hook for adding admin menus
if ( is_admin() ){ // admin actions
  add_action('admin_menu', 'dpSocialTimeline_settings');
  add_action('admin_init', 'dpSocialTimeline_register_mysettings');
} 

// function for adding settings page to wp-admin
function dpSocialTimeline_settings() {
    // Add a new submenu under Options:
	add_menu_page( 'Social Timeline', 'Social Timeline', 'manage_options','dpSocialTimeline-admin', 'dpSocialTimeline_timelines_page', dpSocialTimeline_plugin_url( 'images/dpSocialTimeline_icon.gif' ) );
	add_submenu_page('dpSocialTimeline-admin', 'Timelines', 'Timelines', 'manage_options', 'dpSocialTimeline-admin', 'dpSocialTimeline_timelines_page');
	add_submenu_page('dpSocialTimeline-admin', 'Add new Timeline', 'Add new Timeline', 'manage_options', 'dpSocialTimeline-admin&add=1', 'dpSocialTimeline_timelines_page');
	add_submenu_page('dpSocialTimeline-admin', 'Set API Credentials', 'Set API Credentials', 'manage_options', 'dpSocialTimeline-twitter', 'dpSocialTimeline_twitter');
}
include('timelines.php');
include('twitter.php');
?>