<?php 

/* Defines force font select options. */
function dmb_tmm_force_fonts_options() {
	$options = array ( 
		__('Theme\'s font', TMM_TXTDM ) => 'no',
		__('Default font', TMM_TXTDM ) => 'yes'
	);
	return $options;
}


/* Defines picture link behavior options. */
function dmb_tmm_piclink_beh_options(){
	$options = array ( 
		__('New window', TMM_TXTDM ) => 'new', 
		__('Same window', TMM_TXTDM ) => 'same' 
	);
	return $options;
}


/* Defines bio alignment options. */
function dmb_tmm_bio_align_options() {
	$options = array ( 
		__('Center', TMM_TXTDM) => 'center',
		__('Left', TMM_TXTDM) => 'left',
		__('Right', TMM_TXTDM) => 'right',
		__('Justify', TMM_TXTDM) => 'justify'    
	);
	return $options;
}


/* Defines team columns options. */
function dmb_tmm_columns_options() {
	$options = array ( 
		__('1 per line', TMM_TXTDM) => '1',
		__('2 per line', TMM_TXTDM) => '2',
		__('3 per line', TMM_TXTDM) => '3',
		__('4 per line', TMM_TXTDM) => '4',
		__('5 per line', TMM_TXTDM) => '5'    
	);
	return $options;
}


/* Hooks the metabox. */
add_action('admin_init', 'dmb_tmm_add_settings', 1);
function dmb_tmm_add_settings() {
	add_meta_box( 
		'tmm_settings', 
		'<span class="dashicons dashicons-admin-generic"></span> '.__('Settings', TMM_TXTDM), 
		'dmb_tmm_settings_display', 
		'tmm', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_tmm_settings_display() { 
	
	global $post;

	/* Retrieves select options. */
	$team_columns = dmb_tmm_columns_options();
	$team_bio_align = dmb_tmm_bio_align_options();
	$team_piclink_beh = dmb_tmm_piclink_beh_options();
	$team_force_font = dmb_tmm_force_fonts_options();

	/* Processes retrieved fields. */
	$settings = array();

	$settings['_tmm_columns'] = get_post_meta( $post->ID, '_tmm_columns', true );
	if (!$settings['_tmm_columns']) { $settings['_tmm_columns'] = '3'; }
	$settings['_tmm_color'] = get_post_meta( $post->ID, '_tmm_color', true );
	if (!$settings['_tmm_color']) { $settings['_tmm_color'] = '#333333'; }
	$settings['_tmm_bio_alignment'] = get_post_meta( $post->ID, '_tmm_bio_alignment', true );

	/* Checks if member links open in new window. */
	$settings['_tmm_piclink_beh'] = get_post_meta( $post->ID, '_tmm_piclink_beh', true );
	($settings['_tmm_piclink_beh'] == 'new' ? $tmm_plb = 'target="_blank"' : $tmm_plb = '');

	/* Checks if forcing original fonts. */
	$settings['_tmm_original_font'] = get_post_meta( $post->ID, '_tmm_original_font', true );
	(($settings['_tmm_original_font'] == 'no' || $settings['_tmm_original_font'] != true) ? $settings['_tmm_original_font'] = 'no' : $settings['_tmm_original_font'] = 'yes');

	?>

	<div class="dmb_settings_box">

		<div class="dmb_section_title">
			<?php /* translators: General settings */ _e('General', TMM_TXTDM) ?>
		</div>

		<!-- Team layout -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Members per line', TMM_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_columns">
				<?php foreach ( $team_columns as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_columns'])) ? $settings['_tmm_columns'] : '2', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Bio alignment -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Desc. alignment', TMM_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_bio_align">
				<?php foreach ( $team_bio_align as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_bio_alignment'])) ? $settings['_tmm_bio_alignment'] : 'center', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Photo link behavior -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Photo link behavior', TMM_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_piclink_beh">
				<?php foreach ( $team_piclink_beh as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_piclink_beh'])) ? $settings['_tmm_piclink_beh'] : 'new', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Font option -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Font to use', TMM_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="team_force_font">
				<?php foreach ( $team_force_font as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"<?php selected( (isset($settings['_tmm_original_font'])) ? $settings['_tmm_original_font'] : 'no', $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Main color -->
		<div class="dmb_color_of_team dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Main color', TMM_TXTDM) ?>
			</div>
			<input class="dmb_color_picker dmb_field dmb_color_of_team" name="team_color" type="text" value="<?php echo (isset($settings['_tmm_color'])) ? $settings['_tmm_color'] : '#444444'; ?>" />
		</div>

		<div class="dmb_clearfix"></div>

	</div>

<?php } ?>