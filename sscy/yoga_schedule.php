<?php

    // Set up the database connection
    require_once('mysqli_connect.php');

    $qry_classes = $sscy_database->get_results( "
        SELECT c.*, cs.*, t.*, a.* 
        FROM class_schedule_tbl cs 
        LEFT JOIN class_tbl c ON c.class_id = cs.class_id
        LEFT JOIN teacher_tbl t ON c.teacher_id = t.teacher_id 
        LEFT JOIN account_tbl a ON t.account_id = a.account_id    
    " );

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

    $today = date('w');
    $current_date = date(strtotime('-'.$today.' days'));
    
    ?>
    
        <table class="table table--class">
            <tr>
                <th>Class</th>
                <th>Time</th>
                <th>Teacher</th>
            </tr>
            <tbody>

                <?php for ($i = 0; $i <= 6; $i++){ ?>   
                    
                    <!-- Display the date heading -->
                    <tr class="class-date">
                        <td colspan="3"><?php echo displayDate($current_date); ?></td>
                    </tr>

                    <?php if (sizeof($arr_classes[$i]) == 0) { ?>
                        <tr class="class">
                            <td colspan="3"><strong>No Classes</strong></td>
                        </tr>
                    <?php } ?>
                    

                    <!-- Get the classes for the current day -->
                    <?php foreach ( $arr_classes[$i] as $class) { 
                        
                        // Set up the times
                        $start_time = date_create('2000-01-01 ' . $arr_classes[0][0]->start_time)->format('g:iA'); 
                        $end_time = date_create('2000-01-01 ' . $arr_classes[0][0]->end_time)->format('g:iA'); 

                    ?> 

                        <tr class="class">
                            <td><?php echo $start_time . ' - ' . $end_time; ?></td>
                            <td><a class="class__description_link" href="#"><?php echo $class->name; ?></a></td>
                            <td><a class="class__teacher_link" href="#"><?php echo $class->name_first . ' ' . $class->name_last; ?></a></td>
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
