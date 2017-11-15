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
	    	<label for="sscy_show_heading_yes">Yes <input type="radio" name="sscy_show_heading" id="sscy_show_heading_yes" value="yes" <?php checked($showHeading, 'yes'); ?>/></label>
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
 	wp_register_script('sscy_javascript', get_template_directory_uri() . '/assets/js/common.js', 'common');
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
    
    wp_register_style( 'sscy_styles', get_template_directory_uri() . '/assets/css/style.css' );
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


/*
  =======================================================
  Custom Post Types
  =======================================================
*/
  function job_custom_post_type(){
    $singular = "Job Posting";
    $plural = "Job Postings";
    
    $labels = array(
      'name'        => $plural,
      'singular_name'   => $singular,
      'add_name'      => 'Add New',
      'add_new_item'    => 'Add New ' . $singular,
      'edit'        => 'Edit',
      'edit_item'     => 'Edit ' . $singular,
      'new_item'      => 'New ' . $singular,
      'view'        => 'View ' . $singular,
      'view_item'     => 'View ' . $singular,
      'search_term'   => 'Search ' . $plural,
      'parent'      => 'Parent ' . $singular,
      'not_found'     => 'No ' . $plural . ' found',
      'not_found_in_trash'=> 'No ' . $plural . ' found in trash'
    );
    
    $args = array( 
      'labels'            => $labels,
      'public'            => true,
      'has_archive'       => true,
      'publicly_queyable' => true,
      'query_var'         => true,
      'rewrite'           => true,
      'capability_type'   => 'post',
      'hierarchical'      => true,
      'supports'           => array (
        'title',
        'editor'
      ),
      'taxonimies'        => array('category', 'post_tag'),
      'menu_position'     => 5,
      'exlude_from_search'=> false
    );
    register_post_type( 'job', $args );
  }
add_action( 'init', 'job_custom_post_type' );


/*
  =======================================================
  Custom Post Type Meta Boxes
  =======================================================
*/

  function job_custom_meta_boxes(){
    require_once( 'inc/sscy-job-fields.php' );    

    // Define the custom attachment for pages
    add_meta_box(
        'sscy_jobs_responsibilities_and_qualifications',   // Unique ID
        'Responsibilities & Qualifications',               // Box Title
        'sscy_jobs_responsibilities_and_qualifications',   // Content Callback
        'job'                                              // Post Type
    );

    // Define the custom attachment for pages
    add_meta_box(
        'sscy_jobs_working_conditions',
        'Working Conditions',
        'sscy_jobs_working_conditions',
        'job'
    );    

    // Define the custom attachment for pages
    add_meta_box(
        'sscy_jobs_options',
        'Options',
        'sscy_jobs_options',
        'job'
    );
  }
add_action( 'add_meta_boxes', 'job_custom_meta_boxes' );

/*
  =======================================================
  Save Custom Post Type Meta Data
  =======================================================
*/
  function job_save_meta_data( $post_id ) {
    // Checks save status
    $is_autosave  = wp_is_post_autosave( $post_id );
    $is_revision  = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['sscy_jobs_nonce'] ) && wp_verify_nonce( $_POST['sscy_jobs_nonce'], basename(__FILE__) ) ) ? 'true' : 'false';  
      
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
      die();
      return; 
    }   

      update_post_meta( $post_id, 'responsibilities', $_POST['custom_editor_1'] );
      update_post_meta( $post_id, 'conditions', $_POST['custom_editor_2'] );    
      update_post_meta( $post_id, 'active', isset( $_POST['active'] ) );

  }
add_action( 'save_post', 'job_save_meta_data' );  