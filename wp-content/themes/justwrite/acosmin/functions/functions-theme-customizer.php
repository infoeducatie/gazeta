<?php
/* ------------------------------------------------------------------------- *
 *  WordPress Customise Options
/* ------------------------------------------------------------------------- */



/*  This will output css
/* ------------------------------------ */
function ac_generate_css( $selector, $style, $mod_name, $prefix='', $postfix='', $echo=true ) {
      $return = '';
      $mod = get_theme_mod($mod_name);
      if ( ! empty( $mod ) ) {
         $return = sprintf('%s{%s:%s;}',
            $selector,
            $style,
            $prefix.$mod.$postfix
         );
         if ( $echo ) {
            echo $return;
         }
      }
      return $return;
}



/*  Converts hex to rgb vaules
/* ------------------------------------ */
function ac_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   
   echo $r . ',' . $g . ','. $b;
}



/*  Check if option is not changed
/* ------------------------------------ */
function ac_checkdefault($mod_name, $default) {
	$mod = get_theme_mod($mod_name);
	if ( $mod != $default || $mod == '')	{
		return true;
	} 
}



/*  Sanitize stuff
/* ------------------------------------ */
// Checkbox
function ac_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return 1;
	} else {
		return 0;
	}
}

// Select Font Family
function ac_sanitize_ff( $fontfamily ) {
	if ( ! in_array( $fontfamily, array( 'style1', 'style2', 'style3', 'style4' ) ) ) {
		$fontfamily = 'style1';
	}
	return $layout;
}



/*  Customisation Function
/* ------------------------------------ */
function ac_customize_init($wp_customize) {
	
	// Variables
	$main_color 	= '#e1e1e1';
	$locations      = get_registered_nav_menus();
	$menus          = wp_get_nav_menus();
	$menu_locations = get_nav_menu_locations();
	$num_locations  = count( array_keys( $locations ) );
	
	// Select Options


	$choices = array( 0 => __( '&mdash; Select &mdash;', 'acosmin' ) );
	foreach ( $menus as $menu ) {
		$choices[ $menu->term_id ] = wp_html_excerpt( $menu->name, 40, '&hellip;' );
	}
	
	// Remove some of the default sections
	$wp_customize->remove_section( 'static_front_page' );
	$wp_customize->remove_section( 'nav' );
	
	// Get some settings
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	// Add new sections
	$wp_customize->add_section( 'ac_customize_header', array(
    	'title'				=> __( 'Header', 'acosmin' ),
    	'priority'			=> 35,
		'description'		=> '<small>* If you upload a logo, please resize the window a little. It will update its position.</small><br> 
								<small>* If not use the text logo to set up a title.</small>'
	) );
	$wp_customize->add_section( 'ac_customize_top_menu', array(
    	'title'				=> __( 'Top Menu', 'acosmin' ),
    	'priority'			=> 36,
	) );
	$wp_customize->add_section( 'ac_customize_top_menu_colors', array(
    	'title'				=> __( 'Top Menu Colors', 'acosmin' ),
    	'priority'			=> 37,
	) );
	$wp_customize->add_section( 'ac_customize_links', array(
    	'title'				=> __( 'Global Links Colors', 'acosmin' ),
    	'priority'			=> 38,
	) );
	$wp_customize->add_section( 'ac_customize_bgs', array(
    	'title'				=> __( 'Global Background Colors', 'acosmin' ),
    	'priority'			=> 39,
	) );
	$wp_customize->add_section( 'ac_customize_borders', array(
    	'title'				=> __( 'Global Border Colors', 'acosmin' ),
    	'priority'			=> 40,
	) );
	$wp_customize->add_section( 'ac_customize_gfc', array(
    	'title'				=> __( 'Global Fonts Colors', 'acosmin' ),
    	'priority'			=> 41,
	) );
	$wp_customize->add_section( 'ac_customize_content', array(
    	'title'				=> __( 'Content', 'acosmin' ),
    	'priority'			=> 42,
	) );
	$wp_customize->add_section( 'ac_customize_minisidebar', array(
    	'title'				=> __( 'Mini-Sidebar', 'acosmin' ),
    	'priority'			=> 43,
		'description'		=> '<small>* If you add or change a menu title save your changes.</small>'
	) );
	$wp_customize->add_section( 'ac_customize_footer', array(
    	'title'				=> __( 'Footer', 'acosmin' ),
    	'priority'			=> 44,
	) );
	
	
	// Add new settings
	// -- Header
	$wp_customize->add_setting( 'ac_logo_image', array(
    	'default'			=> '',
		'sanitize_callback' => 'esc_url_raw',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_logo', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_header', array(
		'default'			=> '#111111',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_image_header', array(
		'default'			=> '',
		'sanitize_callback' => 'esc_url_raw',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_header', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_description', array(
    	'default'			=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Top Menu
	$wp_customize->add_setting( 'ac_disable_stickymenu', array(
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'default'			=> false,
		'capability'		=> 'edit_theme_options',
	) );
	$wp_customize->add_setting( 'nav_menu_locations[main]', array(
		'default'			=> 0,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'theme_supports'    => 'menus',
	) );
	$wp_customize->add_setting( 'ac_border_color_top_menu', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_top_menu_bot', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_top_menu_inn', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_top_menu', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Top Menu Colors
	$wp_customize->add_setting( 'ac_color_top_menu_links', array(
		'default'			=> '#444444',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_submenu_links', array(
		'default'			=> '#be5656',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_links_hover', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_top_menu_links_active', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Content
	$wp_customize->add_setting( 'ac_font_select', array(
		'default'			=> 'style1',
		'sanitize_callback' => 'sanitize_text_field',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'refresh',
	) );
	$wp_customize->add_setting( 'ac_border_color_content', array(
		'default'			=> $main_color,
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_be5656', array(
		'default'			=> '#be5656',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_000000', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_border_color_666666', array(
		'default'			=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_444', array(
		'default'			=> '#444444',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_be5656', array(
		'default'			=> '#be5656',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_hover', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_000', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_666', array(
		'default'			=> '#666666',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_222', array(
		'default'			=> '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_333', array(
		'default'			=> '#333333',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_bbb', array(
		'default'			=> '#bbbbbb',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_color_aaa', array(
		'default'			=> '#aaaaaa',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Global Background Colors
	$wp_customize->add_setting( 'ac_background_color_fff', array(
		'default'			=> '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_be5656', array(
		'default'			=> '#be5656',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_e1e1e1', array(
		'default'			=> '#e1e1e1',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_f7f7f7', array(
		'default'			=> '#f7f7f7',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_f2f2f2', array(
		'default'			=> '#f2f2f2',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_background_color_000', array(
		'default'			=> '#000000',
		'sanitize_callback' => 'sanitize_hex_color',
		'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	// -- Mini Sidebar
	$wp_customize->add_setting( 'ac_mini_first_title', array(
    	'default'			=> __( 'ex: Categories', 'acosmin' ),
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'nav_menu_locations[mini-first]', array(
		'default'			=> 0,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'theme_supports'    => 'menus',
	) );
	$wp_customize->add_setting( 'ac_mini_second_title', array(
    	'default'			=> __( 'ex: Blogroll', 'acosmin' ),
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'nav_menu_locations[mini-second]', array(
		'default'			=> 0,
		'sanitize_callback' => 'absint',
		'capability'		=> 'edit_theme_options',
		'theme_supports'    => 'menus',
	) );
	$wp_customize->add_setting( 'ac_disable_minisidebar', array(
		'default'			=> false,
		'sanitize_callback' => 'ac_sanitize_checkbox',
		'capability'		=> 'edit_theme_options',
	) );
	// -- Footer
	$wp_customize->add_setting( 'ac_footer_logo_text', array(
    	'default'			=> 'JustWrite',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	$wp_customize->add_setting( 'ac_footer_copyright_text', array(
    	'default'			=> 'Copyright 2013 JUSTWRITE. All rights reserved.',
		'sanitize_callback' => 'sanitize_text_field',
    	'capability'		=> 'edit_theme_options',
		'transport'         => 'postMessage',
	) );
	
	
	
	// Add new controls
	// -- Header
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ac_logo_image', array(
    	'label'				=> __( 'Logo - Image', 'acosmin' ),
    	'section'			=> 'ac_customize_header',
    	'settings'			=> 'ac_logo_image',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_logo', array(
		'label'				=> __( 'Logo - Font Color', 'acosmin' ),
		'section'			=> 'ac_customize_header',
		'settings'			=> 'ac_color_logo',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_description', array(
		'label'				=> __( 'Description - Font Color', 'acosmin' ),
		'section'			=> 'ac_customize_header',
		'settings'			=> 'ac_color_description',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_header', array(
		'label'				=> __( 'Header - Background Color', 'acosmin' ),
		'section'			=> 'ac_customize_header',
		'settings'			=> 'ac_background_color_header',
	) ) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'ac_background_image_header', array(
    	'label'				=> __( 'Header - Background Image', 'acosmin' ),
    	'section'			=> 'ac_customize_header',
    	'settings'			=> 'ac_background_image_header',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_header', array(
		'label'				=> __( 'Header - Bottom Border Color', 'acosmin' ),
		'section'			=> 'ac_customize_header',
		'settings'			=> 'ac_border_color_header',
	) ) );
	
	// -- Top Menu
	$wp_customize->add_control('ac_disable_stickymenu', array(
		'settings' => 'ac_disable_stickymenu',
		'label'    => __( 'Disable Fixed Style', 'acosmin' ),
		'section'  => 'ac_customize_top_menu',
		'type'     => 'checkbox',
	));
	$wp_customize->add_control( 'nav_menu_locations[main]', array(
		'label'				=> __( 'Select a menu', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'nav_menu_locations[main]',
		'type'   			=> 'select',
		'choices'			=> $choices
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_top_menu', array(
		'label'				=> __( 'Border color', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_border_color_top_menu',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_top_menu_bot', array(
		'label'				=> __( 'Bottom border color', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_border_color_top_menu_bot',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_top_menu_inn', array(
		'label'				=> __( 'Inner borders color', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_border_color_top_menu_inn',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_top_menu', array(
		'label'				=> __( 'Background color', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu',
		'settings'			=> 'ac_background_color_top_menu',
	) ) );
	// -- Top Menu Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_links', array(
		'label'				=> __( 'Main links color', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu_colors',
		'settings'			=> 'ac_color_top_menu_links',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_links_hover', array(
		'label'				=> __( 'Main links color / Hover', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu_colors',
		'settings'			=> 'ac_color_top_menu_links_hover',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_submenu_links', array(
		'label'				=> __( 'Sub-menu links color', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu_colors',
		'settings'			=> 'ac_color_top_menu_submenu_links',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_top_menu_links_active', array(
		'label'				=> __( 'Main links color / Active', 'acosmin' ),
		'section'			=> 'ac_customize_top_menu_colors',
		'settings'			=> 'ac_color_top_menu_links_active',
	) ) );
	// -- Global Links Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_be5656', array(
		'label'				=> __( 'Links - Link/Visited states', 'acosmin' ),
		'section'			=> 'ac_customize_links',
		'settings'			=> 'ac_color_be5656',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_hover', array(
		'label'				=> __( 'Links - Hover state', 'acosmin' ),
		'section'			=> 'ac_customize_links',
		'settings'			=> 'ac_color_hover',
	) ) );
	// -- Global Fonts Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_000', array(
		'section'			=> 'ac_customize_gfc',
		'settings'			=> 'ac_color_000',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_666', array(
		'section'			=> 'ac_customize_gfc',
		'settings'			=> 'ac_color_666'
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_222', array(
		'section'			=> 'ac_customize_gfc',
		'settings'			=> 'ac_color_222',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_333', array(
		'section'			=> 'ac_customize_gfc',
		'settings'			=> 'ac_color_333',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_bbb', array(
		'section'			=> 'ac_customize_gfc',
		'settings'			=> 'ac_color_bbb',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_aaa', array(
		'section'			=> 'ac_customize_gfc',
		'settings'			=> 'ac_color_aaa',
	) ) );
	// -- Global Background Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_fff', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_fff',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_be5656', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_be5656',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_e1e1e1', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_e1e1e1',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_f7f7f7', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_f7f7f7',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_f2f2f2', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_f2f2f2',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_background_color_000', array(
		'section'			=> 'ac_customize_bgs',
		'settings'			=> 'ac_background_color_000',
	) ) );
	// -- Global Borders Colors
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_content', array(
		'label'				=> __( 'Main border color', 'acosmin' ),
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_content',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_be5656', array(
		'label'				=> __( 'Other border colors', 'acosmin' ),
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_be5656',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_000000', array(
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_000000',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_border_color_666666', array(
		'section'			=> 'ac_customize_borders',
		'settings'			=> 'ac_border_color_666666',
	) ) );
	// -- Content
	$wp_customize->add_control('ac_font_select', array(
        'label'				=> __('Select a font family', 'acosmin'),
        'section'    		=> 'ac_customize_content',
        'settings'   		=> 'ac_font_select',
        'type'       		=> 'select',
		'choices'			=> array( 
									'style1' => 'Style #1',
									'style2' => 'Style #2',
									'style3' => 'Style #3',
									'style4' => 'Style #4',
	) ) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ac_color_444', array(
		'label'				=> __( 'Default font color', 'acosmin' ),
		'section'			=> 'ac_customize_content',
		'settings'			=> 'ac_color_444',
	) ) );
	// -- Mini Sidebar
	$wp_customize->add_control( 'ac_mini_first_title', array(
    	'label'				=> __( 'First Menu - Title', 'acosmin' ),
    	'section'			=> 'ac_customize_minisidebar',
    	'settings'			=> 'ac_mini_first_title',
	) );
	$wp_customize->add_control( 'nav_menu_locations[mini-first]', array(
		'label'				=> __( 'First Menu - Select', 'acosmin' ),
		'section'			=> 'ac_customize_minisidebar',
		'settings'			=> 'nav_menu_locations[mini-first]',
		'type'   			=> 'select',
		'choices'			=> $choices
	) );
	$wp_customize->add_control( 'ac_mini_second_title', array(
    	'label'				=> __( 'Second Menu - Title', 'acosmin' ),
    	'section'			=> 'ac_customize_minisidebar',
    	'settings'			=> 'ac_mini_second_title',
	) );
	$wp_customize->add_control( 'nav_menu_locations[mini-second]', array(
		'label'				=> __( 'Second Menu - Select', 'acosmin' ),
		'section'			=> 'ac_customize_minisidebar',
		'settings'			=> 'nav_menu_locations[mini-second]',
		'type'   			=> 'select',
		'choices'			=> $choices
	) );
	$wp_customize->add_control('ac_disable_minisidebar', array(
		'settings' => 'ac_disable_minisidebar',
		'label'    => __( 'Disable Mini-Sidebar', 'acosmin' ),
		'section'  => 'ac_customize_minisidebar',
		'type'     => 'checkbox',
	));
	// -- Footer
	$wp_customize->add_control( 'ac_footer_logo_text', array(
    	'label'				=> __( 'Logo text', 'acosmin' ),
    	'section'			=> 'ac_customize_footer',
    	'settings'			=> 'ac_footer_logo_text',
	) );
	$wp_customize->add_control( 'ac_footer_copyright_text', array(
    	'label'				=> __( 'Copyright text', 'acosmin' ),
    	'section'			=> 'ac_customize_footer',
    	'settings'			=> 'ac_footer_copyright_text',
	) );	

	
	
	/* Enque Theme Customiser JS */
	if ( $wp_customize->is_preview() && ! is_admin() ) {
    	add_action( 'customize_preview_init', 'acosminbusiness_customize_preview' );
	}
	// Enque JS 
	function acosminbusiness_customize_preview() {
		wp_enqueue_script(
			'ac_js_theme_customizer', 
			get_template_directory_uri() . '/assets/js/theme-customizer.js',
			array( 'jquery', 'customize-preview' ),
			'1.0',
			true
		);
	}
	
} // - END Customizations
add_action( 'customize_register', 'ac_customize_init' );




/* AC - Output Saved Settings */
function ac_header_output() {
	
	  $main_color = '#e1e1e1'
	
      ?>
      <!-- Customizer - Saved Styles--> 
      <style type="text/css">
		<?php 
		if(ac_checkdefault('ac_color_be5656', '#be5656') || ac_checkdefault('ac_color_hover', '#000000')) { 
			ac_generate_css( 'a, a:visited, .kk, .share-pagination .title i', 'color', 'ac_color_be5656', '' ); 
			ac_generate_css( 'a:hover', 'color', 'ac_color_hover', '' );
		}
		if(ac_checkdefault('ac_color_logo', '#ffffff')) { ac_generate_css( '.logo a, .logo a:visited, .logo a:hover', 'color', 'ac_color_logo', '' ); }
		if(ac_checkdefault('ac_background_color_header', '#111111')) { ac_generate_css( '.header-wrap', 'background-color', 'ac_background_color_header', '' ); }
		if(ac_checkdefault('ac_background_image_header', '')) { ac_generate_css( '.header-wrap', 'background-image', 'ac_background_image_header', 'url(', ')' ); }
		if(ac_checkdefault('ac_border_color_header', $main_color)) { ac_generate_css( '.header-wrap', 'border-color', 'ac_border_color_header', '' ); }
		if(ac_checkdefault('ac_border_color_top_menu', $main_color)) { ac_generate_css( '.menu-wrap', 'border-color', 'ac_border_color_top_menu', '' ); }
		if(ac_checkdefault('ac_border_color_top_menu_bot', $main_color)) { ac_generate_css( '.menu-wrap', 'border-bottom-color', 'ac_border_color_top_menu_bot', '' ); }
		if(ac_checkdefault('ac_border_color_top_menu_inn', $main_color)) { ac_generate_css( '.menu-main, .menu-main > li, .menu-wrap .search-button, .menu-wrap a.browse-more, .mobile-menu-button, .mobile-menu > li, .mobile-menu .sf-sub-indicator, .menu-main .sub-menu, .menu-main .sub-menu a, .search-wrap.search-visible, .menu-wrap .search-submit', 'border-color', 'ac_border_color_top_menu_inn', '' ); }
		if(ac_checkdefault('ac_border_color_content', $main_color)) { 
			ac_generate_css( 'fieldset, .container, .sidebar, .main-page-title, .post-template-1 .details .p-share .contents .close-this-temp1, .posts-pagination, .page-links-wrap, .posts-pagination .paging-wrap, .page-links-wrap .page-links, .posts-pagination a, .page-links-wrap a, .page-links-wrap span, .comments-pagination, .comments-pagination .paging-wrap, .comments-pagination a, .posts-pagination span.current, .tabs-widget-navigation ul li a, .tabs-widget-navigation ul li a.selected:after, .mini-sidebar.browse-window-opened, .browse-by-wrap, .browse-window-opened:after, #wp-calendar, #wp-calendar tbody td, #wp-calendar thead th, .single-template-1 .details, .single-template-1 .single-content, .single-content blockquote, .comment-text blockquote, .single-content.featured-image:before, .sidebar .sidebar-heading:before, .sidebar .sidebar-heading:after, .ac-recent-posts li.full-width, .sidebar #recentcomments li, .tagcloud a, .slider-controls, .slide-btn, .slider-pagination a, .as-wrap, .share-pagination, .about-the-author, .about-share .title, .post-navigation, .post-navigation a, .ata-wrap .avatar-wrap, .clear-border, .post-navigation span, .content-wrap, .comments-title, .comment-avatar, .comment-main,  textarea, input, select, li .comment-reply-title small, .post-template-1 .details .post-small-button, .sidebar-heading, .tabs-widget-navigation, .sidebar .sidebar-heading, .sidebar .tabs-widget-navigation, .ac-popular-posts .position, .ac-twitter-widget-ul li.ac-twitter-tweet, select, table, th, td, pre, .posts-pagination span.dots, .comment-list li.pingback, .content-wrap #review-statistics .review-wrap-up .review-wu-right, .comments-area .user-comments-grades, .content-wrap #review-statistics .review-wrap-up, .content-wrap #review-statistics .review-wrap-up .cwpr-review-top, .content-wrap #review-statistics .review-wu-bars, .content-wrap #review-statistics .review-wrap-up .review-wu-left .review-wu-grade, .wrap .cwp-popular-review', 'border-color', 'ac_border_color_content', '' );
			ac_generate_css( '.mini-sidebar, .sidebar, .mini-sidebar-bg', 'box-shadow', 'ac_border_color_content', '1px 0 0 ', '' );
			ac_generate_css( '.mini-sidebar, .sidebar, .mini-sidebar-bg', '-moz-box-shadow', 'ac_border_color_content', '1px 0 0 ', '' );
			ac_generate_css( '.mini-sidebar, .sidebar, .mini-sidebar-bg', '-webkit-box-shadow', 'ac_border_color_content', '1px 0 0 ', '' );
			ac_generate_css( '.sidebar', 'box-shadow', 'ac_border_color_content', '-1px 0 0 ', '' );
			ac_generate_css( '.sidebar', '-moz-box-shadow', 'ac_border_color_content', '-1px 0 0 ', '' );
			ac_generate_css( '.sidebar', '-webkit-box-shadow', 'ac_border_color_content', '-1px 0 0 ', '' );
			ac_generate_css( '.single-template-1 .featured-image-wrap', 'box-shadow', 'ac_border_color_content', '-8px 8px 0 ', '' );
			ac_generate_css( '.single-template-1 .featured-image-wrap', '-moz-box-shadow', 'ac_border_color_content', '-8px 8px 0 ', '' );
			ac_generate_css( '.single-template-1 .featured-image-wrap', '-webkit-box-shadow', 'ac_border_color_content', '-8px 8px 0 ', '' );
			ac_generate_css( '.content-wrap #review-statistics .review-wu-bars', 'box-shadow', 'ac_border_color_content', '1px 1px 0 ', '' );
			ac_generate_css( '.comments-area #cwp-slider-comment .comment-form-meta-option .comment_meta_slider', 'box-shadow', 'ac_border_color_content', 'inset 0px 0px 5px ', '' );
			ac_generate_css( '.comment-list .children:before', 'background-color', 'ac_border_color_content', '' );
		} 
		if(ac_checkdefault('ac_border_color_be5656', '#be5656')) { ac_generate_css( 'abbr[title], .back-to-top, .close-browse-by, .tagcloud a:hover, .comment-main .comment-reply-link', 'border-color', 'ac_border_color_be5656', '' ); }
		if(ac_checkdefault('ac_border_color_000000', '#000000')) { ac_generate_css( '.back-to-top:hover, .close-browse-by:hover, .comment-main a.comment-reply-link:hover, textarea:focus, input:focus, select:focus, li .comment-reply-title small:hover, textarea:hover:focus, input:hover:focus, select:hover:focus', 'border-color', 'ac_border_color_000000', '' ); }
		if(ac_checkdefault('ac_border_color_666666', '#666666')) { ac_generate_css( 'textarea:hover, input:hover, select:hover', 'border-color', 'ac_border_color_666666', '' ); }
		if(ac_checkdefault('ac_color_444', '#444444')) { ac_generate_css( 'body, .comments-number, .comments-number:visited, .post-template-1 p, .single-template-1 .single-content, .post-template-1 .details .detail a, .single-template-1 .details .detail a, .post-template-1 .details .detail a:visited, .back-to-top:hover, .footer-credits .copyright, .close-browse-by:hover, .tagcloud a:hover, .post-navigation a.prev-post:hover, .post-navigation a.next-post:hover, .comment-main .vcard .fn, .comment-main .vcard a.comment-edit-link:hover, .content-wrap #review-statistics .review-wrap-up .review-wu-right ul li, .content-wrap #review-statistics .review-wu-bars h3, .content-wrap .review-wu-bars span, .content-wrap #review-statistics .review-wrap-up .cwpr-review-top .cwp-item-category a', 'color', 'ac_color_444', '' ); }
		if(ac_checkdefault('ac_color_000', '#000000')) { ac_generate_css( '.sidebar-heading, .ac-popular-posts .position, .posts-pagination a.selected, .page-links-wrap a.selected, .comments-pagination a.selected, a.back-to-top, .footer-credits .blog-title, .post-template-1 .details .p-share .contents .close-this-temp1, .tabs-widget-navigation ul li a.selected, .browse-by-title, a.close-browse-by, .menu-main > li.current_page_item > a, .menu-main > li.current_page_ancestor > a, .menu-main > li.current-menu-item > a, .menu-main > li.current-menu-ancestor > a, .menu-main .sub-menu .sf-sub-indicator i, .comment-main .vcard .fn a, .comment-main .vcard .fn a:visited, .comment-main .vcard a.comment-edit-link, .comment-main a.comment-reply-link, .menu-wrap .search-submit:hover', 'color', 'ac_color_000', '' ); }
		if(ac_checkdefault('ac_color_666', '#666666')) { ac_generate_css( '.normal-list .current_page_item a, .normal-list .current-menu-item a, .normal-list .current-post-parent a, .wp-caption, textarea, input, .main-page-title .page-title,  blockquote cite, blockquote small', 'color', 'ac_color_666', '' ); }
		if(ac_checkdefault('ac_color_description', '#666666')) { ac_generate_css( '.logo .description', 'color', 'ac_color_description', '' ); }
		if(ac_checkdefault('ac_color_222', '#222222')) { ac_generate_css( '.slider-controls a.slide-btn, .slider .title a, .slider .title a:visited, .slider .com:hover, .post-template-1 .title a, .post-template-1 .title a:visited, .ac-recent-posts a.title, .ac-popular-posts a.title, .ac-featured-posts .thumbnail .details .title, legend, .single-template-1 .title, .single-content h1, .single-content h2, .single-content h3, .single-content h4, .single-content h5, .single-content h6, .comment-text h1, .comment-text h2, .comment-text h3, .comment-text h4, .comment-text h5, .comment-text h6, .category > a:hover, .sidebar .category > a:hover, .sidebar #recentcomments li a, .sidebar #recentcomments a.url:hover, .tagcloud a, .about-share .title, .post-navigation a.prev-post, .post-navigation a.next-post, label, .comment-reply-title, .page-404 h1, .main-page-title .page-title span', 'color', 'ac_color_222', '' ); } 
		if(ac_checkdefault('ac_color_333', '#333333')) { ac_generate_css( '.slider .title a:hover, .post-template-1 .title a:hover, .ac-recent-posts a.title:hover, .ac-popular-posts a.title:hover, .ac-featured-posts .thumbnail .details .title:hover, .footer-credits .theme-author a:hover, .sidebar #recentcomments li a, .comment-main .vcard .fn a:hover, .menu-wrap .search-submit', 'color', 'ac_color_333', '' ); }
		if(ac_checkdefault('ac_color_bbb', '#bbbbbb')) { ac_generate_css( '.post-template-1 .details .detail, .single-template-1 .details .detail, .category > a, .sidebar .category > a,  .ac-twitter-tweet-time, .ac-featured-posts .thumbnail .details .category, .footer-credits .theme-author, .footer-credits .theme-author a, .footer-credits .theme-author a:visited, .post-template-1 .details .p-share .contents em, .sidebar #recentcomments, .sidebar #recentcomments a.url, .slider .date, .slider a.com, a.slide-btn:hover, .banner-small-title, .banner-small-title a, .banner-small-title a:hover, .banner-small-title a:visited', 'color', 'ac_color_bbb', '' ); }
		if(ac_checkdefault('ac_color_aaa', '#aaaaaa')) { ac_generate_css( 'q, .single-content blockquote, .comment-text blockquote, .about-share .author, .post-navigation span, .comment-main .vcard a.comment-date, .not-found-header h2, .menu-wrap .search-submit:active', 'color', 'ac_color_aaa', '' ); }
		if(ac_checkdefault('ac_background_color_fff', '#ffffff')) { 
					$abcf = get_theme_mod('ac_background_color_fff', '#ffffff');
		  			ac_generate_css( 'body, .post-content, .content-wrap, .slider-pagination a, .slide-btn, .slider .title, .slider .com, .container, .ac-ad-title-300px:before, .post-template-1 .details .post-small-button, #wp-calendar, textarea, input, select, .banner-small-title a, .comment-list .comment-avatar, .ac-featured-posts .thumbnail .details', 'background-color', 'ac_background_color_fff', '' ); 
					ac_generate_css( '.comments-title:after', 'border-top-color', 'ac_background_color_fff', '' );
					ac_generate_css( '.comment-main:after', 'border-right-color', 'ac_background_color_fff', '' );
		  }
		if(ac_checkdefault('ac_background_color_e1e1e1', '#e1e1e1')) { ac_generate_css( '.mobile-menu .sub-menu li:before, .no-thumbnail, .featured-image-wrap, .add-some-widgets, a.slide-btn:active, .slider-pagination a span, .menu-wrap .search-submit:active', 'background-color', 'ac_background_color_e1e1e1', '' ); }
		if(ac_checkdefault('ac_background_color_f7f7f7', '#f7f7f7')) { ac_generate_css( 'ins, .slider-controls, .posts-pagination span.current, .page-links-wrap span, .posts-pagination span.current:hover, .page-links-wrap span:hover, .tabs-widget-navigation ul li a.selected, .menu-wrap a.browse-more.activated, .tagcloud a:hover, .slide-btn:hover, .about-share .title, .post-navigation a, .post-navigation span, .comment-reply-title small, .menu-wrap .search-submit, .ac-popular-posts .position, pre, .comments-area #cwp-slider-comment .comment-form-meta-option .comment_meta_slider, .comments-area .user-comments-grades .comment-meta-grade-bar, #review-statistics .review-wu-bars ul li', 'background-color', 'ac_background_color_f7f7f7', '' ); }
		if(ac_checkdefault('ac_background_color_f2f2f2', '#f2f2f2')) { ac_generate_css( 'mark, #wp-calendar tbody a, .tagcloud a, .post-navigation a:hover, .comment-reply-title small:hover, .menu-wrap .search-submit:hover, .banner-small-title:before, .banners-125-wrap ul:before', 'background-color', 'ac_background_color_f2f2f2', '' ); }
		if(ac_checkdefault('ac_background_color_000', '#000000')) { 
			ac_generate_css( '.slider .date', 'background-color', 'ac_background_color_000', '' );
			ac_generate_css( 'span.post-format-icon:after', 'border-color', 'ac_background_color_000', '', ' transparent transparent transparent' );
			ac_generate_css( '.post-content .details a.post-format-icon:after', 'border-color', 'ac_background_color_000', ' transparent ', ' transparent transparent' );
		}
		if(ac_checkdefault('ac_background_color_be5656', '#be5656')) { ac_generate_css( '.ac-popular-posts .the-percentage, .slider .category, .post-thumbnail .sticky-badge, .post-format-icon, button, .contributor-posts-link, input[type="button"], input[type="reset"], input[type="submit"]', 'background-color', 'ac_background_color_be5656', '' ); }
		if(ac_checkdefault('ac_background_color_top_menu', '#ffffff')) { ac_generate_css( '.menu-main .menu-main ul, .mobile-menu .sub-menu a, .menu-main, .menu-wrap, .menu-wrap .search-wrap, .menu-wrap .search-field, .menu-main li:hover .sub-menu', 'background-color', 'ac_background_color_top_menu', '' ); }
		if(ac_checkdefault('ac_color_top_menu_links', '#444444')) { ac_generate_css( '.menu-main > li > a, .menu-wrap a.search-button, .menu-wrap a.browse-more, .menu-wrap a.mobile-menu-button, .menu-wrap .search-field', 'color', 'ac_color_top_menu_links', '' ); }
		if(ac_checkdefault('ac_color_top_menu_submenu_links', '#be5656')) { ac_generate_css( '.menu-main .sub-menu a', 'color', 'ac_color_top_menu_submenu_links', '' ); }
		if(ac_checkdefault('ac_color_top_menu_links_hover', '#000000')) { ac_generate_css( '.mobile-drop-down > a, .mobile-drop-down > a:visited, .menu-main > li.sfHover > a, .menu-main .sub-menu li.sfHover > a, .menu-main a:hover, .menu-main > li > a:hover, .menu-main > li.sfHover > a, .menu-main .sub-menu li.sfHover > a, .menu-wrap a.browse-more:hover, .menu-wrap a.mobile-menu-button:hover, .menu-wrap .search-button:hover, .menu-wrap .search-button:hover i', 'color', 'ac_color_top_menu_links_hover', '' ); }
		if(ac_checkdefault('ac_color_top_menu_links_active', '#000000')) { ac_generate_css( '.menu-wrap .search-button.activated, .menu-wrap a.browse-more.activated, .menu-wrap a.mobile-menu-button.activated, .menu-main > li.current_page_item > a, .menu-main > li.current_page_ancestor > a, .menu-main > li.current-menu-item > a, .menu-main > li.current-menu-ancestor > a', 'color', 'ac_color_top_menu_links_active', '' ); } ?>
		<?php if( get_theme_mod('ac_background_color_fff') != '#ffffff' && get_theme_mod('ac_background_color_fff') != '' ) { $abcf = get_theme_mod('ac_background_color_fff', '#ffffff'); ?>
		.ac-featured-posts .thumbnail .details { background: -moz-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%, rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%, rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); background: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(<?php ac_hex2rgb($abcf); ?>,1)), color-stop(1%,rgba(<?php ac_hex2rgb($abcf); ?>,1)), color-stop(100%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6))); background: -webkit-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%);background: -o-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); background: -ms-linear-gradient(left, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); background: linear-gradient(to right, rgba(<?php ac_hex2rgb($abcf); ?>,1) 0%,rgba(<?php ac_hex2rgb($abcf); ?>,1) 1%,rgba(<?php ac_hex2rgb($abcf); ?>,0.6) 100%); }<?php } ?>
      </style> 
      <!-- END Customizer - Saved Styles -->
      <?php
}
add_action( 'wp_head' , 'ac_header_output' );
?>