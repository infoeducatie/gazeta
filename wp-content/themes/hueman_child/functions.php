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

// load javascript dependencies
wp_enqueue_script('twitter', get_stylesheet_directory_uri() . '/js/twitter.js');
wp_enqueue_script('facebook', get_stylesheet_directory_uri() . '/js/facebook.js');

// fix auto quoting
remove_filter( 'the_title', 'wptexturize' );
remove_filter( 'the_content', 'wptexturize' );
remove_filter( 'the_excerpt', 'wptexturize' );
remove_filter( 'comment_text', 'wptexturize' );
?>
