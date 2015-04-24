<?php 
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();

$option_name = 'jwthemes';

delete_option( $option_name );
global $wpdb;
$easy_team_manager_jw = $wpdb->prefix."easy_team_manager";
$easy_team_manager_description_jw = $wpdb->prefix."easy_team_manager_description";

 $sql= "DROP TABLE IF EXISTS ".$easy_team_manager_jw ;
 $sql1= "DROP TABLE IF EXISTS ".$easy_team_manager_description_jw ;

 $wpdb->query($sql);
 $wpdb->query($sql1);
 
 $upload_dir=wp_upload_dir();
 $upload_dir =$upload_dir['path'].""."/easy_team_manager";
 
 function destroy_upload_dir($upload_dir) { 
    if (!is_upload_dir($upload_dir) || is_link($upload_dir)) return unlink($upload_dir); 
        foreach (scanupload_dir($upload_dir) as $file) { 
            if ($file == '.' || $file == '..') continue; 
            if (!destroy_upload_dir($upload_dir . upload_dirECTORY_SEPARATOR . $file)) { 
                chmod($upload_dir . upload_dirECTORY_SEPARATOR . $file, 0777); 
                if (!destroy_upload_dir($upload_dir . upload_dirECTORY_SEPARATOR . $file)) return false; 
            }; 
        } 
        return rmupload_dir($upload_dir); 
    } 
 ?>