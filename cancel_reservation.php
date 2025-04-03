<?php
session_start();
if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}
include 'includes/db.php';

if (isset($_GET['id'])) {
    $res_id = $_GET['id'];
    $check = mysqli_query($conn, "SELECT * FROM reservations WHERE id = '$res_id'");
    if ($row = mysqli_fetch_assoc($check)) {
        mysqli_query($conn, "UPDATE tables SET status = 'available' WHERE id = '{$row['table_id']}'");
        mysqli_query($conn, "DELETE FROM reservations WHERE id = '$res_id'");
        header("Location: reservation_status.php");
        exit();
    } else {
        echo "❌ ไม่พบข้อมูลการจอง";
    }
} else {
    echo "❌ กรุณาระบุรหัสการจอง";
}
?>
