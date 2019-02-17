<?php
/**
 * Salt Spring Centre Theme functions and definitions
 *
 * @package SSCY
 * @subpackage Salt_Spring_Centre_Theme
 * @since Salt Spring Centre Theme 2.0
 *
 *  1. MAIN THEME SETUP
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

  /* THEME MENUS */
	// Add another menu to the array to add more menus to this theme
	register_nav_menus( array(
    'primary-menu' => __( 'Primary Menu' ),
    'secondary-menu' => __( 'Secondary Menu' ),
    'ytt-menu' => __( 'YTT Menu' )
	) );

  /* WIDGETS */
  // First Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 1',
    'id' => 'footer-sidebar-1',
    'description' => 'Appears in the footer area',
    'before_widget' => '<div class="footer__widget">',
    'after_widget' => '</div>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
    ) );

  // Second Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 2',
    'id' => 'footer-sidebar-2',
    'description' => 'Appears in the footer area',
    'before_widget' => '<div class="footer__widget">',
    'after_widget' => '</div>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );

  // Third Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 3',
    'id' => 'footer-sidebar-3',
    'description' => 'Appears in the footer area',
    'before_widget' => '<div class="footer__widget">',
    'after_widget' => '</div>',
    'before_title' => '<h6 class="widget-title">',
    'after_title' => '</h6>',
  ) );

  // Fourth Footer Widget
  register_sidebar( array(
    'name' => 'Footer Sidebar 4',
    'id' => 'footer-sidebar-4',
    'description' => 'Appears in the footer area',
    'before_widget' => '<div class="footer__widget">',
    'after_widget' => '</div>',
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

/*********************************
  2. REGISTER STYLES AND SCRIPTS
**********************************/
// Javascript
function sscy_register_js() {
  // Register
  wp_register_script('sscy_javascript', get_template_directory_uri() . '/dist/bundle.js', array( 'jquery' ), '1.0', true);
  wp_register_script('fontawesome', get_template_directory_uri() . '/js/vendor/font-awesome/fontawesome-all.min.js');
  wp_register_script('aos', 'https://unpkg.com/aos@2.3.1/dist/aos.js', '', '2.3.1', true);

  // Enqueue
  wp_enqueue_script('jquery');
  wp_enqueue_script('fontawesome');
  wp_enqueue_script('aos');
  wp_enqueue_script('sscy_javascript');

}
add_action( 'init', 'sscy_register_js' );

// CSS
function sscy_register_css() {
    // Register
    wp_register_style( 'google_fonts', 'https://fonts.googleapis.com/css?family=Crimson+Text:300,300i,400,400i,500,500i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i' );
    wp_register_style( 'sscy_styles', get_template_directory_uri() . '/dist/css/style.css' );
    wp_register_style( 'aos', 'https://unpkg.com/aos@2.3.1/dist/aos.css');

    // Enqueue
    wp_enqueue_style( 'google_fonts' );
    wp_enqueue_style( 'sscy_styles' );
    wp_enqueue_style( 'aos' );

}
add_action( 'wp_enqueue_scripts', 'sscy_register_css' );

/***************************************
  3. REGISTER ADMIN STYLES AND SCRIPTS
***************************************
function sscy_register_admin_css() {
    // Register
    wp_register_style( 'font_awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );

    // Enqueue
    wp_enqueue_style( 'font_awesome' );
}
add_action( 'admin_enqueue_scripts', 'sscy_register_admin_css' );*/

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
  echo '<input name="facebook_setting_name" id="facebook_setting_name" type="text" class="regular-text" value="' . get_option( 'facebook_setting_name' ) . '" /> <i class="fab fa-facebook-square"></i>';
 }
  function sscy_twitter_setting_callback_function() {
  echo '<input name="twitter_setting_name" id="twitter_setting_name" type="text" class="regular-text" value="' . get_option( 'twitter_setting_name' ) . '" /> <i class="fab fa-twitter-square"></i>';
 }
  function sscy_youtube_setting_callback_function() {
  echo '<input name="youtube_setting_name" id="youtube_setting_name" type="text" class="regular-text" value="' . get_option( 'youtube_setting_name' ) . '" /> <i class="fab fa-youtube-square"></i>';
 }
  function sscy_instagram_setting_callback_function() {
  echo '<input name="instagram_setting_name" id="instagram_setting_name" type="text" class="regular-text" value="' . get_option( 'instagram_setting_name' ) . '" /> <i class="fab fa-instagram"></i>';
 }
 function sscy_pinterest_setting_callback_function() {
  echo '<input name="pinterest_setting_name" id="pinterest_setting_name" type="text" class="regular-text" value="' . get_option( 'pinterest_setting_name' ) . '" /> <i class="fab fa-pinterest"></i>';
 }

/*******************************************
  9. SHORTCODES
********************************************/

// Social Media
function sscy_socialmedia_shortcode(){
  ob_start();
  ?>
    <ul class="socialmedia_links">
      <?php if( get_option( 'facebook_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'facebook_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Facebook" target="_blank"><i class="fab fa-facebook-square"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'twitter_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'twitter_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Twitter" target="_blank"><i class="fab fa-twitter-square"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'youtube_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'youtube_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on YoutTube" target="_blank"><i class="fab fa-youtube-square"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'instagram_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'instagram_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Instagram" target="_blank"><i class="fab fa-instagram"></i></a></li>
      <?php } ?>
      <?php if( get_option( 'pinterest_setting_name' ) != '' ) { ?>
        <li><a href="<?php echo get_option( 'pinterest_setting_name' ) ?>" class="sscy-socialmedia-link" title="Find us on Pinterest" target="_blank"><i class="fab fa-pinterest"></i></a></li>
      <?php } ?>
    </ul>
  <?php
  return ob_get_clean();
}
add_shortcode( 'sscy_socialmedia', 'sscy_socialmedia_shortcode' );

// Remove hard coded thumbnail sizes
function remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10, 3 );

// SSCY - Yoga Schedule
function sscy_yoga_schedule( $atts = [] ){
  require_once( 'sscy/yoga_schedule.php' );
}
add_shortcode( 'yoga_schedule', 'sscy_yoga_schedule' );

// SSCY - Yoga Schedule
function sscy_teachers( $atts = [] ){
  require_once( 'sscy/teachers.php' );
}
add_shortcode( 'teachers', 'sscy_teachers' );

/*******************************************************************************************

  10. SSCY JOB POSTINGS

  // Custom Job Posting management for SSCY
  {*** move this in to its own plugin ***}

********************************************************************************************/
require_once( 'inc/sscy-job.php' );

/* ADD SSCY HEADER BANNERS */
require_once( 'inc/sscy-banner.php' );

/*******************************************************************************************

  11. GRAVITY FORMS

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

/*******************************************************************************************

  12. UTILITIES

  // Utility functions

********************************************************************************************/
function sscyDB(){
  global $sscy_database;
  $sscy_database = new wpdb('root','','saltspri_internal','localhost');
}
add_action('init','sscyDB');

function displayDate($date){
  return date('l, F j, Y', $date);
}



  /* CUSTOM VARIABLES */

  // Add custom variables {*** I think this is for Gravity Forms, need to check ***}

  function add_query_vars_filter( $vars ){

    $vars[] = "fid";

    return $vars;

  }

  add_filter( 'query_vars', 'add_query_vars_filter' );



// This file will log gravity form errors if uncommented

require_once( 'inc/gravity-forms.php' );