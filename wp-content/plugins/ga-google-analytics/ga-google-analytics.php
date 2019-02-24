<?php 
/*
	Plugin Name: GA Google Analytics
	Plugin URI: https://perishablepress.com/google-analytics-plugin/
	Description: Adds your Google Analytics Tracking Code to your WordPress site.
	Tags: analytics, ga, google, google analytics, tracking, statistics, stats
	Author: Jeff Starr
	Author URI: https://plugin-planet.com/
	Donate link: https://m0n.co/donate
	Contributors: specialk
	Requires at least: 4.1
	Tested up to: 4.8
	Stable tag: 20170731
	Version: 20170731
	Text Domain: gap
	Domain Path: /languages
	License: GPL v2 or later
*/

/*
	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 
	2 of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	
	You should have received a copy of the GNU General Public License
	with this program. If not, visit: https://www.gnu.org/licenses/
	
	Copyright 2017 Monzilla Media. All rights reserved.
*/

if (!defined('ABSPATH')) die();

$gap_wp_vers = '4.1';
$gap_version = '20170731';
$gap_plugin  = esc_html__('GA Google Analytics', 'gap');
$gap_options = get_option('gap_options');
$gap_path    = plugin_basename(__FILE__); // 'ga-google-analytics/ga-google-analytics.php';
$gap_homeurl = 'https://perishablepress.com/ga-google-analytics/';

// i18n
function gap_i18n_init() {
	load_plugin_textdomain('gap', false, dirname(plugin_basename(__FILE__)) .'/languages/');
}
add_action('plugins_loaded', 'gap_i18n_init');

// require minimum version of WordPress
function gap_require_wp_version() {
	global $gap_path, $gap_plugin, $gap_wp_vers;
	$wp_version = get_bloginfo('version');
	if (version_compare($wp_version, $gap_wp_vers, '<')) {
		if (is_plugin_active($gap_path)) {
			deactivate_plugins($gap_path);
			$msg =  '<strong>' . $gap_plugin . '</strong> ' . esc_html__('requires WordPress ', 'gap') . $gap_wp_vers . esc_html__(' or higher, and has been deactivated!', 'gap') . '<br />';
			$msg .= esc_html__('Please return to the ', 'gap') . '<a href="' . admin_url() . '">' . esc_html__('WordPress Admin area', 'gap') . '</a> ' . esc_html__('to upgrade WordPress and try again.', 'gap');
			wp_die($msg);
		}
	}
}
if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	add_action('admin_init', 'gap_require_wp_version');
}

// Google Analytics Tracking Code
function google_analytics_tracking_code() {
	
	$options = get_option('gap_options');
	
	extract($options);
	
	// universal
	$ga_display   = "ga('require', 'displayfeatures');";
	$ga_link_uni  = "ga('require', 'linkid', 'linkid.js');";
	$ga_anon_uni  = "ga('set', 'anonymizeIP', true);";
	$ga_ssl_uni   = "ga('set', 'forceSSL', true);";
	
	// classic
	$ga_alt       = "('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';";
	$ga_src       = "('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
	$ga_link_gaq  = "var pluginUrl = '//www.google-analytics.com/plugins/ga/inpage_linkid.js';\n\t\t\t_gaq.push(['_require', 'inpage_linkid', pluginUrl]);";
	$ga_anon_gaq  = "_gaq.push(['_gat._anonymizeIp']);";
	$ga_ssl_gaq   = "_gaq.push(['_gat._forceSSL']);";
	
	if ($gap_display_ads) $ga_src = $ga_alt;
	
	if ($gap_enable && (!is_user_logged_in() || !current_user_can('administrator') || (current_user_can('administrator') && !$disable_admin))) {
		if ($gap_universal) { ?>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', '<?php echo $gap_id; ?>', 'auto'<?php if ($tracker_object) echo ", " . $tracker_object; ?>);
			<?php 
				if ($gap_display_ads) echo $ga_display      . "\n\t\t\t";
				if ($link_attr)       echo $ga_link_uni     . "\n\t\t\t";
				if ($gap_anonymize)   echo $ga_anon_uni     . "\n\t\t\t";
				if ($gap_force_ssl)   echo $ga_ssl_uni      . "\n\t\t\t";
				if ($gap_custom_code) echo $gap_custom_code . "\n\t\t\t";
			?>ga('send', 'pageview');
		</script>

		<?php } else { ?>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			<?php 
				if ($link_attr)       echo $ga_link_gaq     . "\n\t\t\t";
				if ($gap_anonymize)   echo $ga_anon_gaq     . "\n\t\t\t"; 
				if ($gap_force_ssl)   echo $ga_ssl_gaq      . "\n\t\t\t"; 
				if ($gap_custom_code) echo $gap_custom_code . "\n\t\t\t"; 
			?>_gaq.push(['_setAccount', '<?php echo $gap_id; ?>']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = <?php echo $ga_src . "\n"; ?>
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>

	<?php }
		if ($gap_custom) echo $gap_custom . "\n";
	}	
}

// include tracking code in header or footer
if (isset($gap_options['gap_location']) && $gap_options['gap_location'] == 'header') {
	if (isset($gap_options['admin_area']) && $gap_options['admin_area']) {
		add_action('admin_head', 'google_analytics_tracking_code');
	}
	add_action('wp_head', 'google_analytics_tracking_code');
} else {
	if (isset($gap_options['admin_area']) && $gap_options['admin_area']) {
		add_action('admin_footer', 'google_analytics_tracking_code');
	}
	add_action('wp_footer', 'google_analytics_tracking_code');
}

// display settings link on plugin page
function gap_plugin_action_links($links, $file) {
	global $gap_path;
	if ($file == $gap_path) {
		$gap_links = '<a href="' . get_admin_url() . 'options-general.php?page=' . $gap_path . '">' . esc_html__('Settings', 'gap') .'</a>';
		array_unshift($links, $gap_links);
	}
	return $links;
}
add_filter ('plugin_action_links', 'gap_plugin_action_links', 10, 2);



// rate plugin link
function add_gap_links($links, $file) {
	
	if ($file == plugin_basename(__FILE__)) {
		
		$href  = 'https://wordpress.org/support/plugin/ga-google-analytics/reviews/?rate=5#new-post';
		$title = esc_html__('Give us a 5-star rating at WordPress.org', 'gap');
		$text  = esc_html__('Rate this plugin', 'gap') .'&nbsp;&raquo;';
		
		$links[] = '<a target="_blank" href="'. $href .'" title="'. $title .'">'. $text .'</a>';
		
	}
	
	return $links;
	
}
add_filter('plugin_row_meta', 'add_gap_links', 10, 2);



// delete plugin settings
function gap_delete_plugin_options() {
	delete_option('gap_options');
}
if ($gap_options['default_options'] == 1) {
	register_uninstall_hook (__FILE__, 'gap_delete_plugin_options');
}

// define default settings
function gap_add_defaults() {
	$tmp = get_option('gap_options');
	if(($tmp['default_options'] == '1') || (!is_array($tmp))) {
		$arr = array(
			'version_alert'   => 0,
			'default_options' => 0,
			'gap_enable'      => 0,
			'gap_id'          => 'UA-XXXXX-Y',
			'gap_location'    => 'header',
			'gap_display_ads' => 0,
			'gap_universal'   => 0, 
			'gap_custom'      => '',
			'tracker_object'  => '',
			'link_attr'       => 0,
			'admin_area'      => 0,
			'disable_admin'   => 0,
			'gap_anonymize'   => 0, 
			'gap_force_ssl'   => 0,
			'gap_custom_code' => '',
		);
		update_option('gap_options', $arr);
	}
}
register_activation_hook (__FILE__, 'gap_add_defaults');

// whitelist settings
function gap_init() {
	register_setting('gap_plugin_options', 'gap_options', 'gap_validate_options');
}
add_action ('admin_init', 'gap_init');

// sanitize and validate input
function gap_validate_options($input) {
	global $gap_location;
	
	if (!isset($input['version_alert'])) $input['version_alert'] = null;
	$input['version_alert'] = ($input['version_alert'] == 1 ? 1 : 0);
	
	if (!isset($input['default_options'])) $input['default_options'] = null;
	$input['default_options'] = ($input['default_options'] == 1 ? 1 : 0);
	
	if (!isset($input['gap_enable'])) $input['gap_enable'] = null;
	$input['gap_enable'] = ($input['gap_enable'] == 1 ? 1 : 0);
	
	$input['gap_id'] = wp_filter_nohtml_kses($input['gap_id']);
	
	if (!isset($input['gap_location'])) $input['gap_location'] = null;
	if (!array_key_exists($input['gap_location'], $gap_location)) $input['gap_location'] = null;
	
	if (!isset($input['gap_display_ads'])) $input['gap_display_ads'] = null;
	$input['gap_display_ads'] = ($input['gap_display_ads'] == 1 ? 1 : 0);
	
	if (!isset($input['gap_universal'])) $input['gap_universal'] = null;
	$input['gap_universal'] = ($input['gap_universal'] == 1 ? 1 : 0);
	
	// dealing with kses
	global $allowedposttags;
	$allowed_atts = array(
		'align'=>array(), 'class'=>array(), 'id'=>array(), 'dir'=>array(), 'lang'=>array(), 'style'=>array(), 'label'=>array(), 'url'=>array(), 
		'xml:lang'=>array(), 'src'=>array(), 'alt'=>array(), 'name'=>array(), 'content'=>array(), 'http-equiv'=>array(), 'profile'=>array(), 
		'href'=>array(), 'property'=>array(), 'title'=>array(), 'rel'=>array(), 'type'=>array(), 'charset'=>array(), 'media'=>array(), 'rev'=>array(),
		);
	$allowedposttags['strong'] = $allowed_atts;
	$allowedposttags['script'] = $allowed_atts;
	$allowedposttags['style'] = $allowed_atts;
	$allowedposttags['small'] = $allowed_atts;
	$allowedposttags['span'] = $allowed_atts;
	$allowedposttags['meta'] = $allowed_atts;
	$allowedposttags['item'] = $allowed_atts;
	$allowedposttags['base'] = $allowed_atts;
	$allowedposttags['link'] = $allowed_atts;
	$allowedposttags['abbr'] = $allowed_atts;
	$allowedposttags['code'] = $allowed_atts;
	$allowedposttags['div'] = $allowed_atts;
	$allowedposttags['img'] = $allowed_atts;
	$allowedposttags['h1'] = $allowed_atts;
	$allowedposttags['h2'] = $allowed_atts;
	$allowedposttags['h3'] = $allowed_atts;
	$allowedposttags['h4'] = $allowed_atts;
	$allowedposttags['h5'] = $allowed_atts;
	$allowedposttags['ol'] = $allowed_atts;
	$allowedposttags['ul'] = $allowed_atts;
	$allowedposttags['li'] = $allowed_atts;
	$allowedposttags['em'] = $allowed_atts;
	$allowedposttags['p'] = $allowed_atts;
	$allowedposttags['a'] = $allowed_atts;
	
	$input['gap_custom'] = wp_kses($input['gap_custom'], $allowedposttags);
	
	$input['tracker_object'] = wp_kses($input['tracker_object'], $allowedposttags);
	
	if (!isset($input['link_attr'])) $input['link_attr'] = null;
	$input['link_attr'] = ($input['link_attr'] == 1 ? 1 : 0);
	
	if (!isset($input['admin_area'])) $input['admin_area'] = null;
	$input['admin_area'] = ($input['admin_area'] == 1 ? 1 : 0);
	
	if (!isset($input['disable_admin'])) $input['disable_admin'] = null;
	$input['disable_admin'] = ($input['disable_admin'] == 1 ? 1 : 0);
	
	if (!isset($input['gap_anonymize'])) $input['gap_anonymize'] = null;
	$input['gap_anonymize'] = ($input['gap_anonymize'] == 1 ? 1 : 0);
	
	if (!isset($input['gap_force_ssl'])) $input['gap_force_ssl'] = null;
	$input['gap_force_ssl'] = ($input['gap_force_ssl'] == 1 ? 1 : 0);
	
	$input['gap_custom_code'] = wp_kses($input['gap_custom_code'], $allowedposttags);
	
	return $input;
}

// define dropdown options
$gap_location = array(
	'header' => array(
		'value' => 'header',
		'label' => esc_html__('Include code in the document head (via wp_head)', 'gap')
	),
	'footer' => array(
		'value' => 'footer',
		'label' => esc_html__('Include code in the document footer (via wp_footer)', 'gap')
	),
);

// add the options page
function gap_add_options_page() {
	global $gap_plugin;
	add_options_page($gap_plugin, 'Google Analytics', 'manage_options', __FILE__, 'gap_render_form');
}
add_action ('admin_menu', 'gap_add_options_page');

// create the options page
function gap_render_form() {
	global $gap_plugin, $gap_options, $gap_path, $gap_homeurl, $gap_version, $gap_location; 
	
	if (!$gap_options['version_alert'] && !$gap_options['gap_universal']) $display_alert = ' style="display:block;"';
	else $display_alert = ' style="display:none;"'; ?>

	<style type="text/css">
		.dismiss-alert { margin: 15px; }
		.dismiss-alert-wrap { display: inline-block; padding: 7px 0 10px 0; }
		.dismiss-alert .description { display: inline-block; margin: -2px 15px 0 0; }
		.mm-panel-overview {
			padding: 0 15px 10px 100px; 
			background-image: url(<?php echo plugins_url(); ?>/ga-google-analytics/gap-logo.jpg);
			background-repeat: no-repeat; background-position: 15px 0; background-size: 80px 80px;
			}
		
		.mm-panel-usage { padding-bottom: 10px; }
		
		#mm-plugin-options h1 small { line-height: 12px; font-size: 12px; color: #bbb; }
		#mm-plugin-options h2 { margin: 0; padding: 12px 0 12px 15px; font-size: 16px; cursor: pointer; }
		#mm-plugin-options h3 { margin: 20px 15px; font-size: 14px; }
		
		#mm-plugin-options p { margin-left: 15px; }
		#mm-plugin-options p.mm-alt { margin: 15px 0; }
		#mm-plugin-options .mm-item-caption,
		#mm-plugin-options .mm-item-caption code { font-size: 11px; }
		#mm-plugin-options ul,
		#mm-plugin-options ol { margin: 15px 15px 15px 40px; }
		#mm-plugin-options li { margin: 10px 0; list-style-type: disc; }
		#mm-plugin-options abbr { cursor: help; border-bottom: 1px dotted #dfdfdf; }
		
		.mm-table-wrap { margin: 15px; }
		.mm-table-wrap td { padding: 15px; vertical-align: middle; }
		.mm-table-wrap .widefat td { vertical-align: middle; }
		.mm-table-wrap .widefat th { width: 25%; vertical-align: middle; }
		.mm-code { background-color: #fafae0; color: #333; font-size: 14px; }
		.mm-radio-inputs { margin: 7px 0; }
		.mm-radio-inputs span { padding-left: 5px; }

		#setting-error-settings_updated { margin: 8px 0 15px 0; }
		#setting-error-settings_updated p { margin: 7px 0; }
		#mm-plugin-options .button-primary { margin: 0 0 15px 15px; }

		#mm-panel-toggle { margin: 5px 0; }
		#mm-credit-info { margin-top: -5px; }
		#mm-iframe-wrap { width: 100%; height: 225px; overflow: hidden; }
		#mm-iframe-wrap iframe { width: 100%; height: 100%; overflow: hidden; margin: 0; padding: 0; }
	</style>

	<div id="mm-plugin-options" class="wrap">
		<h1><?php echo $gap_plugin; ?> <small><?php echo 'v' . $gap_version; ?></small></h1>
		<div id="mm-panel-toggle"><a href="<?php get_admin_url() . 'options-general.php?page=' . $gap_path; ?>"><?php esc_html_e('Toggle all panels', 'gap'); ?></a></div>
		
		<form method="post" action="options.php">
			<?php $gap_options = get_option('gap_options'); settings_fields('gap_plugin_options'); ?>

			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable">
					
					<div id="mm-panel-alert"<?php echo $display_alert; ?> class="postbox">
						<h2><?php esc_html_e('Important', 'gap'); ?></h2>
						<div class="toggle">
							<div class="mm-panel-alert">
								<p>
									<?php esc_html_e('Universal Analytics is now the standard for Google Analytics.', 'gap'); ?> 
									<?php esc_html_e('Please read the following info and migrate by enabling Universal Analytics in the plugin settings.', 'gap'); ?> 
									<?php esc_html_e('Universal Analytics will be the default setting in an future version of this plugin (probably in 2017).', 'gap'); ?>
								</p>
								<ul>
									<li><a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/"><?php esc_html_e('Learn about Universal Analytics', 'gap'); ?></a></li>
									<li><a target="_blank" href="https://developers.google.com/analytics/devguides/collection/upgrade/"><?php esc_html_e('Universal Analytics Upgrade Center', 'gap'); ?></a></li>
								</ul>
								<div class="dismiss-alert">
									<div class="dismiss-alert-wrap">
										<input class="input-alert" name="gap_options[version_alert]" type="checkbox" value="1" <?php if (isset($gap_options['version_alert'])) checked('1', $gap_options['version_alert']); ?> />  
										<label class="description" for="gap_options[version_alert]"><?php esc_html_e('Dismiss notice', 'gap') ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-overview" class="postbox">
						<h2><?php esc_html_e('Overview', 'gap'); ?></h2>
						<div class="toggle<?php if (isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<div class="mm-panel-overview">
								<p><?php esc_html_e('This plugin adds the GA Tracking Code to your site. Log in to your Google account to view your stats.', 'gap'); ?></p>
								<ul>
									<li><a id="mm-panel-usage-link" href="#mm-panel-usage"><?php esc_html_e('How to Use', 'gap'); ?></a></li>
									<li><a id="mm-panel-primary-link" href="#mm-panel-primary"><?php esc_html_e('Plugin Settings', 'gap'); ?></a></li>
									<li><a target="_blank" href="https://wordpress.org/support/plugin/ga-google-analytics"><?php esc_html_e('Plugin Homepage', 'gap'); ?></a></li>
								</ul>
								<p>
									<?php esc_html_e('If you like this plugin, please', 'gap'); ?> 
									<a target="_blank" href="https://wordpress.org/support/plugin/ga-google-analytics/reviews/?rate=5#new-post" title="<?php esc_attr_e('THANK YOU for your support!', 'gap'); ?>">
										<?php esc_html_e('give it a 5-star rating', 'gap'); ?>&nbsp;&raquo;
									</a>
								</p>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-usage" class="postbox">
						<h2><?php esc_html_e('How to Use', 'gap'); ?></h2>
						<div class="toggle default-hidden">
							<div class="mm-panel-usage">
								<p><?php esc_html_e('How to use', 'gap'); ?> <?php echo $gap_plugin; ?>:</p>
								<ol>
									<li><?php esc_html_e('In the plugin settings, enter your GA Property ID.', 'gap'); ?></li>
									<li><?php esc_html_e('In the plugin settings, enable either "Legacy Analytics" or "Universal Analytics".', 'gap'); ?></li>
									<li><?php esc_html_e('Configure other settings (optional) as desired and save your changes.', 'gap'); ?></li>
									<li><?php esc_html_e('After 24-48 hours, you can log into your Google Analytics account to view your stats.', 'gap'); ?></li>
								</ol>
								<p>
									<small>
										<?php esc_html_e('Note that it can take 24-48 hours after adding the tracking code before any analytical data appears in your', 'gap'); ?> 
										<a target="_blank" href="http://www.google.com/analytics/"><?php esc_html_e('Google Analytics account', 'gap'); ?></a>. 
										<?php esc_html_e('To check that the GA tacking code is included, look at the source code of your web page(s). Learn more at the', 'gap'); ?> 
										<a target="_blank" href="https://support.google.com/analytics/?hl=en#topic=3544906"><?php esc_html_e('Google Analytics Help Center', 'gap'); ?></a>.
									</small>
								</p>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-primary" class="postbox">
						<h2><?php esc_html_e('Plugin Settings', 'gap'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p><?php esc_html_e('Enter your Tracking Code and choose your options.', 'gap'); ?></p>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_id]"><?php esc_html_e('GA Property ID', 'gap') ?></label></th>
										<td><input type="text" size="20" maxlength="20" name="gap_options[gap_id]" value="<?php echo $gap_options['gap_id']; ?>" /></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_enable]"><?php esc_html_e('Enable Analytics', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_enable]" type="checkbox" value="1" <?php if (isset($gap_options['gap_enable'])) checked('1', $gap_options['gap_enable']); ?> /> 
											<?php esc_html_e('Enable Google Analytics on your site. Uses', 'gap'); ?> 
											<a target="_blank" href="http://code.google.com/apis/analytics/docs/tracking/asyncUsageGuide.html"><?php esc_html_e('Legacy Analytics', 'gap'); ?></a> 
											<?php esc_html_e('by default. To use Universal Analytics, check this box and enable the next setting.', 'gap'); ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_universal]"><?php esc_html_e('Universal Analytics', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_universal]" type="checkbox" value="1" <?php if (isset($gap_options['gap_universal'])) checked('1', $gap_options['gap_universal']); ?> /> 
											<?php esc_html_e('Enable', 'gap'); ?> <a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/"><?php esc_html_e('Universal Analytics', 'gap'); ?></a>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_display_ads]"><?php esc_html_e('Display Advertising', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_display_ads]" type="checkbox" value="1" <?php if (isset($gap_options['gap_display_ads'])) checked('1', $gap_options['gap_display_ads']); ?> /> 
											<?php esc_html_e('Enable support for', 'gap'); ?> <a target="_blank" href="https://support.google.com/analytics/answer/2444872"><?php esc_html_e('Display Advertising', 'gap'); ?></a>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[link_attr]"><?php esc_html_e('Link Attribution', 'gap') ?></label></th>
										<td>
											<input name="gap_options[link_attr]" type="checkbox" value="1" <?php if (isset($gap_options['link_attr'])) checked('1', $gap_options['link_attr']); ?> /> 
											<?php esc_html_e('Enable support for', 'gap'); ?> <a target="_blank" href="https://support.google.com/analytics/answer/2558867?hl=en"><?php esc_html_e('Enhanced Link Attribution', 'gap'); ?></a>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_anonymize]"><?php esc_html_e('IP Anonymization', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_anonymize]" type="checkbox" value="1" <?php if (isset($gap_options['gap_anonymize'])) checked('1', $gap_options['gap_anonymize']); ?> /> 
											<?php esc_html_e('Enable support for', 'gap'); ?> <a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/ip-anonymization"><?php esc_html_e('IP Anonymization', 'gap'); ?></a>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_force_ssl]"><?php esc_html_e('Force SSL', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_force_ssl]" type="checkbox" value="1" <?php if (isset($gap_options['gap_force_ssl'])) checked('1', $gap_options['gap_force_ssl']); ?> />
											<?php esc_html_e('Enable support for', 'gap'); ?> <a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/field-reference#forceSSL">Force SSL</a>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_location]"><?php esc_html_e('Code Location', 'gap'); ?></label></th>
										<td>
											<?php if (!isset($checked)) $checked = '';
												foreach ($gap_location as $gap_loc) {
													$radio_setting = $gap_options['gap_location'];
													if ('' != $radio_setting) {
														if ($gap_options['gap_location'] == $gap_loc['value']) {
															$checked = "checked=\"checked\"";
														} else {
															$checked = '';
														}
													} ?>
													<div class="mm-radio-inputs">
														<input type="radio" name="gap_options[gap_location]" value="<?php echo esc_attr($gap_loc['value']); ?>" <?php echo $checked; ?> /> 
														<span><?php echo $gap_loc['label']; ?></span>
													</div>
											<?php } ?>
											<div class="mm-item-caption">
												<?php esc_html_e('Tip: Google recommends including the Tracking Code in the document header, but including it in the footer can benefit page performance.', 'gap'); ?> 
												<?php esc_html_e('If in doubt, go with the default option to include the code in the header.', 'gap'); ?>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_custom]"><?php esc_html_e('Custom', 'gap'); ?> <code>&lt;head&gt;</code> <?php esc_html_e('Code', 'gap'); ?></label></th>
										<td>
											<textarea type="textarea" rows="3" cols="50" name="gap_options[gap_custom]"><?php if (isset($gap_options['gap_custom'])) echo esc_textarea($gap_options['gap_custom']); ?></textarea>
											<div class="mm-item-caption">
												<?php esc_html_e('Here you may specify any markup to be displayed in the', 'gap'); ?> 
												<code>&lt;head&gt;</code> <?php esc_html_e('section. Leave blank to disable.', 'gap'); ?>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[tracker_object]"><?php esc_html_e('Custom Tracker Objects', 'gap'); ?></label></th>
										<td>
											<textarea type="textarea" rows="3" cols="50" name="gap_options[tracker_object]"><?php if (isset($gap_options['tracker_object'])) echo esc_textarea($gap_options['tracker_object']); ?></textarea>
											<div class="mm-item-caption"> 
												<?php esc_html_e('Any code entered here will be added to the primary', 'gap'); ?> 
												<code>ga('create')</code> <?php esc_html_e('function as the fourth parameter.', 'gap'); ?> 
												<a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/creating-trackers"><?php esc_html_e('Learn more about creating trackers', 'gap'); ?></a>.
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_custom_code]"><?php esc_html_e('Custom GA Code', 'gap'); ?></label></th>
										<td>
											<textarea type="textarea" rows="3" cols="50" name="gap_options[gap_custom_code]"><?php if (isset($gap_options['gap_custom_code'])) echo esc_textarea($gap_options['gap_custom_code']); ?></textarea>
											<div class="mm-item-caption"> 
												<?php esc_html_e('Any code entered here will be added to the GA code snippet. For example, this is useful for', 'gap'); ?> 
												<a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/creating-trackers#working_with_multiple_trackers"><?php esc_html_e('creating multiple trackers', 'gap'); ?></a>.
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[admin_area]"><?php esc_html_e('Admin Area', 'gap') ?></label></th>
										<td>
											<input name="gap_options[admin_area]" type="checkbox" value="1" <?php if (isset($gap_options['admin_area'])) checked('1', $gap_options['admin_area']); ?> /> 
											<?php esc_html_e('Enable GA in the WordPress Admin Area', 'gap'); ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[disable_admin]"><?php esc_html_e('Admin Users', 'gap') ?></label></th>
										<td>
											<input name="gap_options[disable_admin]" type="checkbox" value="1" <?php if (isset($gap_options['disable_admin'])) checked('1', $gap_options['disable_admin']); ?> /> 
											<?php esc_html_e('Disable GA on the frontend for Admin-level users', 'gap') ?>
										</td>
									</tr>
								</table>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'gap'); ?>" />
						</div>
					</div>
					
					<div id="mm-restore-settings" class="postbox">
						<h2><?php esc_html_e('Restore Defaults', 'gap'); ?></h2>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p>
								<input name="gap_options[default_options]" type="checkbox" value="1" id="mm_restore_defaults" <?php if (isset($gap_options['default_options'])) checked('1', $gap_options['default_options']); ?> /> 
								<label class="description" for="gap_options[default_options]"><?php esc_html_e('Restore default options upon plugin deactivation/reactivation.', 'gap'); ?></label>
							</p>
							<p>
								<small>
									<strong><?php esc_html_e('Tip:', 'gap'); ?> </strong> <?php esc_html_e('leave this option unchecked to remember your settings.', 'gap'); ?> 
									<?php esc_html_e('Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'gap'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'gap'); ?>" />
						</div>
					</div>
					
					<div id="mm-panel-current" class="postbox">
						<h2><?php esc_html_e('Show Support', 'gap'); ?></h2>
						<div class="toggle">
							<div id="mm-iframe-wrap">
								<iframe src="https://perishablepress.com/current/data.php?current=gap"></iframe>
							</div>
						</div>
					</div>
					
				</div>
			</div>
			
			<div id="mm-credit-info">
				<a target="_blank" href="<?php echo $gap_homeurl; ?>" title="<?php echo $gap_plugin; ?> Homepage"><?php echo $gap_plugin; ?></a> by 
				<a target="_blank" href="https://twitter.com/perishable" title="Jeff Starr on Twitter">Jeff Starr</a> @ 
				<a target="_blank" href="https://monzillamedia.com/" title="Obsessive Web Design &amp; Development">Monzilla Media</a>
			</div>
			
		</form>
	</div>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			// toggle panels
			jQuery('.default-hidden').hide();
			jQuery('#mm-panel-toggle a').click(function(){
				jQuery('.toggle').slideToggle(300);
				return false;
			});
			jQuery('h2').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('#mm-panel-usage-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-usage .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-panel-primary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-primary .toggle').slideToggle(300);
				return true;
			});
			//dismiss_alert
			if (!jQuery('.dismiss-alert-wrap input').is(':checked')){
				jQuery('.dismiss-alert-wrap input').one('click',function(){
					jQuery('.dismiss-alert-wrap').after('<input type="submit" class="button-secondary" value="<?php esc_attr_e('Save Preference', 'gap'); ?>" />');
				});
			}
			// prevent accidents
			if (!jQuery('#mm_restore_defaults').is(':checked')){
				jQuery('#mm_restore_defaults').click(function(event){
					var r = confirm("<?php esc_html_e('Are you sure you want to restore all default options? (this action cannot be undone)', 'gap'); ?>");
					if (r == true){  
						jQuery('#mm_restore_defaults').attr('checked', true);
					} else {
						jQuery('#mm_restore_defaults').attr('checked', false);
					}
				});
			}
		});
	</script>

<?php }
