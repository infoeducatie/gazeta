<?php

add_action('admin_menu', 'wpnm_admin_add_page');
/**
 * Creates the settings page for the plugin
 * 
 * @since 1.0
 * 
 * 
 */
function wpnm_admin_add_page() {
	add_options_page(__('WP Notifications Manager', 'wp-notifications-manager'), __('WP Notifications Manager', 'wp-notifications-manager'), 'manage_options', 'wpnm', 'wpnm_options_page');
}
/**
 * Displays the settings options for the plugin
 * 
 * @since 1.0
 * 
 * 
 */
function wpnm_options_page() { 
?>
	<div class="wrap">
		<h2><?php _e('WP Notifications Manager', 'wp-notifications-manager'); ?></h2>
		<p><?php _e('Manage your WordPress notification emails.', 'wp-notifications-manager'); ?></p>
		<p><?php _e('Enable/disable your notifications. If disabled, no notification emails will be sent.  If enabled, an email will be sent to the email address set here.  If no email address is set, the notification will be sent to the default admin email address.', 'wp-notifications-manager'); ?></p>
		&nbsp;
		<form action="options.php" method="post">
			<?php settings_fields('wpnm_options'); ?>
			
			<?php do_settings_sections('wpnm'); ?>
			 
			<?php 
				if(function_exists('submit_button')) {
					submit_button();
				} else { ?>
					<input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
			<?php	
				} 
			?>
		</form>
	</div>
	 
<?php
}

add_action('admin_init', 'wpnm_admin_init');

/* ------------------------------------------------------------------------- *
 * Setting Registration
 * ------------------------------------------------------------------------- */

/**
 * Initializes the plugin options page
 * 
 * @since 1.0
 * 
 * 
 */
function wpnm_admin_init() {

	// add new user registration notification settings 
	add_settings_section(
		'wpnm_user_registration', 
		__('New User Registration Notification', 'wp-notifications-manager'),
		'wpnm_user_registration_callback', 
		'wpnm'
	);

	add_settings_field(
		'wpnm_enable_user_registration_notification',
		__('Enable', 'wp-notifications-manager'),
		'wpnm_enable_user_registration_notification_callback',
		'wpnm',
		'wpnm_user_registration',
		array(
			__('Activate this setting to receive new user registration notifications.', 'wp-notifications-manager')
			)
	);

	add_settings_field(
		'wpnm_user_registration_email',
		__('Set email address', 'wp-notifications-manager'),
		'wpnm_user_registration_email_callback',
		'wpnm',
		'wpnm_user_registration',
		array(
			__('Set the email address.', 'wp-notifications-manager')
			)
	);

	// add password change notification settings
	add_settings_section(
		'wpnm_password_change',
		__('Password Change Notification', 'wp-notifications-manager'),
		'wpnm_password_change_callback',
		'wpnm'
	);

	add_settings_field(
		'wpnm_enable_password_change_notification',
		__('Enable', 'wp-notifications-manager'),
		'wpnm_enable_password_change_notification_callback',
		'wpnm',
		'wpnm_password_change',
		array(
			__('Activate this setting to receive password change notifications.', 'wp-notifications-manager')
			)
	);

	add_settings_field(
		'wpnm_password_change_email',
		__('Set email address', 'wp-notifications-manager'),
		'wpnm_password_change_email_callback',
		'wpnm',
		'wpnm_password_change',
		array(
			__('Set the email address.', 'wp-notifications-manager')
			)
	);

	// register user registration settings
	register_setting('wpnm_options', 'wpnm_enable_user_registration_notification');
	register_setting('wpnm_options', 'wpnm_user_registration_email', 'wpnm_sanitize_user_registration_email_option');

	// register password change settings
	register_setting('wpnm_options', 'wpnm_enable_password_change_notification');
	register_setting('wpnm_options', 'wpnm_password_change_email', 'wpnm_sanitize_password_change_email_option');

}

/* ------------------------------------------------------------------------- *
 * Section Callbacks
 * ------------------------------------------------------------------------- */

/**
 * Provides the description for the wpnm_user_registration section
 * 
 * @since 1.0
 * 
 * 
 */
function wpnm_user_registration_callback() {
	echo '<p></p>';
}

/**
 * Provides the description for the wpnm_user_registration section
 * 
 * @since 1.0
 * 
 * 
 */
 function wpnm_password_change_callback() {
 	echo '<p></p>';
 }

function wpnm_moderator_notification_callback() {
	echo '<p>' . __('Control comment notifications for your blog.', 'wp-notifications-manager') . '</p>';
}

/* ------------------------------------------------------------------------- *
 * Field Callbacks
 * ------------------------------------------------------------------------- */

/**
 * Renders checkbox to enable user registration notifications
 * 
 * @since 1.1
 * 
 * 
 */
function wpnm_enable_user_registration_notification_callback($args) {
	$html = '<input type="checkbox" id="wpnm_enable_user_registration_notification" name="wpnm_enable_user_registration_notification" value="1" ' . esc_attr( checked(1, get_option('wpnm_enable_user_registration_notification'), false) ) . '/>';

	echo $html;
}
/**
 * Renders text field in input email address for user registration notifications
 * 
 * @since 1.1
 * 
 * 
 */
function wpnm_user_registration_email_callback($args) {
	$html = '<input type="text" id="wpnm_user_registration_email" name="wpnm_user_registration_email" value="' . esc_attr( get_option('wpnm_user_registration_email') ) . '" />';

	echo $html;
}

/**
 * Renders checkbox to enable user registration notifications
 * 
 * @since 1.1
 * 
 * 
 */
function wpnm_enable_password_change_notification_callback($args) {
	$html = '<input type="checkbox" id="wpnm_enable_password_change_notification" name="wpnm_enable_password_change_notification" value="1" ' . esc_attr( checked(1, get_option('wpnm_enable_password_change_notification'), false) ) . '/>';

	echo $html;
}

/**
 * Renders text field in input email address for password change notifications
 * 
 * @since 1.1
 * 
 * 
 */
function wpnm_password_change_email_callback($args) {
	$html = '<input type="text" id="wpnm_password_change_email" name="wpnm_password_change_email" value="' . esc_attr( get_option('wpnm_password_change_email') ) . '" />';

	echo $html;
}

/**
 * Sanitizes and returns new user registration user input
 * 
 * @since 1.0
 * 
 * 
 */
function wpnm_sanitize_user_registration_email_option($input) {

	$output = '';

	if (isset($input)) {
		if ($input != sanitize_email($input)) {
			add_settings_error(
				'wpnm_user_registration_email',
				'wpnm_user_registration_email_error',
				__('You supplied an invalid email address! (New User Registration Email)', 'wp-notifications-manager'),
				'error'
				);

			return $output;

		} else {
			$output= sanitize_email($input);
		}
	}

	return apply_filters('wpnm_sanitize_user_registration_email_option', $output, $input);
}
/**
 * Sanitizes and returns password change user input
 * 
 * @since 1.0
 * 
 * 
 */
function wpnm_sanitize_password_change_email_option($input) {

	$output = '';

	if (isset($input)) {
		if ($input != sanitize_email($input)) {
			add_settings_error(
				'wpnm_password_change_email',
				'wpnm_password_change_email_error',
				__('You supplied an invalid email address! (Password Change Email)', 'wp-notifications-manager'),
				'error'
				);
			
			return;

		} else {
			$output = sanitize_email($input);
		}
	}

	return apply_filters('wpnm_sanitize_password_change_email_option', $output, $input);
}

?>