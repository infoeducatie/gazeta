<?php
/**
 * Plugin Name: Custom Team Manager
 * Plugin URI: http://webspiderbd.com
 * Description: A custom plugin to manage your team members. Shortcode enabled. Responsive Layout. Easy to use. Just need to install/activate this plugin and add team members through Management Team menu on Dashboard.
 * Version: 2.4.1
 * Author: webspiderbd team
 * Author URI: http://webspiderbd.com
 */

 
define( 'CMT_VERSION', '2.4.1' );
 
require_once(dirname(__FILE__) . '/inc/functions.php');
require_once(dirname(__FILE__) . '/inc/shortcodes.php');

// register style on initialization
add_action('init', 'register_style');
function register_style() {
    wp_register_style( 'stylesheet', plugins_url('/css/stylesheet.css', __FILE__), false, CMT_VERSION, 'all');
}

// use the registered style above
add_action('wp_enqueue_scripts', 'enqueue_style');
function enqueue_style(){
   wp_enqueue_style( 'stylesheet' );
}

// register admin-style on initialization

function cmt_wp_admin_style() {
        wp_register_style( 'cmt_admin_css', plugins_url('/css/admin-style.css', __File__), false, CMT_VERSION, 'all' );
        wp_enqueue_style( 'cmt_admin_css' );
}
add_action( 'admin_enqueue_scripts', 'cmt_wp_admin_style' );

// register admin-js on initialization

function cmt_wp_admin_js() {
        wp_register_script( 'cmt_admin_js', plugins_url('/js/cmt-options.js', __File__), array('jquery'), CMT_VERSION, true );
        wp_enqueue_script( 'cmt_admin_js' );
}
add_action( 'admin_enqueue_scripts', 'cmt_wp_admin_js' );


/* Runs when plugin is activated */
register_activation_hook(__FILE__,'cmt_install'); 
register_deactivation_hook(__FILE__, 'cmt_uninstall');

function cmt_uninstall() {
	delete_option( 'hide_ajax_notification' );
}
	
function cmt_install() {

	//add_option( 'hide_ajax_notification', false );
	update_option( 'hide_ajax_notification', 0, '', 'yes' ); 
	
	//Create custom post type.
    cmt_team_manager();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();

	// Add plugin options to options table
	update_option( 'cmt_single_page', 1, '', 'yes' ); 
	update_option( 'cmt_ajax_load', 1, '', 'yes' ); 
	update_option( 'cmt_show_gridview', 0, '', 'yes' ); 
	update_option( 'cmt_mem_pro_page_slug', 'members', '', 'yes' ); 
	
	// check if there is a page with same name
	function get_page_by_name($pagename){
		$pages = get_pages();
		foreach ($pages as $page) if ($page->post_name == $pagename) return $page;
			return false;
	}

	$page = get_page_by_name('team-members');
	// if there is no page with same name, then create one
	if (empty($page)) {
		$members_page = array(
		'post_type' => 'page',
		'post_name' => 'team-members',
		'post_title' => 'Team Members',
		'post_status' => 'publish',
		'post_content'	=>	'[team-members]' 
		);

		wp_insert_post($members_page);

	}
	
	$page = get_page_by_name('team-members-profile');
	
	//save Profile page id.
	$page_id = array('page_id' => $page->ID);
	update_option( 'cmt_profile_page', $page_id, '', 'yes' ); 
	
	// if there is no page with same name, then create one
	if (empty($page)) {
		$members_profile_page = array(
		'post_type' => 'page',
		'post_name' => 'team-members-profile',
		'post_title' => 'Team Members Profile',
		'post_status' => 'publish',
		'post_content'	=>	'[team-members-profile]' 
		);
		wp_insert_post($members_profile_page);

	}

}

add_action('admin_init', 'cmt_pto_init');
function cmt_pto_init(){
	// Display the admin notice only if it hasn't been hidden
	global $pagenow;
	if (( $pagenow == 'edit.php' ) && ($_GET['post_type'] == 'cmt-management-team')) {
		
		if( ( false == get_option( 'hide_ajax_notification' ) ) && ( !class_exists('Post_Types_Order_Walker')) ) {
			add_action( 'admin_notices', 'cmt_admin_notice' );
		} // end if
	}
}
add_action( 'wp_ajax_cmt_hide_notice', 'cmt_hide_notice' );


?>