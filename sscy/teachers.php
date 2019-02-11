<?php

  // Set up the database connection
  require_once('mysqli_connect.php');

  // Include the utility functions
  require_once('utilities.php');

  $qry_teachers = $sscy_database->get_results( "
    SELECT t.teacher_id as id, t.account_id, t.default_price, t.waiver, t.bio, t.photo, CONCAT(a.name_first, ' ', a.name_last) as name
    FROM teacher_tbl t
    INNER JOIN account_tbl a ON t.account_id = a.account_id
    WHERE teacher_id IN (SELECT teacher_id FROM class_tbl WHERE class_id IN (SELECT class_id from class_weekly_schedule_tbl))
    ORDER BY a.name_first
  " );

?><div class="teacher-page"><?php

  foreach( $qry_teachers as $teacher ){
    ?>
      <div class="teacher" id="teacher-<?php echo $teacher->id; ?>">
        <div class="teacher__photo">
          <div
            class="teacher__photo-container"
            style="background-image: url('<?php echo $teacher->photo; ?>');">
          </div>
        </div>
        <div class="teacher__content">
          <h2><?php echo $teacher->name; ?></h2>
          <div class="teacher__bio"><?php echo nl2br($teacher->bio); ?></div>
        </div>
      </div>

    <?php
  }

?></div>
