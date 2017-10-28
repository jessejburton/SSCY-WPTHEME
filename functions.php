<?php
/**
 * Salt Spring Centre Theme functions and definitions
 *
 * @package SSCY
 * @subpackage Salt_Spring_Centre_Theme
 * @since Salt Spring Centre Theme 1.0
 */

/*
*	Main setup function 
*/
function sscy_theme_setup(){
	// This theme uses wp_nav_menu() in one location.
	// Add another menu to the array in order to add more menus to this theme
	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu' )
	) );
}
add_action( 'after_setup_theme', 'sscy_theme_setup' );

/* 
*	Register Styles and Scripts
*/
// Javascript
function wpt_register_js() {
 	wp_register_script('sscy_javascript', get_template_directory_uri() . '/assets/js/common.js', 'common');
    wp_enqueue_script('sscy_javascript');   
}
add_action( 'init', 'wpt_register_js' );
// CSS
function wpt_register_css() {
	// Bootstrap Styles
    wp_register_style( 'bootstrap_styles', get_template_directory_uri() . '/vendor/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style( 'bootstrap_styles' );    	

    wp_register_style( 'sscy_styles', get_template_directory_uri() . '/assets/css/style.css' );
    wp_enqueue_style( 'sscy_styles' );    

    wp_register_style( 'sscy_secondary_styles', get_template_directory_uri() . '/assets/css/secondary_style.css' );
    wp_enqueue_style( 'sscy_secondary_styles' ); 
}
add_action( 'wp_enqueue_scripts', 'wpt_register_css' );


/*
*	Function to display child pages
*/
function sscy_list_child_pages() { 
	global $post; 
	 
	if ( is_page() && $post->post_parent )	 
	    $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
	else
	    $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );

	if ( $childpages ) 
	    $string = '<ul class="list-group" id="child-pages">' . $childpages . '</ul>';
	else 
		$string = '';
	 
	return $string;
}