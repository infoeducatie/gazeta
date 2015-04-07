<?php

function dcwss_networks($a)
{

	$networks = Array();
	$networks = Array('twitter' => 'Twitter', 'facebook' => 'Facebook','google' => 'Google +1','rss' => 'RSS Feed','flickr' => 'Flickr Feed','delicious' => 'Delicious','youtube' => 'YouTube','pinterest' => 'Pinterest','lastfm' => 'last.fm','dribbble' => 'Dribbble','vimeo' => 'Vimeo','stumbleupon' => 'Stumbleupon','deviantart' => 'Deviantart','tumblr' => 'Tumblr','instagram' => 'Instagram');
	
	$Ids = Array();
	$Ids = Array('twitter' => 'Enter twitter username, list ID or search term', 'facebook' => 'Enter Facebook Page ID or gallery ID','google' => 'Enter Google +1 User ID','rss' => 'Enter RSS Feed URL','flickr' => 'Enter Flickr User ID or Group ID','delicious' => 'Enter Delicious Username','youtube' => 'Enter YouTube Username,search term or playlist','pinterest' => 'Enter Pinterest Username or board','lastfm' => 'Enter last.fm Username','dribbble' => 'Enter Dribbble Username','vimeo'=> 'Enter Vimeo username','stumbleupon'=> 'Enter Stumbleupon username','deviantart' => 'Enter Deviantart Username','tumblr' => 'Enter Tumblr Username','instagram' => 'Enter user ID, location ID, search tag or location');
	
	$settings = Array();
	$settings = Array(
		'days' => 10,
		'limit' => 50,
		'max' => 'days',
		'external' => 'true',
		'speed' => 0.6,
		'height' => 550,
		'wall' => 'false',
		'order' => 'date',
		'filter' => 'true',
		'controls' => 'true',
		'rotate_direction' => 'up',
		'rotate_delay' => 6,
		'cache' => 'true',
		'iconPath' => '',
		'imagePath' => '',
		'twitterId' => '',
		'consumer_key' => '',
		'consumer_secret' => '',
		'access_token' => '',
		'access_token_secret' => '',
		'fb_app_id' => '',
		'fb_app_secret' => '');
		
	$defaults = Array();
	$defaults['twitter'] = Array('id' => '', 'intro' => 'Tweeted', 'search' => 'Tweeted', 'images' => '', 'thumb' => 'false', 'retweets' => 'false', 'replies' => 'false', 'out' => 'intro,thumb,text,share');
	$defaults['facebook'] = Array('id' => '', 'intro' => 'Posted', 'comments' => '3', 'image_width' => '6', 'out' => 'intro,thumb,title,text,user,share');
	$defaults['google'] = Array('id' => '', 'intro' => 'Shared', 'out' => 'intro,thumb,title,text,share', 'api_key' => '');
	$defaults['youtube'] = Array('id' => '', 'intro' => 'Uploaded,Favorite,New Video', 'search' => 'Search', 'thumb' => 'default', 'out' => 'intro,thumb,title,text,user,share', 'feed' => 'uploads,favorites,newsubscriptionvideos');
	$defaults['flickr'] = Array('id' => '', 'intro' => 'Uploaded', 'out' => 'intro,thumb,title,share');
	$defaults['delicious'] = Array('id' => '', 'intro' => 'Bookmarked', 'out' => 'intro,thumb,title,text,user,share');
	$defaults['pinterest'] = Array('id' => '', 'intro' => 'Pinned', 'out' => 'intro,thumb,text,user,share');
	$defaults['rss'] = Array('id' => '', 'intro' => 'Posted', 'out' => 'intro,title,text,share', 'text' => 'contentSnippet');
	$defaults['lastfm'] = Array('id' => '', 'intro' => 'Listened to,Loved,Replied', 'out' => 'intro,thumb,title,text,user,share', 'feed' => 'recenttracks,lovedtracks,replytracker');
	$defaults['dribbble'] = Array('id' => '', 'intro' => 'Posted shot,Liked', 'out' => 'intro,thumb,title,text,user,share', 'feed' => 'shots,likes');
	$defaults['vimeo'] = Array('id' => '', 'intro' => 'Liked,Video,Appeared In,Video,Album,Channel,Group', 'out' => 'intro,thumb,title,text,user,share', 'feed' => 'likes,videos,appears_in,all_videos,albums,channels,groups', 'thumb' => 'medium');
	$defaults['stumbleupon'] = Array('id' => '', 'intro' => 'Shared,Reviewed', 'out' => 'intro,thumb,title,text,user,share', 'feed' => 'favorites,reviews');
	$defaults['deviantart'] = Array('id' => '', 'intro' => 'Deviation', 'out' => 'intro,thumb,title,text,user,share');
	$defaults['tumblr'] = Array('id' => '', 'intro' => 'Posted', 'out' => 'intro,thumb,title,text,user,share', 'thumb'=>'100', 'video'=>'250');
	$defaults['instagram'] = Array('id' => '', 'intro' => 'Posted', 'search' => 'Search', 'out' => 'intro,thumb,text,user,share,meta', 'accessToken'=>'', 'redirectUrl'=>'', 'clientId' => '', 'comments' => '3', 'likes' => '8');
	
	$help = Array();
	$help['twitter'] = Array('id' => '1. Enter a twitter username without the "@"<br />2. To use a twitter list enter "/" followed by the list ID - e.g. /123456<br />3. To search enter "#" followed by the search terms - e.g. #designchemical', 'intro' => 'Text for feed item link', 'search' => 'Text for search item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-thumb' => 'Include profile avatar', 'out-share' => 'Include share links', 'retweets' => 'Include retweets', 'replies' => 'Include replies', 'images' => 'Include Twitter images');
	$help['facebook'] = Array('id' => '1. Facebook page wall posts - Enter the page ID<br />2. Facebook page gallery images -<br />Enter the text you would like to show for the gallery name followed by "/" followed by the gallery ID -<br />
    e.g. "Facebook Timeline/376995711728<br />Enter multiple IDs separated by commas', 'intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Wall post text', 'out-user' => 'Display user name', 'out-share' => 'Include share links', 'comments' => 'Enter number of comments to show for facebook album posts (max 25)<br />Set to 0 to disable comments', 'image_width' => 'Select image width for facebook album posts');
	$help['google'] = Array('id' => '1. Enter your Google +1 profile ID<br />Enter multiple IDs separated by commas', 'intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-share' => 'Include share links', 'api_key' => 'Google API KEY - required');
	$help['youtube'] = Array('id' => '1. Enter a youtube username<br />2. To search enter "#" followed by the search terms - e.g. #music<br />3. Youtube playlist - Enter the text you would like to show for the playlist name followed by "/" then the playlist ID -<br />e.g. "Playlist Title/8BCDD04DE8F771B2"', 'intro' => 'Text for feed item link', 'search' => 'Text for search item link', 'thumb' => 'Select image size', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-share' => 'Include share links', 'feed' => 'Data feed to be shown', 'out-user' => 'Display user name');
	$help['flickr'] = Array('id' => '1. Enter a Flickr username ID<br />2. To use a flickr group enter "/" followed by the group ID - e.g. /646972@N21<br /> Enter multiple usernames/groups separated by commas', 'intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-share' => 'Include share links');
	$help['delicious'] = Array('id' => '1. Enter a Delicious username<br />Enter multiple usernames separated by commas','intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['pinterest'] = Array('id' => '1. Enter a Pinterest username<br />2. To show a Pinterest board enter the username, then "/" followed by the board name - e.g. jaffrey/social-media<br />Enter multiple usernames separated by commas', 'intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['rss'] = Array('id' => '1. Enter the URL for the RSS feed<br />Enter multiple URLs separated by commas', 'intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-share' => 'Include share links', 'text' => 'Display snippet or complete text');
	$help['lastfm'] = Array('id' => '1. Enter a last.fm username<br />Enter multiple usernames separated by commas', 'intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'feed' => 'Data feed to be shown', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['dribbble'] = Array('id' => '1. Enter a Dribbble username<br />Enter multiple usernames separated by commas','intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'feed' => 'Data feed to be shown', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['vimeo'] = Array('id' => '1. Enter a Vimeo username<br />Enter multiple usernames separated by commas','intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'feed' => 'Data feed to be shown', 'thumb' => 'Size of thumbnail image', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['stumbleupon'] = Array('id' => '1. Enter a Stumbleupon username<br />Enter multiple usernames separated by commas','intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'feed' => 'Data feed to be shown', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['deviantart'] = Array('id' => '1. Enter a Deviantart username<br />Enter multiple usernames separated by commas','intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-user' => 'Display user name', 'out-share' => 'Include share links');
	$help['tumblr'] = Array('id' => '1. Enter a Tumblr username<br />Enter multiple usernames separated by commas','intro' => 'Text for feed item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Thumbnail (if available)', 'out-text' => 'Text block', 'out-user' => 'Display user name', 'out-share' => 'Include share links','thumb'=>'Width of thumbnail image - enter 75, 100, 250, 400, 500, or 1280','video'=>'Width of inline video player - enter 250, 400 or 500');
	$help['instagram'] = Array('id' => '1. Enter a user ID starting with a "!" - e.g. !12345<br />2. To search by tag start with the character "#" followed by the tag - e.g. #london<br />3. To show latest posts by a location ID start with a "@" followed by the ID - e.g. @12345<br />4. To search by geographical location start with the character "?" followed by the latitude, longitude and distance in meters (up to a maximum of 5000) all separated by a "/" - e.g. ?55.5/0/20', 'intro' => 'Text for feed item link', 'search' => 'Text for search item link', 'out' => 'Content to include in stream output', 'out-intro' => 'Item summary - icon, link & date', 'out-title' => 'Feed item title', 'out-thumb' => 'Instagram image', 'out-text' => 'Text block', 'out-user' => 'Display user name', 'out-share' => 'Include share links', 'out-meta' => 'Display likes and/or comments', 'comments' => 'Number of comments to display', 'likes' => 'Number of likes to display');
	
	if($a == 'networks'){
		return $networks;
	} else if($a == 'defaults'){
		return $defaults;
	} else if($a == 'settings'){
		return $settings;
	} else if($a == 'help'){
		return $help;
	} else {
		return $Ids;
	}
}

function dcwss_default_pickers()
{
	$out = Array('twitter' => '#4ec2dc', 'facebook' => '#3b5998','google' => '#2d2d2d','rss' => '#FF9800','flickr' => '#f90784','delicious' => '#3271CB','youtube' => '#DF1F1C','pinterest' => '#CB2528','lastfm' => '#C90E12','dribbble' => '#F175A8', 'vimeo' => '#4EBAFF', 'stumbleupon' => '#EB4924', 'deviantart' => '#607365', 'tumblr' => '#385774', 'instagram' => '#413A33', 'dcwss' => '#E5E5E5', 'dcwss-li' => '#FFFFFF');
	return $out;
}

function dcwss_custom_css()
{

	$options = get_option('dcwss_options');
	$networks = dcwss_networks('networks');
	$def_color = dcwss_default_pickers();
	$out = '';
	
	// networks
	foreach($networks as $k => $v){
		$c = $options['color_'.$k] != '' ? $options['color_'.$k] : $def_color[$k];
		$out .= '.stream li.dcsns-'.$k.' .section-intro,.filter .f-'.$k.' a:hover, .wall-outer .dcsns-toolbar .filter .f-'.$k.' a.iso-active{background-color:'.$c.'!important;}';
	}
		
	// tabs
	$c = $options['color_tab'] != '' ? $options['color_tab'] : '#777';
	$out .= '.wall-outer .dcsns-toolbar .filter li a {background:'.$c.';}';
	
	// fixed widths
	if($options['fixed'] == 'true'){
		$fw = $options['fixed_width'] != '' ? $options['fixed_width'] . 'px!important;' : '226px!important;' ;
		$mt = $options['fixed_margin_top'] != '' ? $options['fixed_margin_top'] . 'px ' : '0 ' ;
		$mr = $options['fixed_margin_right'] != '' ? $options['fixed_margin_right'] . 'px ' : '15px ' ;
		$mb = $options['fixed_margin_bottom'] != '' ? $options['fixed_margin_bottom'] . 'px ' : '15px ' ;
		$ml = $options['fixed_margin_left'] != '' ? $options['fixed_margin_left'] . 'px!important;' : '0!important;' ;
		$out .= '.dcwss.dc-wall .stream li {width: ' . $fw . ' margin: ' . $mt . $mr . $mb . $ml . '}';
	}

	// custom css
	$out .= $options['css'] != '' ? $options['css'] . "\n" : '' ;

	// Output styles
	if ($out != '') {
			$out = $out != '' ? "<!-- Custom Styling Social Stream -->\n<style type=\"text/css\">\n" . $out . "</style>\n" : '' ;
	}
		
	return $out;
}

function get_dcwss_default($option)
{
	$options = get_option('dcwss_options');
	return $options[$option];
}

function dcwss_switch($v, $name, $id = null)
{
	$out = '<div class="dcwss-switch-link">';
	$out .= '<a href="#" rel="true" class="link-true ';
	$out .= $v == 'true' ? 'active' : '' ;
	$out .= '"></a>';
	$out .= '<a href="#" rel="false" class="link-false ';
	$out .= $v == 'false' ? 'active' : '' ;
	$out .= '"></a></div>';
	$out .= '<input id="'.$id.'" name="'.$name.'" class="dc-switch-value" type="hidden" value="'.$v.'" />';
	
	return $out;
}

function dcwss_select($f, $k, $v, $o)
{
	
	$out = '<select name="dcwss_options['.$f.']['.$k.']" id="dcwss_'.$f.'_'.$k.'" class="select">';
	
	foreach($o as $opt => $name){
		$select = $v == $opt ? ' selected="selected"' : '' ;
		$out .= '<option value="'.$opt.'"'.$select.'>'.$name.'</option>';
	}
	$out .= '</select>';
	
	return $out;
}

function dcwss_streams($v)
{
	$args = array(
		'post_type'			=>	'dc_streams',
		'orderby'			=>	'menu_order',
		'order'				=>	'DESC',
		'nopaging'			=> 'true'
	);
	
	$wp_query = new WP_Query( $args );
	
	$options = '';
	
	while ($wp_query->have_posts()) : $wp_query->the_post();
		
		if(get_the_content(get_the_ID()) != ''){
			$select = $v == get_the_ID() ? ' class="selected"' : '' ;
			
			$x = get_post(); 
		
			$abc = explode('&',str_replace('"','',$x->post_content));
			foreach($abc as $c){
				$ps = explode('=',$c);
				$results[$ps[0]] = $ps[1];
			}
			
			$options .= '<tr rel="'.get_the_ID().'"'.$select.'><td>'.get_the_ID().'</td><td>'.$results['name'].'</td><td><pre>[dc_social_feed id="'.get_the_ID().'"]</pre></td><td><pre>[dc_social_wall id="'.get_the_ID().'"]</pre></td><td align="center" style="white-space:nowrap;"><a href="options-general.php?page=social-stream&stream='.get_the_ID().'"><img src="'.dc_jqsocialstream::get_plugin_directory().'/images/edit.png" alt="edit" /></a><a href="#" class="dc-stream-delete" rel="'.get_the_ID().'"><img src="'.dc_jqsocialstream::get_plugin_directory().'/images/delete.png" alt="delete" /></a></td></tr>';
		}
		
	endwhile;
			
	wp_reset_postdata();
	
	$out = $options != '' ? '<table width="100%" cellpadding="0" cellspacing="0" border="0" id="dcwss-tbl"><thead><tr><th>ID</th><th width="100%">Name</th><th>Feed Shortcode</th><th>Wall Shortcode</th><th>&nbsp;</th></tr></thead>'.$options.'</table>' : '<p>No saved streams</p>' ;
	
	return $out;
}

function dcwss_get_stream($id)
{
	$results = Array();
	
	if($id != ''){
		
		$x = get_post($id); 
		$content = $x->post_content;

		$abc = explode('&',str_replace('"','',$x->post_content));
			foreach($abc as $c){
				$ps = explode('=',$c);
				$results[$ps[0]] = $ps[1];
			}
	}

	return $results;
	
}

function dcwss_stream_select($n, $o, $v)
{
	
	$out = '<select name="'.$n.'" class="select">';
	
	foreach($o as $opt => $name){
		$select = $v == $opt ? ' selected="selected"' : '' ;
		$out .= '<option value="'.$opt.'"'.$select.'>'.$name.'</option>';
	}
	$out .= '</select>';
	
	return $out;
}

function dcwss_insert_stream(){

	  $postId = $_POST['post_id'];
	  $video = $_POST['video'];
	  
	  // Create post object
	  $my_post = array(
		 'post_title' => 'Title',
		 'post_content' => '',
		 'post_status' => 'publish',
		 'post_author' => 1,
		 'post_type' => 'Stream'
	  );

	// Insert the post into the database
	$id = wp_insert_post( $my_post );

    die();
}

/* Time since function taken from WordPress.com */
if (!function_exists('dcwss_wpcom_time_since')) :

function dcwss_wpcom_time_since( $original, $do_more = 0 ) {
        // array of time period chunks
        $chunks = array(
                array(60 * 60 * 24 * 365 , 'yr'),
                array(60 * 60 * 24 * 30 , 'month'),
                array(60 * 60 * 24 * 7, 'week'),
                array(60 * 60 * 24 , 'day'),
                array(60 * 60 , 'hr'),
                array(60 , 'min'),
        );

        $today = time();
        $since = $today - $original;

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                $seconds = $chunks[$i][0];
                $name = $chunks[$i][1];

                if (($count = floor($since / $seconds)) != 0)
                    break;
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

        if ($i + 1 < $j) {
                $seconds2 = $chunks[$i + 1][0];
                $name2 = $chunks[$i + 1][1];

                // add second item if it's greater than 0
                if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
                        $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
        $print = $print == '42 yrs' ? '' : $print ;
		return $print;
}
endif;

?>