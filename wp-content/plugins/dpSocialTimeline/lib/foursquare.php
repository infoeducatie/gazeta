<?php
error_reporting(E_ALL ^ E_NOTICE);

$count = 0;

if(empty($_GET['url'])) 
	die('The url is required');

$url = urldecode($_GET['url']);
$fileContents= file_get_contents($url);

$fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);

$fileContents = trim(str_replace('"', "'", $fileContents));

$simpleXml = simplexml_load_string($fileContents);
/*$simpleXml->feed = $simpleXml->channel;
print_r($simpleXml->channel);
$simpleXml->feed->entries = $simpleXml->channel->item;
print_r($simpleXml);
die();*/
//echo str_replace("foursquare checkin history for ", "", $simpleXml->channel->title);
$json = str_replace('"title"', '"author":"'.str_replace("foursquare checkin history for ", "", $simpleXml->channel->title).'","title"', str_replace('"pubDate"', '"publishedDate"', str_replace('"item"', '"entries"', str_replace('"channel"', '"feed"', json_encode($simpleXml)))));

$json_format = '{"responseData": '.$json.', "responseDetails": null, "responseStatus": 200}';

header("Content-Type: application/json; charset=UTF-8");
echo $json_format;
?>