<?php
/**
 *  Contains generator functions providing the full text of each license.
 */

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}



// Default License Templates
// Creative Commons licenses use these templates as is.
function bccl_default_license_templates() {
    return array(
        'license_text_long' => __('#work# by #creator# is licensed under a #license#.', 'cc-configurator'), // Supports: #work#, #creator#, #license#, #year#
        'license_text_short' => __('This work is licensed under a #license#.', 'cc-configurator'),  // Supports: #license#, #year#
        'extra_perms' => __('Permissions beyond the scope of this license may be available at #page#.', 'cc-configurator'), // Supports: #page#
        'enclosure' => '<p class="cc-block">%s</p>'
    );
}


// Generator Functions


// Generator for no licensing information (manual)
function bccl_manual_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {
    return '';
}


// All Rights Reserved Generator
function bccl_arr_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {
    $templates = array_merge( bccl_default_license_templates(), array(
        'license_text_long' => __('Copyright &copy; #year# - All Rights Reserved', 'cc-configurator'), // Supports: #work#, #creator#, #license#, #year#
        'license_text_short' => __('Copyright &copy; #year# - All Rights Reserved', 'cc-configurator'),  // Supports: #license#, #year#
        'extra_perms' => '<br />' . __('Information about how to reuse or republish this work may be available at #page#.', 'cc-configurator'), // Supports: #page#
    ));
    return bccl_base_generator( $license_slug, $license_data, $post, $options, $minimal, $templates );
}


// CC Zero Generator
function bccl_cc0_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {
    $templates = array_merge( bccl_default_license_templates(), array(
        'license_text_long' => __('To the extent possible under law, #creator# has waived all copyright and related or neighboring rights to #work#.', 'cc-configurator'), // Supports: #work#, #creator#, #license#, #year#
        'license_text_short' => __('To the extent possible under law, the creator has waived all copyright and related or neighboring rights to this work.', 'cc-configurator'),  // Supports: #license#, #year#
        'extra_perms' => __('Terms and conditions beyond the scope of this waiver may be available at #page#.', 'cc-configurator') // Supports: #page#
    ));
    return bccl_base_generator( $license_slug, $license_data, $post, $options, $minimal, $templates );
}


// CC Generator
function bccl_cc_generator( $license_slug, $license_data, $post, $options, $minimal=false ) {
    // Use default templates.
    $templates = bccl_default_license_templates();
    return bccl_base_generator( $license_slug, $license_data, $post, $options, $minimal, $templates );
}




// Base Generator
function bccl_base_generator( $license_slug, $license_data, $post, $options, $minimal, $templates ) {

    // Templates are required
    if ( empty( $templates ) ) {
        return '';
    }

    // Determine license group
    $license_group = bccl_get_license_group_name( $license_slug );

    // Allow filtering of the templates
    $templates = bccl_license_apply_filters( 'bccl_license_templates', $license_slug, $license_group, $templates );

    // License image hyperlink
    $license_button_hyperlink = bccl_cc_generate_image_hyperlink( $license_slug, $license_group, $license_data, $post, $options );
    // Work hyperlink
    $work_title_hyperlink = bccl_get_work_hyperlink( $post );
    // Creator hyperlink
    $creator_hyperlink = bccl_get_creator_hyperlink( $post, $options["cc_creator"] );

    // License
    $license_text = '';
    if ( ! empty( $license_data['url'] ) ) {
        $license_hyperlink = sprintf('<a rel="license" href="%s">%s</a>', $license_data['url'], $license_data['name']);
    } else {
         $license_hyperlink = sprintf('<em rel="license">%s</em>', $license_data['name']);
    }
    $license_text_long_template = $templates['license_text_long'];
    $license_text_short_template = $templates['license_text_short'];
    if ( ! empty( $license_text_long_template ) && $options['cc_extended'] == '1' ) {
        // Construct long license text.
        $license_text_long_template = bccl_license_apply_filters( 'bccl_license_text_long_template', $license_slug, $license_group, $license_text_long_template );
        $template_vars = array(
            '#work#'    => $work_title_hyperlink,
            '#creator#' => $creator_hyperlink,
            '#license#' => $license_hyperlink,
            '#year#'    => get_the_date('Y')
        );
        $license_text = $license_text_long_template;
        foreach ( $template_vars as $var_name=>$var_value ) {
            $license_text = str_replace( $var_name, $var_value, $license_text );
        }
        //$license_text = sprintf(__('%s by %s is licensed under a %s.', 'cc-configurator'), $work_title_hyperlink, $creator_hyperlink, $license_hyperlink);
    } elseif ( ! empty( $license_text_short_template ) ) {
        // Construct short license text.
        $license_text_short_template = bccl_license_apply_filters( 'bccl_license_text_short_template', $license_slug, $license_group, $license_text_short_template );
        $template_vars = array(
            '#license#' => $license_hyperlink,
            '#year#'    => get_the_date('Y')
        );
        $license_text = $license_text_short_template;
        foreach ( $template_vars as $var_name=>$var_value ) {
            $license_text = str_replace( $var_name, $var_value, $license_text );
        }
        //$license_text = sprintf(__('This work is licensed under a %s.', 'cc-configurator'), $license_hyperlink);
    }
    // Allow filtering of the license text
    $license_text = bccl_license_apply_filters( 'bccl_license_text', $license_slug, $license_group, $license_text );

    // Extra perms
    $extra_perms_text = '';
    $extra_perms_url = bccl_get_extra_perms_url( $post, $options );
    $extra_perms_title = bccl_get_extra_perms_title( $post, $options );
    $extra_perms_template = $templates['extra_perms'];
    if ( ! empty( $extra_perms_template ) && ! empty( $extra_perms_url ) ) {
        if ( empty($extra_perms_title) ) {
            // If there is no title, use the URL as the anchor text.
            $extra_perms_title = $extra_perms_url;
        }
        $extra_perms_hyperlink = sprintf('<a xmlns:cc="http://creativecommons.org/ns#" href="%s" rel="cc:morePermissions">%s</a>', $extra_perms_url, $extra_perms_title);
        // Construct extra permissions clause
        $extra_perms_template = bccl_license_apply_filters( 'bccl_extra_permissions_template', $license_slug, $license_group, $extra_perms_template );
        $template_vars = array(
            '#page#' => $extra_perms_hyperlink
        );
        $extra_perms_text = $extra_perms_template;
        foreach ( $template_vars as $var_name=>$var_value ) {
            $extra_perms_text = str_replace( $var_name, $var_value, $extra_perms_text );
        }
        //$extra_perms_text = sprintf($extra_perms_template, $extra_perms_hyperlink);
        // Alt text: Terms and conditions beyond the scope of this license may be available at %s.
    }
    // Allow filtering of the complete extra permissions clause.
    $extra_perms_text = bccl_license_apply_filters( 'bccl_extra_perms_text', $license_slug, $license_group, $extra_perms_text );

    // Construct HTML block
    if ( $minimal === false ) {

        $cc_block = array();
        // License Button
        if ( ! empty($license_button_hyperlink) ) {
            $cc_block[] = $license_button_hyperlink;
            $cc_block[] = '<br />';
        }
        // License
        if ( ! empty($license_text) ) {
            $cc_block[] = $license_text;
        }
        // Extra perms
        if ( ! empty($extra_perms_text) ) {
            $cc_block[] = $extra_perms_text;
        }
        // Source Work
        //if ( ! empty($source_work_html) ) {
        //    $cc_block[] = '<br />';
        //    $cc_block[] = $source_work_html;
        //}

        // Construct full license text block
        // $pre_text = 'Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved' . '<br />';
        $full_license_block = implode(PHP_EOL, $cc_block);
        $full_license_block = bccl_license_apply_filters( 'bccl_full_license_block', $license_slug, $license_group, $full_license_block );
        // Construct enclosure
        $enclosure_template = '<p class="cc-block">%s</p>';
        $enclosure_template = bccl_license_apply_filters( 'bccl_enclosure_template', $license_slug, $license_group, $enclosure_template );
        return sprintf( $enclosure_template, $full_license_block );

    } else {    // $minimal === true
        // Construct HTML block
        $cc_block = array();
        // License Button
        if ( ! empty($license_button_hyperlink) ) {
            $cc_block[] = $license_button_hyperlink;
            $cc_block[] = '<br /><br />';
        }
        // License
        $cc_block[] = $license_hyperlink;
        // $pre_text = 'Copyright &copy; ' . get_the_date('Y') . ' - Some Rights Reserved' . '<br />';
        $minimal_license_block = implode(PHP_EOL, $cc_block);
        $minimal_license_block = bccl_license_apply_filters( 'bccl_minimal_license_block', $license_slug, $license_group, $minimal_license_block );
        return $minimal_license_block;
    }
}


// License Badge Shortcode

function bccl_license_badge_shortcode( $atts ) {
    // Entire list of supported parameters and their default values
    $pairs = array(
        'type'    => '',    // License slug (required)
        'compact' => '1',   // Display compact image.
        'link'    => '1',   // Create hyperlink to the license page at creativecommons.org
    );
    // Combined and filtered attribute list.
	$atts = shortcode_atts( $pairs, $atts, 'license' );

    // Construct the array with the slugs of the licenses supported by the shortcode.
    $license_slugs_all = array_keys( bccl_get_all_licenses() );
    $license_slugs_unsupported = apply_filters( 'bccl_shortcode_license_unsupported_slugs', array( 'manual', 'arr' ) );
    $license_slugs = array();
    foreach ( $license_slugs_all as $slug ) {
        if ( ! in_array( $slug, $license_slugs_unsupported ) ) {
            $license_slugs[] = $slug;
        }
    }

    // Check for required parameters.
    if ( empty( $atts['type'] ) ) {
        return '<code>license error: missing "type" - supported: ' . implode(', ', $license_slugs) . '</code>';
    }

    // Type validation
    if ( ! in_array( $atts['type'], $license_slugs ) ) {
        // If an invalid license type has been requested we return an empty string.
        // This way, even if the available licenses have been customized, any
        // [license] shortcode with invalid type in the posts would not print the error message.
        //return '<code>license error: invalid type - supported: ' . implode(', ', $license_slugs) . '</code>';
        return '';
    }

    // Get license data
    $license_data = bccl_get_license_data( $atts['type'] );

    // Construct absolute image URL
    $license_image_url = $license_data['button_compact_url'];
    if ( empty( $atts['compact'] ) ) {
        $license_image_url = $license_data['button_url'];
    }
    $license_image_url = bccl_make_absolute_image_url( $license_image_url );

    // Construct HTML output
    $html = '<div class="cc-badge">';
    if ( ! empty( $atts['link'] ) ) {
        // We do not use rel="license" so as to avoid confusing the bots.
        $html .= sprintf('<a href="%s" title="%s">', $license_data['url'], $license_data['name']);
    }
    $html .= sprintf('<img src="%s" alt="%s" />', $license_image_url, $license_data['name']);
    if ( ! empty( $atts['link'] ) ) {
        $html .= '</a>';
    }
    $html .= '</div>';

    $html = apply_filters( 'bccl_shortcode_badge_html', $html );

	return $html;
}
add_shortcode( 'license', 'bccl_license_badge_shortcode' );



    /****** VALID CODE FOR SOURCE WORK
    // Determine Source Work
    $source_work_html = '';
    // Source work
    $source_work_url = get_post_meta( $post->ID, '_bccl_source_work_url', true );
    $source_work_title = get_post_meta( $post->ID, '_bccl_source_work_title', true );
    // $source_work_url & $source_work_title are mandatory for the source work HTML to be generated.
    if ( ! empty($source_work_url) && ! empty($source_work_title) ) {
        $source_work_html = 'Based on';
        // Source work creator
        $source_creator_url = get_post_meta( $post->ID, '_bccl_source_creator_url', true );
        $source_creator_name = get_post_meta( $post->ID, '_bccl_source_creator_name', true );
        if ( empty($source_creator_name) ) {
            // If the creator name is empty, use the source creator URL instead.
            $source_creator_name = $source_creator_url;
        }
        $source_work_creator_html = sprintf('<a xmlns:cc="http://creativecommons.org/ns#" href="%s" property="cc:attributionName" rel="cc:attributionURL">%s</a>')
    }

    if ( ! empty($extra_perms_url) ) {
        if ( empty($extra_perms_title) ) {
            // If there is no title, use the URL as the anchor text.
            $extra_perms_title = $extra_perms_url;
        }
        $extra_perms_text = sprintf('Permissions beyond the scope of this license may be available at <a xmlns:cc="http://creativecommons.org/ns#" href="%s" rel="cc:morePermissions">%s</a>.', $extra_perms_url, $extra_perms_title);
    }
    *****/

