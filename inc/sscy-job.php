<?php

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
    'taxonomies'        => array('category', 'post_tag'),
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
  require_once( 'sscy-job-fields.php' );    

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

    if( isset($_POST['custom_editor_1']) ){
      update_post_meta( $post_id, 'responsibilities', $_POST['custom_editor_1'] );
    }
    if( isset($_POST['custom_editor_2']) ){
      update_post_meta( $post_id, 'conditions', $_POST['custom_editor_2'] );  
    }
    if( isset($_POST['active']) ){  
      update_post_meta( $post_id, 'active', 1 );
    } else {
      update_post_meta( $post_id, 'active', 0 );
    }
    if( isset($_POST['gravity_form_id']) ){  
      update_post_meta( $post_id, 'gravity_form_id', $_POST['gravity_form_id'] );
    }

}
add_action( 'save_post', 'job_save_meta_data' );

