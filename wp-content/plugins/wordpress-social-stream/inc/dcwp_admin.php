<?php
require_once('dcwp_plugin_admin.php');

if(!class_exists('dc_jqsocialstream_admin')) {
	
	class dc_jqsocialstream_admin extends dcwp_plugin_admin_dcwss {
	
		var $hook = 'social-stream';
		var $longname = 'Social Stream Configuration';
		var $shortname = 'Social Stream';
		var $filename = 'wordpress-social-stream/dcwp_social_stream.php';
		var $imageurl = 'http://www.designchemical.com/media/images/wordpress_social_stream.png';
		var $homepage = 'http://www.designchemical.com/blog/index.php/premium-wordpress-plugins/wordpress-social-stream-plugin/';
		var $homeshort = 'http://bit.ly/I5Md1n';
		var $twitter = 'designchemical';
		var $title = 'Wordpress Social Stream';
		var $description = 'Combine all of your favorite social networks profiles & feeds into slick slide out or static tabs. Twitter Latest Tweets, Facebook Like Box & Recommendations Google +1 Feed, Instagram feed & searches, RSS Feed, Tumblr, Delicious, Latest Diggs, Stumbleupon, Pinterest, Youtube Latest Uploads or Favorites, Flickr, last.fm loved tracks, recent tracks or reply tracker, Dribble shots/likes & vimeo likes, videos, appears_in, all_videos, albums, channels or groups';
		
		function __construct() {
		
			parent::__construct();
			add_action('admin_init', array(&$this,'settings_init'));
			add_action("admin_init",array(&$this,'add_dcwss_option_styles'));
			add_action("admin_init",array(&$this,'add_dcwss_option_scripts'));
			add_action('wp_ajax_dcwss_update', array(&$this,'dcwss_ajax_update'));
			add_action('wp_ajax_dcwss_stream', array(&$this,'dcwss_stream'));
			add_action('wp_ajax_dcwss_stream_edit', array(&$this,'dcwss_stream_edit'));
			add_action('wp_ajax_dcwss_stream_delete', array(&$this,'dcwss_stream_delete'));
		}
		 
		function settings_init() {
		
			register_setting('dcwss_options_group', 'dcwss_options');
		}

		function dcwss_ajax_update(){
		
			$option_name = $_POST['option_name'];
			$newvalue = $_POST['option_value'];
			
			if ( get_option( $option_name ) != $newvalue ) {
				update_option( $option_name, $newvalue );
			} else {
				$deprecated = ' ';
				$autoload = 'no';
				add_option( $option_name, $newvalue, $deprecated, $autoload );
			}
			
			if(isset($_POST['option_name1'])){
				$option_name1 = $_POST['option_name1'];
				$newvalue1 = $_POST['option_value1'];
				
				if ( get_option( $option_name1 ) != $newvalue1 ) {
					update_option( $option_name1, $newvalue1 );
				} else {
					$deprecated = ' ';
					$autoload = 'no';
					add_option( $option_name1, $newvalue1, $deprecated, $autoload );
				}
			}
			
			exit;
		}

		function dcwss_stream() {
			
			global $wpdb;
			$id = 0;
			$content = isset($_POST['form']) ? urldecode($_POST['form']) : '' ;
			$content = json_encode($content);
			$title = isset($_POST['name']) ? $_POST['name'] : 'Stream' ;
			
			if($content != ''){

					$my_post = array(
						 'post_title' => $title,
						 'post_content' => $content,
						 'post_status' => 'publish',
						 'post_author' => 1,
						 'post_type' => 'dc_streams'
					);
					
					$id = wp_insert_post( $my_post );
				
					echo $id;
			}
			die();
		}
		
		function dcwss_stream_edit() {
			
			global $wpdb;
			$id = $_POST['id'];
			$content = isset($_POST['form']) ? urldecode($_POST['form']) : '' ;
			$content = json_encode($content);
			$title = isset($_POST['name']) ? $_POST['name'] : 'Stream' ;
			
			if($content != ''){
				$my_post = array();
				$my_post['ID'] = $id;
				$my_post['post_title'] = $title;
				$my_post['post_content'] = $content;
				wp_update_post( $my_post );
				echo 'Stream Updated';
			}
			die();
		}
		
		function dcwss_stream_delete() {
			
			global $wpdb;
			$id = $_POST['id'];
			wp_delete_post( $id, true ); 
			die();
		}
		
		function option_page() {
			
			global $wpdb;
			$this->setup_admin_page('Social Stream Settings','Social Streams');
		?>

		<script type="text/javascript">
		(function($){
			var initLayout = function() {
			$('.color-selector').each(function(){
				var o = $(this);
				var c = $(this).next('.input-color');
				$(this).ColorPicker({
					color: c.val(),
					onShow: function (colpkr) {
						$(colpkr).fadeIn(500);
						return false;
					},
					onHide: function (colpkr) {
						var hx = $('.colorpicker_hex input',colpkr).val();
						var id = o.attr('id');
						$('#'+id+'_input').val('#'+hx);
						$(colpkr).fadeOut(500);
						return false;
					},
					onChange: function (hsb, hex, rgb) {
						$('div',o).css('backgroundColor', '#' + hex);
					}
				});
			});
		};
	
		EYE.register(initLayout, 'init');
})(jQuery)
		</script>
		
			<?php 
				//delete_option('dcwss_options');
				$networks = dcwss_networks('networks');
				$titles = dcwss_networks('Ids');
				$defaults = dcwss_networks('defaults');
				$settings = dcwss_networks('settings');
				$helptext = dcwss_networks('help');
				$colors = dcwss_default_pickers();
				$help = '<a href="#" class="dcwss-help"><img src="'.dc_jqsocialstream::get_plugin_directory().'/images/help.png" alt="?" /></a>';
				$close = '<a href="#" class="dcwss-close"><img src="'.dc_jqsocialstream::get_plugin_directory().'/images/close.png" alt="x" /></a>';
				$close_1 = '<img src="'.dc_jqsocialstream::get_plugin_directory().'/images/close_1.png" alt="?" />';
				$close_2 = '<img src="'.dc_jqsocialstream::get_plugin_directory().'/images/close_2_off.png" alt="?" class="img-swap" />';
				$load = '<img src="'.dc_jqsocialstream::get_plugin_directory().'/images/loading.gif" alt="Loading" />';
			?>
			
			  <div id="dcwss-slider">
			  <div class="dcwss-slide">
			  <?php include('dcwp_streams.php'); ?>
			</div>
			 <div class="dcwss-slide">
			<form method="post" id="dcwss_settings_page" class="dcwp-form" action="options.php">
			<?php 
				settings_fields('dcwss_options_group'); $options = get_option('dcwss_options');

				if(!isset($options['skin'])){
					$options['skin'] = 'true';
				}
				$skin = $options['skin'];
				foreach($settings as $k => $v){
					if(!isset($options['settings'][$k])){
						$options['settings'][$k] = $v;
					}
				}
				
			?>
			<!-- Start Settings -->
			<div class="metabox-holder">
				  <div class="meta-box-sortables min-low">
				    <div class="postbox dcwp">
					  <h3 class="hndle"><span>Settings</span><?php echo $help; ?></h3>
					  <div class="inside">
					  <div class="dcwss-help-text">
						<h3>Help<?php echo $close; ?></h3>
						<h4>Settings</h4>
						<p>The settings section allows you to configure the default features for displaying the social streams. Settings can be changed for individual social streams using the shortcodes:</p>
						<ul>
							<li class="clear"><label>Stream:</label> Select whether to create the stream based on the total number of days (select "days") or number of items per feed (select "limit").</li>
							<li><label>Results:</label>The maximum number of results to display based on the stream type above - e.g. 10 results per feed or 10 days.</li>
							<li><label>Order:</label>Select whether to order by date or randomly.</li>
							<li class="clear"><label>Filter:</label>When set to "on" a navigation bar of all active network icons will appear either at the bottom of the rotating feed list or above the social network wall. Clicking on these icons will allow the user to filter the stream.</li>
							<li><label>Controls:</label>When set to "on" a control bar will appear at the bottom of each tab when the user hovers over the content. The control navigation allows the user to stop/start the rotating feed or go to next/previous entry.</li>
							<li class="clear"><label>Open Links In New Window:</label>Select "on" to open all links in a new browser window</li>
							<li><label>Cache:</label>Select "on" to enable browser caching of feed - reduces up download time</li>
							<li class="clear"><label>Animation Speed:</label>The speed (in seconds) for the rotating animation.</li>
							<li><label>Height:</label>Only applies to the rotating feed display - The height of the widget in pixels</li>
							<li class="clear"><label>Rotate Delay:</label>Enter the number of seconds between each feed item. To disable the rotating feed option set the delay to zero.</li>
							<li><label>Rotate Direction:</label>Sets the rotating feed direction to either "up" or "down"</li>
							<li class="clear"><label>Twitter ID:</label>Enter the twitter username to use in twitter share links - will appear at the end of tweets as "via @username"</li>
							<li class="clear"><label>Twitter API Credentials:</label>To create your Twitter API credentials see plugin documentation<br />FAQ -> Twitter API Credentials</li>
						</ul>
						<div class="clear"></div>
					</div>
				
				<ul class="list-styles half list-switches">
					<li>
					<label>Stream:</label>
					<?php $val = $options['settings']['max'] != '' ? $options['settings']['max'] : 'days' ; ?> 
					<input type="radio" class="radio" value="days" name="dcwss_options[settings][max]" <?php if ($val == 'days') { echo 'checked="checked"'; }?> /> Days 
					<input type="radio" class="radio" value="limit" name="dcwss_options[settings][max]" <?php if ($val == 'limit') { echo 'checked="checked"'; }?>/> Limit</li>
					<li>
					<label>Results:</label>
					<?php $val = $options['settings']['results'] != '' ? $options['settings']['results'] : 10 ; ?>
					<input id="dcwss_setting_results" name="dcwss_options[settings][results]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Order:</label>
					<?php $val = $options['settings']['order'] != '' ? $options['settings']['order'] : 'date' ; ?> 
					<input type="radio" class="radio" value="date" name="dcwss_options[settings][order]" <?php if ($val == 'date') { echo 'checked="checked"'; }?> /> Date <input type="radio" class="radio" value="random" name="dcwss_options[settings][order]" <?php if ($val == 'random') { echo 'checked="checked"'; }?>/> Random
				  </li>
				  <li>
					<label>Cache:</label>
					<?php
						$val = $options['settings']['cache'] != '' ? $options['settings']['cache'] : 'true' ;
					?>
					<div class="dcwss-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcwss_setting_cache" name="dcwss_options[settings][cache]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				   <li>
					<label>Filter:</label>
					<?php
						$val = $options['settings']['filter'] != '' ? $options['settings']['filter'] : 'true' ;
					?>
					<div class="dcwss-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcwss_setting_filter" name="dcwss_options[settings][filter]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				  <li class="tall">
					<label>Open Links In New Window:</label>
					<?php
						$val = $options['settings']['external'] != '' ? $options['settings']['external'] : 'true' ;
					?>
					<div class="dcwss-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcwss_setting_external" name="dcwss_options[settings][external]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				</ul>
				<ul class="list-styles half list-switches">
				  <li>
					<label>Animation Speed:</label>
					<?php $val = $options['settings']['speed'] != '' ? $options['settings']['speed'] : 0.6 ; ?>
					<input id="dcwss_setting_speed" name="dcwss_options[settings][speed]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Height:</label>
					<?php $val = $options['settings']['height'] != '' ? $options['settings']['height'] : 490 ; ?>
					<input id="dcwss_setting_height" name="dcwss_options[settings][height]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Controls:</label>
					<?php
						$val = $options['settings']['controls'] != '' ? $options['settings']['controls'] : 'true' ;
					?>
					<div class="dcwss-switch-link">
						<a href="#" rel="true" class="link-true <?php echo $val == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $val == 'false' ? 'active' : '' ; ?>"></a>
					</div>
					<input id="dcwss_setting_controls" name="dcwss_options[settings][controls]" class="dc-switch-value" type="hidden" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Rotate Delay:</label>
					<?php $val = $options['settings']['rotate_delay'] != '' ? $options['settings']['rotate_delay'] : 6 ; ?>
					<input id="dcwss_setting_rotate_delay" name="dcwss_options[settings][rotate_delay]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Rotate Direction:</label>
					<?php $val = $options['settings']['rotate_direction'] != '' ? $options['settings']['rotate_direction'] : 'down' ; ?> 
					<input type="radio" class="radio" value="up" name="dcwss_options[settings][rotate_direction]" <?php if ($val == 'up') { echo 'checked="checked"'; }?> /> Up <input type="radio" class="radio" value="down" name="dcwss_options[settings][rotate_direction]" <?php if ($val == 'down') { echo 'checked="checked"'; }?>/> Down
				  </li>
				   <li>
					<label>Twitter ID:</label>
					<?php $val = $options['settings']['twitterId'] != '' ? $options['settings']['twitterId'] : '' ; ?>
					<input id="dcwss_setting_twitterId" name="dcwss_options[settings][twitterId]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  </ul>
				  
				  
				
				
				<input id="dcwss_setting_iconPath" name="dcwss_options[settings][iconPath]" type="hidden" value="" />
				<input id="dcwss_setting_imagePath" name="dcwss_options[settings][imagePath]" type="hidden" value="" />
				<div class="clear"></div>
			</div></div></div></div>
			
			
			<div class="metabox-holder">
				  <div class="meta-box-sortables">
				    <div class="postbox dcwp">
					  <h3 class="hndle"><span>Social Network APIs & Authentication</span></h3>
					  <div class="inside">
					  
					  <p class="note">For step-by-step instructions on how to create your Twitter & Facebook API settings please see plugin documentation section: Social Network APIs & Authentication</p>
					 
				  <h4 class="clear">Twitter API Credentials - Required For All Twitter Feeds</h4>

				<ul class="twitter-credentials">
				  <li>
					<label>Consumer Key:</label>
					<?php $val = $options['settings']['consumer_key'] != '' ? $options['settings']['consumer_key'] : '' ; ?>
					<input id="dcwss_setting_consumer_key" name="dcwss_options[settings][consumer_key]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Consumer Secret:</label>
					<?php $val = $options['settings']['consumer_secret'] != '' ? $options['settings']['consumer_secret'] : '' ; ?>
					<input id="dcwss_setting_consumer_secret" name="dcwss_options[settings][consumer_secret]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>OAuth Access Token:</label>
					<?php $val = $options['settings']['access_token'] != '' ? $options['settings']['access_token'] : '' ; ?>
					<input id="dcwss_setting_access_token" name="dcwss_options[settings][access_token]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>OAuth Access Token Secret:</label>
					<?php $val = $options['settings']['access_token_secret'] != '' ? $options['settings']['access_token_secret'] : '' ; ?>
					<input id="dcwss_setting_access_token_secret" name="dcwss_options[settings][access_token_secret]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  
				</ul>
				
				 <h4 class="clear">Facebook APP Details - Required For All Facebook Page Feeds</h4>

				<ul class="twitter-credentials">
				  <li>
					<label>Facebook App ID:</label>
					<?php $val = $options['settings']['fb_app_id'] != '' ? $options['settings']['fb_app_id'] : '' ; ?>
					<input id="dcwss_setting_consumer_key" name="dcwss_options[settings][fb_app_id]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				  <li>
					<label>Facebook App Secret:</label>
					<?php $val = $options['settings']['fb_app_secret'] != '' ? $options['settings']['fb_app_secret'] : '' ; ?>
					<input id="dcwss_setting_consumer_secret" name="dcwss_options[settings][fb_app_secret]" class="text-input" type="text" value="<?php echo $val; ?>" />
				  </li>
				</ul>
			
			
			</div></div></div></div>
			
			
			<?php 
				// styling
				$skin = $options['skin'] != '' ? $options['skin'] : 'true' ;
				$fixed = $options['fixed'] != '' ? $options['fixed'] : 'false' ;
				$def_color = dcwss_default_pickers(); 
			?>
					  
			<div class="metabox-holder">
				  <div class="meta-box-sortables">
				    <div class="postbox dcwp">
					  <h3 class="hndle"><span>Styling</span><?php echo $help; ?></h3>
					  <div class="inside">
					  <div class="dcwss-help-text">
						<h3>Help<?php echo $close; ?></h3>
						<h4>Default Skin</h4>
						<p>Switch the default skin option to "Off" to stop the loading of the default CSS file.</p>
						<h4>Default Tab Color</h4>
						<p>To change the default background color of the social network wall filter tabs click on the colored box - a colorpicker should now appear. Select the new color and then click elsewhere on the screen to close the colorpicker widget. The colored box should now be updated using the new color.</p>
						<h4>Social Network Colors</h4>
						<p>These show the background colors used for the individual social networks. To change one of the network colors click on the relevant colored box - a colorpicker should now appear. Select the new color and then click elsewhere on the screen to close the colorpicker widget. The colored box should now be updated using the new color.</p>
						<h4>Social Wall Feed Item Width</h4>
						<p>The default styling for the social network wall uses % widths for the feed items. To change this to fixed widths set the "Use Fixed Widths" switch to "on" and enter the preferred width and margins (in pixels) for your wall feed items. Turn "off" to revert back to the default % widths.</p>
						<h4>Custom CSS</h4>
						<p>Custom CSS for styling the social media tabs can be entered into the text field. Any CSS rules included in this text area will automatically be inserted into the page.</p>
					</div>

				<ul class="margin-bottom">
					<li>
					  <label for="dcwss_skin">Default Skin:</label>
					  <div class="dcwss-switch-link link-skin">
						<a href="#" rel="true" class="link-true <?php echo $skin == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $skin == 'false' ? 'active' : '' ; ?>"></a>
						</div>
						<input id="dcwss_skin" name="dcwss_options[skin]" class="dc-switch-value" type="hidden" value="<?php echo $skin; ?>" />
					</li>
				</ul>
				
				<div class="default-styles <?php echo $skin; ?>">
					
					<h4 class="clear">Filter Background Color</h4>
					<ul class="list-styles list-picker">
						<?php
							$c = $options['color_tab'] != '' ? $options['color_tab'] : '#777';
						?>
						<li><div id="picker_tab" class="color-selector"><div style="background-color: <?php echo $c; ?>;"></div></div>
							<span>Background</span>
							<input class="input-color" name="dcwss_options[color_tab]" id="picker_tab_input" type="hidden" value="<?php echo $c; ?>" />
						</li>
					</ul>
					
					<h4 class="clear">Social Network Colors</h4>
					<ul class="list-styles list-picker">
						<?php
							foreach($networks as $k => $v){
								$c = $options['color_'.$k] != '' ? $options['color_'.$k] : $def_color[$k];
								echo '<li><div id="picker_'.$k.'" class="color-selector"><div style="background-color: '.$c.';"></div></div>';
								echo '<span>'.$v.'</span>';
								echo '<input class="input-color" name="dcwss_options[color_'.$k.']" id="picker_'.$k.'_input" type="hidden" value="'.$c.'" /></li>';
							}
						?>
					</ul>
				</div>
				
				<h4 class="clear">Social Wall Feed Item Width</h4>
				
				<ul class="margin-bottom">
					<li>
					  <label for="dcwss_fixed">Use Fixed Widths:</label>
					  <div class="dcwss-switch-link link-fixed">
						<a href="#" rel="true" class="link-true <?php echo $fixed == 'true' ? 'active' : '' ; ?>"></a>
						<a href="#" rel="false" class="link-false <?php echo $fixed == 'false' ? 'active' : '' ; ?>"></a>
					  </div>
					  <input id="dcwss_fixed" name="dcwss_options[fixed]" class="dc-switch-value" type="hidden" value="<?php echo $fixed; ?>" />
					</li>
				</ul>
				
				<ul class="clear" id="feed-item-widths">
					<li>
						<label>Width (px):</label>
						<?php $val = $options['fixed_width'] != '' ? $options['fixed_width'] : '226' ; ?>
						<input id="dcwss_fixed_width" name="dcwss_options[fixed_width]" class="text-input" type="text" value="<?php echo $val; ?>" />
					</li>
					<li>
						<label>Margin Top (px):</label>
						<?php $val = $options['fixed_margin_top'] != '' ? $options['fixed_margin_top'] : '0' ; ?>
						<input id="dcwss_fixed_margin_top" name="dcwss_options[fixed_margin_top]" class="text-input" type="text" value="<?php echo $val; ?>" />
					</li>
					<li>
						<label>Margin Right (px):</label>
						<?php $val = $options['fixed_margin_right'] != '' ? $options['fixed_margin_right'] : '15' ; ?>
						<input id="dcwss_fixed_margin_right" name="dcwss_options[fixed_margin_right]" class="text-input" type="text" value="<?php echo $val; ?>" />
					</li>
					<li>
						<label>Margin Bottom (px):</label>
						<?php $val = $options['fixed_margin_bottom'] != '' ? $options['fixed_margin_bottom'] : '15' ; ?>
						<input id="dcwss_fixed_margin_bottom" name="dcwss_options[fixed_margin_bottom]" class="text-input" type="text" value="<?php echo $val; ?>" />
					</li>
					<li>
						<label>Margin Left (px):</label>
						<?php $val = $options['fixed_margin_left'] != '' ? $options['fixed_margin_left'] : '0' ; ?>
						<input id="dcwss_fixed_margin_left" name="dcwss_options[fixed_margin_left]" class="text-input" type="text" value="<?php echo $val; ?>" />
					</li>
				</ul>
				
				<ul class="clear">
					<li>
						<label for="dcwss_css">Custom CSS:</label>
						<textarea class="dcwp-textarea" name="dcwss_options[css]" id="dcwss_css" rows="5"><?php echo $options['css']; ?></textarea>
					</li>
				</ul>
			</div></div></div></div>
			
			
		<div class="submit-container">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<input name="dcwss_options[new_install]" type="hidden" value="no" />
		</div>
		</form>
		</div>
		</div>
		

		</div>

		<div id="dcwss-side" class="postbox-container" style="width:30%;">
			<div class="metabox-holder">	
				<div class="meta-box-sortables">
					<?php
						$this->dcwp_advert();
						$this->likebox();
						$this->latest_posts();
					?>				
				</div>
			</div>
		</div>
	</div>
	<?php
		}
		
		function add_dcwss_option_styles() {

			wp_enqueue_style("dcwss_option_css", plugins_url() . "/wordpress-social-stream/css/colorpicker.css");
		}

		function add_dcwss_option_scripts() {
			wp_enqueue_script('jquery-ui-core');
			wp_enqueue_script('dcwss_option_eye', plugins_url() . '/wordpress-social-stream/inc/js/eye.js');
			wp_enqueue_script('dcwss_option_colorpicker', plugins_url() . '/wordpress-social-stream/inc/js/colorpicker.js');
		}
	}
}