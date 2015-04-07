<?php
function dpSocialTimeline_admin_url( $query = array() ) {
	global $plugin_page;

	if ( ! isset( $query['page'] ) )
		$query['page'] = $plugin_page;

	$path = 'admin.php';

	if ( $query = build_query( $query ) )
		$path .= '?' . $query;

	$url = admin_url( $path );

	return esc_url_raw( $url );
}

function dpSocialTimeline_plugin_url( $path = '' ) {
	global $wp_version;
	if ( version_compare( $wp_version, '2.8', '<' ) ) { // Using WordPress 2.7
		$folder = dirname( plugin_basename( __FILE__ ) );
		if ( '.' != $folder )
			$path = path_join( ltrim( $folder, '/' ), $path );

		return plugins_url( $path );
	}
	return plugins_url( $path, __FILE__ );
}

function dpSocialTimeline_parse_date( $date ) {
	
	$date = substr($date,0,10);
	if($date == "0000-00-00" || $date == "")
		return '';
	$date_arr = explode("-", $date);
	$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0];
	
	return $date ;
}

function dpSocialTimeline_parse_date_widget( $date, $date_format ) {
	if($date == "0000-00-00" || $date == "")
		return '';
		
	$date_arr = explode("-", substr($date, 0, 10));
	$time_arr = explode(":", substr($date, 11, 5));
	
	switch($date_format) {
		case 0: 
			$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0]." ".$time_arr[0].":".$time_arr[1];
			break;
		case 1: 
			$date = $date_arr[2]."/".$date_arr[1]."/".$date_arr[0]." ".$time_arr[0].":".$time_arr[1];
			break;
		case 2: 
			$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0];
			break;
		case 3: 
			$date = $date_arr[2]."/".$date_arr[1]."/".$date_arr[0];
			break;
		case 4: 
			$date = substr(dpSocialTimeline_translate_month($date_arr[1]), 0, 3)." ".$date_arr[2].", ".$date_arr[0];
			break;
		case 5: 
			$date = substr(dpSocialTimeline_translate_month($date_arr[1]), 0, 3)." ".$date_arr[2];
			break;
		default: 
			$date = $date_arr[1]."/".$date_arr[2]."/".$date_arr[0]." ".$time_arr[0].":".$time_arr[1];
			break;	
	}
	
	return $date ;
}

function dpSocialTimeline_translate_month($month) {
	global $dpSocialTimeline;
	
	switch($month) {
		case "01":
			$month_name = $dpSocialTimeline['lang_january'];
			break;
		case "02":
			$month_name = $dpSocialTimeline['lang_february'];
			break;
		case "03":
			$month_name = $dpSocialTimeline['lang_march'];
			break;
		case "04":
			$month_name = $dpSocialTimeline['lang_april'];
			break;
		case "05":
			$month_name = $dpSocialTimeline['lang_may'];
			break;
		case "06":
			$month_name = $dpSocialTimeline['lang_june'];
			break;
		case "07":
			$month_name = $dpSocialTimeline['lang_july'];
			break;
		case "08":
			$month_name = $dpSocialTimeline['lang_august'];
			break;
		case "09":
			$month_name = $dpSocialTimeline['lang_september'];
			break;
		case "10":
			$month_name = $dpSocialTimeline['lang_october'];
			break;
		case "11":
			$month_name = $dpSocialTimeline['lang_november'];
			break;
		case "12":
			$month_name = $dpSocialTimeline['lang_december'];
			break;
		default:
			$month_name = $dpSocialTimeline['lang_january'];
			break;
	}
	
	return $month_name;
}

function dpSocialTimeline_reslash_multi(&$val,$key) 
{
   if (is_array($val)) array_walk($val,'dpSocialTimeline_reslash_multi',$new);
   else {
      $val = dpSocialTimeline_reslash($val);
   }
}

function dpSocialTimeline_generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function dpSocialTimeline_reslash($string)
{
   if (!get_magic_quotes_gpc())$string = addslashes($string);
   return $string;
}

function dpSocialTimeline_CutString ($texto, $longitud = 180) { 
	$str_len = function_exists('mb_strlen') ? mb_strlen($texto) : strlen($texto);
	if($str_len > $longitud) { 
		$strpos = function_exists('mb_strpos') ? mb_strpos($texto, ' ', $longitud) : strpos($texto, ' ', $longitud);
		$pos_espacios = $strpos - 1; 
		if($pos_espacios > 0) { 
			$substr1 = function_exists('mb_substr') ? mb_substr($texto, 0, ($pos_espacios + 1)) : substr($texto, 0, ($pos_espacios + 1));
			$caracteres = count_chars($substr1, 1); 
			if ($caracteres[ord('<')] > $caracteres[ord('>')]) { 
				$strpos2 = function_exists('mb_strpos') ? mb_strpos($texto, ">", $pos_espacios) : strpos($texto, ">", $pos_espacios);
				$pos_espacios = $strpos2 - 1; 
			} 
			$substr2 = function_exists('mb_substr') ? mb_substr($texto, 0, ($pos_espacios + 1)) : substr($texto, 0, ($pos_espacios + 1));
			$texto = $substr2.'...'; 
		} 
		if(preg_match_all("|(<([\w]+)[^>]*>)|", $texto, $buffer)) { 
			if(!empty($buffer[1])) { 
				preg_match_all("|</([a-zA-Z]+)>|", $texto, $buffer2); 
				if(count($buffer[2]) != count($buffer2[1])) { 
					$cierrotags = array_diff($buffer[2], $buffer2[1]); 
					$cierrotags = array_reverse($cierrotags); 
					foreach($cierrotags as $tag) { 
							$texto .= '</'.$tag.'>'; 
					} 
				} 
			} 
		} 
 
	} 
	return $texto; 
}

add_action( 'wp_ajax_getPreview', 'dpSocialTimeline_getPreview' );
 
function dpSocialTimeline_getPreview() {
	
    $nonce = $_POST['postPreviewNonce'];
	if ( ! wp_verify_nonce( $nonce, 'ajax-get-items-nonce' ) )
        die ( 'Busted!');
		
	if(!isset($_POST['data'])) { die(); }
	
	$data = $_POST['data'];
	
	require_once('classes/base.class.php');

	$dpSocialTimeline = new DpSocialTimeline( true, null );
	
	$dpSocialTimeline->setTimelinePreview($data);

	$dpSocialTimeline->addScripts(true);
	$dpSocialTimeline->output(true);	
}

function dpSocialTimeline_updateNotice(){
    echo '<div class="updated">
       <p>Updated Succesfully.</p>
    </div>';
}

if(@$_GET['settings-updated'] && ($_GET['page'] == 'dpSocialTimeline-admin')) {
	add_action('admin_notices', 'dpSocialTimeline_updateNotice');
}

function dpSocialTimeline_br2nl($text) {
	$nl = preg_replace('#<br\s*/?>#i', "\n", $text);
	return $nl;	
}

function dpSocialTimeline_replace_unicode_escape_sequence($match) {
	return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}

function dpSocialTimeline_stripslashesFull($input) {
    if (is_array($input)) {
        $input = array_map('dpSocialTimeline_stripslashesFull', $input);
    } elseif (is_object($input)) {
        $vars = get_object_vars($input);
        foreach ($vars as $k=>$v) {
            $input->{$k} = dpSocialTimeline_stripslashesFull($v);
        }
    } else {
        $input = stripslashes($input);
    }
    return $input;
}
?>