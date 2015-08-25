<?php
/**
 * Plugin Name: Team Members
 * Plugin URI: http://wpdarko.com/team-members
 * Description: A responsive, simple and clean way to display your team. Create new members, add their positions, bios, social links and copy-paste the shortcode into any post/page. Find help and information on our <a href="http://wpdarko.com/support/">support site</a>. This free version is NOT limited and does not contain any ad. Check out the <a href='http://wpdarko.com/team-members'>PRO version</a> for more great features.
 * Version: 3.0
 * Author: WP Darko
 * Author URI: http://wpdarko.com
 * Text Domain: team-members
 * Domain Path: /lang/
 * License: GPL2
 */ 


// Loading text domain
function tmm_load_plugin_textdomain() {
  load_plugin_textdomain( 'team-members', FALSE, basename( dirname( __FILE__ ) ) . '/lang/' );
}
 
add_action( 'plugins_loaded', 'tmm_load_plugin_textdomain' );


// Check for an active PRO version and deactivate this plugin
add_action( 'admin_init', 'tmm_free_pro_check' );
function tmm_free_pro_check() {
    if (is_plugin_active('team-members-pro/tmm-pro.php')) {  
        add_action('admin_notices', 'my_admin_notice');
        function my_admin_notice(){ echo '<div class="updated"><p><strong>PRO</strong> version is activated.</p></div>'; } 
        
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
}


/* Recover old data if there is */
add_action( 'init', 'tmm_old_data' );

function tmm_old_data() {
    
    if(!get_option('tmm_is_updated_yn9090')){
    
        global $post;
        $args = array(
            'post_type' => 'tmm',
            'posts_per_page'   => 9999,
        );
    
        $get_old = get_posts( $args );
        foreach ( $get_old as $post ) : setup_postdata( $post );
    
            $current_id = get_the_id();
            $old_data_teams = get_post_meta( $current_id, 'tmm_head', false );
    
            foreach ($old_data_teams as $key => $odata) {

                $old_plugin_data[$key]['_tmm_firstname'] = $odata['tmm_firstname'];
                $old_plugin_data[$key]['_tmm_lastname'] = $odata['tmm_lastname'];
                $old_plugin_data[$key]['_tmm_job'] = $odata['tmm_job'];
                $old_plugin_data[$key]['_tmm_photo'] = wp_get_attachment_url($odata['tmm_photo']);
                $old_plugin_data[$key]['_tmm_desc'] = $odata['tmm_desc'];
                $old_plugin_data[$key]['_tmm_sc_type1'] = $odata['tmm_sc_type1'];
                $old_plugin_data[$key]['_tmm_sc_title1'] = $odata['tmm_sc_title1'];
                $old_plugin_data[$key]['_tmm_sc_url1'] = $odata['tmm_sc_url1'];
                $old_plugin_data[$key]['_tmm_sc_type2'] = $odata['tmm_sc_type2'];
                $old_plugin_data[$key]['_tmm_sc_title2'] = $odata['tmm_sc_title2'];
                $old_plugin_data[$key]['_tmm_sc_url2'] = $odata['tmm_sc_url2'];
                $old_plugin_data[$key]['_tmm_sc_type3'] = $odata['tmm_sc_type3'];
                $old_plugin_data[$key]['_tmm_sc_title3'] = $odata['tmm_sc_title3'];
                $old_plugin_data[$key]['_tmm_sc_url3'] = $odata['tmm_sc_url3'];
    
                update_post_meta($current_id, '_tmm_head', $old_plugin_data);
                wp_reset_postdata();
    
            }
    
            $test_man = '';
            $old_data_settings = get_post_meta( $current_id, 'tmm_settings_head', false );
    
            foreach ($old_data_settings as $key => $odata) {
    
                $var1 = $odata['tmm_columns'];
                $var2 = $odata['tmm_color'];
    
                update_post_meta($current_id, '_tmm_columns', $var1);
                update_post_meta($current_id, '_tmm_color', $var2);

            }
    
        endforeach;
        
        update_option('tmm_is_updated_yn9090', 'old_data_recovered');
    
    }
  
}


// Enqueue styles and scripts
add_action( 'wp_enqueue_scripts', 'add_tmm_scripts' ); 
function add_tmm_scripts() { wp_enqueue_style( 'tmm', plugins_url('css/tmm_custom_style.min.css', __FILE__)); }


// Enqueue admin styles
add_action( 'admin_enqueue_scripts', 'add_admin_tmm_style' );
function add_admin_tmm_style() { wp_enqueue_style( 'tmm', plugins_url('css/admin_de_style.min.css', __FILE__)); }


// Register Team post type
add_action( 'init', 'register_tmm_type' );
function register_tmm_type() {
	$labels = array(
		'name'               => __( 'Teams', 'team-members' ),
		'singular_name'      => __( 'Team', 'team-members' ),
		'menu_name'          => __( 'Teams', 'team-members' ),
		'name_admin_bar'     => __( 'Team', 'team-members' ),
		'add_new'            => __( 'Add New', 'team-members' ),
		'add_new_item'       => __( 'Add New Team', 'team-members' ),
		'new_item'           => __( 'New Team', 'team-members' ),
		'edit_item'          => __( 'Edit Team', 'team-members' ),
		'view_item'          => __( 'View Team', 'team-members' ),
		'all_items'          => __( 'All Teams', 'team-members' ),
		'search_items'       => __( 'Search Teams', 'team-members' ),
		'not_found'          => __( 'No Teams found.', 'team-members' ),
		'not_found_in_trash' => __( 'No Teams found in Trash.', 'team-members' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
        'show_in_admin_bar'  => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title' ),
        'menu_icon'          => 'dashicons-plus'
	);
	register_post_type( 'tmm', $args );  
}


// Customize update messages
add_filter( 'post_updated_messages', 'tmm_updated_messages' );
function tmm_updated_messages( $messages ) {
	$post             = get_post();
	$post_type        = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );
	$messages['tmm'] = array(
		1  => __( 'Team updated.', 'team-members' ),
		4  => __( 'Team updated.', 'team-members' ),
		6  => __( 'Team published.', 'team-members' ),
		7  => __( 'Team saved.', 'team-members' ),
		10 => __( 'Team draft updated.', 'team-members' )
	);

	if ( $post_type_object->publicly_queryable ) {
		$permalink = get_permalink( $post->ID );

		$view_link = sprintf( '', '', '' );
		$messages[ $post_type ][1] .= $view_link;
		$messages[ $post_type ][6] .= $view_link;
		$messages[ $post_type ][9] .= $view_link;

		$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
		$preview_link = sprintf( '', '', '' );
		$messages[ $post_type ][8]  .= $preview_link;
		$messages[ $post_type ][10] .= $preview_link;
	}
	return $messages;
}


// Add the metabox class (CMB2)
if ( file_exists( dirname( __FILE__ ) . '/inc/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/inc/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/inc/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/inc/CMB2/init.php';
}


// Create the metabox class (CMB2)
add_action( 'cmb2_init', 'tmm_register_group_metabox' );
require_once('inc/tmm-metaboxes.php'); 


// Add shortcode column to post list
add_action( 'manage_tmm_posts_custom_column' , 'tmm_custom_columns', 10, 2 );
add_filter('manage_tmm_posts_columns' , 'add_tmm_columns');
function tmm_custom_columns( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$slug = '' ;
		$slug = $post->post_name;
        $shortcode = '<span style="display:inline-block;border:solid 2px lightgray; background:white; padding:0 8px; font-size:13px; line-height:25px; vertical-align:middle;">[tmm name="'.$slug.'"]</span>';
	    echo $shortcode; 
	    break;
    }
}
function add_tmm_columns($columns) { return array_merge($columns, array('shortcode' => 'Shortcode')); }


// Create the Team shortcode
add_shortcode("tmm", "tmm_sc"); 
function tmm_sc($atts) {
	extract(shortcode_atts(array( "name" => ''), $atts));
    global $post;
    $args = array('post_type' => 'tmm', 'name' => $name);
    $custom_posts = get_posts($args); 
    
    foreach($custom_posts as $post) : setup_postdata($post);
    
        $members = get_post_meta( get_the_id(), '_tmm_head', true );
        $tmm_columns = get_post_meta( $post->ID, '_tmm_columns', true );
        $tmm_color = get_post_meta( $post->ID, '_tmm_color', true );
        $tmm_bio_alignment = get_post_meta( $post->ID, '_tmm_bio_alignment', true );
        
        // Check if member links open in new window
        $tmm_piclink_beh = get_post_meta( $post->ID, '_tmm_piclink_beh', true );
        ($tmm_piclink_beh == 'new' ? $tmm_plb = 'target="_blank"' : $tmm_plb = '');
    
        // Check if forcing original fonts
        $original_font = get_post_meta( $post->ID, '_tmm_original_font', true );
        ($original_font == true ? $ori_f = 'tmm_ori_f' : $ori_f = '');
    
        // Check if last row centered
        $last_row_centered = get_post_meta( $post->ID, '_tmm_last_row_centered', true );
        ($last_row_centered == true ? $last_r = 'tmm_last_row_centered' : $last_r = '');
    
        $output = '';
        $output .= '<div class="tmm '.$last_r.' tmm_'.$name.'">';
            $output .= '<div class="tmm_'.$tmm_columns.'_columns tmm_wrap '.$ori_f.'">';
                
                if (is_array($members) || is_object($members))
                    foreach ($members as $key => $member) {
                        // Create Team container
                        if($key%2 == 0) {
                            // Check if group of two (alignment purposes)
                            $output .= '<span class="tmm_two_containers_tablet"></span>';
                        }
                        if($key%$tmm_columns == 0) {
                            // Check if first div of group and close
                            if($key > 0) $output .= '</div><span class="tmm_columns_containers_desktop"></span>';
                            $output .= '<div class="tmm_container">';
                        }
                        
                        $output .= '<div class="tmm_member" style="border-top:'.$tmm_color.' solid 5px;">';
                        
                            // Display photo
                            if (!empty($member['_tmm_photo_url']))
                                $output .= '<a '.$tmm_plb.' href="'.$member['_tmm_photo_url'].'" title="'.$member['_tmm_firstname'].' '.$member['_tmm_lastname'].'">';
                            
                                if (!empty($member['_tmm_photo']))
                                    $output .= '<div class="tmm_photo tmm_phover_'.$name.'_'.$key.'" style="background: url('.$member['_tmm_photo'].'); margin-left:auto; margin-right:auto; background-size:cover !important;"></div>';
                                
                            if (!empty($member['_tmm_photo_url'])) $output .= '</a>';
                            
                            // Create text block
                            $output .= '<div class="tmm_textblock">';
                                
                                // Display names
                                $output .= '<div class="tmm_names">';
                                    if (!empty($member['_tmm_firstname']))
                                        $output .= '<span class="tmm_fname">'.$member['_tmm_firstname'].'</span> ';
                                    if (!empty($member['_tmm_lastname']))
                                        $output .= '<span class="tmm_lname">'.$member['_tmm_lastname'].'</span>';
                                $output .= '</div>';
                        
                                // Display jobs
                                if (!empty($member['_tmm_job']))
                                    $output .= '<div class="tmm_job">'.$member['_tmm_job'].'</div>';
                        
                                // Display bio
                                if (!empty($member['_tmm_desc']))
                                    $output .= '<div class="tmm_desc" style="text-align:'.$tmm_bio_alignment.'">'.$member['_tmm_desc'].'</div>';
                        
                                // Create social block
                                $output .= '<div class="tmm_scblock">';
                        
                                    // Display social links
                                    for ($i = 1; $i <= 3; $i++) {
                                        if ($member['_tmm_sc_type'.$i] != 'nada') {
                                            if ($member['_tmm_sc_type'.$i] == 'email') {
                                                $output .= '
                                                    <a class="tmm_sociallink" href="mailto:'.(!empty($member['_tmm_sc_url'.$i])?$member['_tmm_sc_url'.$i]:'').'" title="'.$member['_tmm_sc_title'.$i].'"><img alt="'.$member['_tmm_sc_title'.$i].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                                            } else {
                                                $output .= '<a target="_blank" class="tmm_sociallink" href="'.(!empty($member['_tmm_sc_url'.$i])?$member['_tmm_sc_url'.$i]:'').'" title="'.$member['_tmm_sc_title'.$i].'"><img alt="'.$member['_tmm_sc_title'.$i].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type'.$i].'.png"/></a>';
                                            }
                                        }
                                    }
                            
                                $output .= '</div>'; // Close social block
                            $output .= '</div>'; // Close text block
                        $output .= '</div>'; // Close member
                        
                        $page_count = count( $members );
                        if ($key == $page_count - 1) $output .= '<div style="clear:both;"></div>';           
                    }
        
                $output .= '</div>'; // Close container
            $output .= '</div>'; // Close wrap
        $output .= '</div>'; // Close tmm
    
    endforeach; wp_reset_postdata(); 
	return $output;
}

?>