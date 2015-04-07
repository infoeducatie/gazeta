<?php
/*
		Plugin Name: WordPress Social Stream
		Plugin URI: http://www.designchemical.com/blog/index.php/premium-wordpress-plugins/premium-wordpress-plugin-wordpress-social-stream/
		Tags: facebook, twitter, google +1, instagram, rss, digg, delicious, flickr, youtube, last.fm, tumblr, pinterest, dribbble, vimeo, stumbleupon, social networks, jquery, tabs
		Description: Create a single social stream from facebook, twitter, google +1, rss, delicious, flickr, youtube, last.fm, pinterest, stumbleupon, dribbble, vimeo, tumblr, instagram & deviantart feeds.
		Author: Lee Chestnutt
		Version: 1.5.9.1
		Author URI: http://www.designchemical.com/blog/
*/
global $wpdb;

require_once('inc/dcwp_admin.php');
require_once('inc/dcwp_functions.php');
require_once('inc/dcwp_shortcodes.php');

class dc_jqsocialstream {

	function __construct() {
	
		add_filter('init', array(&$this,'dcwss_init'));
		add_action( 'wp_head', array('dc_jqsocialstream', 'header') );
		add_action( 'wp_footer', array('dc_jqsocialstream', 'footer') );
		
		// Add shortcodes
		add_shortcode('dc_social_feed', 'dc_social_feed_shortcode');
		add_shortcode('dc_social_wall', 'dc_social_wall_shortcode');
		
		// Scripts
		add_action("wp_enqueue_scripts",array(&$this,'add_dcwss_styles'));
		add_action("wp_enqueue_scripts",array(&$this,'add_dcwss_scripts'));
		add_action( 'init', array(&$this,'register_dc_streams_posttype') );

	}
	
	function add_dcwss_styles() {

		if(get_dcwss_default('skin') == 'true' || get_dcwss_default('skin') == ''){
			wp_enqueue_style( 'dcwss', plugins_url() . '/wordpress-social-stream/css/dcwss.css');
		}

	}

	function add_dcwss_scripts() {

		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'dcwss-wall', plugins_url() . '/wordpress-social-stream/js/jquery.social.stream.wall.1.6.js' );
		wp_enqueue_script( 'dcwss', plugins_url() . '/wordpress-social-stream/js/jquery.social.stream.1.5.9.min.js' );

	// load footer	
	//	wp_enqueue_script( 'dcwss-wall', dc_jqsocialstream::get_plugin_directory() . '/js/jquery.social.stream.wall.1.6.js', array(), '', true );
	//	wp_enqueue_script( 'dcwss', dc_jqsocialstream::get_plugin_directory() . '/js/jquery.social.stream.1.5.9.min.js', array(), '', true );

	}
		
	function dcwss_init(){

		if(is_admin()) {

			$dc_jqsocialstream_admin = new dc_jqsocialstream_admin();
		}

	}

	function register_dc_streams_posttype() {
		$labels = array(
			'name' => _x( 'Streams', 'post type general name' ),
			'singular_name' => _x( 'Stream', 'post type singular name' ),
			'add_new' => _x( 'Add New', 'Stream'),
			'add_new_item' => __( 'Add New Stream '),
			'edit_item' => __( 'Edit Stream '),
			'new_item' => __( 'New Stream '),
			'view_item' => __( 'View Stream '),
			'search_items' => __( 'Search Streams '),
			'not_found' =>  __( 'No Stream found' ),
			'not_found_in_trash' => __( 'No Stream found in Trash' ),
			'parent_item_colon' => ''
		);

		$supports = array( 'title' , 'editor');

		$post_type_args = array(
			'labels' => $labels,
			'singular_label' => __( 'Stream' ),
			'public' => false,
			'show_ui' => false,
			'publicly_queryable' => false,
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'hierarchical' => false,
			'supports' => $supports
		 );
		 register_post_type( 'dc_streams' , $post_type_args );
	}

	
	/*
	 * Add custom CSS
	 */
	function header(){

		echo dcwss_custom_css();
		
		return;
	}
	
	function footer(){
		
		return;
	}
	
	function get_plugin_directory(){
		return plugins_url() . '/wordpress-social-stream';	
	}
}

// Initialize the plugin.
$dcjqsocialstream = new dc_jqsocialstream();

?>