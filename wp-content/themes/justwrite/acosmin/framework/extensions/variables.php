<?php
/* ------------------------------------------------------------------------- *
 *  Framework & Theme Information
/* ------------------------------------------------------------------------- */

$prefix 					= 'ac_';

// Theme Information
$get_theme_info    			= wp_get_theme();
$get_theme_version 			= $get_theme_info->version;
$get_theme_name    			= $get_theme_info->name;
$get_theme_basename 		= basename(get_template_directory());
$get_theme_path      		= get_template_directory_uri();

// Framework Information
$get_fw_version 			= '1.0.0';
$get_th_changelog_url		= 'http://changelog.acosmin.com/';
?>