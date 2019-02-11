<?php

$servername = "localhost";
$username = "saltspri_web";
$password = "Baba1272*rc";
$dbname = "saltspri_internal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// First find out if the user account exist
$sql = "    
            SELECT account_id
            FROM account_tbl
            WHERE (name_first = '" . $_POST["name_first"] . "' AND name_last = '" . $_POST["name_last"] . "') OR email = '" . $_POST["email"] . "'
            LIMIT 1
        ";

$result = $conn->query($sql);

// If there are results, register that user, otherwise create the user and register them
if ( $result->num_rows == 0 ) {

    // No Account found Add the record
    $sql = "    
                INSERT INTO account_tbl
                ( name_first, name_last, email, username, password ) 
                VALUES
                ( '" . $_POST["name_first"] . "','" . $_POST["name_last"] . "','" . $_POST["email"] . "', 'online', MD5('pword') )
        ";

    $conn->query($sql);
    $id = $conn->insert_id;

} else {    

    // Account found
    $row = $result->fetch_assoc();
    $id = $row["account_id"];

}

// Insert the registration record 

    $sql = "    INSERT INTO registration_tbl
                ( name_first, name_last, email, class_id, date_class, account_id  ) 
                VALUES
                ( '" . $_POST["name_first"] . "','" . $_POST["name_last"] . "','" . $_POST["email"] . "'," . $_POST["class_id"] . ",'" . $_POST["class_date"] . "'," . $id . " )
        ";

    $conn->query($sql);
    $id = $conn->insert_id;
    
    // Set the cookie so that it remains for future registrations
    /*
    *   Currently this just refills the text boxes with the information,
    *   eventually this should be replaced with a login system
    */
    setcookie("name_first", $_POST["name_first"], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("name_last", $_POST["name_last"], time() + (86400 * 30), "/"); // 86400 = 1 day
    setcookie("email", $_POST["email"], time() + (86400 * 30), "/"); // 86400 = 1 day

$conn->close();

echo '{"success":true,"message":"You have been registered for this class.","type":"success","registration_id":' . $id . '}';

?>
