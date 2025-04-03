<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);
        $role = $user['role'];

        if ($role === 'admin') {
            $_SESSION['admin'] = $username;
            header("Location: index.php");
        } elseif ($role === 'customer') {
            $_SESSION['customer'] = $username;
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "❌ ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เข้าสู่ระบบ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php
        if (isset($_SESSION['admin'])) {
            echo '
              <li class="nav-item"><a class="nav-link" href="admin/manage_tables.php">จัดการโต๊ะ</a></li>
              <li class="nav-item"><a class="nav-link" href="admin/manage_menu.php">จัดการเมนู</a></li>
              <li class="nav-item"><a class="nav-link" href="admin/manage_rewards.php">จัดการรางวัล</a></li>
              <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
            ';
        } elseif (isset($_SESSION['customer'])) {
            echo '
              <li class="nav-item"><a class="nav-link" href="booking.php">จองโต๊ะ</a></li>
              <li class="nav-item"><a class="nav-link" href="menu.php">เมนู</a></li>
              <li class="nav-item"><a class="nav-link" href="order.php">สั่งอาหาร</a></li>
              <li class="nav-item"><a class="nav-link" href="redeem.php">แลกแต้ม</a></li>
              <li class="nav-item"><a class="nav-link" href="logout.php">ออกจากระบบ</a></li>
            ';
        } else {
            echo '
              <li class="nav-item"><a class="nav-link" href="login.php">เข้าสู่ระบบ</a></li>
              <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
            ';
        }
        ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-5" style="max-width: 500px;">
  <div class="card shadow">
    <div class="card-body">
      <h3 class="card-title text-center mb-4">เข้าสู่ระบบ</h3>
      <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
      <form method="post">
        <div class="mb-3">
          <label>ชื่อผู้ใช้</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>รหัสผ่าน</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100">เข้าสู่ระบบ</button>
      </form>
      <div class="text-center mt-3">
        <small>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></small>
      </div>
    </div>
  </div>
</div>
</body>
</html>
