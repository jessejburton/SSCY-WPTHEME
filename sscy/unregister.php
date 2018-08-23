<?php

$servername = "localhost";
$username = "saltspri_web";
$password = "Baba1272*rc";
$dbname = "saltspri_internal";
$id = $_POST["registration_id"];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Delete the registration record
$sql = "    DELETE FROM registration_tbl
            WHERE registration_id = $id";

$conn->query($sql);
$conn->close();

echo '{"success":true,"message":"You have been unregistered from this class.","type":"success"}';

?>
