<?php

    // Set up the database connection
    require_once('mysqli_connect.php');

    // Include the utility functions
    require_once('utilities.php');

    $qry_classes = $sscy_database->get_results( "
        SELECT c.*, cs.*, t.*, a.* 
        FROM class_weekly_schedule_tbl cs 
        LEFT JOIN class_tbl c ON c.class_id = cs.class_id
        LEFT JOIN teacher_tbl t ON c.teacher_id = t.teacher_id 
        LEFT JOIN account_tbl a ON t.account_id = a.account_id    
    " );

    var_dump($qry_classes);
    die();

    $arr_classes = [];

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

        <p style="text-align: center;">
            <a href="http://internal.saltspringcentre.com/print/yoga_schedule.php" target="_blank"><i class="fas fa-print"></i> print schedule</a>
        </p>
    
        <table class="table table--class">
            <thead>
                <tr>
                    <th colspan="3" class="clearfix">
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
                        <td colspan="3"><strong style="text-transform: uppercase;"><?php echo date('l', $current_date); ?></strong> <em style="font-size: .8em;"><?php echo date('F jS, Y', $current_date) ?></em></td>
                    </tr>

                    <?php if (sizeof($arr_classes[$i]) == 0) { ?>
                        <tr class="class">
                            <td colspan="3"><strong>No Classes</strong></td>
                        </tr>
                    <?php } ?>
                    

                    <!-- Get the classes for the current day -->
                    <?php foreach ( $arr_classes[$i] as $class) { 
                        
                        // Set up the times
                        $start_time = date_create('2000-01-01 ' . $class->start_time)->format('g:iA'); 
                        $end_time = date_create('2000-01-01 ' . $class->end_time)->format('g:iA'); 

                    ?> 

                        <tr class="class">
                            <td><a class="class__description_link" href="javascript:void(0);" title="<?php echo $class->name; ?>"><?php echo excerpt($class->name, 30); ?></a></td>        
                            <td><a class="class__teacher_link" href="javascript:void(0);"><?php echo $class->name_first . ' ' . $class->name_last; ?></a></td>
                            <td><?php echo $start_time . ' - ' . $end_time; ?></td>
                        </tr>
                        <tr class="class__details class__details--description">
                            <td colspan="4">
                                <div class="class__details-content">
                                    <strong><?php echo $class->name; ?></strong>
                                    <p><?php echo $class->description; ?></p>
                                </div>
                            </td>
                        </tr>
                        <tr class="class__details class__details--teacher">
                            <td colspan="4">
                                <div class="class__details-content">
                                    <strong><?php echo $class->name_first . ' ' . $class->name_last; ?></strong>
                                    <p><?php echo $class->bio; ?></p>
                                </div>
                            </td>
                        </tr>

                    <?php }

                    // Add one day to the current date being displayed.
                    $current_date = date(strtotime('+1 days', $current_date));
                } ?>

            </tbody>
        </table>
