<?php
session_start();
include 'includes/db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['role'] === 'admin') {
            $_SESSION['admin'] = $username;
            header("Location: admin/manage_menu.php");
        } elseif ($user['role'] === 'staff') {
            $_SESSION['staff'] = $username;
            header("Location: staff/orders.php");
        } elseif ($user['role'] === 'customer') {
            $_SESSION['customer'] = $username;
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
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
<div class="container mt-5">
  <div class="col-md-6 offset-md-3">
    <div class="card p-4 shadow">
      <h3 class="text-center mb-3">🔐 เข้าสู่ระบบ</h3>
      <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="mb-3">
          <label>ชื่อผู้ใช้</label>
          <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
          <label>รหัสผ่าน</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">เข้าสู่ระบบ</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
