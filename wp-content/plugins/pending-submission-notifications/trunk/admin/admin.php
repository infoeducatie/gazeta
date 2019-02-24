<?php
/**
 * Create the admin menu link to the plugin settings page. Creates the plugin settings page.
 *
 * @package Pending_Submission_Notification
 * @version 1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( is_admin() ) {
	add_action( 'admin_menu', 'pending_submission_notifications_menu' );
}
/**
 * Registers the plugin menu.
 */
function pending_submission_notifications_menu() {
	add_options_page( 'Pending Submission Notifications Options', 'Pending Submission Notifications', 'manage_options', 'pending-submissions-notifications-settings', 'pending_submission_notifications_options' );
	add_action( 'admin_init', 'register_pending_submission_notifications_settings' );
}


/**
 * Register the plugin settings.
 */
function register_pending_submission_notifications_settings() {
	register_setting( 'pending-submission-notification-group', 'pending_submission_notification_admin_email' );
}

/**
 * Creates the markup for the settings page.
 */
function pending_submission_notifications_options() {

	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'Pending Submission Notifications', 'pending-submission-notifications' ); ?></h2>
		<p><?php esc_html_e( 'Who should receive an email notification for new submissions?', 'pending-submission-notifications' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'pending-submission-notification-group' ); ?>
			<?php do_settings_sections( 'pending-submission-notification-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_html_e( 'Email Address', 'pending-submission-notifications' ); ?>:</th>
					<td><input type="text" name="pending_submission_notification_admin_email" class="regular-text" value="<?php echo esc_attr( get_option( 'pending_submission_notification_admin_email' ) ); ?>"/></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}