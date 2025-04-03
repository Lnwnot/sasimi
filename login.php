<?php
session_start();
include 'includes/db.php';

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && md5($password) === $user['password']) {
        $role = strtolower(trim($user['role']));
        if ($role === 'admin') {
            $_SESSION['admin'] = $username;
            header("Location: admin/manage_menu.php");
        } elseif ($role === 'staff') {
            $_SESSION['staff'] = $username;
            header("Location: staff/orders.php");
        } elseif ($role === 'customer') {
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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Sashimi</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="menu.php">เมนูอาหาร</a></li>
        <li class="nav-item"><a class="nav-link active" href="login.php">เข้าสู่ระบบ</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">สมัครสมาชิก</a></li>
      </ul>
    </div>
  </div>
</nav>

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
          <input type="password" name="password" class="form-control" required autocomplete="off">
        </div>
        <button class="btn btn-primary w-100" type="submit">เข้าสู่ระบบ</button>
      </form>
    </div>
  </div>
</div>
</body>
</html>
