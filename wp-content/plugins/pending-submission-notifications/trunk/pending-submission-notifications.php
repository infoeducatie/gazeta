<?php
/**
 * Plugin Name: Pending Submission Notification
 * Plugin URI: http://lifeofadesigner.com
 * Description: Send email notifications to the admin whenever a new article is submitted for review by a contributor
 * Author: Razvan Horeanga
﻿﻿ * ﻿Text Domain: pending-submission-notifications
 * Version: 1.2
 * Author URI: http://lifeofadesigner.com

 * @package Pending_Submission_Notification
 * @version 1.2
 **/

// Exit if file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once plugin_dir_path( __FILE__ ) . 'admin/admin.php';

add_action( 'transition_post_status', 'pending_submission_notifications_send_email', 10, 3 );

/**
 * Send out email depending on who updates the status of the post.
 *
 * @param string  $new_status New post status.
 * @param string  $old_status Old post status.
 * @param WP_Post $post Post object.
 */
function pending_submission_notifications_send_email( $new_status, $old_status, $post ) {

	// Notify Admin that Contributor has written a post.
	if ( 'pending' === $new_status && user_can( $post->post_author, 'edit_posts' ) && ! user_can( $post->post_author, 'publish_posts' ) ) {
		$pending_submission_email = get_option( 'pending_submission_notification_admin_email' );
		$admins                   = ( empty( $pending_submission_email ) ) ? get_option( 'admin_email' ) : $pending_submission_email;
		$edit_link                = get_edit_post_link( $post->ID, '' );
		$preview_link             = get_permalink( $post->ID ) . '&preview=true';
		$username                 = get_userdata( $post->post_author );
		$username_last_edit       = get_the_modified_author();
		$subject                  = __( 'New submission pending review', 'pending-submission-notifications' ) . ': "' . $post->post_title . '"';
		$message                  = __( 'A new submission is pending review.', 'pending-submission-notifications' );
		$message                 .= "\r\n\r\n";
		$message                 .= __( 'Author', 'pending-submission-notifications' ) . ': ' . $username->user_login . "\r\n";
		$message                 .= __( 'Title', 'pending-submission-notifications' ) . ': ' . $post->post_title . "\r\n";
		$message                 .= __( 'Last edited by', 'pending-submission-notifications' ) . ': ' . $username_last_edit . "\r\n";
		$message                 .= __( 'Last edit date', 'pending-submission-notifications' ) . ': ' . $post->post_modified;
		$message                 .= "\r\n\r\n";
		$message                 .= __( 'Edit the submission', 'pending-submission-notifications' ) . ': ' . $edit_link . "\r\n";
		$message                 .= __( 'Preview the submission', 'pending-submission-notifications' ) . ': ' . $preview_link;
		$result                   = wp_mail( $admins, $subject, $message );
	} // Notify Contributor that Admin has published their post.
	elseif ( 'pending' === $old_status && 'publish' === $new_status && user_can( $post->post_author, 'edit_posts' ) && ! user_can( $post->post_author, 'publish_posts' ) ) {
		$username = get_userdata( $post->post_author );
		$url      = get_permalink( $post->ID );
		$subject  = __( 'Your submission is now live! ', 'pending-submission-notifications' );
		$message  = '"' . $post->post_title . '" ' . __( 'was just published ', 'pending-submission-notifications' ) . "! \r\n\r\n";
		$message .= $url;
		$result   = wp_mail( $username->user_email, $subject, $message );
	}
}