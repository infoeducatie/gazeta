<?php
error_reporting(E_ALL ^ E_NOTICE);

if(empty($_GET['page_id'])) 
	die('The FB Page ID is required');
	
$screen_name_data = $_GET['page_id'];
$count = $_GET['count'];

if($count == "" || $count <= 20) 
	$count = 20;

//Include Configuration
require_once (dirname (__FILE__) . '/../../../../wp-load.php');
global $dpSocialTimeline;

require_once( 'Facebook/facebook.php' );

$facebook = new FacebookGraphV2(array(
  'appId'  => $dpSocialTimeline['facebook_app_id'],
  'secret' => $dpSocialTimeline['facebook_app_secret'],
));

$response = $facebook->api('/'.$screen_name_data.'/posts', 'get', array('limit' => $count));
$graph_arr = $response['data'];
if(empty($response['data'])) {
	$response = $facebook->api('/'.$screen_name_data.'/feed', 'get', array('limit' => $count));
	$graph_arr = $response['data'];
}
/*
echo '<pre>';
print_r($graph_arr);
echo '</pre>';
*/
$count = 0;
$json_decoded = array();

$json_decoded['responseData']['feed']['link'] = "https://facebook.com/".$screen_name_data;
$json_decoded['responseData']['feed']['entries'] = array();

if(is_array($graph_arr)) {
	/*echo '<pre>';
	print_r($graph_arr);
	echo '</pre>';*/
	foreach($graph_arr as $data)
	{
		$picture = $data['picture'];
		
		if(!isset($data['object_id'])) {
			$pic_id = explode("_", $picture);	
			$data['object_id'] = $pic_id[1];
		}
		
		if(strpos($picture, 'safe_image.php') === false && is_numeric($data['object_id'])) {
			$picture = 'http://graph.facebook.com/'.$data['object_id'].'/picture?type=normal';
		}
		
		if($data['message'] == '') {
			$data['message'] = $data['description'];	
		}
		
		if($data['source'] != '') {
			$data['message'] .= '<video width="480" height="320" controls="controls">
			<source src="'.str_replace('https', 'nolink', $data['source']).'" type="video/mp4">
			</video>';	
		}
		
		if(($data['message'] == '' && $picture == '') || (is_numeric($_GET['count']) && $count >= $_GET['count'])) {
			continue;
		}
		/*$picture = str_replace(array("s130x130/", "p130x130/", "p118x90/"), '', $data['picture']);
		$picture = str_replace('/v/t1.0-0/', '/t1.0-0/', $picture);
		$picture = str_replace('/v/t1.0-9/', '/t1.0-9/', $picture);
		$picture = str_replace('/v/l/t1.0-0/', '/t1.0-0/', $picture);
		$picture = str_replace('/v/l/t1.0-9/', '/t1.0-9/', $picture);
		$picture = str_replace('/192x/', '/736x/', $picture);*/
		
		$json_decoded['responseData']['feed']['entries'][$count]['link'] = ($data['link'] != "" ? $data['link'] : "https://facebook.com/".$data['id']);
		$json_decoded['responseData']['feed']['entries'][$count]['contentSnippet'] = $data['message'];
		$json_decoded['responseData']['feed']['entries'][$count]['content'] = $data['message'];
		$json_decoded['responseData']['feed']['entries'][$count]['title'] = $data['message'];
		$json_decoded['responseData']['feed']['entries'][$count]['thumbnail'] = $picture;
		$json_decoded['responseData']['feed']['entries'][$count]['author'] = $data['from']['name'];
		$json_decoded['responseData']['feed']['entries'][$count]['publishedDate'] = date("D, d M Y H:i:s O", strtotime($data['created_time']));
		
		$count++;
	}
}

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($json_decoded);
?>