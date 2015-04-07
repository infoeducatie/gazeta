<?php
error_reporting(E_ALL ^ E_NOTICE);

if(!isset($_GET['q'])) 
	die('The search value is required');

require_once (dirname (__FILE__) . '/../../../../wp-load.php');

$twitter_q = $_GET['q'];
$count = $_GET['count'];
if($count == "" || $count <= 0) 
	$count = 20;

//Include Configuration
global $dpSocialTimeline;

function dpSocialTimeline_buildBaseString($baseURI, $method, $params) {
    $r = array();
    ksort($params);
    foreach($params as $key=>$value){
        $r[] = "$key=" . rawurlencode($value);

    }

    return  $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
}

function dpSocialTimeline_buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = array();
    foreach($oauth as $key=>$value)
        $values[] = "$key=\"" . rawurlencode($value) . "\"";
    $r .= implode(', ', $values);
    return $r;
}

$url = "https://api.twitter.com/1.1/search/tweets.json";

$oauth_access_token = $dpSocialTimeline['twitter_access_token'];
$oauth_access_token_secret = $dpSocialTimeline['twitter_access_secret'];
$consumer_key = $dpSocialTimeline['twitter_consumer_key'];
$consumer_secret = $dpSocialTimeline['twitter_consumer_secret'];

$oauth = array( 'q' => $twitter_q,
				'count' => $count,
				'oauth_consumer_key' => $consumer_key,
                'oauth_nonce' => time(),
                'oauth_signature_method' => 'HMAC-SHA1',
                'oauth_token' => $oauth_access_token,
                'oauth_timestamp' => time(),
                'oauth_version' => '1.0');

$base_info = dpSocialTimeline_buildBaseString($url, 'GET', $oauth);
$composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
$oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
$oauth['oauth_signature'] = $oauth_signature;

// Make Requests
$header = array(dpSocialTimeline_buildAuthorizationHeader($oauth), 'Expect:');
$options = array( CURLOPT_HTTPHEADER => $header,
                  //CURLOPT_POSTFIELDS => $postfields,
                  CURLOPT_HEADER => false,
                  CURLOPT_URL => $url . '?q='.rawurlencode($twitter_q).'&count='.$count, 
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_SSL_VERIFYPEER => false);

$feed = curl_init();
curl_setopt_array($feed, $options);
$json = curl_exec($feed);
curl_close($feed);

$twitter_data = json_decode($json);
$count = 0;
$json_format = '{"responseData": {"feed":{"feedUrl": "http://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"].'","title":"Twitter Search / '.$twitter_q.'","link":"http://search.twitter.com/search?q='.$twitter_q.'","author":"","description":"Twitter Search / '.$twitter_q.'","type":"rss20","entries":[';
if(is_array($twitter_data->statuses)) {
	foreach($twitter_data->statuses as $row) {
		if($count > 0) {
			$json_format .= ',';	
		}
		$media = $row->entities->media;
		$attached = "";
		if(!empty($media)) {
			foreach($media as $key) {
				$attached .= ' <img alt="" src="'.$key->media_url.'" /> ';
			}
		}
		$json_format .= '{"title":' . json_encode($row->text) . ',"link":"http://twitter.com/'.$row->user->screen_name.'/statuses/'.$row->id_str.'","author":"'.$row->user->screen_name.'","profile_image_url":"'.$row->user->profile_image_url.'","publishedDate":"' . date("D, d M Y H:i:s O", strtotime($row->created_at)) . '","contentSnippet":' . json_encode($row->text.$attached) . ',"content":' . json_encode($row->text.$attached) . ',"categories":[]}';
		$count++;
	}
}
$json_format .= ']}}, "responseDetails": null, "responseStatus": 200}';

header("Content-Type: application/json; charset=UTF-8");
echo $json_format;
?>