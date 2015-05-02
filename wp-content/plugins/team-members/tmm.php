<?php
/*
Plugin Name: Team Members
Plugin URI: http://wpdarko.com/support/documentation/get-started-team-members/
Description: A responsive, simple and clean way to display your team. Create new members, add their positions, bios, social links and copy-paste the shortcode into any post/page. Find support and information on the <a href="http://wpdarko.com/team-members/">plugin's page</a>. This free version is NOT limited and does not contain any ad. Check out the <a href='http://wpdarko.com/items/team-members-pro'>PRO version</a> for more great features.
Version: 2.1.2
Author: WP Darko
Author URI: http://wpdarko.com
License: GPL2
*/

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

                $test_man[$key]['_tmm_firstname'] = $odata['tmm_firstname'];
                $test_man[$key]['_tmm_lastname'] = $odata['tmm_lastname'];
                $test_man[$key]['_tmm_job'] = $odata['tmm_job'];
                $test_man[$key]['_tmm_photo'] = wp_get_attachment_url($odata['tmm_photo']);
                $test_man[$key]['_tmm_desc'] = $odata['tmm_desc'];
                $test_man[$key]['_tmm_sc_type1'] = $odata['tmm_sc_type1'];
                $test_man[$key]['_tmm_sc_title1'] = $odata['tmm_sc_title1'];
                $test_man[$key]['_tmm_sc_url1'] = $odata['tmm_sc_url1'];
                $test_man[$key]['_tmm_sc_type2'] = $odata['tmm_sc_type2'];
                $test_man[$key]['_tmm_sc_title2'] = $odata['tmm_sc_title2'];
                $test_man[$key]['_tmm_sc_url2'] = $odata['tmm_sc_url2'];
                $test_man[$key]['_tmm_sc_type3'] = $odata['tmm_sc_type3'];
                $test_man[$key]['_tmm_sc_title3'] = $odata['tmm_sc_title3'];
                $test_man[$key]['_tmm_sc_url3'] = $odata['tmm_sc_url3'];
    
                update_post_meta($current_id, '_tmm_head', $test_man);
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

/* Check for the PRO version */
function tmm_free_pro_check() {
    if (is_plugin_active('team-members-pro/tmm-pro.php')) {
        
        function my_admin_notice(){
        echo '<div class="updated">
                <p><strong>PRO</strong> version is activated.</p>
              </div>';
        }
        add_action('admin_notices', 'my_admin_notice');
        
        deactivate_plugins(__FILE__);
    }
}

add_action( 'admin_init', 'tmm_free_pro_check' );

/* Enqueue styles & scripts */
add_action( 'wp_enqueue_scripts', 'add_tmm_scripts' );
function add_tmm_scripts() {
	wp_enqueue_style( 'tmm', plugins_url('css/tmm_custom_style.min.css', __FILE__));
}

/* Enqueue admin styles */
add_action( 'admin_enqueue_scripts', 'add_admin_tmm_style' );

function add_admin_tmm_style() {
	wp_enqueue_style( 'tmm', plugins_url('css/admin_de_style.min.css', __FILE__));
}

/* Create the Team post type */
add_action( 'init', 'create_tmm_type' );

function create_tmm_type() {
  register_post_type( 'tmm',
    array(
      'labels' => array(
        'name' => 'Teams',
        'singular_name' => 'Team'
      ),
      'public' => true,
      'has_archive'  => false,
      'hierarchical' => false,
      'capability_type'    => 'post',
      'supports'     => array( 'title' ),
      'menu_icon'    => 'dashicons-plus',
    )
  );
}

/* Hide View/Preview since it's a shortcode */
function tmm_admin_css() {
    global $post_type;
    $post_types = array( 
                        'tmm',
                  );
    if(in_array($post_type, $post_types))
    echo '<style type="text/css">#post-preview, #view-post-btn{display: none;}</style>';
}

function remove_view_link_tmm( $action ) {

    unset ($action['view']);
    return $action;
}

add_filter( 'post_row_actions', 'remove_view_link_tmm' );
add_action( 'admin_head-post-new.php', 'tmm_admin_css' );
add_action( 'admin_head-post.php', 'tmm_admin_css' );

// Adding the CMB2 Metabox class
if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
    require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

// Registering Teams metaboxes
function tmm_register_group_metabox() {
    
    $prefix = '_tmm_';
   
    // Tables group
    $main_group = new_cmb2_box( array(
        'id' => $prefix . 'team_metabox',
        'title' => '<span class="dashicons dashicons-welcome-add-page"></span> Manage Members <span style="color:#8a7463; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> Free version</span>',
        'object_types' => array( 'tmm' ),
    ));
    
     $main_group->add_field( array(
         'name'    => '<span style="font-weight:400;">Getting started / Instructions</span>',
         'desc' => 'Edit your members (see below), add more, reorder them and play around with the settings on the right. If you have trouble understanding how this works, click the "Help & Support tab on the right."',
         'id'      => $prefix . 'instructions',
         'type'    => 'title',
         'row_classes' => 'de_hundred de_instructions',
     ) );
    
        $tmm_group = $main_group->add_field( array(
            'id' => $prefix . 'head',
            'type' => 'group',
            'options' => array(
                'group_title' => 'Member {#}',
                'add_button' => 'Add another member',
                'remove_button' => 'Remove member',
                'sortable' => true,
                'single' => false,
            ),
        ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => 'Member details',
                'id' => $prefix . 'member_header',
                'type' => 'title',
                'row_classes' => 'de_hundred de_heading',
            ));

    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-edit"></span> Firstname</span>',
                'id' => $prefix . 'firstname',
                'type' => 'text',
                'row_classes' => 'de_first de_twentyfive de_text de_input',
                'sanitization_cb' => false,
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-edit"></span> Lastname</span>',
                'id' => $prefix . 'lastname',
                'type' => 'text',
                'row_classes' => 'de_twentyfive de_text de_input',
                'sanitization_cb' => false,
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-edit"></span> Job/role</span>',
                'id' => $prefix . 'job',
                'type' => 'text',
                'row_classes' => 'de_fifty de_text de_input',
                'sanitization_cb' => false,
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-edit"></span> Description/bio',
				'id' => $prefix . 'desc',
				'type' => 'textarea',
                'attributes'  => array(
                    'rows' => 6,
                ),
                'row_classes' => 'de_first de_fifty de_textarea de_input',
                'sanitization_cb' => false,
            ));
            
            $main_group->add_group_field( $tmm_group, array(
                'name' => 'Tips & Tricks',
                'desc' => '<span class="dashicons dashicons-yes"></span> Add links<br/><span style="color:#bbb;">&lt;a href="http://you.com/member-page"&gt;View member page&lt;/a&gt;</span>',
                'id'   => $prefix . 'desc_desc',
                'type' => 'title',
                'row_classes' => 'de_fifty de_info',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Complementary info title</span>',
                'desc' => 'This adds a little link below the description/bio, it will reveal the complementary info text when a visitor hovers over it.',
                'id' => $prefix . 'comp_title',
                'type' => 'text',
                'row_classes' => 'de_first de_fifty de_text de_input',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Complementary info text</span>',
				'id' => $prefix . 'comp_text',
				'type' => 'textarea',
                'attributes'  => array(
                    'rows' => 1,
                ),
                'row_classes' => 'de_fifty de_text de_input',
                'sanitization_cb' => false,
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Color (per member)</span>',
                'id' => $prefix . 'freecolor',
                'type' => 'colorpicker',
                'row_classes' => 'de_first de_hundred de_color de_input',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => 'Member links',
                'id' => $prefix . 'member_links_header',
                'type' => 'title',
                'row_classes' => 'de_hundred de_heading',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name'    => '<span class="dashicons dashicons-admin-generic"></span> Link type (icon)',
			 'id'      => $prefix . 'sc_type1',
			 'type'    => 'select',
            'default' => 'nada',
			 'options' => array(
			 	'nada' => '-',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn',
                    'googleplus' => 'Google+',
                    'facebook' => 'Facebook',
                    'instagram' => 'Instagram',
                    'tumblr' => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'email' => 'Email',
                    'website' => 'Website',
                    'customlink' => 'Other links',
			 ),
			 
             'row_classes' => 'de_first de_twentyfive de_select de_text de_input',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-edit"></span> Link title',
                'id' => $prefix . 'sc_title1',
                'type' => 'text',
                'row_classes' => 'de_twentyfive de_text de_input',
            ));
        
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-admin-links"></span> Link URL',
                'id' => $prefix . 'sc_url1',
                'type' => 'text',
                'row_classes' => 'de_fifty de_text de_input',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name'    => '',
			 'id'      => $prefix . 'sc_type2',
			 'type'    => 'select',
            'default' => 'nada',
			 'options' => array(
			 	'nada' => '-',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn',
                    'googleplus' => 'Google+',
                    'facebook' => 'Facebook',
                    'instagram' => 'Instagram',
                    'tumblr' => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'email' => 'Email',
                    'website' => 'Website',
                    'customlink' => 'Other links',
			 ),
                'row_classes' => 'de_first de_twentyfive de_select de_text de_input de_nomtop',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '',
                'id' => $prefix . 'sc_title2',
                'type' => 'text',
                'row_classes' => 'de_twentyfive de_text de_input de_nomtop',
            ));
        
            $main_group->add_group_field( $tmm_group, array(
                'name' => '',
                'id' => $prefix . 'sc_url2',
                'type' => 'text',
                'row_classes' => 'de_fifty de_text de_input de_nomtop',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name'    => '',
			 'id'      => $prefix . 'sc_type3',
			 'type'    => 'select',
            'default' => 'nada',
			 'options' => array(
			 	'nada' => '-',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn',
                    'googleplus' => 'Google+',
                    'facebook' => 'Facebook',
                    'instagram' => 'Instagram',
                    'tumblr' => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'email' => 'Email',
                    'website' => 'Website',
                    'customlink' => 'Other links',
			 ),
                'row_classes' => 'de_first de_twentyfive de_select de_text de_input de_nomtop',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '',
                'id' => $prefix . 'sc_title3',
                'type' => 'text',
                'row_classes' => 'de_twentyfive de_text de_input de_nomtop',
            ));
        
            $main_group->add_group_field( $tmm_group, array(
                'name' => '',
                'id' => $prefix . 'sc_url3',
                'type' => 'text',
                'row_classes' => 'de_fifty de_text de_input de_nomtop',
            )); 
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => 'Member photo',
                'id' => $prefix . 'member_styling_header',
                'type' => 'title',
                'row_classes' => 'de_hundred de_heading',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-format-image"></span> Upload Photo',
                'id'   => $prefix . 'photo',
                'type' => 'file',
                'attributes'  => array(
                    'placeholder' => 'Recommended size: 250x250px',
                ),
                'options' => array(
		            'add_upload_file_text' => __( 'Upload', 'jt_cmb2' ),
	            ),
                'row_classes' => 'de_first de_fifty de_upload de_input',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Upload hover photo',
                'desc' => 'Add another photo that will replace the first one on hover.',
                'id'   => $prefix . 'hoverphoto',
                'type' => 'file',
                'attributes'  => array(
                    'placeholder' => 'Recommended size: 250x250px',
                ),
                'options' => array(
		            'add_upload_file_text' => __( 'Upload', 'jt_cmb2' ),
	            ),
                'row_classes' => 'de_fifty de_upload de_input',
            ));
    
            $main_group->add_group_field( $tmm_group, array(
                'name' => '<span class="dashicons dashicons-admin-links"></span> Photo link URL',
                'desc' => 'If a URL is added here, the member\'s photo will be clickable.',
                'id' => $prefix . 'photo_url',
                'type' => 'text',
                'row_classes' => 'de_first de_hundred de_text de_input de_nomtop',
                'attributes'  => array(
                    'placeholder' => 'http://anything.com',
                ),
            )); 
    
    
    // Settings group
    $side_group = new_cmb2_box( array(
        'id' => $prefix . 'settings_head',
        'title' => '<span class="dashicons dashicons-admin-tools"></span> Team Settings',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'high',
        'closed' => true,
    ));
        
        $side_group->add_field( array(
            'name' => 'General settings',
            'id'   => $prefix . 'other_settings_desc',
            'type' => 'title',
            'row_classes' => 'de_hundred_side de_heading_side',
        ));
    
        $side_group->add_field( array(
            'name' => '<span class="dashicons dashicons-admin-appearance"></span> Main Color</span>',
            'id' => $prefix . 'color',
            'type' => 'colorpicker',
            'row_classes' => 'de_first de_hundred de_color de_input',
        ));
    
        $side_group->add_field( array(
            'name'    => '<span class="dashicons dashicons-arrow-down"></span> Members to show per line',
			'id'      => $prefix . 'columns',
			'type'    => 'select',
			'options' => array(
			    '2'   => 'Two members per line',
			    '3'   => 'Three members per line',
			    '4'   => 'Four members per line',
			),
			'default' => '3',
            'row_classes' => 'de_hundred_side de_text_side',
        ));
    
        $side_group->add_field( array(
            'name'    => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Pictures\' shape</span>',
			'id'      => $prefix . 'picture_shape',
			'type'    => 'select',
			'options' => array(
				'-'   => 'Rounded or Squared',
			),
			'default' => '-',
            'row_classes' => 'de_hundred_side de_text_side',
        ));
    
        $side_group->add_field( array(
            'name'    => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Pictures\' borders</span>',
			'id'      => $prefix . 'picture_border',
			'type'    => 'select',
			'options' => array(
				'-'   => 'Yes or No',
			),
			'default' => '-',
            'row_classes' => 'de_hundred_side de_text_side',
        ));
    
        $side_group->add_field( array(
            'name'    => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Pictures\' position</span>',
			'id'      => $prefix . 'picture_position',
			'type'    => 'select',
			'options' => array(
				'-'   => 'Floating or Inside the box',
			),
			'default' => '-',
            'row_classes' => 'de_hundred_side de_text_side',
        ));
    
        $side_group->add_field( array(
            'name'    => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Pictures\' filter</span>',
			'id'      => $prefix . 'picture_filter',
			'type'    => 'select',
			'options' => array(
				'-'   => 'Choose among 4 filters',
			),
			'default' => '-',
            'row_classes' => 'de_hundred_side de_text_side',
        ));
    
        $side_group->add_field( array(
            'name' => '<span style="color:#8a7463;"><span class="dashicons dashicons-lock"></span> PRO Top border\'s size</span>',
            'desc' => 'In pixels, without the "px".',
		    'id'   => $prefix . 'tp_border_size',
		    'type' => 'text',
            'row_classes' => 'de_hundred_side de_text_side de_input',
        ));
    
    // Help group
    $help_group = new_cmb2_box( array(
        'id' => $prefix . 'help_metabox',
        'title' => '<span class="dashicons dashicons-sos"></span> Help & Support',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'high',
        'closed' => true,
        'row_classes' => 'de_hundred de_heading',
    ));
    
        $help_group->add_field( array(
            'name' => '',
                'desc' => 'Find help at WPdarko.com<br/><br/><a target="_blank" href="http://wpdarko.com/support/forum/plugins/team-members/"><span class="dashicons dashicons-arrow-right-alt2"></span> Support forum</a><br/><a target="_blank" href="http://wpdarko.com/support/documentation/get-started-team-members/"><span class="dashicons dashicons-arrow-right-alt2"></span> Documentation</a>',
                'id'   => $prefix . 'help_desc',
                'type' => 'title',
                'row_classes' => 'de_hundred de_info de_info_side',
        ));
    
    // PRO group
    $pro_group = new_cmb2_box( array(
        'id' => $prefix . 'pro_metabox',
        'title' => '<span class="dashicons dashicons-awards"></span> PRO version',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'high',
        'closed' => true,
        'row_classes' => 'de_hundred de_heading',
    ));
    
        $pro_group->add_field( array(
            'name' => '',
                'desc' => 'This free version is <strong>not</strong> limited and does <strong>not</strong> contain any ad. Check out the PRO version for more great features.<br/><br/><a target="_blank" href="http://wpdarko.com/items/team-members-pro"><span class="dashicons dashicons-arrow-right-alt2"></span> See plugin\'s page</a><br/><br/><span style="font-size:13px; color:#88acbc;">Coupon code <strong>7884661</strong> (10% OFF).</span>',
                'id'   => $prefix . 'pro_desc',
                'type' => 'title',
                'row_classes' => 'de_hundred de_info de_info_side',
        ));
    
    // Shortcode group
    $show_group = new_cmb2_box( array(
        'id' => $prefix . 'shortcode_metabox',
        'title' => '<span class="dashicons dashicons-visibility"></span> Display my Team',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'low',
        'closed' => false,
        'row_classes' => 'de_hundred de_heading',
    ));
    
        $show_group->add_field( array(
            'name' => '',
            'desc' => 'To display your Team on your site, copy-paste the Team\'s [Shortcode] in your post/page. <br/><br/>You can find this shortcode by clicking on the "Teams" tab in the menu on the left.',
            'id'   => $prefix . 'short_desc',
            'type' => 'title',
            'row_classes' => 'de_hundred de_info de_info_side',
        ));

}

add_action( 'cmb2_init', 'tmm_register_group_metabox' );

//Shortcode columns
add_action( 'manage_tmm_posts_custom_column' , 'dktmm_custom_columns', 10, 2 );

function dktmm_custom_columns( $column, $post_id ) {
    switch ( $column ) {
	case 'shortcode' :
		global $post;
		$slug = '' ;
		$slug = $post->post_name;
   
    
    	    $shortcode = '<span style="border: solid 3px lightgray; background:white; padding:7px; font-size:17px; line-height:40px;">[tmm name="'.$slug.'"]</strong>';
	    echo $shortcode; 
	    break;
    }
}

function add_tmm_columns($columns) {
    return array_merge($columns, 
              array('shortcode' => __('Shortcode'),
                    ));
}
add_filter('manage_tmm_posts_columns' , 'add_tmm_columns');

//Tmm shortcode
function tmm_sc($atts) {
	extract(shortcode_atts(array(
		"name" => ''
	), $atts));
	
    global $post;
    $args = array('post_type' => 'tmm', 'name' => $name);
    $custom_posts = get_posts($args);
    foreach($custom_posts as $post) : setup_postdata($post);
    
	$members = get_post_meta( get_the_id(), '_tmm_head', true );
    $options = get_post_meta( get_the_id(), '_tmm_settings_head', true );
    
    $tmm_columns = get_post_meta( $post->ID, '_tmm_columns', true );
    $tmm_color = get_post_meta( $post->ID, '_tmm_color', true );

    $output .= '<div class="tmm tmm_'.$name.'">';
    $output .= '<div class="tmm_'.$tmm_columns.'_columns">';
    $output .= '
        <div class="tmm_wrap">
                ';
                
                $i = 0;
    
                foreach ($members as $key => $member) {
            
                    if($i%$tmm_columns == 0) {
                        if($i > 0) { 
                            $output .= "</div>";
                            $output .= '<div class="clearer"></div>';
                        } // close div if it's not the first
                        
                        
                        $output .= "<div class='tmm_container'>";
                    }
                    
                    $output .= '<div class="tmm_member" style="border-top:'.$tmm_color.' solid 5px;">';
                        if (!empty($member['_tmm_photo_url'])){
                            $output .= '<a href="'.$member['_tmm_photo_url'].'" title="'.$member['_tmm_firstname'].' '.$member['_tmm_lastname'].'">';
                        }
                            if (!empty($member['_tmm_photo'])){
                                $output .= '<div class="tmm_photo tmm_phover_'.$name.'_'.$key.'" style="background: url('.$member['_tmm_photo'].'); margin-left: auto; margin-right:auto; background-size:cover !important;"></div>';
                            }
                        if (!empty($member['_tmm_photo_url'])){
                            $output .= '</a>';
                        }
                        $output .= '<div class="tmm_textblock">';
                            $output .= '<div class="tmm_names">';
                                $output .= '<span class="tmm_fname">'.$member['_tmm_firstname'].'</span>';
                                $output .= '&nbsp;';
                                $output .= '<span class="tmm_lname">'.$member['_tmm_lastname'].'</span>';
                            $output .= '</div>';
                            $output .= '<div class="tmm_job">'.$member['_tmm_job'].'</div>';
                            $output .= '<div class="tmm_desc">'.$member['_tmm_desc'].'</div>';
                            $output .= '<div class="tmm_scblock">';
                            if ($member['_tmm_sc_type1'] != 'nada') {
                                if ($member['_tmm_sc_type1'] == 'email') {
                                    $output .= '<a target="_blank" class="tmm_sociallink" href="mailto:'.$member['_tmm_sc_url1'].'" title="'.$member['_tmm_sc_title1'].'">';
                                    $output .= '<img alt="'.$member['_tmm_sc_title1'].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type1'].'.png"/>';
                                    $output .= '</a>';
                                } else {
                                    $output .= '<a target="_blank" class="tmm_sociallink" href="'.$member['_tmm_sc_url1'].'" title="'.$member['_tmm_sc_title1'].'">';
                                    $output .= '<img alt="'.$member['_tmm_sc_title1'].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type1'].'.png"/>';
                                    $output .= '</a>';
                                }
                            }
                    
                            if ($member['_tmm_sc_type2'] != 'nada') {
                                if ($member['_tmm_sc_type2'] == 'email') {
                                    $output .= '<a target="_blank" class="tmm_sociallink" href="mailto:'.$member['_tmm_sc_url2'].'" title="'.$member['_tmm_sc_title2'].'">';
                                    $output .= '<img alt="'.$member['_tmm_sc_title2'].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type2'].'.png"/>';
                                    $output .= '</a>';
                                } else {
                                    $output .= '<a target="_blank" class="tmm_sociallink" href="'.$member['_tmm_sc_url2'].'" title="'.$member['_tmm_sc_title2'].'">';
                                    $output .= '<img alt="'.$member['_tmm_sc_title2'].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type2'].'.png"/>';
                                    $output .= '</a>';
                                }
                            }
                            
                            if ($member['_tmm_sc_type3'] != 'nada') {
                                if ($member['_tmm_sc_type3'] == 'email') {
                                    $output .= '<a target="_blank" class="tmm_sociallink" href="mailto:'.$member['_tmm_sc_url3'].'" title="'.$member['_tmm_sc_title3'].'">';
                                    $output .= '<img alt="'.$member['_tmm_sc_title3'].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type3'].'.png"/>';
                                    $output .= '</a>';
                                } else {
                                    $output .= '<a target="_blank" class="tmm_sociallink" href="'.$member['_tmm_sc_url3'].'" title="'.$member['_tmm_sc_title3'].'">';
                                    $output .= '<img alt="'.$member['_tmm_sc_title3'].'" src="'.plugins_url('img/links/', __FILE__).$member['_tmm_sc_type3'].'.png"/>';
                                    $output .= '</a>';
                                }
                            }
                            $output .= '</div>';
                        $output .= '</div>';
                    $output .= '</div>';
                    
                    $pages_count = count( $members );
                    if ($key == $pages_count - 1) {
                        $output .= '<div class="clearer"></div>';
                    }
                    
                    $i++;
                    
                    
                }
    
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
    $output .= '</div>';
   

endforeach; wp_reset_query(); 
	
  return $output;

}
add_shortcode("tmm", "tmm_sc"); 

?>