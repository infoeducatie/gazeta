<?php

$access_token = '611606915581035|RdRHbHtrHseQw4C7SDUBFWIrJLA';

//Include this function as it isn't automatically included if the wp-config.php file can't be found
function cff_fetchUrl($url){
    //Can we use cURL?
    if(is_callable('curl_init')){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate,sdch');
        $feedData = curl_exec($ch);
        curl_close($ch);
    //If not then use file_get_contents
    } elseif ( ini_get('allow_url_fopen') == 1 || ini_get('allow_url_fopen') === TRUE ) {
        $feedData = @file_get_contents($url);
    //Or else use the WP HTTP API
    } else {
        if( !class_exists( 'WP_Http' ) ) include_once( ABSPATH . WPINC. '/class-http.php' );
        $request = new WP_Http;
        $result = $request->request($url);
        $feedData = $result['body'];
    }
    
    return $feedData;
}


//Get Post ID
$post_id = $_GET['id'];
//Which meta type should we query?
$metaType = $_GET['type'];
if ($metaType == 'likes'){
   $row = 'like_info';
   $cell = 'like_count';
} else if ($metaType == 'comments'){
   $row = 'comment_info';
   $cell = 'comment_count';
}
$json_object = cff_fetchUrl("https://graph.facebook.com/fql?q=SELECT%20" . $row . "%20FROM%20stream%20WHERE%20post_id='" . $post_id . "'%20&access_token=" . $access_token);
$FBdata = json_decode($json_object);
foreach ($FBdata->data as $news ){
	echo $news->$row->$cell;
}

?>