<?php
$host = "127.0.0.1"; // use IP instead of 'localhost'
$user = "root";
$password = "";
$dbname = "cards";
$port = 3307; // 👈 important: your MySQL port

$conn = mysqli_connect($host, $user, $password, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
