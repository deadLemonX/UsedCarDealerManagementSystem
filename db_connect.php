<?php
$servername = "127.0.0.1";
$db_username = "webadmin";
$db_password = "webadmin";
$dbname = "used_car_database";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(" <div class='db_connected_failure'> [Database Connection: Failed: " . $conn->connect_error) . "] </div>";
}
echo "<div class='db_connected_successful'> [Database Connection: Successful] </div>";
?>
