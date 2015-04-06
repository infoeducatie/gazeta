<?php

/***************************************/

error_reporting(E_ALL ^ E_NOTICE);

if(empty($_GET['username'])) 
	die('The username is required');

//Include Configuration
require_once (dirname (__FILE__) . '/../../../../wp-load.php');
global $dpSocialTimeline;

$username = $_GET['username'];
$count = $_GET['count'];

$client_ID =  $dpSocialTimeline['instagram_client_id'];

if($count == "" || $count <= 0) 
	$count = 20;

require_once 'instagram.class.php';

// Initialize class with client_id
// Register at http://instagram.com/developer/ and replace client_id with your own
$instagram = new SocialTimelineInstagram($client_ID);

// Set keyword for #hashtag
$user = $item_id;
$userid = $instagram->searchUser($username);
$counter = 0;
if(is_array($userid->data)) {
	foreach($userid->data as $key => $value) {
		if($value->username == $username) {
			$userid_filter = $userid->data[$counter]->id;
		}
		$counter++;
	}
}
// Get latest photos according to #hashtag keyword
$media = $instagram->getUserMedia($userid_filter, $count);

$count = 0;
$json_format = '{"responseData": {"feed":{"feedUrl": "http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'","title":"Instagram / '.$username.'","link":"http://instagram.com/'.$username.'","author":"","description":"Instagram updates from '.$username.' / '.$username.'.","type":"rss20","entries":[';
if(is_array($media->data)) {
foreach($media->data as $row)
{

	if($count > 0) {
		$json_format .= ',';	
	}
	$attached = "";
	$attached .= ' <img alt="" src="'.$row->images->standard_resolution->url.'" /> ';

	$json_format .= '{"title":' . json_encode($row->caption->text) . ',"link":"'.$row->link.'","author":"'.$row->user->username.'","publishedDate":"' . date("D, d M Y H:i:s O", $row->created_time) . '","contentSnippet":' . json_encode($row->caption->text.$attached) . ',"content":' . json_encode($row->caption->text.$attached) . ',"categories":[]}';
	$count++;
}
}
$json_format .= ']}}, "responseDetails": null, "responseStatus": 200}';

header("Content-Type: application/json; charset=UTF-8");
echo $json_format;
?>