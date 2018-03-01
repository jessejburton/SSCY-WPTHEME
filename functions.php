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
  // Add Featured Image Support
  add_theme_support( 'post-thumbnails' ); 

	// This theme uses wp_nav_menu() in one location.
	// Add another menu to the array in order to add more menus to this theme
	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu' )
	) );

  // Add custom variables
  function add_query_vars_filter( $vars ){
    $vars[] = "fid";
    return $vars;
  }
  add_filter( 'query_vars', 'add_query_vars_filter' );  

	// Add page options to pages
	add_action( 'add_meta_boxes', 'page_options_meta_box' );

  // Register sidebars and widget areas
  register_sidebar( array(
    'name' => 'Footer Sidebar 1',
    'id' => 'footer-sidebar-1',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
    ) );
  register_sidebar( array(
    'name' => 'Footer Sidebar 2',
    'id' => 'footer-sidebar-2',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );
  register_sidebar( array(
    'name' => 'Footer Sidebar 3',
    'id' => 'footer-sidebar-3',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );
  register_sidebar( array(
    'name' => 'Footer Sidebar 4',
    'id' => 'footer-sidebar-4',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );

  // Enable shortcodes in html widgets
  add_filter('widget_text','do_shortcode');
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
		        <option value="bright-background" <?php selected($bgColor, 'bright-background'); ?> >Primary Color</option>
		        <option value="alt-background" <?php selected($bgColor, 'alt-background'); ?> >Secondary Color</option>
		    </select>
		</p>
    <?php

    // Show heading or not
    ?>
    	<p>
	    	<label for="sscy_show_heading">Show the page heading</label><br />
	    	<label for="sscy_show_heading_yes">Yes <input type="radio" name="sscy_show_heading" id="sscy_show_heading_yes" value="yes" checked="checked" <?php checked($showHeading, 'yes'); ?>/></label>
	    	<label for="sscy_show_heading_np">No <input type="radio" name="sscy_show_heading" id="sscy_show_heading_no" value="no" <?php checked($showHeading, 'no'); ?> /></label>
	    </p>
    <?php
}

function save_page_options_callback( $post_id ) {

// Save the background color
  if (array_key_exists('sscy_background_color', $_POST)) {
    update_post_meta( $post_id, 'background-color', $_POST['sscy_background_color'] );
  }

// Save the show heading option
  if (array_key_exists('sscy_show_heading', $_POST)) {
      update_post_meta( $post_id, 'show-heading', $_POST['sscy_show_heading'] );
  }
}
add_action( 'save_post', 'save_page_options_callback' );

/* 
*	Register Styles and Scripts
*/
// Javascript
function sscy_register_js() {
  wp_register_script('sscy_javascript', get_template_directory_uri() . '/assets/js/common.js', array( 'jquery' ));
  wp_enqueue_script('jquery');
  wp_enqueue_script('sscy_javascript');   
}
add_action( 'init', 'sscy_register_js' );
// CSS
function sscy_register_css() {
    // Font Awesome
    wp_register_style( 'font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'font_awesome' ); 

    wp_register_style( 'google_fonts', 'https://fonts.googleapis.com/css?family=Crimson+Text:400i|Roboto:300,400' );
    wp_enqueue_style( 'google_fonts' );   
    
    wp_register_style( 'sscy_styles', get_template_directory_uri() . '/assets/css/style.min.css' );
    wp_enqueue_style( 'sscy_styles' );    

    wp_register_style( 'sscy_secondary_styles', get_template_directory_uri() . '/assets/css/secondary_style.css' );
    wp_enqueue_style( 'sscy_secondary_styles' ); 
}
add_action( 'wp_enqueue_scripts', 'sscy_register_css' );
// CSS
function sscy_register_admin_css() {
    // Font Awesome
    wp_register_style( 'font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
    wp_enqueue_style( 'font_awesome' ); 
}
add_action( 'admin_enqueue_scripts', 'sscy_register_admin_css' );

/*
*	Function to display child pages
*/
function sscy_list_child_pages() { 
  global $post; 
  
  $has_children = get_pages('child_of=' . $post->ID);
	 
	if ( is_page() && $has_children ){
      $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
      $parent_url = '<li class="page_item page-item-' . $post->ID . '"><a href="' . get_page_link($post) . '">' . get_the_title($post) . '</a>';
  } else {
      $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
      $parent_url = '<li class="page_item page-item-' . $post->post_parent . '"><a href="' . get_page_link($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>';      
  }

	if ( $childpages ) 
	    $string = '<h4>Links</h4><ul class="list-group" id="child-pages">' . $parent_url . $childpages . '</ul>';
	else 
    $string = '';
  
  return $string;
}

function sscy_custom_sidebar() {
  register_sidebar(
      array (
          'name' => __( 'Sidebar', 'SSCY' ),
          'id' => 'sscy-side-bar',
          'description' => __( 'Custom Sidebar', 'SSCY' ),
          'before_widget' => '<div class="widget-content">',
          'after_widget' => "</div>",
          'before_title' => '<h4 class="widget-title">',
          'after_title' => '</h4>',
      )
  );
}
add_action( 'widgets_init', 'sscy_custom_sidebar' );


 // ------------------------------------------------------------------
 // Add all your sections, fields and settings during admin_init
 // ------------------------------------------------------------------
 //
 
 function sscy_setting_api_init() {
  // Add the section to reading settings so we can add our
  // fields to it
  add_settings_section(
    'sscy_social_media_setting_section',
    'Social Media Links',
    'sscy_social_media_setting_section_callback_function',
    'general'
  );
  
  // Add the field with the names and function to use for our new
  // settings, put it in our new section
  //FACEBOOK
  add_settings_field(
    'facebook_setting_name',
    'Facebook URL',
    'sscy_facebook_setting_callback_function',
    'general',
    'sscy_social_media_setting_section'
  );
  register_setting( 'general', 'facebook_setting_name' );
  // TWITTER
  add_settings_field(
    'twitter_setting_name',
    'Twitter URL',
    'sscy_twitter_setting_callback_function',
    'general',
    'sscy_social_media_setting_section'
  );
  register_setting( 'general', 'twitter_setting_name' );  
  // YOUTUBE
  add_settings_field(
    'youtube_setting_name',
    'YouTube URL',
    'sscy_youtube_setting_callback_function',
    'general',
    'sscy_social_media_setting_section'
  );
  register_setting( 'general', 'youtube_setting_name' );
  // INSTAGRAM
  add_settings_field(
    'instagram_setting_name',
    'Instagram URL',
    'sscy_instagram_setting_callback_function',
    'general',
    'sscy_social_media_setting_section'
  );
  register_setting( 'general', 'instagram_setting_name' );  
  // PINTEREST
  add_settings_field(
    'pinterest_setting_name',
    'Pinterest URL',
    'sscy_pinterest_setting_callback_function',
    'general',
    'sscy_social_media_setting_section'
  );
  register_setting( 'general', 'pinterest_setting_name' );

 } // sscy_setting_api_init()

 
 add_action( 'admin_init', 'sscy_setting_api_init' );
 
  
 // ------------------------------------------------------------------
 // Settings section callback function
 // ------------------------------------------------------------------
 //
 // This function is needed if we added a new section. This function 
 // will be run at the start of our section
 //
 
 function sscy_social_media_setting_section_callback_function() {
  echo '<p>Enter your social media links here and then use the shortcode [sscy_socialmedia] to display them on the site.</p>';
 }
 
 // ------------------------------------------------------------------
 // Callback function for our example setting
 // ------------------------------------------------------------------
 //
 // creates a checkbox true/false option. Other types are surely possible
 //
 
 function sscy_facebook_setting_callback_function() {
  echo '<input name="facebook_setting_name" id="facebook_setting_name" type="text" class="regular-text" value="' . get_option( 'facebook_setting_name' ) . '" /> <i class="fa fa-facebook-square"></i>';
 }
  function sscy_twitter_setting_callback_function() {
  echo '<input name="twitter_setting_name" id="twitter_setting_name" type="text" class="regular-text" value="' . get_option( 'twitter_setting_name' ) . '" /> <i class="fa fa-twitter-square"></i>';
 }
  function sscy_youtube_setting_callback_function() {
  echo '<input name="youtube_setting_name" id="youtube_setting_name" type="text" class="regular-text" value="' . get_option( 'youtube_setting_name' ) . '" /> <i class="fa fa-youtube-square"></i>';
 }
  function sscy_instagram_setting_callback_function() {
  echo '<input name="instagram_setting_name" id="instagram_setting_name" type="text" class="regular-text" value="' . get_option( 'instagram_setting_name' ) . '" /> <i class="fa fa-instagram"></i>';
 }
 function sscy_pinterest_setting_callback_function() {
  echo '<input name="pinterest_setting_name" id="pinterest_setting_name" type="text" class="regular-text" value="' . get_option( 'pinterest_setting_name' ) . '" /> <i class="fa fa-pinterest"></i>';
 }


// Short code for Social Media
function sscy_socialmedia_shortcode(){
  ob_start();
  ?> 
    <ul class="socialmedia_links">
      <?php if( get_option( 'facebook_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'facebook_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Facebook" target="_blank"><i class="fa fa-facebook-square"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'twitter_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'twitter_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Twitter" target="_blank"><i class="fa fa-twitter-square"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'youtube_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'youtube_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on YoutTube" target="_blank"><i class="fa fa-youtube-square"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'instagram_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'instagram_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Instagram" target="_blank"><i class="fa fa-instagram"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'pinterest_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'pinterest_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Pinterest" target="_blank"><i class="fa fa-pinterest"></i></a></li>
      <?php } ?>
    </ul>
  <?php
  return ob_get_clean();
}
add_shortcode( 'sscy_socialmedia', 'sscy_socialmedia_shortcode' );

// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
  global $post;
  return '&nbsp;<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more >>></a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function custom_excerpt_length( $length ) {
  return 40;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );


/* ADD SSCY JOB POSTINGS - Want to change this to just use the plugin */
require_once( 'inc/sscy-job.php' );

/* ADD SSCY HEADER BANNERS */
require_once( 'inc/sscy-banner.php' );

function sscy_section_shortcode($atts = [], $content = null)
{
    $content = '<div class="sscy-spaced">' . do_shortcode($content) . '</div>';

    return $content;
}
add_shortcode('sscy_section', 'sscy_section_shortcode');

// For Registration Software
add_action("gform_after_submission", "save_form_to_file", 10, 2);
date_default_timezone_set('America/Los_Angeles');
function save_form_to_file($entry, $form) {
  $filename = $form['id'] . '.';
  $filename .= time();
  $filename .= rand(1,100000);
  $myFile = "/home/saltspringcentre/public_html/new_registrations/{$filename}.csv";
  $fh = fopen($myFile, 'w');
  fputcsv($fh, array($form['title']), ',', '"');
  fputcsv($fh, array($entry['date_created'].' UTC'), ',', '"');
  fputcsv($fh, array('field_id', 'name', 'value'), ',', '"');
  foreach($form['fields'] as $field) {
    if ($field['inputs']) {
      foreach($field['inputs'] as $input) {
        $name = $field['label'].' - '.$input['label'];
        $field_id   = $input['id'];
        if ($name && $field_id) {
          $value      = $entry["$field_id"];
          fputcsv($fh, array($field_id, $name, $value), ',', '"');
        }
      }
    } else {
      $name = $field['label'];
      $field_id   = $field['id'];
      if ($name && $field_id) {
        $value      = $entry[$field_id];
        fputcsv($fh, array($field_id, $name, $value), ',', '"');
      }
    }
  }
  fclose($fh);
}

// Short code for Gravity Form Button
function sscy_gform_button_shortcode( $atts = [] ){
  $text = $atts['text'];
  $FID = get_post_meta($atts['fid'], 'gravity_form_id', true);

  ob_start();
  ?> 
    <a class="button" href="http://www.saltspringcentre.com/form/?fid=<?php echo $FID; ?>"><?php echo $text; ?></a>
  <?php
  return ob_get_clean();
}
add_shortcode( 'sscy_form_button', 'sscy_gform_button_shortcode' );

// This file will log gravity form errors if uncommented
require_once( 'inc/gravity-forms.php' );


