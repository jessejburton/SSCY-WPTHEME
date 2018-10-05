<?php

    // Set up the database connection
    require_once('mysqli_connect.php');

    // Include the utility functions
    require_once('utilities.php');

    $qry_classes = $sscy_database->get_results( "
            SELECT 
                c.class_id AS class_id, c.name, c.description, cs.room_id, c.teacher_id, 
                cs.days_of_week, cs.start_time, cs.end_time, cs.date_until,
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

    foreach( $qry_classes as $class ){
        $days = explode(",", $class->days_of_week);
        
        foreach( $days as $day ){
            if (!array_key_exists($day, $arr_classes)) {
                $arr_classes[$day] = [];
            }
            array_push($arr_classes[$day], $class);
        }

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

    <p style="text-align: center; font-weight: bold;">Please click on the name of a class in the schedule to view a class description and location.</p>

    <div style="padding: 10px 0; font-size: .8em; text-align: right;">
        Class cancelled <span class="cancelled u-box"></span><br />
        Room or Teacher change <span class="room_teacher_change u-box"></span><br />
        Information notice <span class="notice u-box"></span><br />
    </div>

        <p style="text-align: center;">
            <a href="http://portal.saltspringcentre.com/print/yoga_schedule.php" target="_blank"><i class="fas fa-print"></i> print schedule</a>
        </p>
    
        <table class="table table--class">
            <thead>
                <tr>
                    <th colspan="4" class="clearfix">
                        <a href="<?php echo get_permalink(); ?>?datestart=<?php echo strtotime('-7 days', $current_date); ?>" class="table__navigation-link table__navigation-link--prev">
                            <i class="far fa-arrow-alt-circle-left"></i> previous week
                        </a>
                        <a  class="
                    table__navigation-link table__navigation-link--next" href="<?php echo '/sandbox/yoga-schedule/'; ?>?datestart=<?php echo strtotime('+7 days', $current_date); ?>">
                            next week <i class="far fa-arrow-alt-circle-right"></i>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php for ($i = 0; $i <= 6; $i++){ ?>   
                    
                    <!-- Display the date heading -->
                    <tr class="class-date">
                        <td colspan="4"><strong style="text-transform: uppercase;"><?php echo date('l', $current_date); ?></strong> <em style="font-size: .8em;"><?php echo date('F jS, Y', $current_date); ?></em></td>
                    </tr>
                
                    <?php
                        // get a counter for the classes shown, this way I can 
                        // add the No Classes afterwards if no classes were displayed.
                        $classes_shown = 0;
                    ?>

                    <!-- Get the classes for the current day -->
                    <?php foreach ( $arr_classes[$i] as $class) { 

                        // Get any exceptions for this day
                        $qry_exceptions = $sscy_database->prepare( "
                            SELECT exception_id, class_id, exception_date, message, et.type, et.exception_type_id
                            FROM class_exception_tbl ce
                            INNER JOIN exception_type_tbl et ON et.exception_type_id = ce.exception_type_id
                            WHERE   class_id = %d 
                            AND     exception_date = %s 
                        ", $class->class_id, date('Y-m-d', $current_date) );

                        $qry_results = $sscy_database->get_results($qry_exceptions);

                        // Set up the times
                        $start_time = date_create('2000-01-01 ' . $class->start_time)->format('g:iA'); 
                        $end_time = date_create('2000-01-01 ' . $class->end_time)->format('g:iA'); 

                        // Find out if the weekly schedule is over and hide it if it is
                        $show_class = true;

                        if(strlen($class->date_until) > 0){ 
                            $date_until = strtotime($class->date_until);
                            $dif = round(($date_until - $current_date) / 86400);

                            if($dif < 0){
                                // Hide the class
                                $show_class = false;
                            }
                        }

                        // Only show this class if it is supposed to be shown.
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

                        <tr class="class class-<?php echo $class->class_id; ?> <?= sizeof($qry_results) === 1 ? $qry_results[0]->type : ''?>">
                            <td>
                                <a class="class__description_link" href="javascript:void(0);" title="<?php echo $class->name; ?>"><?php echo excerpt($class->name, 30); ?></a>
                            </td>        
                            <td><a class="class__teacher_link" href="javascript:void(0);"><?php echo $class->name_first . ' ' . $class->name_last; ?></a></td>
                            <td style="width: 150px;"><?php echo $start_time . ' - ' . $end_time; ?></td>
                            <td style="text-align: center; width: 100px;">
                                <?php if(1 == 2){ ?>
                                    <?php if(!$registered){ ?>
                                        <a class="button button--small register-button" href="javascript:void(0);" data-class-name="<?php echo $class->name; ?>" data-class-id="<?php echo $class->class_id; ?>" data-class-date="<?php echo date('Y-m-d', $current_date); ?>" data-class-date-styled="<?php echo date('F jS, Y', $current_date); ?>">register</a>
                                    <?php } else { ?>
                                        <a class="button button--small un-register-button" href="javascript:void(0);" data-registration-id="<?php echo $registrationID; ?>" data-class-name="<?php echo $class->name; ?>" data-class-id="<?php echo $class->class_id; ?>" data-class-date="<?php echo date('Y-m-d', $current_date); ?>" data-class-date-styled="<?php echo date('F jS, Y', $current_date); ?>">un-register</a>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                        </tr>
                        <tr class="class__details class__details--description">
                            <td colspan="4">
                                <div class="class__details-content">
                                    <!-- Add the exception message if needed -->
                                    <?php if( sizeof($qry_results) === 1 ){ ?>
                                        <p class="<?php echo $qry_results[0]->type; ?> u-padded"><?php echo $qry_results[0]->message; ?></p>
                                    <?php } ?>
                                    <strong><?php echo $class->name; ?></strong>
                                    <p><?php echo $class->description; ?></p>
                                    <?php if( $class->room_id != 0 ){ ?>
                                        <hr>
                                        <div class="class__details-room">
                                            <p><strong>This class will be held in</strong></p>
                                            <?php if( strlen($class->room_photo) > 0 ){ ?>
                                                <img class="class__details-room-photo photo-left-small" src="<?php echo $class->room_photo; ?>" />
                                            <?php } ?>
                                            <strong><?php echo $class->room_name; ?></strong>
                                            <p><?php echo $class->room_description; ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <tr class="class__details class__details--teacher">
                            <td colspan="4">
                                <div class="class__details-content">
                                    <?php if( strlen($class->photo) > 0 ){ ?>
                                        <img class="class__details-room-photo photo-left-small" src="<?php echo $class->photo; ?>" />
                                    <?php } ?>
                                    <strong><?php echo $class->name_first . ' ' . $class->name_last; ?></strong>
                                    <p><?php echo $class->bio; ?></p>
                                </div>
                            </td>
                        </tr>

                    <?php }}

                    if ($classes_shown == 0) { ?>
                        <tr class="class">
                            <td colspan="3"><strong>No Classes</strong></td>
                        </tr>
                    <?php } 

                    // Add one day to the current date being displayed.
                    $current_date = date(strtotime('+1 days', $current_date));
                } ?>

            </tbody>
        </table>

        <div class="modal">
            <div class="modal__window">
                <div class="modal__header">
                    <h1>Class Registration</h1>
                    <h2><span class="class__name"></span> - <span class="class__date"></span></h2>
                </div>
                <div class="modal__body">
                    <div class="input__group">
                        <input class="modal__input" type="text" id="name_first" placeholder="First Name" value="<?php echo $name_first; ?>" />
                        <label class="modal__label" for="name_first">First Name</label>
                    </div>

                    <div class="input__group">
                        <input class="modal__input" type="text" id="name_last" placeholder="Last Name" value="<?php echo $name_last; ?>" />
                        <label class="modal__label" for="name_last">Last Name</label>
                    </div>

                    <div class="input__group">
                        <input class="modal__input" type="text" id="email" placeholder="Email" value="<?php echo $email; ?>" />
                        <label class="modal__label" for="email">Email</label>
                    </div>

                    <!-- Sign the waiver if they haven't already. -->
                    <?php if(!isset($_COOKIE["name_first"])) { ?>
                        <h4>Acknowledgments</h4>
                        <div class="input__group">
                            <p>
                                <input type="checkbox">
                                I have read the Salt Spring Centre's <a href="http://www.saltspringcentre.com/legal/cancellation-policy/" target="_blank" class="colored">Waiver</a> and agree to its terms.
                            </p>
                            <p>
                                <input type="checkbox">
                                I have read the {Teachers Name}'s <a href="http://www.saltspringcentre.com/legal/cancellation-policy/" target="_blank" class="colored">Waiver</a> and agree to its terms.
                            </p>
                        </div>
                    <?php } ?>
                </div>
                <div class="modal__footer">
                    <a class="modal__footer-link modal__cancel" href="#">cancel</a>
                    <a class="modal__footer-button button class-register" href="#">Register</a>

                    <!-- Hidden Input -->
                    <input type="hidden" id="class_date" />
                    <input type="hidden" id="class_id" />
                </div>
            </div>
        </div>
