<?php 
/*
	Plugin Name: GA Google Analytics
	Plugin URI: https://perishablepress.com/google-analytics-plugin/
	Description: Adds your Google Analytics Tracking Code to your WordPress site.
	Tags: analytics, ga, google, google analytics, tracking, statistics, stats
	Author: Jeff Starr
	Author URI: http://monzilla.biz/
	Donate link: http://m0n.co/donate
	Contributors: specialk
	Requires at least: 3.9
	Tested up to: 4.2
	Stable tag: trunk
	Version: 20150507
	Text Domain: gap
	Domain Path: /languages/
	License: GPL v2 or later
*/

if (!defined('ABSPATH')) die();

$gap_wp_vers = '3.9';
$gap_version = '20150507';
$gap_plugin  = __('GA Google Analytics', 'gap');
$gap_options = get_option('gap_options');
$gap_path    = plugin_basename(__FILE__); // 'ga-google-analytics/ga-google-analytics.php';
$gap_homeurl = 'https://perishablepress.com/ga-google-analytics/';

// i18n
function gap_i18n_init() {
	load_plugin_textdomain('gap', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'gap_i18n_init');

// require minimum version of WordPress
function gap_require_wp_version() {
	global $wp_version, $gap_path, $gap_plugin, $gap_wp_vers;
	if (version_compare($wp_version, $gap_wp_vers, '<')) {
		if (is_plugin_active($gap_path)) {
			deactivate_plugins($gap_path);
			$msg =  '<strong>' . $gap_plugin . '</strong> ' . __('requires WordPress ', 'gap') . $gap_wp_vers . __(' or higher, and has been deactivated!', 'gap') . '<br />';
			$msg .= __('Please return to the ', 'gap') . '<a href="' . admin_url() . '">' . __('WordPress Admin area', 'gap') . '</a> ' . __('to upgrade WordPress and try again.', 'gap');
			wp_die($msg);
		}
	}
}
if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
	add_action('admin_init', 'gap_require_wp_version');
}

// Google Analytics Tracking Code
function google_analytics_tracking_code() { 
	$options    = get_option('gap_options');
	
	$ga_src      = "('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';";
	$ga_alt      = "('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';";
	$ga_display  = "ga('require', 'displayfeatures');";
	$ga_link_uni = "ga('require', 'linkid', 'linkid.js');";
	$ga_link_cla = "var pluginUrl =
			'//www.google-analytics.com/plugins/ga/inpage_linkid.js';
			_gaq.push(['_require', 'inpage_linkid', pluginUrl]);";
	
	$ga_ads      = $options['gap_display_ads'];
	$ga_uni      = $options['gap_universal'];
	$ga_on       = $options['gap_enable'];
	$ga_id       = $options['gap_id'];
	$ga_custom   = $options['gap_custom'];
	$ga_link     = $options['link_attr'];
	$ga_tracker  = $options['tracker_object'];
	
	if ($ga_ads) $ga_src = $ga_alt;
	
	if ($ga_on) {
		if ($ga_uni) { ?>

		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
			ga('create', '<?php echo $ga_id; ?>'<?php if (!empty($ga_tracker)) echo ", " . $ga_tracker; ?>);
			<?php 
				if ($ga_ads) echo $ga_display . "\n\t\t\t";
				if ($ga_link) echo $ga_link_uni . "\n\t\t\t";
			?>ga('send', 'pageview');
		</script>
		<?php } else { ?>

		<script type="text/javascript">
			var _gaq = _gaq || [];
			<?php if ($ga_link) echo $ga_link_cla . "\n\t\t\t"; 
			?>_gaq.push(['_setAccount', '<?php echo $ga_id; ?>']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = <?php echo $ga_src . "\n"; ?>
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	<?php }
		if (!empty($ga_custom)) echo $ga_custom . "\n";
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
		$gap_links = '<a href="' . get_admin_url() . 'options-general.php?page=' . $gap_path . '">' . __('Settings', 'gap') .'</a>';
		array_unshift($links, $gap_links);
	}
	return $links;
}
add_filter ('plugin_action_links', 'gap_plugin_action_links', 10, 2);

// rate plugin link
function add_gap_links($links, $file) {
	if ($file == plugin_basename(__FILE__)) {
		$rate_url = 'http://wordpress.org/support/view/plugin-reviews/' . basename(dirname(__FILE__)) . '?rate=5#postform';
		$links[] = '<a href="' . $rate_url . '" target="_blank" title="Click here to rate and review this plugin on WordPress.org">Rate this plugin</a>';
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
			'gap_id'          => 'UA-XXXXX-X',
			'gap_enable'      => 0,
			'gap_location'    => 'header',
			'gap_display_ads' => 0,
			'gap_universal'   => 0, 
			'gap_custom'      => '',
			'link_attr'       => 0,
			'tracker_object'  => '',
			'admin_area'      => 0,
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
	
	return $input;
}

// define dropdown options
$gap_location = array(
	'header' => array(
		'value' => 'header',
		'label' => __('Include code in the document head (via wp_head)', 'gap')
	),
	'footer' => array(
		'value' => 'footer',
		'label' => __('Include code in the document footer (via wp_footer)', 'gap')
	),
);

// add the options page
function gap_add_options_page() {
	global $gap_plugin;
	add_options_page($gap_plugin, 'GA Plugin', 'manage_options', __FILE__, 'gap_render_form');
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
		.mm-panel-overview { padding-left: 100px; background: url(<?php echo plugins_url(); ?>/ga-google-analytics/gap-logo.png) no-repeat 15px 0; }

		#mm-plugin-options h2 small { font-size: 60%; }
		#mm-plugin-options h3 { cursor: pointer; }
		#mm-plugin-options h4, 
		#mm-plugin-options p { margin: 15px; line-height: 18px; }
		#mm-plugin-options p.mm-alt { margin: 15px 0; }
		#mm-plugin-options .mm-item-caption { font-size: 11px; }
		#mm-plugin-options ul { margin: 15px 15px 15px 40px; }
		#mm-plugin-options li { margin: 10px 0; list-style-type: disc; }
		#mm-plugin-options abbr { cursor: help; border-bottom: 1px dotted #dfdfdf; }

		.mm-table-wrap { margin: 15px; }
		.mm-table-wrap td { padding: 15px; vertical-align: middle; }
		.mm-table-wrap .widefat td { vertical-align: middle; }
		.mm-table-wrap .widefat th { width: 25%; vertical-align: middle; }
		.mm-code { background-color: #fafae0; color: #333; font-size: 14px; }
		.mm-radio-inputs { margin: 7px 0; }
		.mm-radio-inputs span { padding-left: 5px; }

		#setting-error-settings_updated { margin: 10px 0; }
		#setting-error-settings_updated p { margin: 5px; }
		#mm-plugin-options .button-primary { margin: 0 0 15px 15px; }

		#mm-panel-toggle { margin: 5px 0; }
		#mm-credit-info { margin-top: -5px; }
		#mm-iframe-wrap { width: 100%; height: 250px; overflow: hidden; }
		#mm-iframe-wrap iframe { width: 100%; height: 100%; overflow: hidden; margin: 0; padding: 0; }
	</style>

	<div id="mm-plugin-options" class="wrap">
		<h2><?php echo $gap_plugin; ?> <small><?php echo 'v' . $gap_version; ?></small></h2>
		<div id="mm-panel-toggle"><a href="<?php get_admin_url() . 'options-general.php?page=' . $gap_path; ?>"><?php _e('Toggle all panels', 'gap'); ?></a></div>

		<form method="post" action="options.php">
			<?php $gap_options = get_option('gap_options'); settings_fields('gap_plugin_options'); ?>

			<div class="metabox-holder">
				<div class="meta-box-sortables ui-sortable">
					
					<div id="mm-panel-alert"<?php echo $display_alert; ?> class="postbox">
						<h3><?php _e('Important', 'gap'); ?></h3>
						<div class="toggle">
							<div class="mm-panel-alert">
								<p>
									<?php _e('Universal Analytics is now the standard for Google Analytics. 
									Please read the following info and migrate by enabling Universal Analytics in the plugin settings. 
									Universal Analytics will be the default setting in an future version of this plugin.', 'gap'); ?>
								</p>
								<ul>
									<li><a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/"><?php _e('Learn about Universal Analytics', 'gap'); ?></a></li>
									<li><a target="_blank" href="https://developers.google.com/analytics/devguides/collection/upgrade/"><?php _e('Universal Analytics Upgrade Center', 'gap'); ?></a></li>
									<li><a target="_blank" href="https://developers.google.com/analytics/devguides/collection/upgrade/faq#no-upgrade"><?php _e('What happens if I don&rsquo;t upgrade?', 'gap'); ?></a></li>
								</ul>
								<div class="dismiss-alert">
									<div class="dismiss-alert-wrap">
										<input class="input-alert" name="gap_options[version_alert]" type="checkbox" value="1" <?php if (isset($gap_options['version_alert'])) checked('1', $gap_options['version_alert']); ?> />  
										<label class="description" for="gap_options[version_alert]"><?php _e('Dismiss notice', 'gap') ?></label>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div id="mm-panel-overview" class="postbox">
						<h3><?php _e('Overview', 'gap'); ?></h3>
						<div class="toggle">
							<div class="mm-panel-overview">
								<p>
									<strong><?php echo $gap_plugin; ?></strong> <?php _e('(GA Plugin) adds Google Analytics Tracking Code to your WordPress site.', 'gap'); ?>
									<?php _e('Enter your GA ID, save your options, and done. Log into your Google Analytics account to view your stats.', 'gap'); ?>
								</p>
								<ul>
									<li><?php _e('To enter your GA ID, visit', 'gap'); ?> <a id="mm-panel-primary-link" href="#mm-panel-primary"><?php _e('GA Plugin Options', 'gap'); ?></a>.</li>
									<li><?php _e('To restore default settings, visit', 'gap'); ?> <a id="mm-restore-settings-link" href="#mm-restore-settings"><?php _e('Restore Default Options', 'gap'); ?></a>.</li>
									<li>
										<?php _e('For more information check the', 'gap'); ?> <a target="_blank" href="<?php echo plugins_url('/ga-google-analytics/readme.txt', dirname(__FILE__)); ?>">readme.txt</a> 
										<?php _e('and', 'gap'); ?> <a target="_blank" href="<?php echo $gap_homeurl; ?>"><?php _e('GA Plugin Homepage', 'gap'); ?></a>.
									</li>
									<li><?php _e('If you like this plugin, please', 'gap'); ?> 
										<a href="http://wordpress.org/support/view/plugin-reviews/<?php echo basename(dirname(__FILE__)); ?>?rate=5#postform" title="<?php _e('Click here to rate and review this plugin on WordPress.org', 'gap'); ?>" target="_blank">
											<?php _e('rate it at the Plugin Directory', 'gap'); ?>&nbsp;&raquo;
										</a>
									</li>
								</ul>
								<p><small><?php _e('Note that it can take 24-48 hours after adding the tracking code before any analytical data appears in your Google Analytics account. 
												To check that the GA tacking code is included, look at the source code of your web page(s). Learn more at the official', 'gap'); ?> 
												<a href="http://www.google.com/analytics/" target="_blank">GA Homepage</a>
								</small></p>
							</div>
						</div>
					</div>
					<div id="mm-panel-primary" class="postbox">
						<h3><?php _e('GA Plugin Options', 'gap'); ?></h3>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p><?php _e('Enter your Tracking Code and enable/disable the plugin.', 'gap'); ?></p>
							<div class="mm-table-wrap">
								<table class="widefat mm-table">
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_id]"><?php _e('GA property ID', 'gap') ?></label></th>
										<td><input type="text" size="20" maxlength="20" name="gap_options[gap_id]" value="<?php echo $gap_options['gap_id']; ?>" /></td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_enable]"><?php _e('Enable Google Analytics', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_enable]" type="checkbox" value="1" <?php if (isset($gap_options['gap_enable'])) checked('1', $gap_options['gap_enable']); ?> /> 
											<?php _e('Include the', 'gap'); ?> 
											<a target="_blank" href="http://code.google.com/apis/analytics/docs/tracking/asyncUsageGuide.html">GA Tracking Code</a> 
											<?php _e('in your web pages?', 'gap') ?>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_universal]"><?php _e('Enable Universal Analytics', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_universal]" type="checkbox" value="1" <?php if (isset($gap_options['gap_universal'])) checked('1', $gap_options['gap_universal']); ?> /> 
											<?php _e('Enable support for', 'gap'); ?> <a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/"><?php _e('Universal Analytics', 'gap'); ?></a>?
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_display_ads]"><?php _e('Enable Display Advertising', 'gap') ?></label></th>
										<td>
											<input name="gap_options[gap_display_ads]" type="checkbox" value="1" <?php if (isset($gap_options['gap_display_ads'])) checked('1', $gap_options['gap_display_ads']); ?> /> 
											<?php _e('Enable support for', 'gap'); ?> <a target="_blank" href="https://support.google.com/analytics/answer/2444872"><?php _e('Display Advertising', 'gap'); ?></a>?
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[link_attr]"><?php _e('Enable Link Attribution', 'gap') ?></label></th>
										<td>
											<input name="gap_options[link_attr]" type="checkbox" value="1" <?php if (isset($gap_options['link_attr'])) checked('1', $gap_options['link_attr']); ?> /> 
											<?php _e('Enable support for', 'gap'); ?> <a target="_blank" href="https://support.google.com/analytics/answer/2558867?hl=en"><?php _e('Enhanced Link Attribution', 'gap'); ?></a>?
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_location]"><?php _e('Code Location', 'gap'); ?></label></th>
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
														<input type="radio" name="gap_options[gap_location]" value="<?php esc_attr_e($gap_loc['value']); ?>" <?php echo $checked; ?> /> 
														<span><?php echo $gap_loc['label']; ?></span>
													</div>
											<?php } ?>
											<div class="mm-item-caption">
												<?php _e('Tip: Google recommends including the Tracking Code in the document header, but including it in the footer can benefit page performance.
														If in doubt, go with the default option to include the code in the header.', 'gap'); ?>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[gap_custom]"><?php _e('Custom Code', 'gap'); ?></label></th>
										<td>
											<textarea type="textarea" rows="3" cols="50" name="gap_options[gap_custom]"><?php if (isset($gap_options['gap_custom'])) echo esc_textarea($gap_options['gap_custom']); ?></textarea>
											<div class="mm-item-caption"><?php _e('Here you may specify any markup to be displayed in the &lt;head&gt; section. Leave blank to disable.', 'gap'); ?></div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[tracker_object]"><?php _e('Custom Tracker Objects (Advanced)', 'gap'); ?></label></th>
										<td>
											<textarea type="textarea" rows="3" cols="50" name="gap_options[tracker_object]"><?php if (isset($gap_options['tracker_object'])) echo esc_textarea($gap_options['tracker_object']); ?></textarea>
											<div class="mm-item-caption"> 
												<?php _e('To enable Tracker Objects, enter your code here. Note: include straight brackets for single tracker, or curly brackets for multiple trackers.', 'gap'); ?> 
												<a target="_blank" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/advanced#creation"><?php _e('Learn more about Tracker Objects', 'gap'); ?></a>
											</div>
										</td>
									</tr>
									<tr>
										<th scope="row"><label class="description" for="gap_options[admin_area]"><?php _e('WP Admin Area', 'gap') ?></label></th>
										<td>
											<input name="gap_options[admin_area]" type="checkbox" value="1" <?php if (isset($gap_options['admin_area'])) checked('1', $gap_options['admin_area']); ?> /> 
											<?php _e('Enable GA in the WP Admin Area', 'gap'); ?>
										</td>
									</tr>
								</table>
							</div>
							<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'gap'); ?>" />
						</div>
					</div>
					<div id="mm-restore-settings" class="postbox">
						<h3><?php _e('Restore Default Options', 'gap'); ?></h3>
						<div class="toggle<?php if (!isset($_GET["settings-updated"])) { echo ' default-hidden'; } ?>">
							<p>
								<input name="gap_options[default_options]" type="checkbox" value="1" id="mm_restore_defaults" <?php if (isset($gap_options['default_options'])) checked('1', $gap_options['default_options']); ?> /> 
								<label class="description" for="gap_options[default_options]"><?php _e('Restore default options upon plugin deactivation/reactivation.', 'gap'); ?></label>
							</p>
							<p>
								<small>
									<?php _e('<strong>Tip:</strong> leave this option unchecked to remember your settings. Or, to go ahead and restore all default options, check the box, save your settings, and then deactivate/reactivate the plugin.', 'gap'); ?>
								</small>
							</p>
							<input type="submit" class="button-primary" value="<?php _e('Save Settings', 'gap'); ?>" />
						</div>
					</div>
					<div id="mm-panel-current" class="postbox">
						<h3><?php _e('Updates &amp; Info', 'gap'); ?></h3>
						<div class="toggle">
							<div id="mm-iframe-wrap">
								<iframe src="https://perishablepress.com/current/index-gap.html"></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="mm-credit-info">
				<a target="_blank" href="<?php echo $gap_homeurl; ?>" title="<?php echo $gap_plugin; ?> Homepage"><?php echo $gap_plugin; ?></a> by 
				<a target="_blank" href="http://twitter.com/perishable" title="Jeff Starr on Twitter">Jeff Starr</a> @ 
				<a target="_blank" href="http://monzilla.biz/" title="Obsessive Web Design &amp; Development">Monzilla Media</a>
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
			jQuery('h3').click(function(){
				jQuery(this).next().slideToggle(300);
			});
			jQuery('#mm-panel-primary-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-panel-primary .toggle').slideToggle(300);
				return true;
			});
			jQuery('#mm-restore-settings-link').click(function(){
				jQuery('.toggle').hide();
				jQuery('#mm-restore-settings .toggle').slideToggle(300);
				return true;
			});
			//dismiss_alert
			if (!jQuery('.dismiss-alert-wrap input').is(':checked')){
				jQuery('.dismiss-alert-wrap input').one('click',function(){
					jQuery('.dismiss-alert-wrap').after('<input type="submit" class="button-secondary" value="<?php _e('Save Preference', 'gap'); ?>" />');
				});
			}
			// prevent accidents
			if (!jQuery('#mm_restore_defaults').is(':checked')){
				jQuery('#mm_restore_defaults').click(function(event){
					var r = confirm("<?php _e('Are you sure you want to restore all default options? (this action cannot be undone)', 'gap'); ?>");
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
