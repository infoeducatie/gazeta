<?php


// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}



/**
 * Helper function that returns an array containing the post types that are
 * supported by CC-Configurator. These include:
 *
 *   - post
 *   - page
 *   - attachment
 *
 * And also to ALL public custom post types which have a UI.
 *
 */
function bccl_get_supported_post_types() {
    $supported_builtin_types = array('post', 'page', 'attachment');
    $public_custom_types = get_post_types( array('public'=>true, '_builtin'=>false, 'show_ui'=>true) );
    $supported_types = array_merge($supported_builtin_types, $public_custom_types);

    // Allow filtering of the supported content types.
    $supported_types = apply_filters( 'bccl_supported_post_types', $supported_types );

    return $supported_types;
}



/**
 * Helper function that returns an array containing the post types
 * on which the Metadata metabox should be added.
 *
 *   - post
 *   - page
 *
 * And also to ALL public custom post types which have a UI.
 *
 * NOTE ABOUT attachments:
 * The 'attachment' post type does not support saving custom fields like other post types.
 * See: http://www.codetrax.org/issues/875
 */
function bccl_get_post_types_for_metabox() {
    // Get the post types supported by Creative-Commons-Configurator
    $supported_builtin_types = bccl_get_supported_post_types();
    // The 'attachment' post type does not support saving custom fields like
    // other post types. See: http://www.codetrax.org/issues/875
    // So, the 'attachment' type is removed (if exists) so as not to add a metabox there.
    $attachment_post_type_key = array_search( 'attachment', $supported_builtin_types );
    if ( $attachment_post_type_key !== false ) {
        // Remove this type from the array
        unset( $supported_builtin_types[ $attachment_post_type_key ] );
    }
    // Get public post types
    $public_custom_types = get_post_types( array('public'=>true, '_builtin'=>false, 'show_ui'=>true) );
    $supported_types = array_merge($supported_builtin_types, $public_custom_types);

    // Allow filtering of the supported content types.
    $supported_types = apply_filters( 'bccl_metabox_post_types', $supported_types );     // Leave this filter out of the documentation for now.

    return $supported_types;
}




function bccl_get_creator_pool() {
    $creator_arr = array(
        "blogname"    => __('Blog Name', 'cc-configurator'),
        "firstlast"    => __('First + Last Name', 'cc-configurator'),
        "lastfirst"    => __('Last + First Name', 'cc-configurator'),
        "nickname"    => __('Nickname', 'cc-configurator'),
        "displayedname"    => __('Displayed Name', 'cc-configurator'),
        );
    return $creator_arr;
}



/**
 * Return the creator/publisher of the licensed work according to the user-defined option (cc-creator)
 */
function bccl_get_the_creator($what) {

    $author_name = '';
    if ($what == "blogname") {
        $author_name = get_bloginfo("name");
    } elseif ($what == "firstlast") {
        $author_name = get_the_author_meta('first_name') . " " . get_the_author_meta('last_name');
    } elseif ($what == "lastfirst") {
        $author_name = get_the_author_meta('last_name') . " " . get_the_author_meta('first_name');
    } elseif ($what == "nickname") {
        $author_name = get_the_author_meta('nickname');
    } elseif ($what == "displayedname") {
        $author_name = get_the_author_meta('display_name');
    } else {
        $author_name = get_the_author_meta('display_name');
    }
    // If we do not have an author name, revert to the display name.
    if ( trim($author_name) == '' ) {
        return get_the_author();
    }
    return $author_name;
}


function bccl_add_placeholders( $data, $what='html' ) {
    if ( empty( $data ) ) {
        return '';
    }
    if ( $what == 'html' ) {
        return sprintf( PHP_EOL . "<!-- BEGIN License added by Creative-Commons-Configurator plugin for WordPress -->" . PHP_EOL . "%s" . PHP_EOL . "<!-- END License added by Creative-Commons-Configurator plugin for WordPress -->" . PHP_EOL , trim($data) );
    } else {
        return sprintf( PHP_EOL . "<!--" . PHP_EOL . "%s" . PHP_EOL . "-->" . PHP_EOL, trim($data) );
    }
}


function bccl_get_dcmitype( $post ) {

    if ( is_attachment() ) {
        $mime_type = get_post_mime_type( $post->ID );
        //$attachment_type = strstr( $mime_type, '/', true );
        // See why we do not use strstr(): http://www.codetrax.org/issues/1091
        $attachment_type = preg_replace( '#\/[^\/]*$#', '', $mime_type );

        if ( 'image' == $attachment_type ) {
            return 'StillImage';
        } elseif ( 'video' == $attachment_type ) {
            return 'MovingImage';
        } elseif ( 'audio' == $attachment_type ) {
            return 'Sound';
        }

    } elseif ( is_singular() ) {
    
        $format = get_post_format( $post->id );

        if ($format=="gallery") {
            return 'StillImage';
        } elseif ($format=="image") {
            return 'StillImage';
        } elseif ($format=="video") {
            return 'MovingImage';
        } elseif ($format=="audio") {
            return 'Sound';
        }
    }
    return 'Text';
}


function bccl_get_content_license_slug( $post, $options ) {
    $bccl_license_value = get_post_meta( $post->ID, '_bccl_license', true );
    if ( empty( $bccl_license_value ) ) {
        // Set to default
        $bccl_license_value = $options['cc_default_license'];
        // Allow filtering of the default license
        $bccl_license_value = apply_filters( 'bccl_default_license', $bccl_license_value ); // String: License slug (see bccl-licenses.php)
    }
    return $bccl_license_value;
}


function bccl_get_extra_perms_url( $post, $options ) {
    $bccl_perm_url_value = get_post_meta( $post->ID, '_bccl_perm_url', true );
    if ( empty( $bccl_perm_url_value ) ) {
        // Set to default
        $bccl_perm_url_value = $options['cc_perm_url'];
    }
    return $bccl_perm_url_value;
}

function bccl_get_extra_perms_title( $post, $options ) {
    $bccl_perm_title_value = get_post_meta( $post->ID, '_bccl_perm_title', true );
    if ( empty( $bccl_perm_title_value ) ) {
        // Set to default
        $bccl_perm_title_value = $options['cc_perm_title'];
    }
    return $bccl_perm_title_value;
}


function bccl_get_work_hyperlink( $post ) {
    $work_title = get_the_title($post->ID);
    $work_permalink = get_permalink($post->ID);
    $work_type = bccl_get_dcmitype($post);
    $work_title_hyperlink = sprintf('<a href="%s" title="Permalink to %s"><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/%s" property="dct:title" rel="dct:type">%s</span></a>', $work_permalink, $work_title, $work_type, $work_title );
    return $work_title_hyperlink;
}

function bccl_get_creator_hyperlink( $post, $creator_format ) {
    $author_url = get_author_posts_url( get_the_author_meta( 'ID', $post->post_author ) );
    $author_name = bccl_get_the_creator( $creator_format );
    $creator_hyperlink = sprintf('<a xmlns:cc="http://creativecommons.org/ns#" href="%s" property="cc:attributionName" rel="cc:attributionURL">%s</a>', $author_url, $author_name);
    return $creator_hyperlink;
}


// Accepts a URL.
// 1) If the URL is absolute, it returns it as is after correcting the protocol according to the is_ssl() output.
// 2) If the URL is relative, it assumes that the path is relative to (plugin_dir)/media/ and constructs the absolute version of it.
function bccl_make_absolute_image_url( $url ) {
    if ( 0 !== strpos( $url, 'http://' ) && 0 !== strpos( $url, 'https://' ) && 0 !== strpos( $url, '//' ) ) {
        // Construct an absolute URL from a relative URL
        $url = plugins_url( 'media/' . $url, BCCL_PLUGIN_FILE );
    }
    // Use correct protocol for image URL
    if ( is_ssl() ) {
        $url = str_replace( 'http://', 'https://', $url );
    }
    // Make the URL protocol agnostic
    //$url = preg_replace( '#^https?:#i', '', $url );
    return $url;
}

// License Image Hyperlink Generator
function bccl_cc_generate_image_hyperlink( $license_slug, $license_group, $license_data, $post, $options ) {

    if ( $options['cc_body_img'] != "1" ) {
        return;
    }

    // Image URL
    $license_image_url = $license_data['button_url'];
    if ( $options['cc_compact_img'] == "1" ) {
        $license_image_url = $license_data['button_compact_url'];
    }
    if ( empty($license_image_url) ) {
        return;
    }
    // Construct absolute image URL
    $license_image_url = bccl_make_absolute_image_url( $license_image_url );
    // Allow filtering of the image URL
    $license_image_url = bccl_license_apply_filters( 'bccl_license_image_url', $license_slug, $license_group, $license_image_url );

    // Other License Data
    $license_name = $license_data['name_short'];
    $license_url = $license_data['url'];

    // Construct hyperlink
    // style="border-width:0" attribute is not used. class="cc-button" is used instead.
    if ( empty($license_url) ) {
        return sprintf('<img alt="%s" class="cc-button" src="%s" />', $license_name, $license_image_url);
    } else {
        return sprintf('<a rel="license" href="%s"><img alt="%s" class="cc-button" src="%s" /></a>', $license_url, $license_name, $license_image_url);
    }
}


// Helper function to apply filters per license, per license group and to all licenses.
function bccl_license_apply_filters( $filter_base_name, $license_slug, $license_group, $data ) {
    // Filter for single license, eg `bccl_license_templates_cc__by-nc-sa`
    $data = apply_filters( $filter_base_name.'_'.$license_slug, $data );
    if ( ! empty( $license_group ) ) {
        // Filter for group of licenses, eg `bccl_license_templates_cc`
        $data = apply_filters( $filter_base_name.'_'.$license_group, $data );
    }
    // Filter for all licenses, eg: `bccl_license_templates`
    $data = apply_filters( $filter_base_name, $data );
    return $data;
}


// Determine license group
function bccl_get_license_group_name( $license_slug ) {
    // License slugs can be of the form: `group__term1-term2-term3`
    // An example is the Creative Commons licenses. See `bccl-licenses.php`.
    $license_group = '';
    $license_slug_parts = explode('__', $license_slug);
    if ( count( $license_slug_parts ) > 1 ) {
        $license_group = $license_slug_parts[0];
    }
    return $license_group;
}

