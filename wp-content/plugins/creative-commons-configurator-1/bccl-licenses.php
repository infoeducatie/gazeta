<?php

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}


/**
 *  Licenses Database
 */
function bccl_get_all_licenses() {
    $licenses = array(
        // No license
        'manual'   =>  array(         // slug (unique for each license)
            'url' => '',    // URL to license page
            'name' => sprintf(__('No Licensing Information', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => '',
            'button_url' => '', // URL to license button
            'button_compact_url' => '', // URL to a small license button
            'generator_func' => 'bccl_manual_generator'
        ),
        // Creative Commons 4 Licenses
        'cc__by'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/licenses/by/4.0/',    // URL to license page
            'name' => sprintf(__('Creative Commons Attribution %s International License', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => 'CC BY 4.0',
            'button_url' => 'cc/by/4.0/88x31.png', // URL to license button
            'button_compact_url' => 'cc/by/4.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc_generator'
        ),
        'cc__by-nd'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/licenses/by-nd/4.0/',    // URL to license page
            'name' => sprintf(__('Creative Commons Attribution-NoDerivatives %s International License', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => 'CC BY-ND 4.0',
            'button_url' => 'cc/by-nd/4.0/88x31.png', // URL to license button
            'button_compact_url' => 'cc/by-nd/4.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc_generator'
        ),
        'cc__by-sa'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/licenses/by-sa/4.0/',    // URL to license page
            'name' => sprintf(__('Creative Commons Attribution-ShareAlike %s International License', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => 'CC BY-SA 4.0',
            'button_url' => 'cc/by-sa/4.0/88x31.png', // URL to license button
            'button_compact_url' => 'cc/by-sa/4.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc_generator'
        ),
        'cc__by-nc'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/licenses/by-nc/4.0/',    // URL to license page
            'name' => sprintf(__('Creative Commons Attribution-NonCommercial %s International License', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => 'CC BY-NC 4.0',
            'button_url' => 'cc/by-nc/4.0/88x31.png', // URL to license button
            'button_compact_url' => 'cc/by-nc/4.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc_generator'
        ),
        'cc__by-nc-nd'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/licenses/by-nc-nd/4.0/',    // URL to license page
            'name' => sprintf(__('Creative Commons Attribution-NonCommercial-NoDerivatives %s International License', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => 'CC BY-NC-ND 4.0',
            'button_url' => 'cc/by-nc-nd/4.0/88x31.png', // URL to license button
            'button_compact_url' => 'cc/by-nc-nd/4.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc_generator'
        ),
        'cc__by-nc-sa'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/licenses/by-nc-sa/4.0/',    // URL to license page
            'name' => sprintf(__('Creative Commons Attribution-NonCommercial-ShareAlike %s International License', 'cc-configurator'), '4.0'),   // Name of the license
            'name_short' => 'CC BY-NC-SA 4.0',
            'button_url' => 'cc/by-nc-sa/4.0/88x31.png', // URL to license button
            'button_compact_url' => 'cc/by-nc-sa/4.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc_generator'
        ),
        // CC Zero
        'cc0'   =>  array(         // slug (unique for each license)
            'url' => 'http://creativecommons.org/publicdomain/zero/1.0/',    // URL to license page
            'name' => 'CC0 1.0 Universal',   // Name of the license
            'name_short' => 'CC0 1.0',
            'button_url' => 'zero/1.0/88x31.png', // URL to license button
            'button_compact_url' => 'zero/1.0/80x15.png', // URL to a small license button
            'generator_func' => 'bccl_cc0_generator'
        ),
        // All Rights Reserved
        'arr'   =>  array(         // slug (unique for each license)
            'url' => '',    // URL to license page
            'name' => 'All Rights Reserved',   // Name of the license
            'name_short' => '',
            'button_url' => '', // URL to license button
            'button_compact_url' => '', // URL to a small license button
            'generator_func' => 'bccl_arr_generator'
        ),

    );

    // Allow filtering of the available licenses
    $licenses = apply_filters( 'bccl_licenses', $licenses );

    return $licenses;
}


function bccl_get_license_data( $slug ) {
    $licenses = bccl_get_all_licenses();
    if ( array_key_exists( $slug, $licenses ) ) {
        return $licenses[$slug];
    } else {
        return array();
    }
}


function bccl_get_license_selection_form( $default_license, $current_license, $element_name="cc_default_license", $mark_default=false ) {
    $licenses = bccl_get_all_licenses();
    $output = array();
    $output[] = '<select id='.$element_name.' name="'.$element_name.'" >';
    foreach ( $licenses as $license_slug => $license_data ) {
        $select_option = sprintf( '<option value="%s" %s>%s', $license_slug, (($current_license == $license_slug) ? 'selected="selected"' : ''), $license_data['name'] );
        if ( ! empty($license_data['name_short'] ) ) {
            $select_option .= sprintf(' (%s)', $license_data['name_short']);
        }
        if ( $mark_default === true && $license_slug == $default_license ) {
            $select_option .= ' (Default)';
        }
        $select_option .= '</option>';
        $output[] = $select_option;
    }
    $output[] = '</select>';
    return implode(PHP_EOL, $output);
}

