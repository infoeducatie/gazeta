<?php
/**
 * @package Facebook Open Graph, Google+ and Twitter Card Tags
 * @version 2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Webdados_FB_Admin {

	/* Version */
	private $version;

	/* Database options */
	private $options;

	/* Construct */
	public function __construct( $options, $version ) {
		$this->options = $options;
		$this->version = $version;
	}
	
	/* Admin menu */
	public function create_admin_menu() {
		$options_page = add_options_page( WEBDADOS_FB_PLUGIN_NAME, WEBDADOS_FB_PLUGIN_NAME, 'manage_options', basename(__FILE__), array( $this, 'options_page' ) );
		add_action( 'admin_print_styles-' . $options_page, array( $this, 'admin_style' ) );
		add_action( 'admin_print_scripts-' . $options_page, array( $this, 'admin_scripts' ) );
	}

	/* Register settings and sanitization */
	public function options_init() {
		register_setting( 'wonderm00n_open_graph_settings', 'wonderm00n_open_graph_settings', array( $this, 'validate_options' ) );
	}

	/* WPML - Options translation */
	public function options_wpml($oldvalue, $newvalue, $option) {
		global $webdados_fb;
		if ( $webdados_fb->is_wpml_active() ) {
			// Homepage description
			icl_register_string( 'wd-fb-og', 'wd_fb_og_desc_homepage_customtext', trim($newvalue['fb_desc_homepage_customtext']) );
			// Default description
			icl_register_string( 'wd-fb-og', 'wd_fb_og_fb_desc_default', trim($newvalue['fb_desc_default']) );
		}
	}

	/* Settings link on the plugins page */
	public function place_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=class-webdados-fb-open-graph-admin.php">' . __( 'Settings', 'wonderm00ns-simple-facebook-open-graph-tags' ) . '</a>';
		// place it before other links
		array_unshift( $links, $settings_link );
		return $links;
	}

	/* Extra user fields */
	public function user_contactmethods( $usercontacts ) {
		global $webdados_fb;
		if ( !$webdados_fb->is_yoast_seo_active() ) {
			//Google+
			$usercontacts['googleplus'] = __('Google+', 'wonderm00ns-simple-facebook-open-graph-tags');
			//Twitter
			$usercontacts['twitter'] = __('Twitter username (without @)', 'wonderm00ns-simple-facebook-open-graph-tags');
			//Facebook
			$usercontacts['facebook'] = __('Facebook profile URL', 'wonderm00ns-simple-facebook-open-graph-tags');
		}
		return $usercontacts;
	}

	/* Meta boxes on posts */
	public function add_meta_boxes( $usercontacts ) {
		global $post;
		//All public post types
		$public_types = get_post_types( array('public'=>true) );
		//Do not show for some post types
		$exclude_types = array(
			'attachment',
		);
		$exclude_types = apply_filters( 'fb_og_metabox_exclude_types', $exclude_types );
		if ( is_object($post) ) {
			if ( in_array(get_post_type($post->ID), $public_types) && !in_array(get_post_type($post->ID), $exclude_types) ) {
				add_meta_box(
					'webdados_fb_open_graph',
					WEBDADOS_FB_PLUGIN_NAME,
					array(&$this, 'post_meta_box'),
					$post->post_type
				);
			}
		}
	}
	public function post_meta_box() {
		global $post, $webdados_fb;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'webdados_fb_open_graph_custom_box', 'webdados_fb_open_graph_custom_box_nonce' );
		// Current image value
		$value_image = get_post_meta($post->ID, '_webdados_fb_open_graph_specific_image', true);
		?>
		<p>
			<strong>
				<label for="webdados_fb_open_graph_specific_image">
					<?php _e('Use this image', 'wonderm00ns-simple-facebook-open-graph-tags'); ?>:
				</label>
			</strong>
			<br/>
			<input type="text" id="webdados_fb_open_graph_specific_image" name="webdados_fb_open_graph_specific_image" value="<?php echo esc_attr( $value_image ); ?>" size="50"/>
			<input id="webdados_fb_open_graph_specific_image_button" class="button" type="button" value="<?php echo esc_attr( __('Upload/Choose','wonderm00ns-simple-facebook-open-graph-tags') ); ?>"/>
			<input id="webdados_fb_open_graph_specific_image_button_clear" class="button" type="button" value="<?php echo esc_attr( __('Clear field','wonderm00ns-simple-facebook-open-graph-tags') ); ?>"/>
			<br/>
			<?php printf( __( 'Recommended size: %dx%dpx', 'wonderm00ns-simple-facebook-open-graph-tags' ), WEBDADOS_FB_W, WEBDADOS_FB_H); ?>
			<script type="text/javascript">
			jQuery(document).ready(function($){
				// Instantiates the variable that holds the media library frame.
				var meta_image_frame;
				// Runs when the image button is clicked.
				$('#webdados_fb_open_graph_specific_image_button').click(function(e){
					// Prevents the default action from occuring.
					e.preventDefault();
					// If the frame already exists, re-open it.
					if ( meta_image_frame ) {
						meta_image_frame.open();
						return;
					}
					// Sets up the media library frame
					meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
						title: "<?php _e('Select image', 'wonderm00ns-simple-facebook-open-graph-tags'); ?>",
						button: { text:  "<?php _e('Use this image', 'wonderm00ns-simple-facebook-open-graph-tags'); ?>" },
						library: { type: 'image' }
					});
					// Runs when an image is selected.
					meta_image_frame.on('select', function(){
						// Grabs the attachment selection and creates a JSON representation of the model.
						var media_attachment = meta_image_frame.state().get('selection').first().toJSON();
						// Sends the attachment URL to our custom image input field.
						$('#webdados_fb_open_graph_specific_image').val(media_attachment.url);
					});
					// Opens the media library frame.
					meta_image_frame.open();
				});
				// Clear
				$('#webdados_fb_open_graph_specific_image_button_clear').click(function(e){
					// Prevents the default action from occuring.
					e.preventDefault();
					// Clears field
					$('#webdados_fb_open_graph_specific_image').val('');
				});
			});
			</script>
		</p>

		<?php
		// Current description value
		$value_description = get_post_meta($post->ID, '_webdados_fb_open_graph_specific_description', true);
		?>
		<p>
			<strong>
				<label for="webdados_fb_open_graph_specific_description">
					<?php _e('Use this description', 'wonderm00ns-simple-facebook-open-graph-tags'); ?>:
				</label>
			</strong>
			<br/>
			<?php
			if ( $webdados_fb->is_yoast_seo_active() && $this->options['fb_show_wpseoyoast']==1 ) {
				_e('The Yoast SEO integration is active, so it\'s description will be used', 'wonderm00ns-simple-facebook-open-graph-tags');
			} else {
				?>
				<textarea id="webdados_fb_open_graph_specific_description" name="webdados_fb_open_graph_specific_description" style="width: 100%;" rows="3"><?php echo esc_textarea(trim($value_description)); ?></textarea>
				<br/>
				<?php
				_e('If this field is not filled, the description will be generated from the excerpt, if it exists, or from the content', 'wonderm00ns-simple-facebook-open-graph-tags');
			}
			?>
		</p>
		<?php
		
	}
	public function save_meta_boxes($post_id) {
		global $webdados_fb_open_graph_settings;
		$save=true;
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) || empty($_POST['post_type']))
			return $post_id;
		// If the post is not public
		$post_type = get_post_type_object( get_post_type($post_id) );
		if ($post_type->public) {
			//OK - Go on
		} else {
			//Not publicly_queryable (or page) -> Go away
			return $post_id;
		}

		// Check if our nonce is set.
		if (!isset($_POST['webdados_fb_open_graph_custom_box_nonce']))
			$save=false;
	  	
	  	$nonce=(isset($_POST['webdados_fb_open_graph_custom_box_nonce']) ? $_POST['webdados_fb_open_graph_custom_box_nonce'] : '');

		// Verify that the nonce is valid.
		if (!wp_verify_nonce($nonce, 'webdados_fb_open_graph_custom_box'))
			$save=false;

		// Check the user's permissions.
		if ('page' == $_POST['post_type']) {
			if (!current_user_can('edit_page', $post_id))
				$save=false;
		} else {
			if (!current_user_can('edit_post', $post_id))
				$save=false;
		}
		if ($save) {
			/* OK, its safe for us to save the data now. */
			//Image
			if ( isset($_POST['webdados_fb_open_graph_specific_image']) ) {
				// Sanitize user input.
				$mydata = trim( sanitize_text_field( $_POST['webdados_fb_open_graph_specific_image'] ) );
				// Update the meta field in the database.
				update_post_meta($post_id, '_webdados_fb_open_graph_specific_image', $mydata);
			}
			//Description
			if ( isset($_POST['webdados_fb_open_graph_specific_description']) ) {
				// Sanitize user input.
				if ( get_bloginfo('version')>='4.7.0' ) { //sanitize_textarea_field only exists since 4.7.0
					$mydata = trim( sanitize_textarea_field( $_POST['webdados_fb_open_graph_specific_description'] ) );
				} else {
					//Just in case...
					$mydata = trim( sanitize_text_field( $_POST['webdados_fb_open_graph_specific_description'] ) );
				}
				// Update the meta field in the database.
				update_post_meta($post_id, '_webdados_fb_open_graph_specific_description', $mydata);
			}
		}
		if ($save) {
			//Force Facebook update anyway - Our meta box could be hidden - Not really! We'll just update if we got our metabox
			if (get_post_status($post_id)=='publish' && intval($this->options['fb_adv_notify_fb'])==1) {
				$fb_debug_url='http://graph.facebook.com/?id='.urlencode(get_permalink($post_id)).'&scrape=true&method=post';
				$response=wp_remote_get($fb_debug_url);
				if ( is_wp_error($response) ) {
					$_SESSION['wd_fb_og_updated_error']=1;
					$_SESSION['wd_fb_og_updated_error_message']=__('URL failed:', 'wonderm00ns-simple-facebook-open-graph-tags').' '.$fb_debug_url;
				} else {
					if ( $response['response']['code']==200 && intval($this->options['fb_adv_supress_fb_notice'])==0 ) {
						$_SESSION['wd_fb_og_updated']=1;
					} else {
						if ( $response['response']['code']==500 ) {
							$_SESSION['wd_fb_og_updated_error']=1;
							$error=json_decode($response['body']);
							$_SESSION['wd_fb_og_updated_error_message']=__('Facebook returned:', 'wonderm00ns-simple-facebook-open-graph-tags').' '.$error->error->message;
						}
					}
				}
			}
		}
		return $post_id;
	}
	public function admin_notices() {
		if ($screen = get_current_screen()) {
			if (isset($_SESSION['wd_fb_og_updated']) && $_SESSION['wd_fb_og_updated']==1 && $screen->parent_base=='edit' && $screen->base=='post') {
				global $post;
				?>
				<div class="updated">
					<p><?php _e('Facebook Open Graph Tags cache updated/purged.', 'wonderm00ns-simple-facebook-open-graph-tags'); ?> <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink($post->ID));?>" target="_blank"><?php _e('Share this on Facebook', 'wonderm00ns-simple-facebook-open-graph-tags'); ?></a></p>
				</div>
				<?php
			} else {
				if (isset($_SESSION['wd_fb_og_updated_error']) && $_SESSION['wd_fb_og_updated_error']==1 && $screen->parent_base=='edit' && $screen->base=='post') {
					?>
					<div class="error">
						<p><?php
							echo '<b>'.__('Error: Facebook Open Graph Tags cache NOT updated/purged.', 'wonderm00ns-simple-facebook-open-graph-tags').'</b>';
							echo '<br/>'.$_SESSION['wd_fb_og_updated_error_message'];
						?></p>
					</div>
					<?php
				}
			}
		}
		unset($_SESSION['wd_fb_og_updated']);
		unset($_SESSION['wd_fb_og_updated_error']);
		unset($_SESSION['wd_fb_og_updated_error_message']);
	}

	/* Options page */
	public function options_page() {
		$options = $this->options;
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/options-page.php';
	}
	public function admin_style() {
		wp_enqueue_style( 'webdados_fb_admin_style', plugins_url( 'css/webdados-fb-open-graph-admin.css', __FILE__ ), false, $this->version );
	}
	public function admin_scripts() {
		wp_enqueue_script( 'webdados_fb_admin_script', plugins_url( 'js/webdados-fb-open-graph-admin.js', __FILE__ ), array( 'jquery', 'jquery-ui-tabs', 'media-upload' ), $this->version );
		wp_localize_script( 'webdados_fb_admin_script', 'texts', array(
			'select_image'	=> __('Select image', 'wonderm00ns-simple-facebook-open-graph-tags'),
			'use_this_image'	=> __('Use this image', 'wonderm00ns-simple-facebook-open-graph-tags'),
		) );
	}

	/* Sanitize options */
	public function validate_options( $options ) {
		global $webdados_fb;
		$all_options = $webdados_fb->all_options();
		foreach($all_options as $key => $temp) {
			if ( isset($options[$key]) ) {
				switch($temp) {
					case 'intval':
						$options[$key] = intval($options[$key]);
						break;
					case 'trim':
						$options[$key] = trim($options[$key]);
						break;
				}
			} else {
				switch($temp) {
					case 'intval':
						$options[$key] = 0;
						break;
					case 'trim':
						$options[$key] = '';
						break;
				}
			}
		}
		return $options;
	}

}