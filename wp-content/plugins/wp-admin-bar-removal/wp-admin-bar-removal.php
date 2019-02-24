<?php
/*
Plugin Name: WP Admin Bar Removal
Plugin URI: http://slangji.wordpress.com/wp-admin-bar-removal/
Description: disable admin bar or toolbar on WordPress 3.1+ to 3.8+ for all admin and user roles, completely remove code on front and back end with related user personal options settings, for minimize memory consumption and speed up loading of the admin control panel with new unified coding approach, without loosing logout and network multisite functionality: the configuration of this plugin is Automatic!
Version: 2014.0816.0392
Author: slangjis
Author URI: http://slangji.wordpress.com/
Requires at least: 3.1
Tested up to: 3.9.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
Indentation: GNU style coding standard
Indentation URI: http://www.gnu.org/prep/standards/standards.html
Humans: We are the humans behind
Humans URI: http://humanstxt.org/Standard.html
 *
 * LICENSING (license.txt)
 *
 * [WP Admin Bar Removal](//wordpress.org/plugins/wp-admin-bar-removal/)
 *
 * Disable WordPress Admin Bar or Toolbar and Remove Code
 *
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the [GNU General Public License](//wordpress.org/about/gpl/)
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see [GNU General Public Licenses](//www.gnu.org/licenses/),
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * DISCLAIMER
 *
 * This program is distributed "AS IS" in the hope that it will be useful, but:
 * without any warranty of function, without any warranty of merchantability,
 * without any fitness for a particular or specific purpose, without any type
 * of future assistance from your own author or other authors.
 *
 * The license under which the WordPress software is released is the GPLv2 (or later) from the
 * Free Software Foundation. A copy of the license is included with every copy of WordPress.
 *
 * Part of this license outlines requirements for derivative works, such as plugins or themes.
 * Derivatives of WordPress code inherit the GPL license.
 *
 * There is some legal grey area regarding what is considered a derivative work, but we feel
 * strongly that plugins and themes are derivative work and thus inherit the GPL license.
 *
 * The license for this software can be found on [Free Software Foundation](//www.gnu.org/licenses/gpl-2.0.html) and
 * as license.txt into this plugin package.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * THERMS
 *
 * This uses (or it parts) code derived from
 *
 * wp-header-footer-log.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2009-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-admin-bar-removal.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-admin-bar-removal-node-addon.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * global-admin-bar-hide-or-remove.php by Donald J. Fischer (email: <dfischer [at] fischercreativemedia [dot] com>)
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 * Copyright (C) 2011-2014 [prophecy2040](//www.fischercreativemedia.com/) (email: <dfischer [at] fischercreativemedia [dot] com>
 *
 * global-hide-admin-tool-bar.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 * Copyright (C) 2011-2014 [prophecy2040](//www.fischercreativemedia.com/) (email: <dfischer [at] fischercreativemedia [dot] com>
 *
 * one-click-logout.php by olyma <olyma [at] rackofpower [dot] com>)
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 * Copyright (C) 2011-2014 [olyma](//rackofpower.com/) (email: <olyma [at] rackofpower [dot] com>)
 *
 * one-click-logout-barless.php by olyma <olyma [at] rackofpower [dot] com>)
 * Copyright (C) 2010-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 * Copyright (C) 2011-2014 [olyma](//rackofpower.com/) (email: <olyma [at] rackofpower [dot] com>))
 *
 * toolbar-removal-completely-disable.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2011-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-toolbar-removal.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2012-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-toolbar-removal-node-addon.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2012-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * according to the terms of the GNU General Public License version 2 (or later)
 *
 * This wp-header-footer-log.php uses (or it parts) code derived from
 *
 * wp-footer-log.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2008-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * sLa2sLaNGjIs.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2009-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * according to the terms of the GNU General Public License version 2 (or later)
 *
 * According to the Terms of the GNU General Public License version 2 (or later) part of Copyright belongs to your
 * own author and part belongs to their respective other authors:
 *
 * Copyright (C) 2008-2014 [sLaNGjIs](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 * Copyright (C) 2011-2014 [olyma](//rackofpower.com/) (email: <olyma [at] rackofpower [dot] com>)
 * Copyright (C) 2011-2014 [prophecy2040](//www.fischercreativemedia.com/) (email: <dfischer [at] fischercreativemedia [dot] com>
 *
 * VIOLATIONS
 *
 * [Violations of the GNU Licenses](//www.gnu.org/licenses/gpl-violation.en.html)
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * GUIDELINES
 *
 * This software meet [Detailed Plugin Guidelines](//wordpress.org/plugins/about/guidelines/) paragraphs
 * 1,4,10,12,13,16,17 quality requirements.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * CODING
 *
 * This software implement [GNU style](//www.gnu.org/prep/standards/standards.html) coding standard indentation.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * VALIDATION
 *
 * This readme.txt rocks. Seriously. Flying colors. It meet the specifications according to WordPress
 * [Readme Validator](//wordpress.org/plugins/about/validator/) directives.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * HUMANS (humans.txt)
 *
 * We are the Humans behind this project [humanstxt.org](//humanstxt.org/Standard.html)
 *
 * This software meet detailed humans rights belongs to your own author and to their respective other authors.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * THANKS
 *
 * [storkontheroof](//wordpress.org/support/topic/not-working-for-me-14#post-3990523)
 * [focus3d](//wordpress.org/support/topic/date-in-french#post-4380604)
 *
 * and all other that send me bugfix, suggestions or triks :)
 *
 * TODOLIST
 *
 * [to-do list and changelog](//wordpress.org/plugins/wp-admin-bar-removal/changelog/)
 *
 */

	/**
	 * @package WP Admin Bar Removal
	 * @subpackage WordPress Plugin
	 * @description Disable WordPress Admin Bar or Toolbar and Remove Code
	 * @install The configuration of this plugin is Automatic!
	 * @branche 2014
	 * @build   2014-08-15
	 * @since   3.1+
	 * @tested  3.9+
	 * @version 2014.0816.0392
	 * @status STABLE (trunk) release
	 * @development Code in Becoming!
	 * @author slangjis
	 * @license GPLv2 or later
	 * @indentation GNU style coding standard
	 * @keytag 74be16979710d4c4e7c6647856088456
	 */

	if ( !function_exists( 'add_action' ) )
		{
			header( 'HTTP/0.9 403 Forbidden' );
			header( 'HTTP/1.0 403 Forbidden' );
			header( 'HTTP/1.1 403 Forbidden' );
			header( 'Status: 403 Forbidden' );
			header( 'Connection: Close' );
				exit();
		}

	global $wp_version;

	if ( $wp_version < 3.1 )
		{
			wp_die( __( 'This Plugin Requires WordPress 3.1+ or Greater: Activation Stopped!' ) );
		}

	function wpabr_1st()
		{
			$path = str_replace( WP_PLUGIN_DIR . '/', '', __FILE__ );

			if ( $plugins = get_option( 'active_plugins' ) )
				{
					if ( $key = array_search( $path, $plugins ) )
						{
							array_splice( $plugins, $key, 1 );
							array_unshift( $plugins, $path );
							update_option( 'active_plugins', $plugins );
						}
				}
		}
	add_action( "activated_plugin", "wpabr_1st" );

	function wpabr_rbams()
		{
			echo "\n\n<!--Start Admin Bar Removal Code-->\n\n";
			echo '<style type="text/css">#adminmenushadow,#adminmenuback{background-image:none}</style>';
			echo "\n\n<!--End Admin Bar Removal Code-->\n\n";
		}

	if ( $wp_version >= 3.2 )
		{
			add_action( 'admin_head', 'wpabr_rbams' );
		}

	function wpabr_rbf28px()
		{
			echo "\n\n<!--Start Admin Bar Removal Code-->\n\n";
			echo '<style type="text/css">html.wp-toolbar,html.wp-toolbar #wpcontent,html.wp-toolbar #adminmenu,html.wp-toolbar #wpadminbar,body.admin-bar,body.admin-bar #wpcontent,body.admin-bar #adminmenu,body.admin-bar #wpadminbar{padding-top:0px !important}</style>';
			echo "\n\n<!--End Admin Bar Removal Code-->\n\n";
		}
	add_action( 'admin_print_styles', 'wpabr_rbf28px', 21 );

	function wpabr_ablh()
		{
			echo "\n\n<!--Start Admin Bar Removal Code-->\n\n";
?>
<style type="text/css">table#tbrcss td#tbrcss_ttl a:link,table#tbrcss td#tbrcss_ttl a:visited{text-decoration:none}table#tbrcss td#tbrcss_lgt,table#tbrcss td#tbrcss_lgt a{text-decoration:none}</style>
<table style="margin-left:6px;float:left;z-index:100;position:relative;left:0px;top:0px;background:none;padding:0px;border:0px;border-bottom:1px solid #DFDFDF" id="tbrcss" border="0" cols="4" width="97%" height="33">
<tr>
<td align="left" valign="center" id="tbrcss_ttl">
<?php

	echo '<a href="' . home_url() . '">' . __( get_bloginfo() ) . '</a>';

?>
</td>
<td align="right" valign="center" id="tbrcss_lgt">
<div style="padding-top:2px">
<?php

	echo date_i18n( get_option( 'date_format' ) );

?>

 @ 

<?php

	echo date_i18n( get_option( 'time_format' ) );

?>

<?php

	wp_get_current_user();

	$current_user = wp_get_current_user();

	if ( !( $current_user instanceof WP_User ) )
		return;

	echo ' | ' . $current_user->display_name . '';

	if ( is_multisite() && is_super_admin() )
		{
			if ( !is_network_admin() )
				{
					echo ' | <a href="' . network_admin_url() . '">' . __( 'Network Admin' ) . '</a>';
				}
			else
				{
					echo ' | <a href="' . get_DashBoard_url( get_current_user_id() ) . '">' . __( 'Site Admin' ) . '</a>';
				}
		}

	echo ' | <a href="' . wp_logout_url( home_url() ) . '">' . __( 'Log Out' ) . '</a>';

?>
</div>
</td>
<td width="8">
</td>
</tr>
</table>
<?php
			echo "\n<!--End Admin Bar Removal Code-->\n\n";
		}

	if ( $wp_version >= 3.3 )
		{
			add_action( 'in_admin_header', 'wpabr_ablh' );
			add_filter( 'show_wp_pointer_admin_bar', '__return_false' );
		}

	function wp_admin_bar_init()
		{
			add_filter( 'show_admin_bar', '__return_false' );
			add_filter( 'wp_admin_bar_class', '__return_false' );
		}
	add_filter( 'init', 'wp_admin_bar_init', 9 );

	function wpabr_ruppoabpc()
		{
			echo "\n\n<!--Start Admin Bar Removal Code-->\n\n";
			echo '<style type="text/css">.show-admin-bar{display:none}</style>';
			echo "\n\n<!--End Admin Bar Removal Code-->\n\n";
		}
	add_action( 'admin_print_styles-profile.php', 'wpabr_ruppoabpc' );

	$wp_scripts = new WP_Scripts();
	wp_deregister_script( 'admin-bar' );

	$wp_styles = new WP_Styles();
	wp_deregister_style( 'admin-bar' );

	remove_action( 'init', 'wp_admin_bar_init' );
	remove_filter( 'init', 'wp_admin_bar_init' );
	remove_action( 'wp_head', 'wp_admin_bar' );
	remove_filter( 'wp_head', 'wp_admin_bar' );
	remove_action( 'wp_footer', 'wp_admin_bar' );
	remove_filter( 'wp_footer', 'wp_admin_bar' );
	remove_action( 'admin_head', 'wp_admin_bar' );
	remove_filter( 'admin_head', 'wp_admin_bar' );
	remove_action( 'admin_footer', 'wp_admin_bar' );
	remove_filter( 'admin_footer', 'wp_admin_bar' );
	remove_action( 'wp_head', 'wp_admin_bar_class' );
	remove_filter( 'wp_head', 'wp_admin_bar_class' );
	remove_action( 'wp_footer', 'wp_admin_bar_class' );
	remove_filter( 'wp_footer', 'wp_admin_bar_class' );
	remove_action( 'admin_head', 'wp_admin_bar_class' );
	remove_filter( 'admin_head', 'wp_admin_bar_class' );
	remove_action( 'admin_footer', 'wp_admin_bar_class' );
	remove_filter( 'admin_footer', 'wp_admin_bar_class' );
	remove_action( 'wp_head', 'wp_admin_bar_css' );
	remove_filter( 'wp_head', 'wp_admin_bar_css' );
	remove_action( 'wp_head', 'wp_admin_bar_dev_css' );
	remove_filter( 'wp_head', 'wp_admin_bar_dev_css' );
	remove_action( 'wp_head', 'wp_admin_bar_rtl_css' );
	remove_filter( 'wp_head', 'wp_admin_bar_rtl_css' );
	remove_action( 'wp_head', 'wp_admin_bar_rtl_dev_css' );
	remove_filter( 'wp_head', 'wp_admin_bar_rtl_dev_css' );
	remove_action( 'admin_head', 'wp_admin_bar_css' );
	remove_filter( 'admin_head', 'wp_admin_bar_css' );
	remove_action( 'admin_head', 'wp_admin_bar_dev_css' );
	remove_filter( 'admin_head', 'wp_admin_bar_dev_css' );
	remove_action( 'admin_head', 'wp_admin_bar_rtl_css' );
	remove_filter( 'admin_head', 'wp_admin_bar_rtl_css' );
	remove_action( 'admin_head', 'wp_admin_bar_rtl_dev_css' );
	remove_filter( 'admin_head', 'wp_admin_bar_rtl_dev_css' );
	remove_action( 'wp_footer', 'wp_admin_bar_js' );
	remove_filter( 'wp_footer', 'wp_admin_bar_js' );
	remove_action( 'wp_footer', 'wp_admin_bar_dev_js' );
	remove_filter( 'wp_footer', 'wp_admin_bar_dev_js' );
	remove_action( 'admin_footer', 'wp_admin_bar_js' );
	remove_filter( 'admin_footer', 'wp_admin_bar_js' );
	remove_action( 'admin_footer', 'wp_admin_bar_dev_js' );
	remove_filter( 'admin_footer', 'wp_admin_bar_dev_js' );
	remove_action( 'locale', 'wp_admin_bar_lang' );
	remove_filter( 'locale', 'wp_admin_bar_lang' );
	remove_action( 'wp_head', 'wp_admin_bar_render', 1000 );
	remove_filter( 'wp_head', 'wp_admin_bar_render', 1000 );
	remove_action( 'wp_footer', 'wp_admin_bar_render', 1000 );
	remove_filter( 'wp_footer', 'wp_admin_bar_render', 1000 );
	remove_action( 'admin_head', 'wp_admin_bar_render', 1000 );
	remove_filter( 'admin_head', 'wp_admin_bar_render', 1000 );
	remove_action( 'admin_footer', 'wp_admin_bar_render', 1000 );
	remove_filter( 'admin_footer', 'wp_admin_bar_render', 1000 );
	remove_action( 'admin_footer', 'wp_admin_bar_render' );
	remove_filter( 'admin_footer', 'wp_admin_bar_render' );
	remove_action( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render', 1000 );
	remove_filter( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render', 1000 );
	remove_action( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render' );
	remove_filter( 'wp_ajax_adminbar_render', 'wp_admin_bar_ajax_render' );

	function wpabr_rml( $links, $file )
		{
			if ( $file == plugin_basename( __FILE__ ) )
				{
					$links[] = '<a title="Bugfix and Suggestions" href="//slangji.wordpress.com/contact/">Contact</a>';
					$links[] = '<a title="Offer a Beer to sLa" href="//slangji.wordpress.com/donate/">Donate</a>';
					$links[] = '<a title="Visit other author plugins site" href="//slangji.wordpress.com/plugins/">Other</a>';
				}
			return $links;
		}
	add_filter( 'plugin_row_meta', 'wpabr_rml', 10, 2 );

	function wpabr_hfl()
		{
			echo "\n<!--Plugin WP Admin Bar Removal 2014.0816.0392 Active - Tag ".md5(md5("".""))."-->\n";
			echo "\n<!--Site Optimized to Speedup Control Panel Minimize Memory Consumption with Disabled";

			global $wp_version;

			if ( $wp_version >= 3.3 )
				{
					echo " Toolbar";
				}

			if ( $wp_version >= 3.1 )
				{
					if ( $wp_version < 3.3 )
						{
							echo " Admin Bar";
						}
				}

			echo "-->\n\n";
		}
	add_action( 'wp_head', 'wpabr_hfl' );
	add_action( 'wp_footer', 'wpabr_hfl' );

	add_filter( 'in_admin_header' , 'wpabr_remove_wptbr_abtlh' , 1 );

	function wpabr_remove_wptbr_abtlh()

		{

			if ( has_filter( 'in_admin_header' , 'wptbr_abtlh' ) )

				{

					remove_filter( 'in_admin_header' , 'wptbr_abtlh' );

				}

		}

	add_filter( 'in_admin_header', 'wpabr_remove_wptrcd_atblh', 1 );

	function wpabr_remove_wptrcd_atblh()

		{

			if ( has_filter( 'in_admin_header' , 'wptrcd_atblh') )

				{

					remove_filter('in_admin_header', 'wptrcd_atblh');

				}

		}

	if( file_exists( plugin_dir_path( __FILE__ ) . 'wp-admin-bar-removal.js' ) )

		{

			add_action( 'admin_enqueue_scripts' , 'wp_admin_bar_removal_js' );

		}

	function wp_admin_bar_removal_js()

		{

			wp_enqueue_script( 'wp-admin-bar-removal' , plugins_url( 'wp-admin-bar-removal.js' , __FILE__ ) , array( 'admin-bar' , 'common' ) );

		}

	if( file_exists( plugin_dir_path( __FILE__ ) . 'wp-admin-bar-removal.css' ) )

		{

			add_action( 'admin_enqueue_scripts' , 'wp_admin_bar_removal_css' );

		}

	function wp_admin_bar_removal_css()

		{

			wp_enqueue_style( 'wp-admin-bar-removal' , plugins_url( 'wp-admin-bar-removal.css' , __FILE__ ) );

		}

?>