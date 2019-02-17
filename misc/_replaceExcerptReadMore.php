<?php
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
?>