<?php

/*
  =======================================================
  Custom Post Types
  =======================================================
*/
function banner_custom_post_type(){
  $singular = "Banner";
  $plural = "Banners";

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
    'hierarchical'      => false,
    'supports'           => array (
      'title',
      'editor',
      'page-attributes',
      'thumbnail'
    ),
    'menu_position'     => 6,
    'exlude_from_search'=> false
  );
  register_post_type( 'banner', $args );
}
add_action( 'init', 'banner_custom_post_type' );

/*
  =======================================================
  Custom Post Type Meta Boxes
  =======================================================
*/

function banner_custom_meta_boxes(){
  require_once( 'sscy-banner-fields.php' );

  // Define the custom attachment for pages
  add_meta_box(
      'sscy_banner_link',   // Unique ID
      'Banner Button',      // Box Title
      'sscy_banner_link',   // Content Callback
      'banner'              // Post Type
  );
}
add_action( 'add_meta_boxes', 'banner_custom_meta_boxes' );

/*
  =======================================================
  Save Custom Post Type Meta Data
  =======================================================
*/
function banner_save_meta_data( $post_id ) {
    // !!!!!NONCE NOT WORKING NEED TO FIX!!!!!!

    /*
    // Checks save status
    $is_autosave  = wp_is_post_autosave( $post_id );
    $is_revision  = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST['sscy_jobs_nonce'] ) && wp_verify_nonce( $_POST['sscy_jobs_nonce'], basename(__FILE__) ) ) ? 'true' : 'false';

    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
      die();
      return;
    }

    */

    if( isset($_POST['banner_url']) ){
      update_post_meta( $post_id, 'banner_url', $_POST['banner_url'] );
    }
    if( isset($_POST['banner_url_text']) ){
      update_post_meta( $post_id, 'banner_url_text', $_POST['banner_url_text'] );
    } else {
      update_post_meta( $post_id, 'banner_url_text', "Learn More" );
    }

}
add_action( 'save_post', 'banner_save_meta_data' );

