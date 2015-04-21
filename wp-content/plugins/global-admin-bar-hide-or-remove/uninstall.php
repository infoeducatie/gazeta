<?php 

	/**
	 * @package     WordPress Plugin
	 * @subpackage  Global Hide Admin Tool Bar
	 * @description Uninstall Module
	 * @author      sLa NGjI's @ slangji.wordpress.com
	 * @status      Code in Becoming!
	 * @todolist    WordPress 3.9+ and WordPress 4.0+ and WordPress 4.1+ Compatibility
	 *
	 * @indentation //www.gnu.org/prep/standards/standards.html
	 * @license     //www.gnu.org/licenses/gpl-2.0.html
	 * @link        //wordpress.org/plugins/global-admin-bar-hide-or-remove/
	 *
	 * @since  WordPress 3.1+
	 * @tested WordPress 3.7+
	 *
	 * @branche 2014
	 * @version 1.6.1
	 * @build   2014-04-16 1ST - 2014-04-14
	 */

	if ( ! function_exists( 'add_action' ) )

		{

			header( 'HTTP/0.9 403 Forbidden' );
			header( 'HTTP/1.0 403 Forbidden' );
			header( 'HTTP/1.1 403 Forbidden' );
			header( 'Status: 403 Forbidden' );
			header( 'Connection: Close' );

				exit;

		}

	defined ( 'ABSPATH' ) or exit;

	defined ( 'WPINC' ) or exit;

	defined ( 'WP_UNINSTALL_PLUGIN' ) or exit;

	$option_names = array( 

			/**
			 * remove all new options from database to keep it clean
			 *
			 * sLa NGjI's 2014-05-19
			 */

			'global-admin-bar-admins',
			'global-admin-bar-cleanup',
			'global-admin-bar-default',
			'global-admin-bar-disable',
			'global-admin-bar-optimize',
			'global-admin-bar-remove',
			'global-admin-bar-roles',
			'global-admin-bar-settings',
			'global-admin-bar-show',
			'global-admin-bar-speedup',
			'global-admin-bar-users',

			/**
			 * remove all old options from database to keep it clean
			 *
			 * sLa NGjI's 2014-05-18
			 */

			'global-admin-bar-plugin-setting',
			'global-admin-bar-plugin-user-setting',
			'global-admin-bar-profiles'

	);

	if ( ! is_multisite() )

		{

			foreach ( $option_names as $option_name )

				{

					delete_option( $option_name );

				}

		}

	if ( is_multisite() )

		{

			foreach ( $option_names as $option_name )

				{

					delete_option( $option_name );

				}

			global $wpdb;

			$blog_ids         = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
			$original_blog_id = get_current_blog_id();

			foreach ( $blog_ids as $blog_id )

				{

					switch_to_blog( $blog_id );

					foreach ( $option_names as $option_name )

						{

							delete_site_option( $option_name );

						}

				}

			switch_to_blog( $original_blog_id );

		}

?>