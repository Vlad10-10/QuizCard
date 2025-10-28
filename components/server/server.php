<?php
$host = "localhost"; 
$user = "root";
$password = "";
$dbname = "cards";

$conn = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
