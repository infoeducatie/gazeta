<?php 
/*
Plugin Name: Global Hide Toolbar Bruteforce
Plugin URI: //wordpress.org/plugins/global-admin-bar-hide-or-remove/
Description: Bruteforce Disable Front and Back End Toolbar for all Admin and User Roles - BETA (2014-04-16) - Version Discontinued Please Install <a title="Please install WP Toolbar Removal" href="//wordpress.org/plugins/wp-toolbar-removal/">WP Toolbar Removal</a>
Version: 1.6.1
Author: <a title="Visit author homepage" href="//slangji.wordpress.com/">sLa NGjI's</a> & <a title="Visit plugin-master-author homepage" href="//www.fischercreativemedia.com/">D.J.Fischer</a>
Requires at least: 3.1
Network: true
Text Domain: global-hide-remove-toolbar-plugin
Domain Path: /lang/
License: GPLv2 or later (license.txt)
License URI: //www.gnu.org/licenses/gpl-2.0.html
Indentation: GNU style coding standard
Indentation URI: //www.gnu.org/prep/standards/standards.html
Humans: We are the humans behind
Humans URI: http://humanstxt.org/Standard.html
 *
 * LICENSING (license.txt)
 *
 * [Global Hide Admin Tool Bar Bruteforce](//wordpress.org/plugins/global-admin-bar-hide-or-remove/)
 *
 * Bruteforce Disable Front and Back End Toolbar for all Admin and User Roles Logged In and Out
 *
 * Copyright (C) 2013-2014 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlegmail [dot] com>)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the [GNU General Public License](//wordpress.org/about/gpl/)
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * on an "AS IS", but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, see [GNU General Public Licenses](//www.gnu.org/licenses/),
 * or write to the Free Software Foundation, Inc., 51 Franklin Street,
 * Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * DISCLAIMER
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
 * The license for this software can be found on [Free Software Foundation](//www.gnu.org/licenses/gpl-2.0.html) and as license.txt into this plugin package.
 *
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * THERMS
 *
 * This global-hide-brute-force-admin-bar.php uses (or it parts) code derived from:
 *
 * global-brute-force-wordpress-toolbar-removal.php by Donald J. Fischer (email: <dfischer [at] fischercreativemedia [dot] com>)
 * Copyright (C) 2011-2013 [prophecy2040](//www.fischercreativemedia.com/) (email: <dfischer [at] fischercreativemedia [dot] com>)
 *
 * wp-admin-bar-removal.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2010-2014 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-admin-bar-removal-node-addon.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2010-2013 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * one-click-logout-barless.php by olyma <olyma [at] rack of power [dot] com>)
 * Copyright (C) 2011-2012 [olyma](//rackofpower.com/) (email: <olyma [at] rack of power [dot] com>)
 *
 * toolbar-removal-completely-disable.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2011-2013 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-toolbar-removal.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2012-2014 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * wp-toolbar-removal-node-addon.php by slangjis <slangjis [at] googlemail [dot] com>
 * Copyright (C) 2012-2013 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 *
 * according to the terms of the GNU General Public License version 2 (or later) this uses or it parts code was derived.
 *
 * According to the Terms of the GNU General Public License version 2 (or later) part of Copyright belongs to your own author and part belongs to their respective others authors:
 *
 * Copyright (C) 2008-2014 [slangjis](//slangji.wordpress.com/) (email: <slangjis [at] googlemail [dot] com>)
 * Copyright (C) 2011-2013 Donald J. Fischer (email: <dfischer [at] fischercreativemedia [dot] com>)
 * Copyright (C) 2011-2012 [olyma](//rackofpower.com/) (email: <olyma [at] rack of power [dot] com>)
 *
 * VIOLATIONS
 *
 * [Violations of the GNU Licenses](//www.gnu.org/licenses/gpl-violation.en.html)
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * GUIDELINES
 *
 * This software meet [Detailed Plugin Guidelines](//wordpress.org/plugins/about/guidelines/)
 * paragraphs 1,4,10,12,13,16,17 quality requirements.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * CODING
 *
 * This software implement [GNU style](//www.gnu.org/prep/standards/standards.html) coding standard indentation.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * VALIDATION
 *
 * This readme.txt rocks. Seriously. Flying colors. It meet the specifications according to
 * WordPress [Readme Validator](//wordpress.org/plugins/about/validator/) directives.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * HUMANS (humans.txt)
 *
 * We are the Humans behind this project [humanstxt.org](//humanstxt.org/Standard.html)
 *
 * This software meet detailed humans rights belongs to your own author and to their respective other authors.
 * The author of this plugin is available at any time, to make all changes, or corrections, to respect these specifications.
 *
 * THANKS
 *
 * Thanks to Donald J. Fischer a.k.a prophecy2040 @ www.fischercreativemedia.com for this plugin!
 *
 * TODOLIST
 *
 * [to-do list and changelog](//wordpress.org/plugins/global-admin-bar-hide-or-remove/changelog/)
 *
 * Planned for Version 1.7.0 - [Code Merge Migration](//wordpress.org/support/topic/brute-force-plugin-code-migration/) to WP Admin Bar Removal and WP Toolbar Removal
 */

	/**
	 * @package     WordPress Plugin
	 * @subpackage  Global Hide Admin Tool Bar Bruteforce
	 * @description Bruteforce Disable Front and Back End Toolbar for all Admin and User Roles Logged In and Out
	 * @author      slangjis &CO prophecy2040
	 * @status      Code in Becoming!
	 * @since       3.1+
	 * @branche     2014
	 * @version     1.6.1
	 * @build       2014-04-16 1ST 2014-04-14
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

	defined( 'ABSPATH' ) or exit;

	defined( 'WPINC' ) or exit;

	function ghatb_bfp_1st()

		{

			$wp_path_to_this_file = preg_replace( '/(.*)plugins\/(.*)$/', WP_PLUGIN_DIR . "/$2", __FILE__ );
			$this_plugin          = plugin_basename( trim( $wp_path_to_this_file ) );
			$active_plugins       = get_option( 'active_plugins' );
			$this_plugin_key      = array_search( $this_plugin, $active_plugins );

			if ( $this_plugin_key )

				{

					array_splice( $active_plugins, $this_plugin_key, 1 );
					array_unshift( $active_plugins, $this_plugin );
					update_option( 'active_plugins', $active_plugins );

				}

		}

	add_action( 'activated_plugin', 'ghatb_bfp_1st', 0 );

	global $wp_version;

	if ( $wp_version < 3.1 )

		{

			wp_die( __( 'This Plugin Requires WordPress 3.1+ or Greater: Activation Stopped!', 'global-hide-remove-toolbar-plugin'  ) );

		}

	if ( $wp_version >= 3.2 )

		{

			add_action( 'admin_head', 'ghatb_bfp_admin_back_menu_remove' );
		}

		if ( ! is_multisite() )

			{

				add_action( 'admin_notices', 'ghatb_bfp_warning_notice' );

			}

		if ( is_multisite() )

			{

				add_action( 'network_admin_notices', 'ghatb_bfp_warning_notice_ms' );

			}

	function ghatb_bfp_warning_notice()

		{

			if ( is_plugin_active( 'global-admin-bar-hide-or-remove/global-hide-admin-tool-bar.php' ) )

				{

					echo '<div id="message" class="error"><h3><strong>' . __( 'Activation Warning:', 'global-hide-remove-toolbar-plugin' ) . '</strong></h3><p>' . __( 'Cannot Use Both <strong style="color:#880000;">Global Hide Toolbar</strong> and <strong style="color:#880000;">Global Hide Toolbar Bruteforce</strong> at Same Time!', 'global-hide-remove-toolbar-plugin'  ) . '</p></div>';

				}

		}

	function ghatb_bfp_warning_notice_ms()

		{

			if ( is_plugin_active_for_network( 'global-admin-bar-hide-or-remove/global-hide-admin-tool-bar.php' ) )

				{

					echo '<div id="message" class="error"><h3><strong>' . __( 'Multisite Activation Warning:', 'global-hide-remove-toolbar-plugin'  ) . '</strong></h3><p>' . __( 'Cannot Use Both <strong style="color:#880000;">Global Hide Toolbar</strong> and <strong style="color:#880000;">Global Hide Toolbar Bruteforce</strong> at Same Time!', 'global-hide-remove-toolbar-plugin'  ) . '</p></div>';

				}

		}

	function ghatb_bfp_admin_back_menu_remove()

		{

			echo '<!--Start Plugin Global Hide Admin Tool Bar Bruteforce Code-->';
			echo '<style type="text/css">#adminmenushadow,#adminmenuback{background-image:none}</style>';
			echo '<!--/ End Plugin Global Hide Admin Tool Bar Bruteforce Code-->';

		}

	function ghatb_bfp_admin_styles()

		{

			echo '<!--Start Plugin Global Hide Admin Tool Bar Bruteforce Code-->';
			echo '<style type="text/css">#wp-bftoolbar-bar-menu-toggle{color:#fff;font-size:26px;text-align:center;line-height:29px;display:none;cursor:pointer;width:30px;height:27px;float:left;margin-right:8px;background:#222;margin-top:3px}html.wp-toolbar,html.wp-toolbar #wpcontent,html.wp-toolbar #adminmenu,html.wp-toolbar #wpadminbar,body.admin-bar,body.admin-bar #wpcontent,body.admin-bar #adminmenu,body.admin-bar #wpadminbar{padding-top:0px !important}</style>';
			echo '<!--/ End Plugin Global Hide Admin Tool Bar Bruteforce Code-->';

		}

	add_action( 'admin_print_styles', 'ghatb_bfp_admin_styles', 21 );

	function ghatb_bfp_login_header()

		{

			global $wp_version;

			wp_get_current_user();

			$current_user = wp_get_current_user();

			if ( ! ( $current_user instanceof WP_User ) )

				{

					return;

				}

			$date_format   = get_option( 'date_format' );
			$time_format   = get_option( 'time_format' );
			$formatteddate = date( $date_format . ' ' . $time_format, current_time( 'timestamp' ) );
			$logout_link   = '<a href="' . wp_logout_url( home_url() ) . '">' . __( 'Log Out', 'global-hide-remove-toolbar-plugin' ) . '</a>';
			$admin_link    = is_multisite() && is_super_admin() ? ( ! is_network_admin() ? ' | <a href="' . network_admin_url() . '">' . __( 'Network Admin', 'global-hide-remove-toolbar-plugin' ) . '</a>' : ' | <a href="' . get_DashBoard_url( get_current_user_id() ) . '">' . __( 'Site Admin', 'global-hide-remove-toolbar-plugin' ) . '</a>' ) : '';
			$displayname   = $current_user->display_name;
			$toggle        = ( $wp_version >= 3.8 ) ? '<div id="wp-bftoolbar-bar-menu-toggle" class="dashicons dashicons-menu"></div>' : '';
			$homelink      = '<a href="' . home_url() . '">' . __( get_bloginfo() ) . '</a>';

			echo '
			<!--Start Plugin Global Hide Admin Tool Bar Bruteforce Code-->
			<style type="text/css">
				@media screen and (max-width:782px){
					#wp-bftoolbar-bar-menu-toggle {display:block}
					.wp-responsive-open #bftoobar {right: -190px}
					.wp-responsive-open #bftoobar #bftoobar_ttl{width:auto;padding-right:2%}
					.wp-responsive-open #bftoobar #bftoobar_lgt{width:auto}
				}
				#bftoobar {position:relative;z-index:10;border-bottom:1px solid #e1e1e1;height:33px;line-height:33px}
				#bftoobar #bftoobar_ttl a:link,
					#bftoobar #bftoobar_ttl a:visited{text-decoration:none}
				#bftoobar #bftoobar_lgt,
				#bftoobar #bftoobar_lgt a{text-decoration:none}
				#bftoobar #bftoobar_ttl{width:33%;float:left;text-align:left}
				#bftoobar #bftoobar_lgt{width:65%;float:left;text-align:right;padding-right:2%}

			</style>
				<div id="bftoobar">
				<div id="bftoobar_ttl">' . $toggle . $homelink . '</div>
				<div id="bftoobar_lgt">' . $formatteddate . ' | ' . $displayname . $admin_link . ' | ' . $logout_link . '</div>
			</div>
			<!--/ End Plugin Global Hide Admin Tool Bar Bruteforce Code-->
			';

			if ( $wp_version >= 3.8 )

				{

					echo '<!--Start Plugin Global Hide Admin Tool Bar Bruteforce Code-->';
					echo '<script>jQuery(document).ready(function(){var $wpwrap=jQuery("#wpwrap");jQuery("#wp-bftoolbar-bar-menu-toggle").on("click",function(event) {console.log("clicked");event.preventDefault();$wpwrap.toggleClass("wp-responsive-open");});});</script>';
					echo '<!--/ End Plugin Global Hide Admin Tool Bar Bruteforce Code-->';

				}

		}

	if ( $wp_version >= 3.3 )

		{

			add_action( 'in_admin_header', 'ghatb_bfp_login_header' );

			add_filter( 'show_wp_pointer_admin_bar', '__return_false' );

		}

	function ghatb_bfp_wp_toolbar_init()

		{

			add_filter( 'show_admin_bar', '__return_false' );
			add_filter( 'wp_admin_bar_class', '__return_false' );

		}

	add_filter( 'init', 'ghatb_bfp_wp_toolbar_init', 9 );

	function ghatb_bfp_remove_profile_option()

		{

			echo '<!--Start Plugin Global Hide Admin Tool Bar Bruteforce Code-->';
			echo '<style type="text/css">.show-admin-bar{display:none}</style>';
			echo '<!--/ End Plugin Global Hide Admin Tool Bar Bruteforce Code-->';

		}

	add_action( 'admin_print_styles-profile.php', 'ghatb_bfp_remove_profile_option' );

	$wp_scripts = new WP_Scripts();
	wp_deregister_script( 'admin-bar' );

	$wp_styles = new WP_Styles();
	wp_deregister_style( 'admin-bar' );

	$hooks_filters = array(
				 'init' => array(
							 array(
										 'wp_admin_bar_init',
										'' 
							) 
				),
				'admin_footer' => array(
							 array(
										 'wp_admin_bar',
										'' 
							),
							array(
										 'wp_admin_bar_class',
										'' 
							),
							array(
										 'wp_admin_bar_render',
										'1000' 
							),
							array(
										 'wp_admin_bar_js',
										'' 
							),
							array(
										 'wp_admin_bar_dev_js',
										'' 
							) 
				),
				'admin_head' => array(
							 array(
										 'wp_admin_bar',
										'' 
							),
							array(
										 'wp_admin_bar_class',
										'' 
							),
							array(
										 'wp_admin_bar_css',
										'' 
							),
							array(
										 'wp_admin_bar_dev_css',
										'' 
							),
							array(
										 'wp_admin_bar_rtl_css',
										'' 
							),
							array(
										 'wp_admin_bar_rtl_dev_css',
										'' 
							),
							array(
										 'wp_admin_bar_render',
										1000 
							) 
				),
				'locale' => array(
							 array(
										 'wp_admin_bar_lang',
										'' 
							) 
				),
				'wp_head' => array(
							 array(
										 'wp_admin_bar',
										'' 
							),
							array(
										 'wp_admin_bar_class',
										'' 
							),
							array(
										 'wp_admin_bar_css',
										'' 
							),
							array(
										 'wp_admin_bar_dev_css',
										'' 
							),
							array(
										 'wp_admin_bar_rtl_css',
										'' 
							),
							array(
										 'wp_admin_bar_rtl_dev_css',
										'' 
							),
							array(
										 'wp_admin_bar_render',
										1000 
							) 
				),
				'wp_footer' => array(
							 array(
										 'wp_admin_bar',
										'' 
							),
							array(
										 'wp_admin_bar_class',
										'' 
							),
							array(
										 'wp_admin_bar_render',
										1000 
							),
							array(
										 'wp_admin_bar_js',
										'' 
							),
							array(
										 'wp_admin_bar_dev_js',
										'' 
							) 
				),
				'wp_ajax_adminbar_render' => array(
							 array(
										 'wp_admin_bar_ajax_render',
										1000 
							) 
				) 
	);

	foreach ( $hooks_filters as $hookkey => $hookval )

		{

			foreach ( $hookval as $hook )

				{

					remove_action( $hook[ 0 ], $hook[ 1 ] );

					remove_filter( $hook[ 0 ], $hook[ 1 ] );

				}

		}

	function ghatb_bfp_prml( $links, $file )

		{

			if ( $file == plugin_basename( __FILE__ ) )

				{

					$links[] = '<a title="' . __( 'Bugfix and Suggestions', 'global-hide-remove-toolbar-plugin' ) . '" href="//slangji.wordpress.com/contact/">' . __( 'Contact', 'global-hide-remove-toolbar-plugin' ) . '</a>';

					$links[] = '<a title="' . __( 'Offer a Beer to sLa', 'global-hide-remove-toolbar-plugin' ) . '" href="//slangji.wordpress.com/donate/">' . __( 'Donate', 'global-hide-remove-toolbar-plugin' ) . '</a>';

					$links[] = '<a title="' . __( 'Visit other author plugins', 'global-hide-remove-toolbar-plugin' ) . '" href="//slangji.wordpress.com/plugins/">' . __( 'Other', 'global-hide-remove-toolbar-plugin' ) . '</a>';

				}

			return $links;

		}

	add_filter( 'plugin_row_meta', 'ghatb_bfp_prml', 10, 2 );

	function ghatb_bfp_shfl()

		{

			echo "\n<!--Plugin Global Hide Admin Tool Bar Bruteforce Active-->\n";

		}

	add_action( 'wp_head', 'ghatb_bfp_shfl', 0 );
	add_action( 'wp_footer', 'ghatb_bfp_shfl', 0 );

?>