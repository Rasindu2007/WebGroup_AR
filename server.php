<?php
$server="dbaas-db-10484483-do-user-18869992-0.j.db.ondigitalocean.com";
$username="doadmin";
$password="AVNS_LQe5J0OTY9hQx-y9e9s";
$dbname="defaultdb";
$port="25060";

$conn = new mysqli($server, $username,$password,$dbname, $port);
if($conn->connect_error){
    die("Error : ".$conn->error);
}
?>