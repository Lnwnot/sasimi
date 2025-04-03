<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'restaurant_db';

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die('เชื่อมต่อฐานข้อมูลล้มเหลว: ' . mysqli_connect_error());
}
?>
