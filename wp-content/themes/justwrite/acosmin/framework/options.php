<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'acosmin'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/acosmin/framework/images/';
	$imagepath_extensions =  get_template_directory_uri() . '/acosmin/framework/extensions/images/';
	
	$options = array();

	$options[] = array(
		'name' => __('Basic Settings', 'acosmin'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Information', 'acosmin'),
		'desc' => __('- You can upload a logo and see it live by using the', 'acosmin') . ' <a href="' . get_admin_url() . '/customize.php">' . __('Theme Customizer', 'acosmin') . '</a>. <br />',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Favicon', 'options_framework_theme'),
		'desc' => __('Upload a favicon image for your website. <strong>(16x16px)</strong>', 'acosmin'),
		'id' => 'ac_favicon_desktop',
		'type' => 'upload');
	
	$options[] = array(
		'name' => __('Custom RSS Feed Url:', 'acosmin'),
		'desc' => __('Ex: <strong>http://feeds.feedburner.com/acosmin</strong>', 'acosmin'),
		'id' => 'ac_custom_rss_url',
		'std' => '',
		'type' => 'text');

	/* ------------------------------------------------------------------- */
	
	$ac_theme_options = apply_filters( 'ac_other_theme_options', array( 'acosmin/framework/extensions/options-theme.php' ) );
	if ( $other_theme_options_file = locate_template( $ac_theme_options ) ) {
		$maybe_other_theme_options = require_once $other_theme_options_file;
	}

	return $options;
}