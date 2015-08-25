<?php
/**
 * Register metaboxes for Teams.
 */
function tmm_register_group_metabox() {

    /* Custom sanitization call-back to allow HTML in most fields */
    function tmm_html_allowed_sani_cb($content) {
        return is_array( $content ) ? array_map( 'wp_kses_post', $content ) : wp_kses_post( $content );
    }

    $prefix = '_tmm_';
    $main_group = new_cmb2_box( array(
        'id' => $prefix . 'team_metabox',
        'title' => '<span style="font-weight:400;">'.__( 'Manage Members', 'team-members' ).'</span> <a target="_blank" class="wpd_free_pro" title="'.__( 'Unlock more features with Team Members PRO!', 'team-members' ).'" href="http://wpdarko.com/items/team-members-pro"><span style="color:#8a7463;font-size:15px; font-weight:400; float:right; padding-right:14px;"><span class="dashicons dashicons-lock"></span> '.__( 'Free version', 'team-members' ).'</span></a>',
        'object_types' => array( 'tmm' ),
        'priority' => 'high',
    ));

        $tmm_group = $main_group->add_field( array(
            'id' => $prefix . 'head',
            'type' => 'group',
            'options' => array(
                'group_title' => __( 'Member {#}', 'team-members' ),
                'add_button' => __( 'Add another member', 'team-members' ),
                'remove_button' => __( 'Remove member', 'team-members' ),
                'sortable' => true,
                'single' => false,
            ),
        ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Member details', 'team-members' ),
                'id' => $prefix . 'member_header',
                'type' => 'title',
                'row_classes' => 'de_hundred de_heading',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Firstname', 'team-members' ),
                'id' => $prefix . 'firstname',
                'type' => 'text',
                'row_classes' => 'de_first de_twentyfive de_text de_input',
                'sanitization_cb' => 'tmm_html_allowed_sani_cb',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Lastname', 'team-members' ),
                'id' => $prefix . 'lastname',
                'type' => 'text',
                'row_classes' => 'de_twentyfive de_text de_input',
                'sanitization_cb' => 'tmm_html_allowed_sani_cb',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Job/role', 'team-members' ),
                'id' => $prefix . 'job',
                'type' => 'text',
                'row_classes' => 'de_fifty de_text de_input',
                'sanitization_cb' => 'tmm_html_allowed_sani_cb',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Description/bio', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'Basic HTML allowed', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
				'id' => $prefix . 'desc',
				'type' => 'textarea',
                'attributes'  => array('rows' => 6),
                'row_classes' => 'de_first de_hundred de_textarea de_input',
                'sanitization_cb' => 'tmm_html_allowed_sani_cb',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Member links', 'team-members' ),
                'id' => $prefix . 'member_links_header',
                'type' => 'title',
                'row_classes' => 'de_hundred de_heading',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name'    => __( 'Type of link', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'Choose which icon is going to show in the member box', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
			    'id'      => $prefix . 'sc_type1',
			    'type'    => 'select',
                'default' => 'nada',
			    'options' => array(
			 	'nada' => '-',
                    'twitter' => 'Twitter',
                    'linkedin' => 'LinkedIn',
                    'googleplus' => 'Google+',
                    'facebook' => 'Facebook',
                    'vk' => 'VK',
                    'instagram' => 'Instagram',
                    'tumblr' => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'email' => __( 'Email', 'team-members' ),
                    'website' => __( 'Website', 'team-members' ),
                    'customlink' => __( 'Other links', 'team-members' ),
			 ),
                'row_classes' => 'de_first de_twentyfive de_select de_text de_input',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Title attribute', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'eg. Follow us on Twitter!', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
                'id' => $prefix . 'sc_title1',
                'type' => 'text',
                'row_classes' => 'de_twentyfive de_text de_input',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => 'URL  <a class="wpd_tooltip" title="'.__( 'Start with http://', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
                'id' => $prefix . 'sc_url1',
                'type' => 'text',
                'attributes' => array('placeholder' => 'http://'),
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
                    'vk' => 'VK',
                    'instagram' => 'Instagram',
                    'tumblr' => 'Tumblr',
                    'email' => __( 'Email', 'team-members' ),
                    'website' => __( 'Website', 'team-members' ),
                    'customlink' => __( 'Other links', 'team-members' ),
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
                'attributes' => array('placeholder' => 'http://'),
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
                    'vk' => 'VK',
                    'instagram' => 'Instagram',
                    'tumblr' => 'Tumblr',
                    'pinterest' => 'Pinterest',
                    'email' => __( 'Email', 'team-members' ),
                    'website' => __( 'Website', 'team-members' ),
                    'customlink' => __( 'Other links', 'team-members' ),
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
                'attributes' => array('placeholder' => 'http://'),
                'row_classes' => 'de_fifty de_text de_input de_nomtop',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Member photo', 'team-members' ),
                'id' => $prefix . 'member_styling_header',
                'type' => 'title',
                'row_classes' => 'de_hundred de_heading',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Upload photo', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'Recommended:', 'team-members' ).' 250x250px"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
                'id'   => $prefix . 'photo',
                'type' => 'file',
                'options' => array('add_upload_file_text' => __( 'Upload', 'team-members' )),
                'row_classes' => 'de_first de_hundred de_upload de_input',
            ));

            $main_group->add_group_field( $tmm_group, array(
                'name' => __( 'Photo link URL', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'If a URL is added here, the member\'s photo will be clickable — Start with http://', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
                'id' => $prefix . 'photo_url',
                'type' => 'text',
                'attributes' => array('placeholder' => 'http://'),
                'row_classes' => 'de_first de_hundred de_text de_input de_nomtop',
            ));


    // Settings
    $side_group = new_cmb2_box( array(
        'id' => $prefix . 'settings_head',
        'title' => '<span style="font-weight:400;">'.__( 'Settings', 'team-members' ).'</span>',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'high',
    ));

        $side_group->add_field( array(
            'name' => __( 'General settings', 'team-members' ),
            'id'   => $prefix . 'gene_settings_desc',
            'type' => 'title',
            'row_classes' => 'de_hundred de_heading_side',
        ));

        $side_group->add_field( array(
            'name' => __( 'Main color', 'team-members' ),
            'id' => $prefix . 'color',
            'type' => 'colorpicker',
            'row_classes' => 'de_first de_hundred de_color de_input',
        ));

        $side_group->add_field( array(
            'name'    => __( 'Members to show per line', 'team-members' ),
			'id'      => $prefix . 'columns',
			'type'    => 'select',
			'options' => array(
			    '2'   => __( '2 members per line', 'team-members' ),
			    '3'   => __( '3 members per line', 'team-members' ),
			    '4'   => __( '4 members per line', 'team-members' ),
			),
			'default' => '3',
            'row_classes' => 'de_hundred de_text_side',
        ));

        $side_group->add_field( array(
            'name' => __( 'Others', 'team-members' ),
            'id'   => $prefix . 'other_settings_desc',
            'type' => 'title',
            'row_classes' => 'de_hundred de_heading_side',
        ));

        $side_group->add_field( array(
            'name'    => __( 'Description/bio alignment', 'team-members' ),
			'id'      => $prefix . 'bio_alignment',
			'type'    => 'select',
			'options' => array(
			    'center'   => __( 'Centre', 'team-members' ),
			    'left'   => __( 'Left', 'team-members' ),
			    'right'   => __( 'Right', 'team-members' ),
                'justify'   => __( 'Justify', 'team-members' ),
			),
			'default' => 'center',
            'row_classes' => 'de_hundred de_text_side',
        ));

        $side_group->add_field( array(
            'name' => __( 'Picture link behavior', 'team-members' ),
		    'id'   => $prefix . 'piclink_beh',
		    'type'    => 'select',
			'options' => array(
			    'same'   => __( 'Open in same window', 'team-members' ),
			    'new'   => __( 'Open in new window', 'team-members' ),
			),
            'default' => 'same',
            'row_classes' => 'de_hundred de_checkbox_side',
            'default' => false,
        ));

        $side_group->add_field( array(
            'name' => __( 'Force original fonts', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'Check this to use the plugin\'s font instead of your theme\'s', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
            'desc' => __( 'Check to enable', 'team-members' ),
		    'id'   => $prefix . 'original_font',
		    'type' => 'checkbox',
            'row_classes' => 'de_hundred de_checkbox_side',
            'default' => false,
        ));

        $side_group->add_field( array(
            'name' => __( 'Last row centered', 'team-members' ).' <a class="wpd_tooltip" title="'.__( 'Check this if your last row of members isn\'t full to center your last member(s)', 'team-members' ).'"><span class="wpd_help_icon dashicons dashicons-editor-help"></span></a>',
            'desc' => __( 'Check to enable', 'team-members' ),
		    'id'   => $prefix . 'last_row_centered',
		    'type' => 'checkbox',
            'row_classes' => 'de_hundred de_checkbox_side',
            'default' => false,
        ));

    // PRO version
    $pro_group = new_cmb2_box( array(
        'id' => $prefix . 'pro_metabox',
        'title' => '<span style="font-weight:400;">Upgrade to <strong>PRO version</strong></span>',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'low',
        'row_classes' => 'de_hundred de_heading',
    ));

        $pro_group->add_field( array(
            'name' => '',
                'desc' => '<div><span class="dashicons dashicons-yes"></span> 1 to 5 members per line<br/><span class="dashicons dashicons-yes"></span> Add a hover photo<br/><span class="dashicons dashicons-yes"></span> Complementary info box</strong><br/><span class="dashicons dashicons-yes"></span> Per member color</strong><br/><span class="dashicons dashicons-yes"></span> 5 social links<br/><span class="dashicons dashicons-arrow-right"></span> And more...<br/><br/><a style="display:inline-block; background:#33b690; padding:8px 25px 8px; border-bottom:3px solid #33a583; border-radius:3px; color:white;" class="wpd_pro_btn" target="_blank" href="http://wpdarko.com/items/team-members-pro">See all PRO features</a><br/><span style="display:block;margin-top:14px; font-size:13px; color:#0073AA; line-height:20px;"><span class="dashicons dashicons-tickets"></span> Code <strong>7884661</strong> (10% OFF)</span></div>',
                'id'   => $prefix . 'pro_desc',
                'type' => 'title',
                'row_classes' => 'de_hundred de_info de_info_side',
        ));

    // Help
    $help_group = new_cmb2_box( array(
        'id' => $prefix . 'help_metabox',
        'title' => '<span style="font-weight:400;">'.__( 'Help & Support', 'team-members' ).'</span>',
        'object_types' => array( 'tmm' ),
        'context' => 'side',
        'priority' => 'low',
        'row_classes' => 'de_hundred de_heading',
    ));

        $help_group->add_field( array(
            'name' => '',
                'desc' => '<span style="font-size:15px;">'.__( 'Display your Team', 'team-members' ).'</span><br/><br/>'.__( 'To display your Team on your site, copy-paste the Team\'s <strong>[Shortcode]</strong> in your post/page. You can find this shortcode by clicking <strong>All Teams</strong> in the menu on the left.', 'team-members' ).'<br/><br/><span style="font-size:15px;">'.__( 'Get support', 'team-members' ).'</span><br/><br/><a style="font-size:13px !important;" target="_blank" href="http://wpdarko.com/support/">— '.__( 'Submit a ticket', 'team-members' ).'</a><br/><a style="font-size:13px !important;" target="_blank" href="https://wpdarko.zendesk.com/hc/en-us/articles/206303627-Get-started-with-the-Team-Members-plugin">— '.__( 'View documentation', 'team-members' ).'</a>',
                'id'   => $prefix . 'help_desc',
                'type' => 'title',
                'row_classes' => 'de_hundred de_info de_info_side',
        ));
}
?>
