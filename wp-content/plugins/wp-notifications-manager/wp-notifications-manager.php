<?php
/**
 * Plugin Name: WP Notifications Manager
 * Description: Allows you to manage new user registration & password change notifications. You can enable/disable the notifications and also specify the email address to which you want the notifications sent.
 * Version: 1.1
 * Author: Chad Anderson
 * Author URI: http://chadanderson.me
 * License: GPL2
 */


/*  Copyright 2014  Chad Anderson  (email : chad@chadanderson.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!defined('WPNM_PLUGIN_DIR'))
	define( 'WPNM_PLUGIN_DIR', untrailingslashit(dirname(__FILE__)));

if (!defined('WPNM_PLUGIN_BASENAME'))
	define('WPNM_PLUGIN_BASENAME', plugin_basename(__FILE__));


require_once WPNM_PLUGIN_DIR . '/options.php';

/**
 * Load the plugin's translated strings
 *
 * @since 1.0
 *
 * 
 */
function wpnm_init() {
	load_plugin_textdomain('wp-notifications-manager', false, dirname(WPNM_PLUGIN_BASENAME) . '/languages');
}
add_action('plugins_loaded', 'wpnm_init');
/**
 * Set the default enable notification options to "Enable" if activating for the first time
 *
 * @since 1.0
 *
 * 
 */
function wp_notifications_manager_activate() {

	$wpnm_options = array(
		'wpnm_enable_user_registration_notification',
	    'wpnm_enable_password_change_notification',
    	);

	foreach ($wpnm_options as $option) {

		// load the option into cache
		$value = get_option($option);

		$notoptions = wp_cache_get('notoptions', 'options');

		// if options don't exist, create them and add default value 1; otherwise, do nothing
		if ( isset( $notoptions[$option] ) ) {
		    update_option($option, 1);
		}
	}
}
register_activation_hook(__FILE__, 'wp_notifications_manager_activate');


if ( !function_exists('wp_new_user_notification')) :
	/**
	 * Notify set admin a new user registered on the site
	 *
	 * @since 1.0
	 *
	 * @param int $user_id User ID, string $plaintext_pass Plaintext Password
	 */
	function wp_new_user_notification($user_id, $plaintext_pass = '') {

		$user = new WP_User($user_id);

		$user_login = stripslashes($user->user_login);
		$user_email = stripslashes($user->user_email);
			
		// check to see if new user registration notification is enabled
		if (get_option('wpnm_enable_user_registration_notification')) {

			$message  = sprintf(__('New user registration on %s:'), get_option('blogname')) . "\r\n\r\n";
			$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
			$message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

			// if email option is set, use that email address; otherwise use default admin email
			$email = (get_option('wpnm_user_registration_email') ? get_option('wpnm_user_registration_email') : get_option('admin_email'));

			@wp_mail(
				$email,
				sprintf(__('[%s] New User Registration'), get_option('blogname')),
				$message
			);
		} 

		if ( empty($plaintext_pass))
				return;

		$message  = __('Hi there,') . "\r\n\r\n";
		$message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
		$message .= wp_login_url() . "\r\n";
		$message .= sprintf(__('Username: %s'), $user_login ) . "\r\n";
		$message .= sprintf(__('Password: %s'), $plaintext_pass ) . "\r\n\r\n";
		$message .= sprintf(__('If you have any problems, please contact me at %s.'), get_option('admin_email')) . "\r\n\r\n";
		$message .= __('Adios!');

		wp_mail(
			$user_email,
			sprintf(__('[%s] Your username and password'), get_option('blogname')),
			$message
		);
	}
endif;

if (!function_exists('wp_password_change_notification')) :
	/**
	 * Notify the blog admin of a user changing password, normally via email.
	 *
	 * @since 1.0
	 *
	 * @param object $user User Object
	 */
	function wp_password_change_notification(&$user) {
		// send a copy of password change notification to the admin
		// but check to see if it's the admin whose password we're changing, and skip this
		if ($user->user_email != get_option('admin_email')) {
			// check to see if password lost/changed notification is enabled
			if (get_option('wpnm_enable_password_change_notification')) {
				$message = sprintf(__('Password Lost and Changed for user: %s'), $user->user_login) . "\r\n";
				// The blogname option is escaped with esc_html on the way into the database in sanitize_option
				// we want to reverse this for the plain text arena of emails.
				$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

				// if email option is set, use that email address; otherwise use default admin email
				$email = (get_option('wpnm_password_change_email') ? get_option('wpnm_password_change_email') : get_option('admin_email'));
				wp_mail($email, sprintf(__('[%s] Password Lost/Changed'), $blogname), $message);

			}
		}
	}
endif;

?>