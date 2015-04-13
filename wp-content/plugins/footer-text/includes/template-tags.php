<?php

/**
 * Template Tags
 */

/**
 * Format the footer text by applying the same filters that are
 * used with post content.
 *
 * We could use `apply_filters( 'the_content' )` but some plugins
 * do strange things to this and we don't want to break anything
 *
 * @since 2.0
 */
function footer_text_register_formatting_filters() {

	$filters = array(
		'do_shortcode',
		'wptexturize',
		'convert_smilies',
		'convert_chars',
		'wpautop',
		'shortcode_unautop',
		'capital_P_dangit',
	);

	foreach ( $filters as $filter ) {
		add_filter( 'get_footer_text', $filter );
	}

}

add_action( 'init', 'footer_text_register_formatting_filters' );

/**
 * Fetches the footer text from the database
 * with formatting functions applied
 *
 * @param  string $default What to use if no footer text is set
 * @return string          The formatted footer text
 *
 * @since  1.0
 */
function get_footer_text( $default = '' ) {

	/* Retrieve the footer text from the database */
	$footer_text = get_option( 'theme_footer_text', $default );

	/* Filter and return the text */
	return apply_filters( 'get_footer_text', $footer_text );
}

/**
 * Retrieves the footer text and displays it if it is set
 * Nothing is displayed if the footer text is not set
 *
 * @uses   get_footer_text() To retrieve the footer text
 *
 * @param  string $default   What to display if no text is set
 * @param  string $before    The text to display before the footer text
 * @param  string $after     The text to display after the footer text
 * @return void
 *
 * @since  1.0
 */
function footer_text( $default = '', $before = '', $after = '' ) {
	$footer_text = get_footer_text( $default );

	if ( $footer_text ) {
		echo $before . $footer_text . $after;
	}
}

/**
 * Add an action as an alternate way to add footer text
 */
add_action( 'footer_text', 'footer_text', 10, 3 );
