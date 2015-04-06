<?php
/* ------------------------------------------------------------------------- *
 *  These options are related only to JustWrite	
/* ------------------------------------------------------------------------- */


	
	
	// -----------------------------
	// Data
	// -----------------------------
	
	$slider_how_many = array(
		'3' 	=> __('Three', 'acosmin'),
		'4'		=> __('Four', 'acosmin'),
		'5'		=> __('Five', 'acosmin'),
		'6'		=> __('Six', 'acosmin'),
		'7' 	=> __('Seven', 'acosmin'),
		'8'		=> __('Eight', 'acosmin'),
		'9'		=> __('Nine', 'acosmin'),
		'10'	=> __('Ten', 'acosmin'),
	);
	
	$disable_elements = array(
		'comments' 	=> __('Comments globally.', 'acosmin'),
		'about'		=> __('"About The Author" box.', 'acosmin'),
		'credit'	=> __('Footer Credit Links', 'acosmin'),
	);

	$disable_elements_defaults = array(
		'comments' 	=> '0',
		'about' 	=> '0',
		'credit' 	=> '0',
	);
	
	//--------------------------------------------------------------------------
	

	// -----------------------------
	// Slider Tab
	// -----------------------------	
		
	$options[] = array(
		'name' => __('Slider', 'acosmin'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Information', 'acosmin'),
		'desc' => __('- You need at least 3 posts marked as featured for the slider to show up. </br>- When you post an article click on "Mark this post as featured". ', 'acosmin'),
		'type' => 'info');
		
	$options[] = array(
		'name' => __('Show Featured Posts Slider', 'acosmin'),
		'desc' => __('Check this box if you would like to display it.', 'acosmin'),
		'id' => 'ac_show_slider',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('How Many Posts?', 'acosmin'),
		'desc' => __('Select a number of posts you would like to display.', 'acosmin'),
		'id' => 'ac_slider_how_many',
		'std' => '3',
		'type' => 'select',
		'options' => $slider_how_many);
		
	$options[] = array(
		'name' => __('Auto Start', 'acosmin'),
		'desc' => __('Whether to autostart autoscrolling.', 'acosmin'),
		'id' => 'ac_slider_auto_start',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('Transition Delay', 'acosmin'),
		'desc' => __('The autoscrolling interval in milliseconds <strong>(only numbers)</strong>.', 'acosmin'),
		'id' => 'ac_slider_interval',
		'std' => '5000',
		'type' => 'text');
		
		
	// -----------------------------
	// Social Tab
	// -----------------------------
	
	$options[] = array(
		'name' => __('Social', 'acosmin'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Google Plus Page URL', 'acosmin'),
		'desc' => __('Example: <strong>https://plus.google.com/+acosmin</strong>', 'acosmin'),
		'id' => 'ac_gplus_url',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Facebook URL', 'acosmin'),
		'desc' => __('Example: <strong>https://www.facebook.com/acosmincom</strong>', 'acosmin'),
		'id' => 'ac_facebook_url',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Twitter Username', 'acosmin'),
		'desc' => __('Example: <strong>acosmin</strong>', 'acosmin'),
		'id' => 'ac_twitter_username',
		'std' => '',
		'type' => 'text');
		
	
	// -----------------------------
	// Advertising Tab
	// -----------------------------
		
	$options[] = array(
		'name' => __('Advertising', 'acosmin'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Information', 'acosmin'),
		'desc' => __('- You need at least 3 posts marked as featured for the slider to show up. </br>- When you post an article click on "Mark this post as featured". ', 'acosmin'),
		'type' => 'info');
		
	$options[] = array(
		'name' => __('728x90px Ad', 'acosmin'),
		'desc' => __('Show this banner. Add the code in the following box', 'acosmin'),
		'id' => 'ac_ad728_show',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('728x90px Ad HTML Code', 'acosmin'),
		'desc' => __('Add your banner\'s code. Example: <strong>Google Adsense or a simple HTML banner</strong>', 'acosmin'),
		'id' => 'ac_ad728_code',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('160x600px Ad', 'acosmin'),
		'desc' => __('Show this banner. Add the code in the following box', 'acosmin'),
		'id' => 'ac_ad160_show',
		'std' => '0',
		'type' => 'checkbox');
		
	$options[] = array(
		'name' => __('160x600px Ad HTML Code', 'acosmin'),
		'desc' => __('Add your banner\'s code. This banner will show up in the left sidebar on screen resolutions higher than 1600px. Example: <strong>Google Adsense or a simple HTML banner</strong>', 'acosmin'),
		'id' => 'ac_ad160_code',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('160x600px Title:', 'acosmin'),
		'desc' => __('Example: <strong>Advertising</strong>. Leave this blank if you don\'t want a title.', 'acosmin'),
		'id' => 'ac_ad160_title',
		'std' => '',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('160x600px Title Link:', 'acosmin'),
		'desc' => __('Example: <strong>http://yoursite.com/advertising/', 'acosmin'),
		'id' => 'ac_ad160_url',
		'std' => '',
		'type' => 'text');
		
	// -----------------------------
	// More Settings Tab
	// -----------------------------
	
	$options[] = array(
		'name' => __('More Settings', 'acosmin'),
		'type' => 'heading');
		
	$options[] = array(
		'name' => __('Disable', 'acosmin'),
		'desc' => __('These elements won\'t show up if you check the boxes.', 'acosmin'),
		'id' => 'ac_disable_elements',
		'std' => $disable_elements_defaults,
		'type' => 'multicheck',
		'options' => $disable_elements);

?>