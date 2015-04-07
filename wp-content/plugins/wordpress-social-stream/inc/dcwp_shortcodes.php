<?php

/* Social Stream */
function dc_social_feed_shortcode( $atts, $content = null ){

	extract( shortcode_atts( array(
	'id' => '',
	'twitterId' => '',
	'limit' => 50,
	'days' => 10,
	'max' => '',
	'external' => 'true',
	'style' => 'light',
	'speed' => 0.6,
	'height' => 550,
	'wall' => 'false',
	'order' => 'date',
	'filter' => 'true',
	'controls' => 'true',
	'remove' => '',
	'rotate_delay' => 8,
	'rotate_direction' => 'up',
	'cache' => 'true',
	'iconPath' => '/images/dcwss-dark/',
	'imagePath' => '/images/dcwss-light-1/',
	'debug' => 'false'
	), $atts ));
		
	$out = '';
	$networks = Array();
	$options = Array();
	$defaults = Array();
	$options = get_option('dcwss_options');
	$networks = dcwss_networks('networks');
	$settings = dcwss_networks('settings');
	$defaults = dcwss_networks('defaults');
	$stream = Array();
	$stream = dcwss_get_stream($id);
	$i = 0;
	$feeds = 'feeds: {';
	$params = '';
	$opt = '';
	$t1 = 0;
	$f1 = 0;
	if(isset($stream['remove'])){
		$remove = $stream['remove'];
	} else {
		$remove = '';
	}

//	print_r($atts);
	
	foreach($networks as $function=>$f){
					
		if($function != '' && $stream['feeds_'.$function.'_id'] != '' && $stream['feeds_'.$function.'_id'] != ' '){
			
			$feeds .= $i > 0 ? ','.$function.': {' : $function.': {' ;
			
			if($function == 'twitter' && $t1 == 0){
				$url_p = '?1='.trim($options['settings']['consumer_key']).'&2='.trim($options['settings']['consumer_secret']).'&3='.trim($options['settings']['access_token']).'&4='.trim($options['settings']['access_token_secret']);
				$feeds .= 'url: "'.dc_jqsocialstream::get_plugin_directory() . '/inc/dcwp_twitter.php'.$url_p.'",';
			//  multisite subdomain
			//	$feeds .= 'url: "' . get_bloginfo('url')  . '/wp-content/plugins/wordpress-social-stream/inc/dcwp_twitter.php'.$url_p.'",';	
				$t1 = 1;
			}
			
			if($function == 'facebook' && $f1 == 0){
				$feeds .= 'url: "'.dc_jqsocialstream::get_plugin_directory() . '/inc/dcwp_facebook.php",';
			//  multisite subdomain
			//	$feeds .= 'url: "' . get_bloginfo('url')  . '/wp-content/plugins/wordpress-social-stream/inc/dcwp_facebook.php",';	
				$f1 = 1;
			}
			
			$j = 0;
			foreach($defaults[$function] as $k=>$v){
				
				if($k == 'out'){
				
					$feeds .= ','.$k.': "intro';
					$section = explode(',', $defaults[$function][$k]);
					$m = 1;
					
					foreach($section as $s){
						$idv = $stream['feeds_'.$function.'_'.$k.'_'.$s] != '' ? $stream['feeds_'.$function.'_'.$k.'_'.$s] : $def ;
						$x = $m > 0 ? ',' : '' ;
						if($s != 'intro'){
							$feeds .= $stream['feeds_'.$function.'_'.$k.'_'.$s] == 'true' ? $x.$s : '' ;
						}
						$m++;						
					}
					
					$feeds .= '"';
											
				} else if ($k == 'feed'){
				
					$feeds .= ','.$k.': "';
					$section = explode(',', $defaults[$function][$k]);
					$m = 0;
					
					foreach($section as $s){
						$idv = $stream['feeds_'.$function.'_'.$k.'_'.$s] != '' ? $stream['feeds_'.$function.'_'.$k.'_'.$s] : $def ;
						$x = $m > 0 ? ',' : '' ;
						$feeds .= $stream['feeds_'.$function.'_'.$k.'_'.$s] == 'true' ? $x.$s : '' ;
						$m++;						
					}
					
					$feeds .= '"';
											
				} else {
					if(isset($stream['feeds_'.$function.'_'.$k])){
						if($function.'_'.$k == 'twitter_thumb' || $function.'_'.$k == 'twitter_retweets' || $function.'_'.$k == 'twitter_replies' || $function.'_'.$k == 'facebook_comments' || $function.'_'.$k == 'facebook_image_width' || $function.'_'.$k == 'facebook_thumb'){
							$feeds .= $j > 0 ? ','.$k.': '.$stream['feeds_'.$function.'_'.$k] : $k.': '.$stream['feeds_'.$function.'_'.$k] ;
						} else {
							$feeds .= $j > 0 ? ','.$k.': "'.$stream['feeds_'.$function.'_'.$k].'"' : $k.': "'.$stream['feeds_'.$function.'_'.$k].'"' ;
						}
					}
				}
				
				$j++;
			}
			$feeds .= '}';
			$i++;
		}
	}
	
	$feeds .= '}';
	
	// remove specific posts
	if(isset($atts['remove'])){
		$opt .= ',remove:"'.$atts['remove'].'"';
	} else {
		$opt .= ',remove:"'.$remove.'"';
	}

	// get settings
	if(isset($options['settings'])){
		foreach($options['settings'] as $k => $v)
		{
			switch($k)
			{
				case 'speed':
				if(isset($atts[$k])){
					$opt .= ',speed: '.$atts[$k]*1000 ;
				} else {
					$v = $v * 1000;
					$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
				}
				break;
				case 'controls':
				if(isset($atts[$k])){
					$opt .= ',controls: '.$atts[$k] ;
				} else {
					$opt .= $v != $settings[$k] ? ',controls: "false"' : '' ;
				}
				break;
				case 'max':
				if(isset($atts[$k])){
					$opt .= ',max: "'.$atts[$k].'"' ;
				} else {
					$opt .= $v != $settings[$k] ? ',max: "'.$v.'"' : '' ;
				}
				break;
				case 'order':
				if(isset($atts[$k])){
					$opt .= ',order: "'.$atts[$k].'"' ;
				} else {
					$opt .= $v != $settings[$k] ? ',order: "'.$v.'"' : '' ;
				}
				break;
				case 'results':
				if($atts['max'] == '') {
					if(isset($atts[$k])){
						$opt .= ',days: '.$atts[$k];
						$opt .= $options['settings']['max'] == 'limit' ? ',limit: '.$atts[$k] : ',limit: 100' ;
					} else {
						$opt .= ',days: '.$v;
						$opt .=  $options['settings']['max'] == 'limit' ? ',limit: '.$v : ',limit: 100' ;
					}
				} else {
					if($atts['max'] == 'days'){
						$opt .= ',limit: 100' ;
						$opt .= $atts[$k] != '' ? ',days: '.$atts[$k] : ',days: '.$options['settings']['results'] ;
					} else if($atts['max'] == 'limit'){
						$opt .= ',days: '.$options['settings']['results'] ;
						$opt .= $atts[$k] != '' ? ',limit: '.$atts[$k] : ',limit: '.$options['settings']['results'] ;
					}
				}
				break;
				case 'rotate_delay':
				break;
				case 'rotate_direction':
				break;
				case 'consumer_key':
				break;
				case 'consumer_secret':
				break;
				case 'access_token':
				break;
				case 'access_token_secret':
				break;
				case 'fb_app_id':
				break;
				case 'fb_app_secret':
				break;
				case 'cache':
				if(isset($atts[$k])){
					$opt .= ',cache: '.$atts[$k];
				} else {
					$opt .= $v != $settings[$k] ? ',cache: '.$v : '' ;
				}
				break;
				case 'filter':
				if(isset($atts[$k])){
					$opt .= ',filter: '.$atts[$k];
				} else {
					$opt .= $v != $settings[$k] ? ',filter: '.$v : '' ;
				}
				break;
				case 'twitterId':
				if(isset($atts[$k])){
					$opt .= ',twitterId: "'.$atts[$k].'"' ;
				} else {
					$opt .= $v != $settings[$k] ? ',twitterId: "'.$v.'"' : '' ;
				}
				break;
				default:
				if(isset($atts[$k])){
					$opt .= ','.$k.': '.$atts[$k];
				} else {
					$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
				}
				break;
			}
		}
	}
	
	$opt .= ',rotate: {delay: ';
	if(isset($atts['rotate_delay'])){
		$opt .= $atts['rotate_delay']*1000;
	} else {
		$v = $options['settings']['rotate_delay'] * 1000;
		$opt .= $v != $settings['rotate_delay'] ? $v : $settings['rotate_delay'];
	}
	$opt .= ', direction: "';
	if(isset($atts['rotate_direction'])){
		$opt .= $atts['rotate_direction'];
	} else {
		if(isset($options['settings']['rotate_direction'])){
		$opt .= $options['settings']['rotate_direction'] != $settings['rotate_direction'] ? $options['settings']['rotate_direction'] : $settings['rotate_direction'];
	}
	}
	$opt .= '"}';
	$iconPath = $style == 'dark' ? '/images/dcwss-dark/' : $iconPath ;
	$imagePath = $style == 'dark' ? '/images/dcwss-dark/' : $imagePath ;
	
	$config = '{'.$feeds.$opt;
	$config .= ',container: "dcwss",cstream: "stream",content: "dcwss-content"';
	$config .= ',imagePath: "'.dc_jqsocialstream::get_plugin_directory().$imagePath.'"';
	$config .= ',iconPath: "'.dc_jqsocialstream::get_plugin_directory().$iconPath.'"}';
	
	$out .='<script type="text/javascript">jQuery(document).ready(function($){';
	$out .= 'var config = '.$config.';';
	$out .= 'if(!jQuery().dcSocialStream) { $.getScript("'.dc_jqsocialstream::get_plugin_directory().'/js/jquery.social.stream.1.5.9.min.js", function(){$("#social-stream-'.$id.'").dcSocialStream(config);}); } else {';
	$out .= '$("#social-stream-'.$id.'.dc-feed").dcSocialStream(config);}});</script>'."\n";
	$out .= '<div id="social-stream-'.$id.'" class="dc-feed '.$style.'"></div>';
	
    return $out;
}

/* Social Stream */
function dc_social_wall_shortcode( $atts, $content = null ){

	extract( shortcode_atts( array(
	'id' => '',
	'twitterId' => '',
	'limit' => 50,
	'days' => 10,
	'cols' => 4,
	'max' => 'days',
	'external' => 'true',
	'speed' => 0.6,
	'height' => 550,
	'filter' => 'true',
	'controls' => 'true',
	'remove' => '',
	'order' => 'date',
	'rotate_delay' => 8,
	'rotate_direction' => 'up',
	'cache' => 'true',
	'iconPath' => '/images/dcwss-dark/',
	'imagePath' => '/images/dcwss-dark/',
	'debug' => 'false'
	), $atts ));
	
	$out = '';
	$networks = Array();
	$options = Array();
	$defaults = Array();
	$options = get_option('dcwss_options');
	$networks = dcwss_networks('networks');
	$settings = dcwss_networks('settings');
	$defaults = dcwss_networks('defaults');
	$stream = Array();
	$stream = dcwss_get_stream($id);
	$i = 0;
	$t1 = 0;
	$f1 = 0;
	$feeds = 'feeds: {';
	$params = '';
	$opt = '';
	if(isset($stream['remove'])){
		$remove = $stream['remove'];
	} else {
		$remove = '';
	}

//	print_r($atts);
	
	foreach($networks as $function=>$f){
					
		if($function != '' && $stream['feeds_'.$function.'_id'] != '' && $stream['feeds_'.$function.'_id'] != ' '){
			
			$feeds .= $i > 0 ? ','.$function.': {' : $function.': {' ;
			
			if($function == 'twitter' && $t1 == 0){
			$url_p = '?1='.trim($options['settings']['consumer_key']).'&2='.trim($options['settings']['consumer_secret']).'&3='.trim($options['settings']['access_token']).'&4='.trim($options['settings']['access_token_secret']);
			
			$feeds .= 'url: "'.dc_jqsocialstream::get_plugin_directory() . '/inc/dcwp_twitter.php'.$url_p.'",';

			//  multisite subdomain
			//	$feeds .= 'url: "' . get_bloginfo('url')  . '/wp-content/plugins/wordpress-social-stream/inc/dcwp_twitter.php'.$url_p.'",';			
				$t1 = 1;
			}
			
			if($function == 'facebook' && $f1 == 0){
				$feeds .= 'url: "'.dc_jqsocialstream::get_plugin_directory() . '/inc/dcwp_facebook.php",';
			//  multisite subdomain
			//	$feeds .= 'url: "' . get_bloginfo('url')  . '/wp-content/plugins/wordpress-social-stream/inc/dcwp_facebook.php",';	
				$f1 = 1;
			}

			$j = 0;
			foreach($defaults[$function] as $k=>$v){
				
				if($k == 'out'){
				
					$feeds .= ','.$k.': "intro';
					$section = explode(',', $defaults[$function][$k]);
					$m = 1;
					
					foreach($section as $s){
						$idv = $stream['feeds_'.$function.'_'.$k.'_'.$s] != '' ? $stream['feeds_'.$function.'_'.$k.'_'.$s] : $def ;
						$x = $m > 0 ? ',' : '' ;
						if($s != 'intro'){
							$feeds .= $stream['feeds_'.$function.'_'.$k.'_'.$s] == 'true' ? $x.$s : '' ;
						}
						$m++;						
					}
					
					$feeds .= '"';
											
				} else if ($k == 'feed'){
				
					$feeds .= ','.$k.': "';
					$section = explode(',', $defaults[$function][$k]);
					$m = 0;
					
					foreach($section as $s){					
						$idv = $stream['feeds_'.$function.'_'.$k.'_'.$s] != '' ? $stream['feeds_'.$function.'_'.$k.'_'.$s] : $def ;
						$x = $m > 0 ? ',' : '' ;
						$feeds .= $stream['feeds_'.$function.'_'.$k.'_'.$s] == 'true' ? $x.$s : '' ;
						$m++;						
					}
					
					$feeds .= '"';
											
				} else {
					if(isset($stream['feeds_'.$function.'_'.$k])){
						if($function.'_'.$k == 'twitter_thumb' || $function.'_'.$k == 'twitter_retweets' || $function.'_'.$k == 'twitter_replies' || $function.'_'.$k == 'facebook_comments' || $function.'_'.$k == 'facebook_image_width' || $function.'_'.$k == 'facebook_thumb'){
							$feeds .= $j > 0 ? ','.$k.': '.$stream['feeds_'.$function.'_'.$k] : $k.': '.$stream['feeds_'.$function.'_'.$k] ;
						} else {
							$feeds .= $j > 0 ? ','.$k.': "'.$stream['feeds_'.$function.'_'.$k].'"' : $k.': "'.$stream['feeds_'.$function.'_'.$k].'"' ;
						}
					}
				}
				
				$j++;
			}
			$feeds .= '}';
			$i++;
		}
	}
	
	$feeds .= '}';
	
	// remove specific posts
	if(isset($atts['remove'])){
		$opt .= ',remove:"'.$atts['remove'].'"';
	} else {
		$opt .= ',remove:"'.$remove.'"';
	}

	// get settings
	if(isset($options['settings'])){
		foreach($options['settings'] as $k => $v)
		{
			switch($k)
			{
				case 'speed':
				$v = $v * 1000;
				$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
				break;
				case 'controls':
				$opt .= $v != $settings[$k] ? ',controls: "false"' : '' ;
				break;
				case 'max':
				if(isset($atts[$k])){
					$opt .= ',max: "'.$atts[$k].'"' ;
				} else {
					$opt .= $v != $settings[$k] ? ',max: "'.$v.'"' : '' ;
				}
				break;
				case 'order':
				if(isset($atts[$k])){
					$opt .= ',order: "'.$atts[$k].'"' ;
				} else {
					$opt .= $v != $settings[$k] ? ',order: "'.$v.'"' : '' ;
				}
				break;
				case 'results':
				$atts['max'] = isset($atts['max']) ? $atts['max'] : '' ;
				if($atts['max'] == '') {
					if(isset($atts[$k])){
						$opt .= ',days: '.$atts[$k];
						$opt .= $options['settings']['max'] == 'limit' ? ',limit: '.$atts[$k] : ',limit: 100' ;
					} else {
						$opt .= ',days: '.$v;
						$opt .=  $options['settings']['max'] == 'limit' ? ',limit: '.$v : ',limit: 100' ;
					}
				} else {
					if($atts['max'] == 'days'){
						$opt .= ',limit: 100' ;
						$opt .= $atts[$k] != '' ? ',days: '.$atts[$k] : ',days: '.$options['settings']['results'] ;
					} else if($atts['max'] == 'limit'){
						$opt .= ',days: '.$options['settings']['results'] ;
						$opt .= $atts[$k] != '' ? ',limit: '.$atts[$k] : ',limit: '.$options['settings']['results'] ;
					}
				}
				break;
				case 'rotate_delay':
				break;
				case 'rotate_direction':
				break;
				case 'consumer_key':
				break;
				case 'consumer_secret':
				break;
				case 'access_token':
				break;
				case 'access_token_secret':
				break;
				case 'fb_app_id':
				break;
				case 'fb_app_secret':
				break;
				case 'cache':
				if(isset($atts[$k])){
					$opt .= ',cache: '.$atts[$k];
				} else {
					$opt .= $v != $settings[$k] ? ',cache: '.$v : '' ;
				}
				break;
				case 'filter':
				if(isset($atts[$k])){
					$opt .= ',filter: '.$atts[$k];
				} else {
					$opt .= $v != $settings[$k] ? ',filter: '.$v : '' ;
				}
				break;
				case 'twitterId':
				if(isset($atts[$k])){
					$opt .= ',twitterId: "'.$atts[$k].'"' ;
				} else {
					$opt .= $v != $settings[$k] ? ',twitterId: "'.$v.'"' : '' ;
				}
				break;
				default:
				if(isset($atts[$k])){
					$opt .= ','.$k.': '.$atts[$k];
				} else {
					$opt .= $v != $settings[$k] ? ','.$k.': '.$v : '' ;
				}
				break;
			}
		}
	}
	
	$opt .= ',rotate: {delay: 0';
	$opt .= ', direction: "';
	if(isset($options['settings']['rotate_direction'])){
		$opt .= $options['settings']['rotate_direction'] != $settings['rotate_direction'] ? $options['settings']['rotate_direction'] : $settings['rotate_direction'];
	}
	$opt .= '"}';
	
	$config = '{'.$feeds.$opt;
	$config .= ',wall: true,container: "dcwss",cstream: "stream",content: "dcwss-content"';
	$config .= ',imagePath: "'.dc_jqsocialstream::get_plugin_directory().$imagePath.'"';
	$config .= ',iconPath: "'.dc_jqsocialstream::get_plugin_directory().$iconPath.'"}';

	$out .='<script type="text/javascript">jQuery(document).ready(function($){';
	$out .= 'var config = '.$config.';';
	$out .= 'if(!jQuery().dcSocialStream) { $.getScript("'.dc_jqsocialstream::get_plugin_directory().'/js/jquery.social.stream.wall.1.6.js", function(){}); $.getScript("'.dc_jqsocialstream::get_plugin_directory().'/js/jquery.social.stream.1.5.9.min.js", function(){$("#social-stream-'.$id.'").dcSocialStream(config);}); } else {';
	$out .= '$("#social-stream-'.$id.'.dc-wall").dcSocialStream(config);}});</script>'."\n";
	$out .= '<div class="wall-outer"><div id="social-stream-'.$id.'" class="dc-wall col-'.$cols.'"></div></div>';

    return $out;
}

?>