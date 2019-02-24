<?php
/*
 * Removes options from database when plugin is deleted.
 *  
 *
 */

//if uninstall not called from WordPress exit
if (!defined('WP_UNINSTALL_PLUGIN' )) 
    exit();

$options = array(
    'wpnm_enable_user_registration_notification',
    'wpnm_user_registration_email',
    'wpnm_enable_password_change_notification',
    'wpnm_password_change_email'
    );

// For Single site
if ( !is_multisite() ) 
{
    foreach ($options as $option) {
        delete_option($option);
    }
} 
// For Multisite
else 
{
    // For regular options.
    global $wpdb;
    $blog_ids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");
    $original_blog_id = get_current_blog_id();
    foreach ($blog_ids as $blog_id) 
    {
        switch_to_blog( $blog_id );
        foreach ($options as $option) {
            delete_option($option);
        } 
    }
    switch_to_blog($original_blog_id);

    // For site options.
    foreach ($options as $option) {
        delete_site_option($option); 
    } 
}

?>