<?php
session_start();
include 'includes/db.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);
    $confirm = md5($_POST['confirm']);

    if ($password !== $confirm) {
        $msg = "<div class='alert alert-danger'>❌ รหัสผ่านไม่ตรงกัน</div>";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($check) > 0) {
            $msg = "<div class='alert alert-warning'>⚠️ ชื่อผู้ใช้นี้ถูกใช้งานแล้ว</div>";
        } else {
            mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', 'customer')");
            $msg = "<div class='alert alert-success'>✅ สมัครสมาชิกเรียบร้อย! <a href='login.php'>เข้าสู่ระบบ</a></div>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>สมัครสมาชิก</title>
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

<div class="container mt-5" style="max-width: 500px;">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title mb-4 text-center">สมัครสมาชิก</h3>
            <?= $msg ?>
            <form method="post">
                <div class="mb-3">
                    <label>ชื่อผู้ใช้</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>รหัสผ่าน</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>ยืนยันรหัสผ่าน</label>
                    <input type="password" name="confirm" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">สมัครสมาชิก</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
