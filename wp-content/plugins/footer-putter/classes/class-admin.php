<?php
abstract class Footer_Putter_Admin {
	protected $version;
	protected $path;
	protected $parent_slug;
	protected $slug;
    protected $screen_id;
    private $tooltips;
    private $tips = array();

	function __construct($version, $path, $parent_slug, $slug = '') {
		$this->version = $version;
		$this->path = $path;
		$this->parent_slug = $parent_slug;
		if (empty($slug))
			$this->slug = $this->parent_slug;
		else
			$this->slug = $this->parent_slug.'-'.$slug;
		$this->tooltips = new Footer_Putter_Tooltip($this->tips);
		$this->init();
	}
	
    function get_screen_id(){
		return $this->screen_id;
	}

	function get_version() {
		return $this->version;
	}

    function get_path() {
		return $this->path;
	}

    function get_parent_slug() {
		return $this->parent_slug;
	}

    function get_slug() {
		return $this->slug;
	}

 	function get_url() {
		return admin_url('admin.php?page='.$this->get_slug());
	}

 	function get_code($code='') {
 		$format = empty($code) ? '%1$s' : '%1$s-%2$s';	
		return sprintf($format, $this->get_parent_slug(), $code);
	}
	
	function get_keys() { 
		return array_keys($this->tips);
	}

	function get_tip($label) { 
		return $this->tooltips->tip($label);
	}

	function plugin_action_links ( $links, $file ) {
		if ( is_array($links) && ($this->get_path() == $file )) {
			$settings_link = '<a href="' .$this->get_url() . '">Settings</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;
	}

	function set_tooltips($tips) {
		$this->tips = $tips;
		$this->tooltips = new Footer_Putter_Tooltip($this->tips);
		$this->add_tooltip_support();
	}
	
	function add_tooltip_support() {
		add_action('admin_enqueue_scripts', array( $this, 'enqueue_tooltip_styles'));
		add_action('admin_enqueue_scripts', array( $this, 'enqueue_color_picker_styles'));
		add_action('admin_enqueue_scripts', array( $this, 'enqueue_color_picker_scripts'));
	}
	
	function register_tooltip_styles() {
		wp_register_style('diy-tooltip', plugins_url('styles/tooltip.css',dirname(__FILE__)), array(), $this->get_version());
	}	

	function register_admin_styles() {
		wp_register_style($this->get_code('admin'), plugins_url('styles/admin.css',dirname(__FILE__)), array(),$this->get_version());
	}

	function enqueue_admin_styles() {
		wp_enqueue_style($this->get_code('admin'));
 	}

	function enqueue_tooltip_styles() {
		wp_enqueue_style('diy-tooltip');
		wp_enqueue_style('dashicons');
	}	

	function enqueue_color_picker_styles() {
        wp_enqueue_style('wp-color-picker');
	}

	function enqueue_color_picker_scripts() {
		wp_enqueue_script('wp-color-picker');
		add_action('admin_print_footer_scripts', array($this, 'enable_color_picker'));
 	}

    function enable_color_picker() {
	    print <<< SCRIPT
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
	        $('.color-picker').wpColorPicker();
		});
		//]]>
	</script>
SCRIPT;
    }

	function enqueue_postbox_scripts() {
		wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');	
		add_action('admin_footer-'.$this->get_screen_id(), array($this, 'toggle_postboxes'));
 	}
 		
	function toggle_postboxes() {
		$hook = $this->get_screen_id();
    	print <<< SCRIPT
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready( function($) {
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	postboxes.add_postbox_toggles('{$hook}');
});
//]]>
</script>
SCRIPT;
    }	

 	function add_meta_box($code, $title, $callback_func, $callback_params = null, $context = 'normal', $priority = 'core', $post_type = false ) {
		if (empty($post_type)) $post_type = $this->get_screen_id();
		add_meta_box($this->get_code($code), __($title), array($this, $callback_func), $post_type, $context, $priority, $callback_params);
	}

	function form_field($id, $name, $label, $value, $type, $options = array(), $args = array(), $wrap = false) {
		if (!$label) $label = $id;
		$label_args = (is_array($args) && array_key_exists('label_args', $args)) ? $args['label_args'] : false;
 		return Footer_Putter_Utils::form_field($id, $name, $this->tooltips->tip($label, $label_args), $value, $type, $options, $args, $wrap);
 	}	

	function print_form_field($fld, $value, $type, $options = array(), $args = array(), $wrap = false) {
 		print $this->form_field($fld, $fld, false, $value, $type, $options, $args, $wrap);
 	}	

	function print_text_field($fld, $value, $args = array()) {
 		$this->print_form_field($fld, $value, 'text', array(), $args);
 	}
 	
	function admin_heading($title = '', $icon_class = '') {
		if (empty($title)) $title = sprintf('%1$s %2$s', ucwords(str_replace('-',' ',$this->slug)), $this->get_version());
		$icon = empty($icon_class) ? '' : sprintf('<i class="%1$s"></i>',
			'dashicons-'==substr($icon_class,0,10) ? ('dashicons '.$icon_class) : $icon_class) ;
    	return sprintf('<h2 class="title">%2$s%1$s</h2>', $title, $icon);				
	}

	function print_admin_form_with_sidebar_start($title) {
    	print <<< ADMIN_START
<div class="wrap">
{$title}
<div id="poststuff" class="metabox-holder has-right-sidebar">
<div id="side-info-column" class="inner-sidebar">
ADMIN_START;
	}

	function print_admin_form_with_sidebar_middle($enctype = false) {
		$this_url = $_SERVER['REQUEST_URI'];
	 	$enctype = $enctype ? 'enctype="multipart/form-data" ' : '';
	    print <<< ADMIN_MIDDLE
</div>
<div id="post-body" class="has-sidebar"><div id="post-body-content" class="has-sidebar-content diy-wrap">
<form id="diy_options" method="post" {$enctype}action="{$this_url}">
ADMIN_MIDDLE;
	}
	
	function print_admin_form_start($title, $enctype = false) {
	 	$this_url = $_SERVER['REQUEST_URI'];
	 	$enctype = $enctype ? 'enctype="multipart/form-data" ' : '';
    	print <<< ADMIN_START
<div class="wrap">
{$title}
<div id="poststuff" {$enctype}class="metabox-holder"><div id="post-body"><div id="post-body-content">
<form id="diy_options" method="post" {$enctype}action="{$this_url}">
ADMIN_START;
	}
	
	function print_admin_form_end($referer = false, $keys = false, $button_text = 'Save Changes') {
		$nonces = $referer ? $this->get_nonces($referer) : '';
		$page_options = $button = '';
		if ($keys) {
			$keys = is_array($keys) ? implode(',', $keys) : $keys;
			$page_options = sprintf('<input type="hidden" name="page_options" value="%1$s" />', $keys);
			$button = $this->submit_button($button_text);
		}
		print <<< ADMIN_END
<p class="submit">{$button}{$page_options}{$nonces}</p>
</form></div></div><br class="clear"/></div></div>
ADMIN_END;
	}
	
	function get_nonces($referer) {
		return wp_nonce_field($referer, '_wpnonce', true, false).
			wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false, false ).
			wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false, false);
	}
	
 	function submit_button($button_text='Save Changes') {	
		return sprintf('<input type="submit" name="options_update" value="%1$s" class="button-primary" />', $button_text);
	}
 	
	function save_options($options_class, $settings_name, $trim_option_prefix = false) {
	
  		$page_options = explode(",", stripslashes($_POST['page_options']));
  		
  		if (is_array($page_options)) {
  			$options = call_user_func( array($options_class, 'get_options'));
  			$updates = false; 
    		foreach ($page_options as $option) {
       			$option = trim($option);
       			$val = array_key_exists($option, $_POST) ? trim(stripslashes($_POST[$option])) : '';
       			if ($trim_option_prefix) $option = substr($option,$trim_option_prefix); //remove prefix
				$options[$option] = $val;
    		} //end for
   			$saved = call_user_func( array($options_class, 'save_options'), $options) ;
   			if ($saved)  {
	  		    $class='updated fade';		
       			$message = 'settings saved successfully.';
   			} else {
 	 		    $class='error fade';
       			$message = 'settings have not been changed.';
			}
  		} else {
  		    $class='error';
       		$message= 'settings not found!';
  		}
  		return sprintf('<div id="message" class="%1$s"><p>%2$s %3$s</p></div>',
  			$class, __($settings_name), __($message));
	}

    function fetch_message() {
		$message = '' ;
		if (isset($_REQUEST['message']) && ! empty($_REQUEST['message'])) { 
			$message = urldecode($_REQUEST['message']);
			$_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
			$style = strpos($message,'success') !== FALSE ? ' success' : (strpos($message,'fail') !== FALSE ? ' error' : '');
			$message = sprintf('<div class="updated %2$$">%1$s</div>',$message,$style); 
		}
		return $message;
    } 

	function screen_layout_columns($columns, $screen) {
		if (!defined( 'WP_NETWORK_ADMIN' ) && !defined( 'WP_USER_ADMIN' )) {
			if ($screen == $this->get_screen_id()) {
				$columns[$this->get_screen_id()] = 2;
			}
		}
		return $columns;
	}

	abstract function init() ;

	abstract function admin_menu() ;

	abstract function page_content(); 

	abstract function load_page();

}
