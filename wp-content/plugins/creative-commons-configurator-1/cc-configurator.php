<?php
/*
Plugin Name: Creative Commons Configurator
Plugin URI: http://www.g-loaded.eu/2006/01/14/creative-commons-configurator-wordpress-plugin/
Description: Helps you publish your content under the terms of Creative Commons and other licenses.
Version: 1.8.7
Author: George Notaras
Author URI: http://www.g-loaded.eu/
License: Apache License v2
Text Domain: cc-configurator
Domain Path: /languages/
*/

/**
 *  Copyright 2008-2015 George Notaras <gnot@g-loaded.eu>, CodeTRAX.org
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}

// Store plugin directory
define( 'BCCL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
// Store plugin directory
define( 'BCCL_PLUGIN_FILE', __FILE__ );

// Import modules
require_once( BCCL_PLUGIN_DIR . 'bccl-settings.php' );
require_once( BCCL_PLUGIN_DIR . 'bccl-admin-panel.php' );
require_once( BCCL_PLUGIN_DIR . 'bccl-template-tags.php' );
require_once( BCCL_PLUGIN_DIR . 'bccl-utils.php' );
require_once( BCCL_PLUGIN_DIR . 'bccl-licenses.php' );
require_once( BCCL_PLUGIN_DIR . 'bccl-generators.php' );
require_once( BCCL_PLUGIN_DIR . 'bccl-deprecated.php' );


/*
 * Translation Domain
 *
 * Translation files are searched in: wp-content/plugins
 */
load_plugin_textdomain('cc-configurator', false, dirname( plugin_basename( BCCL_PLUGIN_FILE ) ) . '/languages/');


/**
 * Settings Link in the ``Installed Plugins`` page
 */
function bccl_plugin_actions( $links, $file ) {
    if( $file == plugin_basename( BCCL_PLUGIN_FILE ) && function_exists( "admin_url" ) ) {
        $settings_link = '<a href="' . admin_url( 'options-general.php?page=cc-configurator-options' ) . '">' . __('Settings') . '</a>';
        // Add the settings link before other links
        array_unshift( $links, $settings_link );
    }
    return $links;
}
add_filter( 'plugin_action_links', 'bccl_plugin_actions', 10, 2 );
// ALT: add_filter( 'plugin_action_links_'.plugin_basename( plugin_dir_path( BCCL_PLUGIN_FILE ) . 'plugin.php'), 'admin_plugin_settings_link' );


/**
 *  Return license text for widget
 */
function bccl_get_widget_output() {

    // Licensing is added on posts, pages, attachments and custom post types.
    if ( ! is_singular() || is_front_page() ) {
        return;
    }
    $post = get_queried_object();

    $options = get_option("cc_settings");
    if ( $options === FALSE ) {
        return;
    }

    $license_slug = bccl_get_content_license_slug( $post, $options );
    if ( empty($license_slug) ) {
        return;
    }

    $license_data = bccl_get_license_data( $license_slug );
    if ( empty($license_data) ) {
        return;
    }

    // Check whether we should display the widget content or not.
    // In general, if the license block is set to be displayed under the content,
    // then the widget is suppressed.

    if ( is_attachment() ) {
        if ( $options["cc_body_attachments"] == "1" ) {
            return;
        }
    } elseif ( is_page() ) {
        if ( $options["cc_body_pages"] == "1" ) {
            return;
        }
    //} elseif ( is_single() ) {
    } else {    // posts and custom post types.
        if ( $options["cc_body"] == "1" ) {
            return;
        }
    }

    // Append the license block to the content
    $widget_html = call_user_func( $license_data['generator_func'], $license_slug, $license_data, $post, $options, $minimal=true );

    // Allow filtering of the widget HTML
    $widget_html = apply_filters( 'bccl_widget_html', $widget_html );

    return $widget_html;
}



/*
Adds a link element with "license" relation in the web page HEAD area.

Also, adds style for the license block, only if the user has:
 - enabled the display of such a block
 - not disabled internal license block styling
 - if it is single-post view
*/
function bccl_add_to_header() {

    // Licensing is added on posts, pages, attachments and custom post types.
    if ( ! is_singular() || is_front_page() ) {
        return;
    }
    $post = get_queried_object();

    $options = get_option("cc_settings");
    if ( $options === FALSE ) {
        return;
    }

    $license_slug = bccl_get_content_license_slug( $post, $options );
    if ( empty($license_slug) ) {
        return;
    }

    $license_data = bccl_get_license_data( $license_slug );
    if ( empty($license_data) ) {
        return;
    }

    // Print our comment
    echo PHP_EOL . "<!-- BEGIN License added by Creative-Commons-Configurator plugin for WordPress -->" . PHP_EOL;

    // Internal style. If the user has not deactivated our internal style, print it too
    if ( $options["cc_no_style"] != "1" ) {
        // Adds style for the license block
        $color = $options["cc_color"];
        $bgcolor = $options["cc_bgcolor"];
        $brdrcolor = $options["cc_brdr_color"];
        $style_output = array();
        $style_output[] = '<style type="text/css">';
        //$style_output[] = '<!--';
        $style_output[] = "p.cc-block { clear: both; width: 90%; margin: 8px auto; padding: 4px; text-align: center; border: 1px solid $brdrcolor; color: $color; background-color: $bgcolor; }";
        //$style_output[] = "p.cc-block a:link, p.cc-block a:visited, p.cc-block a:hover, p.cc-block a:active { text-decoration: none; color: $color; }";
        $style_output[] = "p.cc-block a:link, p.cc-block a:visited, p.cc-block a:hover, p.cc-block a:active { text-decoration: underline; color: $color; }";
        $style_output[] = ".cc-button { border-width: 0; }";
        //$style_output[] = '-->';
        $style_output[] = '</style>';
        $style_output[] = ''; // Blank line
        $style = implode(PHP_EOL, $style_output);
        echo $style;
    }

    // If the addition of data in the head section has been enabled
    if ( $options["cc_head"] == "1" ) {

        if ( substr($license_slug, 0, 2) == 'cc' ) {
            // Currently only licenses by the Creative Commons Corporation are
            // supported for inclusion in the HEAD area (CC & CC0).
            // Adds a link element with "license" relation in the web page HEAD area.
            echo '<link rel="license" type="text/html" href="' . $license_data['url'] . '" />';
        }

    }

    // Closing comment
    echo PHP_EOL . "<!-- END License added by Creative-Commons-Configurator plugin for WordPress -->" . PHP_EOL . PHP_EOL;
}
add_action('wp_head', 'bccl_add_to_header', 10);


/**
 * Adds the CC RSS module namespace declaration.
 */
function bccl_add_cc_ns_feed() {

    $options = get_option("cc_settings");
    if ( $options === FALSE ) {
        return;
    }

    $license_slug = $options['cc_default_license']; // We use the general default license
    if ( empty($license_slug) ) {
        return;
    }

    if ( $options["cc_feed"] == "1" ) {
        if ( substr($license_slug, 0, 2) == 'cc' ) {
            // Currently only licenses by the Creative Commons Corporation are
            // supported for inclusion in the feeds (CC & CC0).
            echo "xmlns:creativeCommons=\"http://backend.userland.com/creativeCommonsRssModule\"" . PHP_EOL;
        }
    }
}


/**
 * Adds the CC URL to the feed.
 */
function bccl_add_cc_element_feed() {

    $options = get_option("cc_settings");
    if ( $options === FALSE ) {
        return;
    }

    $license_slug = $options['cc_default_license']; // We use the general default license
    if ( empty($license_slug) ) {
        return;
    }

    $license_data = bccl_get_license_data( $license_slug );
    if ( empty($license_data) ) {
        return;
    }

    if ( $options["cc_feed"] == "1" ) {
        if ( substr($license_slug, 0, 2) == 'cc' ) {
            // Currently only licenses by the Creative Commons Corporation are
            // supported for inclusion in the feeds (CC & CC0).
            echo "\t<creativeCommons:license>" . $license_data['url'] . "</creativeCommons:license>" . PHP_EOL;
        }
    }
}


/**
 * Adds the CC URL to the feed items.
 */
function bccl_add_cc_element_feed_item() {

    // No need to check is_singular() here. We always have a post.
    //$post = get_queried_object();
    // Do not use get_queried_object() as it does not retrieve the item.
    global $post;

    $options = get_option("cc_settings");
    if ( $options === FALSE ) {
        return;
    }

    $license_slug = bccl_get_content_license_slug( $post, $options );
    if ( empty($license_slug) ) {
        return;
    }

    $license_data = bccl_get_license_data( $license_slug );
    if ( empty($license_data) ) {
        return;
    }

    // If the addition of data in the feeds has been enabled
    if ( $options["cc_feed"] == "1" ) {

        if ( substr($license_slug, 0, 2) == 'cc' ) {
            // Currently only licenses by the Creative Commons Corporation are
            // supported for inclusion in the HEAD area (CC & CC0).
            echo "\t\t<creativeCommons:license>" . $license_data['url'] . "</creativeCommons:license>" . PHP_EOL;
        }
    }
}


/*
 * Adds the license block under the published content.
 *
 * The check if the user has chosen to display a block under the published
 * content is performed in bccl_get_license_block(), in order not to retrieve
 * the saved settings two timesor pass them between functions.
 */
function bccl_append_to_post_body($PostBody) {

    // Licensing is added on posts, pages, attachments and custom post types.
    if ( ! is_singular() || is_front_page() ) {
        return $PostBody;
    }
    $post = get_queried_object();

    $options = get_option("cc_settings");
    if ( $options === FALSE ) {
        return $PostBody;
    }

    $license_slug = bccl_get_content_license_slug( $post, $options );
    if ( empty($license_slug) ) {
        return $PostBody;
    }

    $license_data = bccl_get_license_data( $license_slug );
    if ( empty($license_data) ) {
        return $PostBody;
    }

    // Append according to options
    if ( is_attachment() ) {
        if ( $options["cc_body_attachments"] != "1" ) {
            return $PostBody;
        }
    } elseif ( is_page() ) {
        if ( $options["cc_body_pages"] != "1" ) {
            return $PostBody;
        }
    //} elseif ( is_single() ) {
    } else {    // posts and custom post types
        if ( $options["cc_body"] != "1" ) {
            return $PostBody;
        }
    }

    // Append the license block to the content
    $cc_block = call_user_func( $license_data['generator_func'], $license_slug, $license_data, $post, $options );
    //$cc_block = bccl_get_license_block("", "", "default", "default");
    if ( ! empty($cc_block) ) {
        $PostBody .= bccl_add_placeholders($cc_block);
    }

    return $PostBody;
}
add_filter('the_content', 'bccl_append_to_post_body', 250);

// Feed actions
add_action('rdf_ns', 'bccl_add_cc_ns_feed');
add_action('rdf_header', 'bccl_add_cc_element_feed');
add_action('rdf_item', 'bccl_add_cc_element_feed_item');

add_action('rss2_ns', 'bccl_add_cc_ns_feed');
add_action('rss2_head', 'bccl_add_cc_element_feed');
add_action('rss2_item', 'bccl_add_cc_element_feed_item');

add_action('atom_ns', 'bccl_add_cc_ns_feed');
add_action('atom_head', 'bccl_add_cc_element_feed');
add_action('atom_entry', 'bccl_add_cc_element_feed_item');

?>