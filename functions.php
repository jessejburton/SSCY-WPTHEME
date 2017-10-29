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

	// Add page options to pages
	add_action( 'add_meta_boxes', 'page_options_meta_box' );
}
add_action( 'after_setup_theme', 'sscy_theme_setup' );

function page_options_meta_box()
{
    add_meta_box( 'page-options-meta-box', 'Page Options', 'page_options_meta_box_callback', 'page', 'side', 'high' );
}

/*
*	Dispay the available page options
*/
function page_options_meta_box_callback( $post ){
	wp_nonce_field( basename(__FILE__), 'sscy_nonce' );
	$sscy_page_options_meta = get_post_meta( $post->ID );
	$bgColor = get_post_meta($post->ID, 'background-color', true);
	$showHeading = get_post_meta($post->ID, 'show-heading', true);
    
    // Content background color
    ?>
    	<p>
		    <label for="sscy_background_color">Background color for content</label>
		    <select name="sscy_background_color" id="sscy_background_color">
		        <option value="">Default</option>
		        <option value="bright-background" <?php selected($bgColor, 'bright-background'); ?>>Primary Color</option>
		        <option value="alt-background" <?php selected($bgColor, 'alt-background'); ?>>Secondary Color</option>
		    </select>
		</p>
    <?php

    // Show heading or not
    ?>
    	<p>
	    	<label for="sscy_show_heading">Show the page heading</label><br />
	    	<label for="sscy_show_heading_yes">Yes <input type="radio" name="sscy_show_heading" id="sscy_show_heading_yes" value="yes" <?php selected($showHeading, 'yes'); ?>/></label>
	    	<label for="sscy_show_heading_np">No <input type="radio" name="sscy_show_heading" id="sscy_show_heading_no" value="no" <?php selected($showHeading, 'no'); ?> /></label>
	    </p>
    <?php
}

function save_page_options_callback( $post_id ) {
  // Checks save status
  $is_autosave  = wp_is_post_autosave( $post_id );
  $is_revision  = wp_is_post_revision( $post_id );
  $is_valid_nonce = ( isset( $_POST['sscy_nonce'] ) && wp_verify_nonce( $_POST['sscy_nonce'], basename(__FILE__) ) ) ? 'true' : 'false';  
  $sscy_stored_meta = get_post_meta( $post_id );  // Get the data to know if a file already exists for this post 

  if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
    die();
    return; 
  }   

  // Save the background color
    if ( isset( $_POST['sscy_background_color'] ) )
        update_post_meta( $post_id, 'background-color', $_POST['sscy_background_color'] );
    else 
     	add_post_meta( $post_id, 'background-color', $_POST['sscy_background_color'] );

  // Save the show heading option
    if ( isset( $_POST['sscy_show_heading'] ) )
        update_post_meta( $post_id, 'show-heading', $_POST['sscy_show_heading'] );
    else 
     	add_post_meta( $post_id, 'show-heading', 'yes' );     
}
add_action( 'save_post', 'save_page_options_callback' );

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