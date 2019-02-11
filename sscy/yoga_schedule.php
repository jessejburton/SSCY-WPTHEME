<?php

    // Set up the database connection
    require_once('mysqli_connect.php');

    // Include the utility functions
    require_once('utilities.php');

    $qry_classes = $sscy_database->get_results( "
            SELECT
                c.class_id AS class_id, c.name, c.description, cs.room_id, c.teacher_id,
                cs.days_of_week, cs.start_time, cs.end_time, cs.date_until, cs.date_from,
                t.teacher_id, t.account_id, t.default_price, t.waiver, t.bio, t.photo,
                a.name_first, a.name_last,
                r.name AS room_name, r.photo AS room_photo, r.description AS room_description
            FROM class_weekly_schedule_tbl cs
            INNER JOIN class_tbl c ON c.class_id = cs.class_id
            LEFT JOIN teacher_tbl t ON c.teacher_id = t.teacher_id
            LEFT JOIN account_tbl a ON t.account_id = a.account_id
            LEFT JOIN room_tbl r ON r.room_id = cs.room_id
            WHERE cs.date_until IS NULL OR cs.date_until >= CURDATE()
            ORDER BY cs.start_time
    " );

    // When I put this on the server it seems to need to have a fully
    // set up array to work. It errors on any items that don't have
    // classes otherwise
    $arr_classes = [];
    $arr_classes[0] = [];
    $arr_classes[1] = [];
    $arr_classes[2] = [];
    $arr_classes[3] = [];
    $arr_classes[4] = [];
    $arr_classes[5] = [];
    $arr_classes[6] = [];

    $arr_teachers = [];

    foreach( $qry_classes as $class ){
        $days = explode(",", $class->days_of_week);

        foreach( $days as $day ){
            if (!array_key_exists($day, $arr_classes)) {
                $arr_classes[$day] = [];
            }
            array_push($arr_classes[$day], $class);
        }

        $teacher = [];
        $arr_teachers[$class->account_id] = [];
        $teacher["name"] = $class->name_first . ' ' . $class->name_last;
        $teacher["bio"] = $class->bio;
        $teacher["photo"] = $class->photo;
        $teacher["id"] = $class->teacher_id;
        array_push($arr_teachers[$class->account_id], $teacher);
    }

    // Check if a date has been passed in
    if( isset($_GET["datestart"]) && date('w', $_GET["datestart"]) == 0 ){
        $current_date = date($_GET["datestart"]);
    } else {
        $today = date('w');
        $current_date = date(strtotime('-'.$today.' days'));
    }

    ?>

    <!-- Set some variables if a cookie exists and add a heading -->
    <?php

        if(!isset($_COOKIE["name_first"])) {
            $name_first = "";
            $name_last = "";
            $email = "";
        } else {
            $name_first = $_COOKIE["name_first"];
            $name_last = $_COOKIE["name_last"];
            $email = $_COOKIE["email"];

            ?>
                <h4 class="heading__schedule">
                    Hi
                    <span class="heading__schedule-name"><?php echo $name_first; ?></span>!
                    | <a href="javascript:void(0);" class="heading__schedule-link logout">logout</a>
                </h4>
            <?php
        }

    ?>

<div class="yoga-schedule">

    <!-- PRICING - Setting up the pricing display -->
    <?php
    $qry_prices = $sscy_database->get_results( "
        SELECT default_price AS price, CONCAT(a.name_first, ' ', a.name_last) AS name
        FROM teacher_tbl t
        INNER JOIN account_tbl a ON a.account_id = t.account_id
        WHERE default_price != ''
        ORDER BY a.name_first
    " );
    ?>

    <h2 class="teachers__heading">Meet Our Teachers</h2>
    <div class="teachers">
      <?php foreach( $arr_teachers as $teacher ){ ?>
        <div class="teacher" onclick="window.location='our-teachers/#teacher-<?php echo $teacher[0]["id"]; ?>'">
          <div
            class="teacher__image"
            style="background-image: url('<?php echo $teacher[0]["photo"]; ?>');">
            <div class="teacher__name-container">
              <div class="teacher__name">
                <?php echo $teacher[0]["name"]; ?>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>

    <p style="text-align: center;"><strong>*** Online Registration now available ***</strong><br /> Please consider pre-registering for your classes online. It is as simple as clicking register and entering your name and e-mail. Once you have registered once your information will be saved for next time on this device! This will save you from having to write your name out when you get to class and it also helps us save paper.</p>

    <p style="text-align: center;">Please click on the name of a class in the schedule to view a class description and location and the name of the teacher to view their bio.</p>

    <div class="legend">
      <div class="legend__prices">
        <table>
            <tr><th>Teacher</th><th>Price</th></tr>
            <?php foreach($qry_prices as $price){ ?>
                <tr><td><?php echo $price->name ?></td><td><?php echo $price->price; ?></td></tr>
            <?php } ?>
        </table>
      </div>
      <div class="legend__colors">
          Class cancelled <span class="cancelled box"></span><br />
          Room or Teacher change <span class="room_teacher_change box"></span><br />
          Information notice <span class="notice box"></span><br />
      </div>
    </div>

    <div class="schedule">
      <div class="schedule__navigation">
          <div class="prev">
            <a href="<?php echo get_permalink(); ?>?datestart=<?php echo strtotime('-7 days', $current_date); ?>">
              <i class="far fa-arrow-alt-circle-left"></i> previous week
            </a>
          </div>
          <div class="print">
            <a href="http://portal.saltspringcentre.com/print/yoga_schedule.php" target="_blank">
              <i class="fas fa-print"></i> print schedule
            </a>
          </div>
          <div class="next">
            <a href="<?php echo get_permalink(); ?>?datestart=<?php echo strtotime('+7 days', $current_date); ?>">
              next week <i class="far fa-arrow-alt-circle-right"></i>
            </a>
          </div>
      </div>

      <?php for ($i = 0; $i <= 6; $i++){ ?>

        <!-- Display the date heading -->
        <div class="schedule__date">
          <strong><?php echo date('l', $current_date); ?></strong>
          <em style="font-size: .8em;"><?php echo date('F jS, Y', $current_date); ?></em>
        </div>

        <div class="day"><!-- Start of Day Group -->
          <?php
            // get a counter for the classes shown, this way I can
            // add the No Classes afterwards if no classes were displayed.
            $classes_shown = 0;
            foreach ( $arr_classes[$i] as $class) {
              // Get any exceptions for this day
              $qry_exceptions = $sscy_database->prepare( "
              SELECT exception_id, class_id, exception_date, message, et.type, et.exception_type_id
              FROM class_exception_tbl ce
              INNER JOIN exception_type_tbl et ON et.exception_type_id = ce.exception_type_id
              WHERE   class_id = %d
              AND     exception_date = %s
              ", $class->class_id, date('Y-m-d', $current_date) );

              $qry_results = $sscy_database->get_results($qry_exceptions);
              $notice = false;
              if( sizeof($qry_results) === 1 ){
                $notice = true;
              }

              // Set up the times
              $start_time = date_create('2000-01-01 ' . $class->start_time)->format('g:iA');
              $end_time = date_create('2000-01-01 ' . $class->end_time)->format('g:iA');

              $show_class = true;
              /* Find out if the weekly schedule is over and hide it if it is */

              if(strlen($class->date_until) > 0){
                  $date_until = strtotime($class->date_until);
                  $dif = round(($date_until - $current_date) / 86400);

                  if($dif < 0){
                      // Hide the class
                      $show_class = false;
                  }
              }

              // Find out if the weekly schedule has started yet
              if(strlen($class->date_from) > 0){
                  $date_from = strtotime($class->date_from);
                  $dif = round(($current_date - $date_from) / 86400);

                  if($dif < 0){
                      // Hide the class
                      $show_class = false;
                  }
              }

              if($show_class){
                // Increment the classes shown by 1 for each class
                $classes_shown++;

                /* FIND OUT IF THE USER IS REGISTERED ALREADY */
                if(isset($_COOKIE["email"])){
                  $qry_registration = $sscy_database->prepare( "
                      SELECT registration_id
                      FROM registration_tbl
                      WHERE   class_id = %d
                      AND     email = %s
                      AND     date_class = %s
                  ", $class->class_id, $_COOKIE["email"], date('Y-m-d', $current_date) );

                  $qry_reg_results = $sscy_database->get_results($qry_registration);

                  $registered = false;
                  $registrationID = 0;
                  if(sizeof($qry_reg_results) == 1){
                      $registered = true;
                      $registrationID = $qry_reg_results[0]->registration_id;
                  }
                }
                ?>

                  <!-- Add the exception message if needed -->
                  <?php if( $notice ){ ?>
                      <div class="message <?php echo $qry_results[0]->type; ?>">
                        <span>***</span> <?php echo $qry_results[0]->message; ?> <span>***</span>
                      </div>
                  <?php } ?>

                  <div class="class class--<?php echo $class->class_id; ?> <?php echo $qry_results[0]->type; ?>">
                    <div class="class__name">
                      <a class="class__name-link" title="<?php echo $class->name; ?>">
                        <?php echo excerpt($class->name, 30); ?>
                      </a>
                    </div>
                    <div class="class__teacher">
                      <a class="class__teacher-link" title="<?php echo $class->name_first . ' ' . $class->name_last; ?>">
                        <?php echo $class->name_first . ' ' . $class->name_last; ?>
                      </a>
                    </div>
                    <div class="class__time">
                      <?php echo $start_time . ' - ' . $end_time; ?>
                    </div>
                    <div class="class__register">
                      <?php if(!$registered){ ?>
                          <a
                            class="button button--register"
                            data-class-name="<?php echo $class->name; ?>"
                            data-class-id="<?php echo $class->class_id; ?>"
                            data-class-date="<?php echo date('Y-m-d', $current_date); ?>" data-class-date-styled="<?php echo date('F jS, Y', $current_date); ?>">
                            register
                          </a>
                      <?php } else { ?>
                          <a
                            class="button button--register"
                            data-registration-id="<?php echo $registrationID; ?>"
                            data-class-name="<?php echo $class->name; ?>"
                            data-class-id="<?php echo $class->class_id; ?>"
                            data-class-date="<?php echo date('Y-m-d', $current_date); ?>" data-class-date-styled="<?php echo date('F jS, Y', $current_date); ?>">
                            un-register
                          </a>
                      <?php } ?>
                    </div>
                  </div><!-- Class End -->

                  <!-- Class Details -->
                  <div class="class__details <?php echo $qry_results[0]->type; ?>">
                    <div class="class__details-content">

                      <!-- Display Class Details -->
                        <h2><?php echo $class->name; ?></h2>
                        <p><?php echo $class->description; ?></p>
                        <?php
                          if(isset($class->default_price) ||
                          !is_null($class->default_price) ||
                          strlen($class->default_price > 1)) { ?>
                            <div class="class__price">
                              Price: <span><?php echo $class->default_price; ?></span>
                          </div>
                        <?php } ?>
                    </div>

                    <hr />

                    <div class="location">
                      <h4><small>in</small> <?php echo $class->room_name; ?></h4>
                      <div class="location__details">
                        <div class="location__photo">
                          <div class="location__photo-container" style="background-image: url('<?php echo $class->room_photo; ?>');"></div>
                        </div>
                        <div class="location__content">
                          <p><?php echo $class->room_description; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Teacher Details -->
                  <div class="class__details class__details--teacher">
                    <div class="teacher__heading"><h4><small>with</small> <?php echo $class->name_first . ' ' . $class->name_last; ?></h4></div>
                    <div class="teacher__details">
                      <div class="teacher__photo" onclick="window.location='our-teachers/#teacher-<?php echo $class->teacher_id; ?>'">
                        <div class="teacher__photo-container" style="background-image: url('<?php echo $class->photo; ?>');"></div>
                      </div>
                      <div class="teacher__content">
                        <p><?php echo $class->bio; ?></p>
                      </div>
                    </div>
                  </div>

                <?php } ?>
              <?php }

              if ($classes_shown == 0) { ?>
                <div class="class">
                  <div class="class--none">No Classes</div>
                </div>
              <?php } ?>

              </div><!-- End of Day Group -->

              <?php
              // Add one day to the current date being displayed.
              $current_date = date(strtotime('+1 days', $current_date));
            } ?>
      </div>