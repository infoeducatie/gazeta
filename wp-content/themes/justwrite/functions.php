<?php
/* ------------------------------------------------------------------------- *
 *  Functions
 *  ________________
 *
 *	If you want to add/edit functions please use a child theme
 *	http://codex.wordpress.org/Child_Themes
 *	________________
 *
/* ------------------------------------------------------------------------- */



/* ------------------------------------------------------------------------- *
 *  Required Files
/* ------------------------------------------------------------------------- */
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/acosmin/framework/' );

require_once ( get_template_directory() . '/acosmin/framework/extensions/variables.php' );
require_once ( get_template_directory() . '/acosmin/framework/options-framework.php' );
require_once ( get_template_directory() . '/acosmin/framework/extensions/functions-extended.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-default.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-icons.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-post-options.php' );
require_once ( get_template_directory() . '/acosmin/functions/functions-theme-customizer.php' );
require_once ( get_template_directory() . '/acosmin/functions/class-tgm-plugin-activation.php' );



/*  Setup some info
/* ------------------------------------ */

// 	Content width
if ( ! isset( $content_width ) ) {
	$content_width = 940;
}



/*  Theme setup
/* ------------------------------------ */
if ( ! function_exists( 'ac_setup' ) ) {
	function ac_setup() {
		
		// Make JustWrite available for translation.
		load_theme_textdomain( 'acosmin', get_template_directory() . '/languages' );
		
		// Post Thumbnails
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 600, 400, true );
		add_image_size( 'ac-post-thumbnail', 600, 400, true );
		add_image_size( 'ac-slide-thumbnail', 515, 300, true );
		add_image_size( 'ac-sidebar-featured', 638, 368, true );
		add_image_size( 'ac-sidebar-small-thumbnail', 210, 140, true );
		
		// Enable post format support
		add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery' ) );
		
		// Menues
		// This theme has only one menu, located in the header.
		register_nav_menus( array(
			'main'				=> __( 'Main Menu', 'acosmin' ),
			'mini-first'		=> __( 'Right Sidebar - First Menu', 'acosmin' ),
			'mini-second'		=> __( 'Right Sidebar - Second Menu', 'acosmin' ),
		) );
		
		// This feature adds theme support for themes to display titles.
		add_theme_support( 'title-tag' );
		
		// This feature enables post and comment RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );
		
		// This feature allows the use of HTML5 markup for the comment forms, search forms and comment lists.
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
		
		// Adding theme support for TinyMCE editor style.
		$selected_ff = ac_get_selected_ff();
		add_editor_style( array( 'assets/css/editor-style.css', 'assets/css/es-' . $selected_ff . '.css', ac_font_url( $selected_ff ) ) );
		
		// Custom header and background support
		if ( isset( $ac_custom_header ) && isset( $ac_custom_bg ) ) { 
			add_theme_support( 'custom-header' ); add_theme_support( 'custom-background' ); 
		}
		
		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

	}
}
add_action( 'after_setup_theme', 'ac_setup' );



/*  Title - Backwards compatibility
/* ------------------------------------ */
if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function ac_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
    add_action( 'wp_head', 'ac_render_title' );
}



/*  Load CSS files
/* ------------------------------------ */
if ( ! function_exists( 'ac_css_files' ) ) {  

	function ac_css_files() {
		
		// Register
		wp_register_style( 'ac_webfonts_' . ac_get_selected_ff(), ac_font_url( ac_get_selected_ff() ), array(), null);
			
		// Enqueue
		wp_enqueue_style( 'ac_style', get_stylesheet_uri(), array(), '1.0.8', 'all' );
		wp_enqueue_style( 'ac_icons', get_template_directory_uri() . '/assets/icons/css/font-awesome.min.css', array(), '4.3.0', 'all' );
		wp_enqueue_style( 'ac_webfonts_' . ac_get_selected_ff() );
			
	}

}
add_action( 'wp_enqueue_scripts', 'ac_css_files', 99 );



/*  Load JavaScript files
/* ------------------------------------ */
if ( ! function_exists( 'ac_js_files' ) ) {
	
	function ac_js_files() {
		
		// Enqueue
		wp_enqueue_script( 'ac_js_fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery'), '1.1', true );
		wp_enqueue_script( 'ac_js_menudropdown', get_template_directory_uri() . '/assets/js/menu-dropdown.js', array('jquery'), '1.4.8', true );
		wp_enqueue_script( 'ac_js_slider', get_template_directory_uri() . '/assets/js/slider.js', array('jquery'), '0.3.0', true );
		wp_enqueue_script( 'ac_js_myscripts', get_template_directory_uri() . '/assets/js/myscripts.js', array('jquery'), '1.0.6', true );
		wp_enqueue_script( 'ac_js_html5', get_template_directory_uri() . '/assets/js/html5.js', array('jquery'), '3.7.0', false );
		
		// Comments Script
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { wp_enqueue_script( 'comment-reply' ); }
	}
	
}
add_action( 'wp_enqueue_scripts', 'ac_js_files' );



/*  Font Families
/* ------------------------------------ */ 
if ( ! function_exists( 'ac_font_url' ) ) {
	
	function ac_font_url( $font_type = 'style1' ) {
		
		// You have 4 optios
		// Please select a option from the WP Theme Customise, Content tab.
		$font_url = '';
		$google_fonts_url = "//fonts.googleapis.com/css";
		
		if( $font_type == 'style1' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Montserrat:400,700|Questrial|Arimo:400,700|Source Sans Pro:400,700,400italic,700italic' ), $google_fonts_url );
		} elseif( $font_type == 'style2' ) {
			$font_url = add_query_arg( 'family', urlencode( 'PT Serif:400,700,400italic,700italic|Montserrat:400,700|Questrial' ), $google_fonts_url );
		} elseif( $font_type == 'style3' ) {
			$font_url = add_query_arg( 'family', urlencode( 'Roboto:400,700italic,700,400italic|Montserrat:400,700|Questrial' ), $google_fonts_url );
		} elseif( $font_type == 'style4' ) {
			$font_url = add_query_arg( 'family', urlencode( 'PT Sans:400,700,400italic,700italic' ), $google_fonts_url );
		}
		
		return $font_url;
		
	}

}



/*  Font Styles
/* ------------------------------------ */
if ( ! function_exists( 'ac_font_styles' ) ) {
	
	function ac_font_styles() {
		
		$selected = get_theme_mod('ac_font_select');
		$font_style_url = get_stylesheet_directory_uri() . '/assets/css/font-' . $selected . '.css';
		
		if( $selected == '' || $selected == 'style1' ) {
			return;	
		} else {
			wp_enqueue_style( 'ac_webfonts_selected-' . $selected, $font_style_url, array(), null );
		}
		
	}
	
}
add_action( 'wp_enqueue_scripts', 'ac_font_styles', 100 );



/*  Get selected font
/* ------------------------------------ */
if ( ! function_exists( 'ac_get_selected_ff' ) ) {
	function ac_get_selected_ff() {
		
		// Check if a font is selected
		$selected = get_theme_mod( 'ac_font_select' );
		
		if ( $selected == '' ) {
			$current_font = 'style1';	
		} else { 
			$current_font = $selected;
		}
		
		return $current_font;
		
	}
	
}



/*  Setup posts excerpt
/* ------------------------------------ */
if ( ! function_exists( 'ac_custom_excerpt_length' ) ) {
	
	function ac_custom_excerpt_length( $length ) {
		return 45;
	}
	
}
add_filter( 'excerpt_length', 'ac_custom_excerpt_length', 999 );

if ( ! function_exists( 'ac_no_excerpt_dots' ) ) {
	
	function ac_no_excerpt_dots( $more ) {
		return '';
	}
	
}
add_filter('excerpt_more', 'ac_no_excerpt_dots'); 



/*  Widgets and Sidebars Setup
/* ------------------------------------ */
if ( ! function_exists( 'ac_sidebars_widgets' ) ) {
	
	function ac_sidebars_widgets() {
		
		// Include Widgets
		require_once get_template_directory() . '/acosmin/widgets/ac-default-widgets-init.php';
		require_once get_template_directory() . '/acosmin/widgets/ac-custom-widgets-init.php';
	
		// Main sidebar that appears on the right.
		register_sidebar( array(
			'name'          => __( 'Main Sidebar', 'acosmin' ),
			'id'            => 'main-sidebar',
			'description'   => __( 'Main sidebar that appears on the right.', 'acosmin' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );
		
		// Same as above, designed for the articles area.
		register_sidebar( array(
			'name'          => __( 'Posts Sidebar', 'acosmin' ),
			'id'            => 'posts-sidebar',
			'description'   => __( 'Same as "Main Sidebar", designed for the posts.', 'acosmin' ),
			'before_widget' => '<aside id="%1$s" class="side-box clearfix widget %2$s"><div class="sb-content clearfix">',
			'after_widget'  => '</div></aside><!-- END .sidebox .widget -->',
			'before_title'  => '<h3 class="sidebar-heading">',
			'after_title'   => '</h3>',
		) );
		
	}
	
}
add_action( 'widgets_init', 'ac_sidebars_widgets' );



/*  Title formatting
/* ------------------------------------ */
if ( ! function_exists( 'ac_wp_title' ) ) {
	
	function ac_wp_title( $title, $sep ) {
		global $paged, $page;
	
		if ( is_feed() ) {
			return $title;
		}
	
		// Add the site name.
		$title .= get_bloginfo( 'name' );
	
		// Add the site description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title = "$title $sep $site_description";
		}
	
		// Add a page number if necessary.
		if ( $paged >= 2 || $page >= 2 ) {
			$title = "$title $sep " . sprintf( __( 'Page %s', 'acosmin' ), max( $paged, $page ) );
		}
	
		return $title;
		
	}
	
}
add_filter( 'wp_title', 'ac_wp_title', 10, 2 );



/*  Set mini-sidebar to disabled
/* ------------------------------------ */
if ( ! function_exists( 'ac_mini_disabled' ) ) {
	
	function ac_mini_disabled() {
		
		// Adds a class to the mini-sidebar if you select to disable it
		$is_enabled = get_theme_mod( 'ac_disable_minisidebar' );
		$class		= '';
		
		if ( $is_enabled ) {
			$class = ' mini-disabled';	
		}
		
		echo $class;
		
	}
	
}



/*  Comment template
/* ------------------------------------ */
if ( ! function_exists( 'ac_comment_template' ) ) {

	function ac_comment_template( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		$classes = array(
			'clearfix'
		);
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class( $classes ); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix">
	
	
				<figure class="comment-avatar">
					<?php echo get_avatar( $comment, 70 ); ?>
				</figure>
	
	
				 <div class="comment-main">
	
					<header class="vcard clearfix">
						<?php printf(__('<cite class="fn">%s says:</cite>', 'acosmin'), get_comment_author_link()) ?>
						
						<aside class="comm-edit">
							<a class="comment-date" href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf('%1$s', get_comment_date('M d, Y'),  get_comment_time()) ?></a>
							<?php edit_comment_link(__('Edit', 'acosmin'),'  ','') ?>
						</aside>
					</header>
	
					<div class="comment-text">
					<?php comment_text(); ?>
						<?php if ($comment->comment_approved == '0') : ?>
							 <em><?php _e('Your comment is awaiting moderation.', 'acosmin') ?></em>
							 <br />
						<?php endif; ?>
					</div>
					
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'before' => '<footer class="reply">', 'after' => '</footer>','max_depth' => $args['max_depth']))) ?>
					
				</div>
	 
			</div><!-- #comment-<?php comment_ID(); ?>  -->
	
		<?php
			break;
			case 'pingback'  :
		?>
			<li <?php comment_class(); ?> id="li-pingback-<?php comment_ID(); ?>">
				<?php _e('Pingback:', 'acosmin') ?> <?php echo get_comment_author_link(); ?> <small class="ping-edit"><?php ac_icon('edit'); edit_comment_link(__('Edit', 'acosmin'),'  ','') ?></small>
			</li>
		<?php
			case 'trackback' :
		?>
			<li <?php comment_class(); ?> id="li-trackback-<?php comment_ID(); ?>">
				<?php _e('Trackback:', 'acosmin') ?> <?php echo get_comment_author_link(); ?> <small class="ping-edit"><?php ac_icon('edit'); edit_comment_link(__('Edit', 'acosmin'),'  ','') ?></small>
			</li>
		<?php
		endswitch;
	}
	
}



/*  Logo output
/* ------------------------------------ */
if ( ! function_exists( 'ac_get_logo' ) ) {
	
	function ac_get_logo() {
		
		// Adds different classes in case you select an image logo.
		$logo_text 		= get_bloginfo( 'name' );
		$logo_image 	= get_theme_mod( 'ac_logo_image' );
		
		if ( $logo_image ) { 
			echo '<img src="' . esc_url( $logo_image ) . '" alt="' . get_bloginfo( 'name' ) . '" />'; 
		} else { 
			if ( $logo_text != '' ) {
				echo esc_html( $logo_text );
			}
		}
	}
	
	function ac_logo_class() {
		if ( get_theme_mod( 'ac_logo_image' ) ) {
			echo ' logo-image'; 	
		} else {
			echo ' logo-text'; 
		}
		
	}

}



/*  Pagination
/* ------------------------------------ */
if ( ! function_exists( 'ac_paginate' ) ) {
	
	function ac_paginate() {
		if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
			return;
		}
	
		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
	
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
	
		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	
		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';
	
		$links   = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $GLOBALS['wp_query']->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'acosmin' ),
			'next_text' => __( 'Next &rarr;', 'acosmin' ),
		) );
	
		if ( $links ) :
	
		?>
		<nav class="posts-pagination clearfix" role="navigation">
			<div class="paging-wrap">
				<?php echo $links; ?>
			</div><!-- END .paging-wrap -->
		</nav><!-- .posts-pagination -->
		<?php
		endif;
		
	}
	
}



/*  Slider options
/* ------------------------------------ */
if ( ! function_exists( 'ac_slider_options' ) ) {
	function ac_slider_options() {
		
		if ( of_get_option( 'ac_show_slider' ) && is_front_page() && !is_paged() && ac_featured_posts_count() > 2 ) {
			
			if ( of_get_option( 'ac_slider_auto_start' ) ) {
				$slider_autostart = 'true';		
			} else {
				$slider_autostart = 'false';	
			}
			
			$slider_transition_delay = of_get_option( 'ac_slider_interval' );
			
			?>
			
			<script type="text/javascript">
			jQuery(function($){
				$('.slider').jcarouselAutoscroll({
					interval: <?php echo esc_html( $slider_transition_delay ); ?>,
					autostart: <?php echo $slider_autostart; ?>
				});
			});
			</script>
			
			<?php
		}
		
		return;
		
	}
	
}
add_action( 'ac_before_body_closed_hook', 'ac_slider_options' );



/*  Get featured posts count
/* ------------------------------------ */
if ( ! function_exists( 'ac_featured_posts_count' ) ) {
	
	function ac_featured_posts_count() {
		
		// Get total number
		$featured_posts_nr = get_posts( array( 
			'meta_key' => 'ac_featured_article',
			'meta_value' => 1,
		));
		
		$count_featured_posts = count( $featured_posts_nr );
		
		return $count_featured_posts;
	}
	
}



/*  Post pagination
/* ------------------------------------ */
if ( ! function_exists( 'ac_post_nav_arrows' ) ) {
	
	function ac_post_nav_arrows() {
		global $post;
		
		$prev_post = get_next_post();
		$next_post = get_previous_post();
		
		if( $prev_post ) { 
			$prev_post_id = $prev_post->ID; 
			$prev_post_url = get_permalink($prev_post_id); 
		};
		if( $next_post ) { 
			$next_post_id = $next_post->ID; 
			$next_post_url = get_permalink($next_post_id);	
		};
		
		echo '<div class="post-navigation clearfix">';
								
		if( $prev_post ) {
			echo '<a href="' . esc_url( $prev_post_url ) . '" class="prev-post" title="Previous Post">' . ac_icon('angle-left', false) . '</a>';	
		} else {
			echo '<span class="prev-post">' . ac_icon('angle-left', false) . '</span>';	
		}
								
		if( $next_post ) {
			echo '<a href="' . esc_url( $next_post_url ) . '" class="next-post" title="Next Post">' . ac_icon('angle-right', false) . '</a>';	
		} else {
			echo '<span class="next-post">' . ac_icon('angle-right', false) . '</span>';	
		}
		
		echo '</div>';
	}
	
}



/*  Plugins Compatibility
/* ------------------------------------ */

// WP Product Review -- Unregister FontAwesome 
if ( ! function_exists( 'ac_compatibility_unreg_icons' ) ) {
	
	function ac_compatibility_unreg_icons() {
		 wp_deregister_style( 'cwp-pac-fontawesome-stylesheet');
	}
	
}
add_action('init', 'ac_compatibility_unreg_icons');



/*  TGM Setup & Plugins
/* ------------------------------------ */
add_action( 'tgmpa_register', 'my_theme_register_required_plugins' );

function my_theme_register_required_plugins() {

    $plugins = array(
        
		array(
            'name'      => 'Revive Old Post',
            'slug'      => 'tweet-old-post',
            'required'  => false,
        ),
		
		array(
            'name'      => 'WP Product Review',
            'slug'      => 'wp-product-review',
            'required'  => false,
        ),

    );

    $config = array(
        'default_path' => '',
        'menu'         => 'tgmpa-install-plugins',
        'has_notices'  => true,
        'dismissable'  => true,
        'dismiss_msg'  => '',
        'is_automatic' => false,
        'message'      => '',
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'acosmin' ),
            'menu_title'                      => __( 'Install Plugins', 'acosmin' ),
            'installing'                      => __( 'Installing Plugin: %s', 'acosmin' ),
            'oops'                            => __( 'Something went wrong with the plugin API.', 'acosmin' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'acosmin' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'acosmin' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'acosmin' ),
            'nag_type'                        => 'updated'
        )
    );

    tgmpa( $plugins, $config );

}
?>