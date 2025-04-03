<?php
session_start();
include 'includes/db.php';

$role = '';
$username = '';
$membership = '';

if (isset($_SESSION['admin'])) {
    $username = $_SESSION['admin'];
    $role = 'admin';
} elseif (isset($_SESSION['customer'])) {
    $username = $_SESSION['customer'];
    $role = 'customer';
    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $membership = $user['membership'];
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>หน้าแรก | Sashimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<?php
if (isset($_SESSION['admin'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">Sashimi Admin</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="admin/manage_tables.php">จัดการโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/manage_menu.php">จัดการเมนู</a></li>
        <li class="nav-item"><a class="nav-link" href="admin/manage_rewards.php">จัดการรางวัล</a></li>
        <li class="nav-item"><a class="nav-link" href=logout.php>ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php elseif (isset($_SESSION['customer'])): ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href=booking.php>จองโต๊ะ</a></li>
        <li class="nav-item"><a class="nav-link" href=menu.php>เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=order.php>สั่งอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=reward_vouchers.php>แลกแต้ม</a></li>
        <li class="nav-item"><a class="nav-link" href=reservation_status.php>สถานะการจอง</a></li>
        <li class="nav-item"><a class="nav-link" href=logout.php>ออกจากระบบ</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php else: ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href=menu.php>เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link" href=login.php>เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href=register.php>สมัครสมาชิก</a></li>
      </ul>
    </div>
  </div>
</nav>
<?php endif; ?>
<?php
if (isset($_SESSION['admin'])): ?>

<?php elseif (isset($_SESSION['customer'])): ?>

<?php else: ?>

<?php endif; ?>
<?php
if (isset($_SESSION['admin'])): ?>

<?php elseif (isset($_SESSION['customer'])): ?>

<?php else: ?>

<?php endif; ?>



<?php if ($role === 'admin'): ?>

<?php elseif ($role === 'customer'): ?>

<?php else: ?>

<?php endif; ?>

<div class="container text-center mt-5">
  <h1 class="display-4">ยินดีต้อนรับสู่ร้าน Sashimi 🍣</h1>
  <?php if ($role === 'admin'): ?>
    <p class="lead">คุณเข้าสู่ระบบในฐานะ <strong>แอดมิน</strong> (<?= $username ?>)</p>
  <?php elseif ($role === 'customer'): ?>
    <p class="lead">สวัสดีคุณ <strong><?= $username ?></strong></p>
    <p>ระดับสมาชิกของคุณ: <strong><?= ucfirst($membership) ?></strong></p>
  <?php else: ?>
    <p class="lead">กรุณาเข้าสู่ระบบหรือสมัครสมาชิกเพื่อใช้งาน</p>
    <a href=login.php class="btn btn-dark btn-lg m-2">เข้าสู่ระบบ</a>
    <a href=register.php class="btn btn-outline-secondary btn-lg m-2">สมัครสมาชิก</a>
  <?php endif; ?>
</div>

</body>
</html>
