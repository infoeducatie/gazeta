<?php

// Add parent stylesheet as dependency
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

function hide_update_notice_to_all_but_admin_users() { if (!current_user_can('administrator') && !is_admin()) { remove_action( 'admin_notices', 'update_nag', 3 ); } } 
add_action( 'admin_head', 'hide_update_notice_to_all_but_admin_users', 1 );

?>
