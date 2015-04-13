<?php

// Prevent direct access to this file.
if ( ! defined( 'ABSPATH' ) ) {
    header( 'HTTP/1.0 403 Forbidden' );
    echo 'This file should not be accessed directly!';
    exit; // Exit if accessed directly
}


/*
$work: The work that is licensed can be defined by the user.
$css_class : The user can define the CSS class that will be used to
$show_button: (default, yes, no)
format the license block. (if empty, the default cc-block is used)
*/
function bccl_license_block($work = "", $css_class = "", $show_button = "default", $button = "default") {
    echo bccl_add_placeholders(bccl_get_license_block($work, $css_class, $show_button, $button));
}


/*
Displays the full HTML code of the license
*/  
function bccl_full_html_license() {

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

    // Append the license block to the content
    $cc_block = call_user_func( $license_data['generator_func'], $license_slug, $license_data, $post, $options, $minimal=true );

    echo bccl_add_placeholders(cc_block);
}


/*
Displays the licence summary page from creative commons in an iframe
*/
function bccl_license_legalcode($width="100%", $height="600px", $css_class="cc-frame") {

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

    // Append the license block to the content
    $cc_block = call_user_func( $license_data['generator_func'], $license_slug, $license_data, $post, $options, $minimal=true );

    printf('
        <iframe src="%slegalcode" frameborder="0" width="%s" height="%s" class="%s"></iframe>', $cc_block, $width, $height, $css_class);
}


/*
Displays the licence summary page from creative commons in an iframe
*/
function bccl_license_summary($width="100%", $height="600px", $css_class="cc-frame") {

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

    // Append the license block to the content
    $cc_block = call_user_func( $license_data['generator_func'], $license_slug, $license_data, $post, $options, $minimal=true );

    printf('
        <iframe src="%s" frameborder="0" width="%s" height="%s" class="%s"></iframe>', $cc_block, $width, $height, $css_class);
}


/*
Displays Full IMAGE hyperlink to License <a href=...><img...</a>
*/
function bccl_license_image_hyperlink() {

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

    // Determine license group
    $license_group = bccl_get_license_group_name( $license_slug );

    // Append the license block to the content
    $image_hyperlink = bccl_cc_generate_image_hyperlink( $license_slug, $license_group, $license_data, $post, $options );

    echo bccl_add_placeholders($image_hyperlink);
}


/*
Displays Full TEXT hyperlink to License <a href=...>...</a>
*/
function bccl_license_text_hyperlink() {

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

    $license_text_hyperlink = call_user_func( $license_data['generator_func'], $license_slug, $license_data, $post, $options, $minimal=true );

    echo bccl_add_placeholders($license_text_hyperlink);
}


/*
Returns the URL of the license or an empty string.
*/
function bccl_get_license_url() {

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

    return $license_data['url'];
}

