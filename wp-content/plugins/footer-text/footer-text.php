<?php
/**
 * Plugin Name: Footer Text
 * Plugin URI:  http://bungeshea.com/plugins/footer-text/
 * Description: Allow changing of the theme footer text easily from the dashboard
 * Author:      Shea Bunge
 * Author URI:  http://bungeshea.com
 * License:     MIT
 * License URI: http://opensource.org/licenses/MIT
 * Version:     2.0.1
 * Text Domain: footer-text
 * Domain Path: /languages
 */

/**
 * Administration
 */
require plugin_dir_path( __FILE__ ) . 'includes/admin.php';

/**
 * Shortcodes
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes.php';
$GLOBALS['footer_text_shortcodes'] = new Footer_Text_Shortcodes();

/**
 * Template Tags
 */
require plugin_dir_path( __FILE__ ) . 'includes/template-tags.php';


/**
 * Load the plugin textdomain
 */
function load_footer_text_textdomain() {
	load_plugin_textdomain( 'footer-text', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'load_footer_text_textdomain' );
