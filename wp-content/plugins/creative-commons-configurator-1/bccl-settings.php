<?php


/**
 * Module containing settings related functions.
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}


/**
 * Returns an array with the default options.
 */
function bccl_get_default_options() {
    return array(
        "settings_version"  => 3,       // IMPORTANT: SETTINGS UPGRADE: Every time settings are added or removed this has to be incremented for auto upgrade of settings.
        "cc_default_license"   => "manual",
        "cc_head"       => "0",
        "cc_feed"       => "0",
        "cc_body"       => "0",     // Add license information under posts and custom post types.
        "cc_body_pages" => "0",     // Add license information under pages.
        "cc_body_attachments"   => "0", // Add license information under attachment pages.
        "cc_body_img"   => "0",     // Show license image
        "cc_compact_img"   => "0",     // Show compact license image
        "cc_extended"   => "0",
        "cc_creator"    => "blogname",
        "cc_perm_url"   => "",
        "cc_perm_title" => "",
        "cc_color"      => "#000000",
        "cc_bgcolor"    => "#eef6e6",
        "cc_brdr_color" => "#cccccc",
        "cc_no_style"   => "0",
        "cc_i_have_donated" => "0"
    );
}



/**
 * Performs upgrade of the plugin settings.
 */
function bccl_plugin_upgrade() {

    // First we try to determine if this is a new installation or if the
    // current installation requires upgrade.

    // Default CC-Configurator Settings
    $default_options = bccl_get_default_options();

    // Try to get the current CC-Configurator options from the database
    $stored_options = get_option('cc_settings');
    if ( empty($stored_options) ) {
        // This is the first run, so set our defaults.
        update_option('cc_settings', $default_options);
        return;
    }

    // Check the settings version

    // If the settings version of the default options matches the settings version
    // of the stored options, there is no need to upgrade.
    if (array_key_exists('settings_version', $stored_options) &&
            ( intval($stored_options["settings_version"]) == intval($default_options["settings_version"]) ) ) {
        // Settings are up to date. No upgrade required.
        return;
    }

    // On any other case a settings upgrade is required.

    // 1) Add any missing options to the stored CC-Configurator options
    foreach ($default_options as $opt => $value) {
        // Always upgrade the ``settings_version`` option
        if ($opt == 'settings_version') {
            $stored_options['settings_version'] = $value;
        }
        // Add missing options
        elseif ( ! array_key_exists($opt, $stored_options) ) {
            $stored_options[$opt] = $value;
        }
        // Existing stored options are untouched here.
    }

    // 2) Migrate any current options to new ones.
    // Migration rules should go here.

    // Version 1.4.2 (settings_version 1->2)
    // Settings from $cc_settings['options'] inner array moved to $cc_settings root
    // Migration is required.
    if ( array_key_exists( 'options', $stored_options ) ) {
        // Step 1: All options saved in $cc_settings['options'] are moved to $cc_settings root
        foreach ( $stored_options['options'] as $opt => $value ) {
            $stored_options[$opt] = $value;
        }
        // Step 2: Delete $stored_options['options']
        unset( $stored_options['options'] );
    }
    
    // Version 1.8.0 (settings_version 2->3)
    // Removed setting "license_url"
    // Removed setting "license_name"
    // Removed setting "license_button"
    // Removed setting "deed_url"
    // Added setting "cc_default_license"
    // Added setting "cc_compact_img"
    // Added setting "cc_perm_title"
    // No migration required.

    // 3) Clean stored options.
    foreach ($stored_options as $opt => $value) {
        if ( ! array_key_exists($opt, $default_options) ) {
            // Remove any options that do not exist in the default options.
            unset($stored_options[$opt]);
        }
    }

    // Finally save the updated options.
    update_option('cc_settings', $stored_options);

}
//add_action('plugins_loaded', 'bccl_plugin_upgrade');
// See function bccl_admin_init() in bccl-admin-panel.php



/**
 * Saves the new settings in the database.
 * Accepts the POST request data.
 */
function bccl_save_settings($post_payload) {
    
    // Default CC-Configurator Settings
    $default_options = bccl_get_default_options();

    $cc_settings = array();

    // First add the already stored license info

    foreach ( $default_options as $def_key => $def_value ) {

        // **Always** use the ``settings_version`` from the defaults
        if ($def_key == 'settings_version') {
            $cc_settings['settings_version'] = $def_value;
        }

        // Add options from the POST request (saved by the user)
        elseif ( array_key_exists($def_key, $post_payload) ) {

            // Validate and sanitize input before adding to 'cc_settings'
            if ( in_array( $def_key, array( 'cc_perm_url' ) ) ) {
                $cc_settings[$def_key] = esc_url_raw( stripslashes( $post_payload[$def_key] ), array( 'http', 'https') );
            } else {
                $cc_settings[$def_key] = sanitize_text_field( stripslashes( $post_payload[$def_key] ) );
            }
        }
        
        // If missing (eg checkboxes), use the default value, except for the case
        // those checkbox settings whose default value is 1.
        else {

            // The following settings have a default value of 1, so they can never be
            // deactivated, unless the following check takes place.
            if (
                $def_key == 'SOME_CHECKBOX_WITH_DEFAULT_VALUE_1' ||
                $def_key == 'SOME_OTHER_CHECKBOX_WITH_DEFAULT_VALUE_1'
            ) {
                if( ! isset($post_payload[$def_key]) ){
                    $cc_settings[$def_key] = "0";
                }
            } else {
                // Else save the default value in the db.
                $cc_settings[$def_key] = $def_value;
            }
        }
    }

    // Finally update the CC-Configurator options.
    update_option('cc_settings', $cc_settings);

    //var_dump($post_payload);
    //var_dump($cc_settings);

    bccl_show_info_msg(__('Creative-Commons-Configurator options saved', 'cc-configurator'));
}



/**
 * Reset settings to the defaults.
 *
 * Resets all settings (which are available in the settings form) to
 * their default values.
 */
function bccl_reset_settings() {
    // Default CC-Configurator Settings
    $default_options = bccl_get_default_options();

    delete_option('cc_settings');
    update_option('cc_settings', $default_options);
    bccl_show_info_msg(__('Creative-Commons-Configurator options were reset to defaults', 'cc-configurator'));
}

