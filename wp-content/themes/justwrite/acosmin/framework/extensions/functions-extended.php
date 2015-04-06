<?php
/* ------------------------------------------------------------------------- *
 *  Some functions to improve Options Framework
/* ------------------------------------------------------------------------- */




/*  Include Extended JS/CSS
/* ------------------------------------ */
function ac_widgets_panel_css() {
	
	// Some styles needed in the Widgets Panel
	wp_enqueue_style( 'ac_admin_widgets_panel', get_template_directory_uri() . '/acosmin/framework/extensions/css/admin-widgets-panel-css.css', false, '1.0.0' );
		
}
add_action( 'admin_print_styles-widgets.php', 'ac_widgets_panel_css' );




/*  Extend Sanitization Array
/* ------------------------------------ */
function ac_change_santiziation() {
    remove_filter( 'of_sanitize_textarea', 'of_sanitize_textarea' );
    add_filter( 'of_sanitize_textarea', 'ac_custom_sanitize_textarea' );
}

function ac_custom_sanitize_textarea($input) {
	global $allowedposttags;
	
	$custom_allowedtags["embed"] = array(
		"src" => array(),
      	"type" => array(),
      	"allowfullscreen" => array(),
      	"allowscriptaccess" => array(),
      	"height" => array(),
		"width" => array()
	);
	
	$custom_allowedtags["script"] = array(
		"type" => array(),
		"async" => array(),
		"src" => array(),
	);
	
	$allowedposttags["ins"] = array(
		"data-ad-client" => array(),
		"data-ad-slot" => array(),
		"class" => array(),
		"style" => array(),
	);
	
	$custom_allowedtags = array_merge($custom_allowedtags, $allowedposttags);
	$output = wp_kses( $input, $custom_allowedtags);
	
    return $output;
}
add_action('admin_init','ac_change_santiziation', 100);
?>