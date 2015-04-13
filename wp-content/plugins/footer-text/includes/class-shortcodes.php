<?php

/**
 * Handles the shortcodes used by this plugin
 */
class Footer_Text_Shortcodes {

	/**
	 * The shortcode tags to run* on the footer text, paired with their callbacks
	 *
	 * @var    array
	 * @since  2.0
	 * @access private
	 */
	private $shortcode_tags;

	/**
	 * Constructor
	 *
	 * @param array $shortcode_tags The shortcode tags to be applied to the footer text
	 * @since 2.0
	 */
	function __construct( $shortcode_tags = array() ) {

		$this->shortcode_tags = wp_parse_args(
			$shortcode_tags,
			array(
				'last_modified' => array( $this, 'shortcode_last_modified' ),
				'page_link'     => array( $this, 'shortcode_permalink' ),
				'year'          => array( $this, 'shortcode_current_year' ),
			)
		);

		add_action( 'init', array( $this, 'add_shortcodes' ) );
		add_filter( 'the_content', array( $this, 'post_content_remove_shortcodes' ), 0 );
		add_filter( 'the_content', array( $this, 'post_content_add_shortcodes' ), 99 );
	}

	/**
	 * Returns a formatted link to
	 * the current page's permalink
	 *
	 * @uses   get_permalink()
	 *
	 * @param  array  $atts    Unused
	 * @param  string $content The text the shortcode is wrapped around
	 * @return string
	 *
	 * @since  1.0
	 */
	function shortcode_permalink( $atts, $content ) {
		$label = ! empty( $content ) ? $content : get_permalink();
		return sprintf ( '<a href="%1$s">%2$s</a>', get_permalink(), $label );
	}

	/**
	 * Returns the date when the current page
	 * was last modified
	 *
	 * @uses   the_modified_date()
	 * @return string
	 * @since  1.0
	 */
	function shortcode_last_modified() {
		return the_modified_date( 'd/m/Y', '<time>', '</time>', false );
	}

	/**
	 * Returns the current year, ideal for
	 * a copyright notice
	 *
	 * @return string
	 * @since  1.0
	 */
	function shortcode_current_year() {
		return sprintf ( '<time>%s</time>', date( 'Y' ) );
	}

	/**
	 * Returns an array of the shortcode tags to run
	 * on the footer text, paired with their callbacks
	 *
	 * @return array
	 * @since  1.0
	 * @access public
	 */
	public function get_shortcode_tags() {
		return $this->shortcode_tags;
	}

	/**
	 * Registers our shortcodes with WordPress
	 *
	 * @uses  add_shortcode()
	 * @since 1.0
	 */
	function add_shortcodes() {
		$shortcode_tags = $this->get_shortcode_tags();

		foreach ( $shortcode_tags as $shortcode_tag => $callback ) {
			add_shortcode( $shortcode_tag, $callback );
		}
	}

	/**
	 * Removes our custom shortcodes from the post content
	 * so they don't interfere with anything
	 *
	 * @link   http://justintadlock.com/archives/2013/01/08/disallow-specific-shortcodes-in-post-content
	 *
	 * @param  string $content The post content with the custom shortcodes
	 * @return string          The post content without the custom shortcodes
	 *
	 * @since  1.0
	 */
	function post_content_remove_shortcodes( $content ) {

		/* Retrieve an array of all the shortcode tags */
		$shortcode_tags = $this->get_shortcode_tags();

		/* Loop through the shortcodes and remove them */
		foreach ( $shortcode_tags as $shortcode_tag => $callback ) {
			remove_shortcode( $shortcode_tag );
		}

		/* Return the post content */
		return $content;
	}

	/**
	 * Adds our shortcodes back to the post content when it's safe
	 *
	 * @see    http://justintadlock.com/archives/2013/01/08/disallow-specific-shortcodes-in-post-content
	 *
	 * @param  string $content The post content without the custom shortcodes
	 * @return string          The post content with the custom shortcodes
	 *
	 * @since  1.0
	 */
	function post_content_add_shortcodes( $content ) {

		/* Add the original shortcodes back. */
		$this->add_shortcodes();

		/* Return the post content. */
		return $content;
	}

}
