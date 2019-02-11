<?php
/* Title Trim - for Protected files */
  function the_title_trim($title) {

    $title = attribute_escape($title);

    $findthese = array(
      '#Protected:#'
    );

    $replacewith = array(
      '', // What to replace "Protected:" with
      '' // What to replace "Private:" with
    );

    $title = preg_replace($findthese, $replacewith, $title);
    return $title;
  }
  add_filter('the_title', 'the_title_trim');
?>