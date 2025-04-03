<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['customer'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['customer'];
$user_result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
$user = mysqli_fetch_assoc($user_result);
$user_id = $user['id'];
$points = $user['points'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reward_id'])) {
    $reward_id = intval($_POST['reward_id']);
    $reward_result = mysqli_query($conn, "SELECT * FROM rewards WHERE id = $reward_id");
    $reward = mysqli_fetch_assoc($reward_result);

    if ($reward && $points >= $reward['points_required']) {
        // หักแต้ม
        mysqli_query($conn, "UPDATE users SET points = points - {$reward['points_required']} WHERE id = $user_id");
        // เพิ่มบัตรส่วนลด
        mysqli_query($conn, "INSERT INTO vouchers (user_id, reward_id, status) VALUES ($user_id, $reward_id, 'active')");
        header("Location: reward_vouchers.php?success=1");
        exit();
    } else {
        header("Location: reward_vouchers.php?error=1");
        exit();
    }
}
header("Location: reward_vouchers.php");
exit();
?>
