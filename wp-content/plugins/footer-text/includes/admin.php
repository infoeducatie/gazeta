<?php

/**
 * Dashboard Administration Menu
 */

/**
 * Registers the 'edit_footer_text' cap with WordPress
 *
 * @since 2.0
 */
function add_footer_text_caps() {
	$roles = apply_filters( 'footer_text_roles', array( 'editor', 'administrator' ) );

	foreach ( $roles as $role ) {
		/* Retrieve the editor role to add the cap to */
		$role = get_role( $role );

		/* Add the capability to edit footer text */
		$role->add_cap( 'edit_footer_text' );
	}
}

add_action( 'admin_init', 'add_footer_text_caps');

/**
 * Add the footer text options page to
 * the 'Appearance' dashboard menu
 *
 * @uses   add_theme_page() To register the new sub-menu
 * @return void
 * @since  1.0
 */
function add_footer_text_options_page() {
	add_theme_page(
		__( 'Footer Text', 'footer-text' ),
		__( 'Footer Text', 'footer-text' ),
		'edit_footer_text',
		'footer-text',
		'render_footer_text_options_page'
	);
}

add_action( 'admin_menu', 'add_footer_text_options_page' );

/**
 * Display the footer text options page
 * and save posted text to the database
 *
 * @uses   update_option() To save the text to the database
 * @uses   screen_icon()   To display the dashboard menu icon
 * @uses   wp_editor()     For a visual editor
 * @uses   get_option()    To retrieve the current text from the database
 * @uses   submit_button() To generate a form submit button
 *
 * @return void
 *
 * @since  1.0
 */
function render_footer_text_options_page() {

	if ( isset( $_POST['footer_text'] ) ) {
		update_option( 'theme_footer_text', stripslashes( $_POST['footer_text'] ) );
	}

	echo '<div class="wrap">';

	screen_icon();
	printf ( '<h2>%s</h2>', __( 'Footer Text', 'footer-text' ) );

	echo '<form method="post" action="" style="margin: 20px 0;">';

	wp_editor( get_option( 'theme_footer_text', '' ), 'footer_text' );
	submit_button();

	echo '</form></div>';

}
