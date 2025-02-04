<?php
$servername = "dbaas-db-10484483-do-user-18869992-0.j.db.ondigitalocean.com";
$username = "doadmin"; // Default username for local MySQL
$password = "AVNS_LQe5J0OTY9hQx-y9e9s"; // Default password for local MySQL
$database = "community_db";
$port ="25060";

$conn = new mysqli($servername, $username, $password, $database,$port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
