<?php

// Add parent stylesheet as dependency
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// Function for creating Widegets
function create_widget($name, $id, $description) {

    register_sidebar(array(
        'name' => __( $name ),
        'id' => $id,
        'description' => __( $description ),
        'before_widget' => '<aside id="'.$id.'" class="widget %1$s %2$s">',
		'after_widget' => '</aside>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ));

}

// Create the actual widgets
create_widget("Footer Widget", "footer-widget-2", "Displays in the footer of the site, below the copyright");

?>
