<?php
/**
 * Salt Spring Centre Theme functions and definitions
 *
 * @package SSCY
 * @subpackage Salt_Spring_Centre_Theme
 * @since Salt Spring Centre Theme 1.0
 * 
 *  1. MAIN THEME SETUP
 *  2. THEME OPTIONS METABOX
 *  3. THEME OPTIONS CALLBACK
 *  4. REGISTER STYLES AND SCRIPTS
 *  5. REGISTER ADMIN STYLES AND SCRIPTS
 *  6. DISPLAY CHILD PAGE LINKS
 *  7. THEME SETTINGS
 *  8. CALLBACK FUNCTIONS FOR THEME SETTINGS
 *  9. SHORTCODES
 *  10. MINDBODY
 *  11.
 *  12. 
 * 
 */

/******************************	
  1. MAIN THEME SETUP
*******************************/
function sscy_theme_setup(){

  /* THEME OPTIONS */
  // Add Featured Image Support
  add_theme_support( 'post-thumbnails' ); 

  // Enable shortcodes in html widgets
  add_filter('widget_text','do_shortcode');

  // Add custom page options to the page editor. Shows up in the top right of the editor
    // Background-color
    // Show Page Heading
  function page_options_meta_box() {
      add_meta_box( 
        'page-options-meta-box', 
        'Page Options', 
        'page_options_meta_box_callback', 
        'page', 
        'side', 
        'high' 
      );
  }
  add_action( 'add_meta_boxes', 'page_options_meta_box' );

  /* EXCERPTS */
  // Replaces the excerpt "Read More" text by a link
  function new_excerpt_more($more) {
    global $post;
    return '&nbsp;<a class="moretag" href="'. get_permalink($post->ID) . '"> Read more >>></a>';
  }
  add_filter('excerpt_more', 'new_excerpt_more');

  // Change the standard length for excerts
  function custom_excerpt_length( $length ) {
    return 40;
  }
  add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

  /* CUSTOM VARIABLES */
  // Add custom variables {*** I think this is for Gravity Forms, need to check ***}
  function add_query_vars_filter( $vars ){
    $vars[] = "fid";
    return $vars;
  }
  add_filter( 'query_vars', 'add_query_vars_filter' );    

  /* THEME MENUS */
	// This theme uses wp_nav_menu() in one location (where...?).
	// Add another menu to the array to add more menus to this theme
	register_nav_menus( array(
		'primary-menu' => __( 'Primary Menu' )
	) );

  /* WIDGETS */
  // First Footer Widget
  register_sidebar( array(                                  
    'name' => 'Footer Sidebar 1',
    'id' => 'footer-sidebar-1',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
    ) ); 

  // Second Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 2',
    'id' => 'footer-sidebar-2',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );

  // Third Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 3',
    'id' => 'footer-sidebar-3',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );

  // Fourth Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 4',
    'id' => 'footer-sidebar-4',
    'description' => 'Appears in the footer area',
    'before_widget' => '<li class="footer-widget">',
    'after_widget' => '</li>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );

  /* SIDEBAR */
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
}
add_action( 'after_setup_theme', 'sscy_theme_setup' );  


/******************************	
  2. THEME OPTIONS METABOX
*******************************/
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

/******************************	
  3. THEME OPTIONS CALLBACK
*******************************/
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

/*********************************	
  4. REGISTER STYLES AND SCRIPTS
**********************************/
// Javascript
function sscy_register_js() {
  // Register
  wp_register_script('sscy_javascript', get_template_directory_uri() . '/assets/js/common.js', array( 'jquery' ));
  wp_register_script('mindbody', 'https://widgets.healcode.com/javascripts/healcode.js');
  wp_register_script('fontawesome', get_template_directory_uri() . '/vendor/fontawesome-all.min.js');

  // Enqueue
  wp_enqueue_script('jquery');
  wp_enqueue_script('sscy_javascript');   
  wp_enqueue_script('mindbody');   
  wp_enqueue_script('fontawesome');   
}
add_action( 'init', 'sscy_register_js' );
// CSS
function sscy_register_css() {
    // Register
    wp_register_style( 'font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
    wp_register_style( 'google_fonts', 'https://fonts.googleapis.com/css?family=Crimson+Text:400i|Roboto:300,400' );
    wp_register_style( 'sscy_styles', get_template_directory_uri() . '/assets/css/style.min.css' );

    // Enqueue
    wp_enqueue_style( 'font_awesome' ); 
    wp_enqueue_style( 'google_fonts' );   
    wp_enqueue_style( 'sscy_styles' );    
}
add_action( 'wp_enqueue_scripts', 'sscy_register_css' );

/***************************************	
  5. REGISTER ADMIN STYLES AND SCRIPTS
****************************************/
function sscy_register_admin_css() {
    // Register
    wp_register_style( 'font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );

    // Enqueue
    wp_enqueue_style( 'font_awesome' ); 
}
add_action( 'admin_enqueue_scripts', 'sscy_register_admin_css' );

/*******************************************************
    
  6. DISPLAY CHILD PAGE LINKS

  If the current post is a page and it has children, 
  show the list of child links in an unordered list,
  otherwise show this pages > parents > children 
  (siblings) Depending on if we need to display children
  or siblings, we also need to add either the current 
  page link or the parents page link to the start of the 
  list.

*********************************************************/
function sscy_list_child_pages() { 
  global $post; 
  
  // Find out if the page has children
  $has_children = get_pages('child_of=' . $post->ID);
  
  // If this is a page and it has children, show the list of links, otherwise show siblings
	if ( is_page() && $has_children ){
      // Get the children
      $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->ID . '&echo=0' );
      // Set the parent url to be the current page
      $parent_url = '<li class="page_item page-item-' . $post->ID . '"><a href="' . get_page_link($post) . '">' . get_the_title($post) . '</a>';
  } else {
      // Get the parents children
      $childpages = wp_list_pages( 'sort_column=menu_order&title_li=&child_of=' . $post->post_parent . '&echo=0' );
      // Set the parent url to be the current pages parent
      $parent_url = '<li class="page_item page-item-' . $post->post_parent . '"><a href="' . get_page_link($post->post_parent) . '">' . get_the_title($post->post_parent) . '</a>';      
  }

  // Create the DOM element string including the heading, or return nothing
	if ( $childpages ) 
	    $string = '<h4>Links</h4><ul class="list-group" id="child-pages">' . $parent_url . $childpages . '</ul>';
	else 
    $string = '';
  
  return $string;
}

/**********************	
  7. THEME SETTINGS

  {*** I would like to move these out of here and in to the theme options ***}
***********************/
function sscy_setting_api_init() {
  // Add the section to general settings so we can add our fields to it
  add_settings_section(
    'sscy_social_media_setting_section',
    'Social Media Links',
    'sscy_social_media_setting_section_callback_function',
    'general'
  );

  // FACEBOOK
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
}
add_action( 'admin_init', 'sscy_setting_api_init' );
 
/*******************************************	
  8. CALLBACK FUNCTIONS FOR THEME SETTINGS
********************************************/
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

/*******************************************	
  9. SHORTCODES
********************************************/
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

/*******************************************************************************************	
  
  10. MINDBODY

  // Mind Body Integration, custom shortcode built by BurtonMedia
  {*** move this in to its own file sometime, all Mind Body stuff ***}

********************************************************************************************/
function mindbody_shortcode( $atts = [] ){
  $type = $atts['type'];
  $partner = $atts['partner'];
  $id = $atts['id'];
  $version = $atts['version'];

  ob_start();
  ?> 
    <healcode-widget data-type="<?php echo $type; ?>" data-widget-partner="<?php echo $partner; ?>" data-widget-id="<?php echo $id; ?>" data-widget-version="<?php echo $version; ?>"></healcode-widget>
  <?php
  return ob_get_clean();
}
add_shortcode( 'mindbody_widget', 'mindbody_shortcode' );

/*******************************************************************************************	
  
  11. SSCY JOB POSTINGS

  // Custom Job Posting management for SSCY
  {*** move this in to its own plugin ***}

********************************************************************************************/
require_once( 'inc/sscy-job.php' );

/* ADD SSCY HEADER BANNERS */
require_once( 'inc/sscy-banner.php' );

/*******************************************************************************************	
  
  12. GRAVITY FORMS

  // Gravity Form Integration - built by BurtonMedia
  {*** move this in to its own plugin sometime, all Gravity Form stuff ***}

********************************************************************************************/
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


