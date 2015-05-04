<?php

// load theme styles from parent and from child
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

// load languages from child theme
load_theme_textdomain( 'hueman', get_stylesheet_directory() . '/languages' );

function footerads_widget_init() {
	register_sidebar( array( 
		'name' => 'Footer Ads',
		'id' => 'footer-ads-custom', 
		'description' => "Footer ads area", 
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));
}

add_action('widgets_init', 'footerads_widget_init');
?>
