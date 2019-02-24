<?php

/* Defines highlight select options. */
function dmb_tmm_social_links_options() {
	$options = array ( 
    __('-', TMM_TXTDM ) => 'nada', 
    __('Twitter', TMM_TXTDM ) => 'twitter',
    __('LinkedIn', TMM_TXTDM ) => 'linkedin',
    __('YouTube', TMM_TXTDM ) => 'youtube',
    __('Google+', TMM_TXTDM ) => 'googleplus',
		__('Facebook', TMM_TXTDM ) => 'facebook',
		__('Pinterest', TMM_TXTDM ) => 'pinterest',
    __('VK', TMM_TXTDM ) => 'vk',
    __('Instagram', TMM_TXTDM ) => 'instagram',
		__('Tumblr', TMM_TXTDM ) => 'tumblr',
		__('Research Gate', TMM_TXTDM ) => 'researchgate',
    __('Email', TMM_TXTDM ) => 'email',
    __('Website', TMM_TXTDM ) => 'website',
    __('Other links', TMM_TXTDM ) => 'customlink'
  );
	return $options;
}


/* Hooks the metabox. */
add_action('admin_init', 'dmb_tmm_add_team', 1);
function dmb_tmm_add_team() {
	add_meta_box( 
		'tmm', 
		'<span class="dashicons dashicons-edit"></span> '.__('Team editor', TMM_TXTDM ), 
		'dmb_tmm_team_display', // Below
		'tmm', 
		'normal', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_tmm_team_display() {

	global $post;
	
	/* Gets team data. */
	$team = get_post_meta( $post->ID, '_tmm_head', true );
	
	$fields_to_process = array(
    '_tmm_firstname',
    '_tmm_lastname',
    '_tmm_job',
    '_tmm_desc',
    '_tmm_sc_type1', '_tmm_sc_title1', '_tmm_sc_url1',
    '_tmm_sc_type2', '_tmm_sc_title2', '_tmm_sc_url2',
    '_tmm_sc_type3', '_tmm_sc_title3', '_tmm_sc_url3',
    '_tmm_photo',
    '_tmm_photo_url'
	);

	/* Retrieves select options. */
	$social_links_options = dmb_tmm_social_links_options();

	wp_nonce_field( 'dmb_tmm_meta_box_nonce', 'dmb_tmm_meta_box_nonce' ); ?>

	<div id="dmb_preview_team">
		<!-- Closes preview button. -->
		<a class="dmb_preview_button dmb_preview_team_close" href="#">
			<?php _e('Close preview', TMM_TXTDM ) ?>
		</a>
	</div>

	<?php if( !class_exists('acf') ) { ?>

	<div id="dmb_unique_editor">
		<?php wp_editor( '', 'dmb_editor', array('editor_height' => '300px' ) );  ?>
		<br/>
		<a class="dmb_big_button_primary dmb_ue_update" href="#">
			<?php _e('Update', TMM_TXTDM ) ?>
		</a>
		<a class="dmb_big_button_secondary dmb_ue_cancel" href="#">
			<?php _e('Cancel', TMM_TXTDM ) ?>
		</a>
	</div>

	<?php } ?>

	<!-- Toolbar for member metabox -->
	<div class="dmb_toolbar">
		<div class="dmb_toolbar_inner">
			<a class="dmb_big_button_secondary dmb_expand_rows" href="#"><span class="dashicons dashicons-editor-expand"></span> <?php _e('Expand all', TMM_TXTDM ) ?>&nbsp;</a>&nbsp;&nbsp;
			<a class="dmb_big_button_secondary dmb_collapse_rows" href="#"><span class="dashicons dashicons-editor-contract"></span> <?php _e('Collapse all', TMM_TXTDM ) ?>&nbsp;</a>&nbsp;&nbsp;
			<a class="dmb_show_preview_team dmb_preview_button"><span class="dashicons dashicons-admin-appearance"></span> <?php _e('Instant preview', TMM_TXTDM ) ?>&nbsp;</a>
			<div class="dmb_clearfix"></div>
		</div>
	</div>

	<?php if ( $team ) {

		/* Loops through rows. */
		foreach ( $team as $team_member ) {

			/* Retrieves each field for current member. */
			$member = array();
			foreach ( $fields_to_process as $field) {
				switch ($field) {
					default:
						$member[$field] = ( isset($team_member[$field]) ) ? esc_attr($team_member[$field]) : '';
						break;
				}
			} ?>

			<!-- START member -->
			<div class="dmb_main">

        <textarea class="dmb_data_dump" name="tmm_data_dumps[]"></textarea>  

				<!-- Member handle bar -->
				<div class="dmb_handle">
					<a class="dmb_big_button_secondary dmb_move_row_up" href="#" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
					<a class="dmb_big_button_secondary dmb_move_row_down" href="#" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
					<div class="dmb_handle_title"></div>
					<a class="dmb_big_button_secondary dmb_remove_row_btn" href="#" title="Remove"><span class="dashicons dashicons-no-alt"></span></a>
					<a class="dmb_big_button_secondary dmb_clone_row" href="#" title="Clone"><span class="dashicons dashicons-admin-page"></span><?php _e('Clone', TMM_TXTDM ); ?></a>
					<div class="dmb_clearfix"></div>
				</div>

				<!-- START inner -->
				<div class="dmb_inner">

					<div class="dmb_section_title">
						<?php _e('Member details', TMM_TXTDM ) ?>
					</div>

					<div class="dmb_grid dmb_grid_33 dmb_grid_first">
						<div class="dmb_field_title">
							<?php _e('First name', TMM_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_highlight_field dmb_firstname_of_member" type="text" value="<?php echo $member['_tmm_firstname']; ?>" placeholder="<?php _e('e.g. John', TMM_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_33 ">
						<div class="dmb_field_title">
							<?php _e('Lastname', TMM_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_lastname_of_member" type="text" value="<?php echo $member['_tmm_lastname']; ?>" placeholder="<?php _e('e.g. Doe', TMM_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_33 dmb_grid_last">
						<div class="dmb_field_title">
							<?php _e('Job/role', TMM_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_job_of_member" type="text" value="<?php echo $member['_tmm_job']; ?>" placeholder="<?php _e('e.g. Project manager', TMM_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
					
						<?php if( !class_exists('acf') ) { ?>

								<div class="dmb_field_title">
									<?php _e('Description/biography', TMM_TXTDM ) ?>
									<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Edit your member\'s biography by clicking the button below. Once updated, it will show up here.', TMM_TXTDM ) ?>">[?]</a>
								</div>

								<div class="dmb_field dmb_description_of_member">
									<?php echo $member["_tmm_desc"]; ?>
								</div>

						<?php } else { ?>

							<div class="dmb_field_title">
								<?php _e('Description/biography', TMM_TXTDM ) ?>
							</div>

							<div class="dmb_field dmb_description_of_member_fb" style="display:none !important;"><?php echo $member["_tmm_desc"]; ?></div>
							<textarea id="acf-fallback-bio"><?php echo $member["_tmm_desc"]; ?></textarea>

						<?php } ?>

						<div class="dmb_clearfix"></div>

						<?php if( !class_exists('acf') ) { ?>
							<div class="dmb_edit_description_of_member dmb_small_button_primary">
								<span class="dashicons dashicons-edit"></span> <?php _e('Edit biography', TMM_TXTDM ) ?>&nbsp;
							</div>
						<?php } ?>

					</div>

					<div class="dmb_clearfix"></div>

					<div class="dmb_section_title">
						<?php _e('Social links', TMM_TXTDM ) ?>
						<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('These links will appear below your members\' biography.', TMM_TXTDM ) ?>">[?]</a>
					</div>

          <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <div class="dmb_field_title">
              <?php _e('Link type', TMM_TXTDM ) ?>
            </div>
            <select class="dmb_scl_type_select dmb_scl_type1_of_member">
              <?php foreach ( $social_links_options as $label => $value ) { ?>
              <option value="<?php echo $value; ?>"<?php selected( $member['_tmm_sc_type1'], $value ); ?>><?php echo $label; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="dmb_grid dmb_grid_33 ">
						<div class="dmb_field_title">
							<?php _e('Title attribute', TMM_TXTDM ) ?>
							<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Optional. This is the HTML <a> tag\'s title attribute.', TMM_TXTDM ) ?>">[?]</a>
						</div>
						<input class="dmb_field dmb_scl_title1_of_member" type="text" value="<?php echo $member['_tmm_sc_title1']; ?>" placeholder="<?php _e('e.g. Faceook page', TMM_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_33 dmb_grid_last">
						<div class="dmb_field_title">
							<?php _e('Link URL', TMM_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_scl_url1_of_member" type="text" value="<?php echo $member['_tmm_sc_url1']; ?>" placeholder="<?php _e('e.g. http://fb.com/member-profile', TMM_TXTDM ) ?>" />
          </div>

          <div class="dmb_clearfix"></div>
          
          <div class="dmb_grid dmb_grid_33 dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type2_of_member">
              <?php foreach ( $social_links_options as $label => $value ) { ?>
              <option value="<?php echo $value; ?>"<?php selected( $member['_tmm_sc_type2'], $value ); ?>><?php echo $label; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="dmb_grid dmb_grid_33 ">
						<input class="dmb_field dmb_scl_title2_of_member" type="text" value="<?php echo $member['_tmm_sc_title2']; ?>" placeholder="<?php _e('e.g. Twitter page', TMM_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_33 dmb_grid_last">
						<input class="dmb_field dmb_scl_url2_of_member" type="text" value="<?php echo $member['_tmm_sc_url2']; ?>" placeholder="<?php _e('e.g. http://tw.com/member-profile', TMM_TXTDM ) ?>" />
          </div>

          <div class="dmb_clearfix"></div>

          <div class="dmb_grid dmb_grid_33 dmb_grid_first dmb_grid_first">
            <select class="dmb_scl_type_select dmb_scl_type3_of_member">
              <?php foreach ( $social_links_options as $label => $value ) { ?>
              <option value="<?php echo $value; ?>"<?php selected( $member['_tmm_sc_type3'], $value ); ?>><?php echo $label; ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="dmb_grid dmb_grid_33 ">
						<input class="dmb_field dmb_scl_title3_of_member" type="text" value="<?php echo $member['_tmm_sc_title3']; ?>" placeholder="<?php _e('e.g. Google+ page', TMM_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_33 dmb_grid_last">
						<input class="dmb_field dmb_scl_url3_of_member" type="text" value="<?php echo $member['_tmm_sc_url3']; ?>" placeholder="<?php _e('e.g. http://gp.com/member-profile', TMM_TXTDM ) ?>" />
          </div>

					<div class="dmb_clearfix"></div>

					<div class="dmb_tip">
						<span class="dashicons dashicons-yes"></span> Links with the email type open your visitors' mail client. <a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Your member\'s email address must be entered in the Link URL field. Title attribute can be left blank.', TMM_TXTDM ) ?>">[?]</a>
					</div>

					<div class="dmb_clearfix"></div>
					
					<div class="dmb_section_title">
						<?php _e('Photo', TMM_TXTDM ) ?>
					</div>
		
					<div class="dmb_grid dmb_grid_33 dmb_grid_first">
		
						<div class="dmb_field_title">
							<?php _e('Member\'s photo', TMM_TXTDM ) ?>
							<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('We recommend square images (e.g. 250x250px).', TMM_TXTDM ) ?>">[?]</a>
						</div>
		
						<div>
							<div class="dmb_field_title dmb_img_data_url dmb_photo_of_member" data-img="<?php echo $member['_tmm_photo']; ?>"></div>
							<div class="dmb_upload_img_btn dmb_small_button_primary">
								<span class="dashicons dashicons-upload"></span> 
								<?php _e('Upload photo', TMM_TXTDM ) ?>&nbsp;
							</div>
						</div>
		
					</div>

					<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
						<div class="dmb_field_title">
							<?php _e('Photo link', TMM_TXTDM ) ?>
							<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Your visitors will be redirected to this link if they click the member\'s photo.', TMM_TXTDM ) ?>">[?]</a>
						</div>
						<input class="dmb_field dmb_photo_url_of_member" type="text" value="<?php echo $member['_tmm_photo_url']; ?>" placeholder="<?php _e('e.g. http://your-site.com/full-member-page/', TMM_TXTDM ) ?>" />
          </div>

					<div class="dmb_clearfix"></div>	

				<!-- END inner -->
				</div>
			
			<!-- END row -->
			</div>

			<?php
		}
	} ?>

	<!-- START empty member -->
	<div class="dmb_main dmb_empty_row" style="display:none;">

		<textarea class="dmb_data_dump" name="tmm_data_dumps[]"></textarea>  

		<!-- Member handle bar -->
		<div class="dmb_handle">
			<a class="dmb_big_button_secondary dmb_move_row_up" href="#" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
			<a class="dmb_big_button_secondary dmb_move_row_down" href="#" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
			<div class="dmb_handle_title"></div>
			<a class="dmb_big_button_secondary dmb_remove_row_btn" href="#" title="Remove"><span class="dashicons dashicons-no-alt"></span></a>
			<a class="dmb_big_button_secondary dmb_clone_row" href="#" title="Clone"><span class="dashicons dashicons-admin-page"></span><?php _e('Clone', TMM_TXTDM ); ?></a>
			<div class="dmb_clearfix"></div>
		</div>

		<!-- START inner -->
		<div class="dmb_inner">

			<div class="dmb_section_title">
				<?php _e('Member details', TMM_TXTDM ) ?>
			</div>
      
      <div class="dmb_grid dmb_grid_33 dmb_grid_first">
        <div class="dmb_field_title">
          <?php _e('First name', TMM_TXTDM ) ?>
        </div>
        <input class="dmb_field dmb_highlight_field dmb_firstname_of_member" type="text" value="" placeholder="<?php _e('e.g. John', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_grid dmb_grid_33 ">
        <div class="dmb_field_title">
          <?php _e('Lastname', TMM_TXTDM ) ?>
        </div>
        <input class="dmb_field dmb_lastname_of_member" type="text" value="" placeholder="<?php _e('e.g. Doe', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_grid dmb_grid_33 dmb_grid_last">
        <div class="dmb_field_title">
          <?php _e('Job/role', TMM_TXTDM ) ?>
        </div>
        <input class="dmb_field dmb_job_of_member" type="text" value="" placeholder="<?php _e('e.g. Project manager', TMM_TXTDM ) ?>" />
      </div>

			<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">

			
			<?php if( !class_exists('acf') ) { ?>

				<div class="dmb_field_title">
					<?php _e('Description/biography', TMM_TXTDM ) ?>
					<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Edit your member\'s biography by clicking the button below. Once updated, it will show up here.', TMM_TXTDM ) ?>">[?]</a>
				</div>

				<div class="dmb_field dmb_description_of_member"></div>

			<?php } else { ?>

					<div class="dmb_field_title">
						<?php _e('Description/biography', TMM_TXTDM ) ?>
					</div>

					<div class="dmb_field dmb_description_of_member_fb" style="display:none !important;"></div>
					<textarea id="acf-fallback-bio"></textarea>

			<?php } ?>

			<div class="dmb_clearfix"></div>

			<?php if( !class_exists('acf') ) { ?>
				<div class="dmb_edit_description_of_member dmb_small_button_primary">
					<span class="dashicons dashicons-edit"></span> <?php _e('Edit biography', TMM_TXTDM ) ?>&nbsp;
				</div>
			<?php } ?>

			</div>

			<div class="dmb_clearfix"></div>

			<div class="dmb_section_title">
				<?php _e('Social links', TMM_TXTDM ) ?>
				<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('These links will appear below your members\' biography.', TMM_TXTDM ) ?>">[?]</a>
			</div>

			<div class="dmb_clearfix"></div>

			<div class="dmb_grid dmb_grid_33 dmb_grid_first">
				<div class="dmb_field_title">
					<?php _e('Link type', TMM_TXTDM ) ?>
				</div>
			
        <select class="dmb_scl_type_select dmb_scl_type1_of_member">
					<?php foreach ( $social_links_options as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php } ?>
				</select>
      </div>

      <div class="dmb_grid dmb_grid_33">
				<div class="dmb_field_title">
					<?php _e('Title attribute', TMM_TXTDM ) ?>
					<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Optional. This is the HTML <a> tag\'s title attribute.', TMM_TXTDM ) ?>">[?]</a>
				</div>
        <input class="dmb_field dmb_scl_title1_of_member" type="text" value="" placeholder="<?php _e('e.g. Facebook page', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_grid dmb_grid_33 dmb_grid_last">
        <div class="dmb_field_title">
          <?php _e('Link URL', TMM_TXTDM ) ?>
        </div>
        <input class="dmb_field dmb_scl_url1_of_member" type="text" value="" placeholder="<?php _e('e.g. http://fb.com/member-profile', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_clearfix"></div>

      <div class="dmb_grid dmb_grid_33 dmb_grid_first">
        <select class="dmb_scl_type_select dmb_scl_type2_of_member">
					<?php foreach ( $social_links_options as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php } ?>
				</select>
      </div>

      <div class="dmb_grid dmb_grid_33">
        <input class="dmb_field dmb_scl_title2_of_member" type="text" value="" placeholder="<?php _e('e.g. Twitter page', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_grid dmb_grid_33 dmb_grid_last">
        <input class="dmb_field dmb_scl_url2_of_member" type="text" value="" placeholder="<?php _e('e.g. http://tw.com/member-profile', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_clearfix"></div>

      <div class="dmb_grid dmb_grid_33 dmb_grid_first">
        <select class="dmb_scl_type_select dmb_scl_type3_of_member">
					<?php foreach ( $social_links_options as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php } ?>
				</select>
      </div>

      <div class="dmb_grid dmb_grid_33">
        <input class="dmb_field dmb_scl_title3_of_member" type="text" value="" placeholder="<?php _e('e.g. Google+ page', TMM_TXTDM ) ?>" />
      </div>

      <div class="dmb_grid dmb_grid_33 dmb_grid_last">
        <input class="dmb_field dmb_scl_url3_of_member" type="text" value="" placeholder="<?php _e('e.g. http://gp.com/member-profile', TMM_TXTDM ) ?>" />
      </div>

			<div class="dmb_clearfix"></div>

			<div class="dmb_tip">
				<span class="dashicons dashicons-yes"></span> Links with the email type open your visitors' mail client. <a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Your member\'s email address must be entered in the Link URL field. Title attribute can be left blank.', TMM_TXTDM ) ?>">[?]</a>
			</div>

			<div class="dmb_clearfix"></div>
			
			<div class="dmb_section_title">
				<?php _e('Photo', TMM_TXTDM ) ?>
			</div>

			<div class="dmb_grid dmb_grid_33 dmb_grid_first">

				<div class="dmb_field_title">
					<?php _e('Member\'s photo', TMM_TXTDM ) ?>
					<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('We recommend square images (e.g. 250x250px).', TMM_TXTDM ) ?>">[?]</a>
				</div>

				<div>
					<div class="dmb_field_title dmb_img_data_url dmb_photo_of_member" data-img=""></div>
					<div class="dmb_upload_img_btn dmb_small_button_primary">
						<span class="dashicons dashicons-upload"></span> 
						<?php _e('Upload photo', TMM_TXTDM ) ?>&nbsp;
					</div>
				</div>

			</div>

			<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
				<div class="dmb_field_title">
					<?php _e('Photo link', TMM_TXTDM ) ?>
					<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Your visitors will be redirected to this link if they click the member\'s photo.', TMM_TXTDM ) ?>">[?]</a>
				</div>
				<input class="dmb_field dmb_photo_url_of_member" type="text" value="" placeholder="<?php _e('e.g. http://your-site.com/full-member-page/', TMM_TXTDM ) ?>" />
			</div>

			<div class="dmb_clearfix"></div>

		<!-- END inner -->
		</div>

	<!-- END empty row -->
	</div>

	<div class="dmb_clearfix"></div>

	<div class="dmb_no_row_notice">
		<?php /* translators: Leave HTML tags */ _e('Create your team by <strong>adding members</strong> to it.<br/>Click the button below to get started.', TMM_TXTDM ) ?>
	</div>

	<!-- Add row button -->
	<a class="dmb_big_button_primary dmb_add_row" href="#">
		<span class="dashicons dashicons-plus"></span> 
		<?php _e('Add a member', TMM_TXTDM ) ?>&nbsp;
	</a>

<?php }